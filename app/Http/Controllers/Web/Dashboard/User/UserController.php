<?php

namespace App\Http\Controllers\Web\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Userinfo;
use App\Models\Notification;
use App\Models\PaymentSetting;
use App\Models\Meberships;
use App\Models\MembershipCode;
use App\Http\DataProviders\Web\Dashboard\User\IndexDataProvider;
use App\Http\Requests\Web\Dashboard\User\BlockRequest;
use App\Http\Requests\Web\Dashboard\User\UnBlockRequest;
use App\Http\Requests\Web\Dashboard\User\DeleteRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Web\Dashboard\Mebership\EditRequest;
use App\Http\Requests\Web\Dashboard\User\IndexRequest;
use App\Http\Requests\Web\Dashboard\Mebership\StoreRequest;
use App\Http\Requests\Web\Dashboard\Mebership\UpdateRequest;
use Illuminate\Http\Request;
use Hash;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    public function index(Request $request, IndexDataProvider $provider)
    {
        $search = $request->query('search');

    	return view('dashboard.pages.user.index',$provider->meta($search));
    }

    public function createUser() {
        return view('dashboard.pages.user.admin-add');
    }

    public function specialCode(Request $request) {
        if (Auth::user()->role_id != 1) { //prevent regular users from changing codes
            echo "<h1>You are not authorized to be here</h1>";
                exit;
        }
        //$user = User::findOrFail($id);
        $meberships = Meberships::where('levelstatus', 1)->orderBy('amount', 'ASC')->get();
        $mem_code = MembershipCode::get();

        $mem_code_array = [];
        $mem_used_array = [];
        foreach ($mem_code as $mc) {
            $mem_code_array[$mc->membership_id] = $mc->membership_code;
            $mem_used_array[$mc->membership_id] = $mc->used;
        }

        return view('dashboard.pages.user.user-code', ['mem_used_array' => $mem_used_array, 'mem_code_array' => $mem_code_array, 'meberships' => $meberships]);
    }

    public function storeCode(Request $request) {
        if (Auth::user()->role_id != 1) { //prevent regular users from changing codes
            echo "<h1>You are not authorized to be here</h1>";
                exit;
        }
        $data = $request->all();
         
        $meberships = Meberships::where('levelstatus', 1)->get();

        $membership = array();
        foreach ($meberships as $meb) {
            $membership['membership_id'] = $meb->id;
            $membership['membership_code'] = $_POST['membership_'.$meb->id];
            $membership['used'] = $_POST['used_'.$meb->id];

            //$membership['user_id'] = $data['user_id'];
            $mem_exist = MembershipCode::where('membership_id', $meb->id)->first();
            if ($mem_exist) {
                $mem_exist = MembershipCode::where('membership_id', $meb->id)
                ->update(['used' => $membership['used'], 'membership_code' => $membership['membership_code']]);
            }
            else {
                MembershipCode::insert($membership);
            }
        }

        return redirect()->route('user.specialcode');
    }


    public function editUser(Request $request, $id) {
        $adminUser = User::findOrFail($id);
        $user_info = Userinfo::where('user_id', $adminUser->id)->first();
        $activeTab = '';

        if (Auth::user()->role_id != 1) { //prevent regular users from changing another profile
            if ($id != Auth::id()) {
                echo "<h1>You are not authorized to be here</h1>";
                exit;
            }
        }  
        
        $payment = PaymentSetting::where('user_id', $adminUser->id)->first();
        $meberships = Meberships::where('levelstatus', 1)->orderBy('amount', 'ASC')->get();
        $currentUserTier = $meberships[0];
        for ($i = 0; $i < count($meberships); $i++) {
            $desc = nl2br($meberships[$i]->description);
            $meberships[$i]->descs = explode("<br />", $desc);

            if ($adminUser->meberships_id === $meberships[$i]->id)
                $currentUserTier = $meberships[$i];
        }
        $amount = Meberships::select('amount')->where('id', $adminUser->id)->value('amount');

        return view('dashboard.pages.user.admin-edit', ['user_info' => $user_info, 'currentUserTier' => $currentUserTier, 
        'meberships' => $meberships, 'admin_user' => $adminUser, 'activeTab' => $activeTab, 'payment' => $payment, 'amount' => $amount]);
        //user_info', 'payment', 'meberships', 'amount', 'currentUserTier', 'activeTab'
    }
    
    public function adminRegistration(Request $request)
    {

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'company_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'group_type' => 'required',

        ]);

        $data = $request->all();
        $check = $this->createData($data);
        flashWebResponse('message', 'Admin User add successfully.!');
        return back();
    }

    public function adminUpdate(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'company_name' => 'required',
            'email' => 'required|email',
            'group_type' => 'required',

        ]);
        $user = User::findOrFail($id);
        $user->update($this->updateData($request));
        $user->save();

        $data = [
            'user_id'     => $id,
            'status' => 0
        ];

        $status = '';

        if ($request->hasFile('profile_image')) {
            $file = Storage::disk('public')->putFile('', $request->file('profile_image'), 'public');
            $image_path = public_path('images/profile');
            $public_file = $request->file('profile_image');
            $fileName = explode('images/', $file);
            $public_file->move($image_path, $fileName[0]);

            $status = "uploaded";
        }

        $userinfo = Userinfo::where('user_id', $id)->get()->count();
        if ($userinfo == 0) {
            $this->userinfo = Userinfo::create($data);
        }
        
        if ($status == "uploaded") {
            Userinfo::where('user_id', '=', $id)->update(array('profile_image' => $file));
        }

        $userInfo_dat = [
            'status' => $request->input('status'),
            'dob' => $request->input('dob'),
            'marriage_status' => $request->input('marriage_status'),
            'website' => $request->input('website'),
            'phone_number' => $request->input('phone_number'),
            'country' => $request->input('country'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'description' => $request->input('address'),
            'gender' => $request->input('gender'),
            'facebook_url' => $request->input('facebook_url')
       ];  

        $userInfo = Userinfo::where('user_id' , $id)->first();
        $userInfo->update($userInfo_dat);
        $userInfo->save();

        flashWebResponse('message', 'Admin User edit successfully.!');
        return back();
    }
    
    public function createData(array $data)
    {
      return User::create([
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'name' => $data['first_name'].' '.$data['last_name'],
        'company_name' => $data['company_name'],
        'slug' => str_replace(" ","_",$data['company_name']),
        'email' => $data['email'],
        'role_id' => 2,
        'password' => Hash::make($data['password']),
        'group_type' => $data['group_type'],
        'status' => $data['status'],
        'meberships_id' => 4,
        'edate' => Carbon::now()->addDays(14),
      ]);
    }

    public function updateData(Request $request): array
    {
        return [
            'first_name'     => $request->input('first_name'), 
            'last_name'     => $request->input('last_name'),
            'company_name'     => $request->input('company_name'),
            'email'     => $request->input('email'),
            'group_type'     => $request->input('group_type'),
            'status' => $request->input('status')
        ];
    }

    public function blockUser(BlockRequest $request, User $user)
    {
        if (request()->ajax()) {
            flashWebResponse('block', 'block! user has been block successfully.');
            return ($request->persist()->getMsg()) ? blockWebResponse('block') : errorWebResponse();
        }
        return httpWebResponse();
    }

    public function unblockUser(UnBlockRequest $request, User $user)
    {
        if (request()->ajax()) {
            flashWebResponse('unblock', 'unblock! user has been unblock successfully.');
            return ($request->persist()->getMsg()) ? unblockWebResponse('block') : errorWebResponse();
        }
        return httpWebResponse();
    }

    public function userList(IndexRequest $request, IndexDataProvider $provider)
    {
       return view('dashboard.pages.user.userlist',$provider->meta());
    }

    public function create(CreateRequest $request)
    {
    	return view('dashboard.pages.mebership.create',$request->getStore());
    }

    public function store(StoreRequest $request)
    {
    	if ($level = $request->persist()->getLevel()) {
            flashWebResponse('created', 'store level');
            return redirect()->route('mebership', $level->id);
        }
        flashWebResponse('error');
        return redirect()->back();
    }
    public function edit(Request $request,$meberships)
    {
        $meberships = Meberships::findOrFail($meberships);
        $storemasters = Storemasters::join('storepermisions','storepermisions.store_id','storemasters.id')->where('storepermisions.meberships_id',$meberships->id)->get();
        return view('dashboard.pages.mebership.edit',['meberships' => $meberships,'storemasters' => $storemasters]);
    }

    public function update(UpdateRequest $request, Meberships $meberships)
    {
        if ($update = $request->persist()->getMeberships()) {
            flashWebResponse('updated', 'level');
            return redirect()->route('mebership-edit', $update->id);
        }
        flashWebResponse('error');
        return redirect()->back();
    }

    public function destroy(DestroyRequest $request, Meberships $mebership)
    {
        if (request()->ajax()) {
            flashWebResponse('trashed', 'level');
            return ($request->persist()->getMsg()) ? trashedWebResponse('level') : errorWebResponse();
        }
        return httpWebResponse();
    }

    public function delete(DeleteRequest $request, User $user)
    {
        if (request()->ajax()) {
            flashWebResponse('trashed', 'user');
            return ($request->persist()->getMsg()) ? trashedWebResponse('level') : errorWebResponse();
        }
        return httpWebResponse();
    }

    public function admindetails(User $user)
    {
       return view('dashboard.pages.user.admindetails',compact('user'));
    }

    public function addUserComment(Request $request) {
        $this->validate($request, [
          'comment' => 'required',
        ]);

        //  Store data in database
        $userinfo = Userinfo::where('user_id',$request->user_id)->first();
        if (isset($userinfo->user_id)) {
            Userinfo::where('user_id',$request->user_id)->update(['comment' => $request->comment]);
        }
        else {
            Userinfo::create(['comment' => $request->comment, 'user_id' => $request->user_id]);
        }
        flashWebResponse('updated', 'comment');
        return redirect()->route('user.viewdetails', $request->user_id);
    }

    public function alerts()
    {
        $authId = Auth::id();
        $query = "SELECT messages.*, userinfos.profile_image, users.name FROM messages
            INNER JOIN (SELECT user_id, MAX(created_at) AS end_date FROM messages GROUP BY user_id) T2
            ON messages.user_id=T2.user_id AND messages.created_at=T2.end_date
            LEFT JOIN userinfos ON messages.user_id=userinfos.user_id
            LEFT JOIN users ON messages.user_id=users.id
            WHERE messages.receiver_id=$authId AND messages.is_seen=0";
        $alertMessageUsers = DB::select(DB::raw($query));

        $notifications = DB::table('notifications')
                        ->select('notifications.*', 'userinfos.profile_image', 'users.name')
                        ->leftJoin('userinfos', 'notifications.user_id', '=', 'userinfos.user_id')
                        ->leftJoin('users', 'notifications.user_id', '=', 'users.id')
                        ->where('notifications.receiver_id', $authId)
                        ->where('is_seen', 0)
                        ->orderByDesc('created_at')
                        ->get();

        $rst = [];
        $rst['messengers'] = $alertMessageUsers;
        $rst['notifications'] = $notifications;

        return $rst;
    }
}
