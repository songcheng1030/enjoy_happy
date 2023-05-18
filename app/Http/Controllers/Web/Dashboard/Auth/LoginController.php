<?php

namespace App\Http\Controllers\Web\Dashboard\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Meberships;
use App\Models\MembershipCode;
use App\Models\AdminSetting;
use App\Models\InviteUser;
use App\Models\InviteGroupUser;
use App\Models\GroupUser;
use App\Models\Payment as PaymentModel;
use Stripe;
use Carbon\Carbon;

class LoginController extends Controller
{
    // /**
    //  * Show the login form.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function showLoginForm()
    // {
    //     if (Auth::check()) {
    //         return redirect('dashboard');
    //     }
    //     return view('dashboard.pages.auth.login');
    // }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('dashboard.pages.auth.login');
    }

    public function membership($id) 
    {
        $id = decrypt($id);
        $user = User::find($id);
        if (!$user) {
            echo "<h1>ERROR - user does not exist</h1>";
            exit;
        }
        $user = $user->first();
        $email = $user->email;
        $meberships = Meberships::where('levelstatus', 1)->orderBy('amount', 'ASC')->get();

        $currentUserTier = $meberships[0];
        for ($i = 0; $i < count($meberships); $i++) {
            $desc = nl2br($meberships[$i]->description);
            $meberships[$i]->descs = explode("<br />", $desc);

            /*if (Auth::user()->meberships_id === $meberships[$i]->id)
                $currentUserTier = $meberships[$i];*/
        }

        return view('auth.membership', compact('meberships', 'id', 'email'));
    }

    public function membershipCart(Request $request, $id)
    {
        $user_id = decrypt($id);
        $user = User::find($user_id );
        if (!$user) {
            echo "<h1>ERROR - user does not exist</h1>";
            exit;
        }

        $data = $request->all();
       
        $meberships = Meberships::where('levelstatus', 1)->orderBy('amount', 'ASC')->get();
        $currentUserTier = $meberships[0];
        for ($i = 0; $i < count($meberships); $i++) {
            $desc = nl2br($meberships[$i]->description);
            $meberships[$i]->descs = explode("<br />", $desc);

            /*if (Auth::user()->meberships_id === $meberships[$i]->id)
                $currentUserTier = $meberships[$i];*/
        }

        $mebership_id = $data['membership_id'];
        
        if (!is_numeric($mebership_id)) {
            echo "ERROR - unable to figure out membership";
            exit;
        }

        return view('auth.payment', compact('meberships', 'user_id', 'mebership_id'));
    }

    public function membershipSpecialCode(Request $request)
    {
        $data = $request->all();
        $membershipCode = MembershipCode::where('membership_code', $data['special_pc'] )
        ->where('membership_id', (int)$data['membershipId'])
        ->where('used', 0)->first();

        if ($membershipCode) {
            User::where('id', (int)$data['user_id'])->update(['meberships_id' => (int)$data['membershipId']]);
            
            $membershipCode = MembershipCode::where('membership_code', $data['special_pc'] )
            ->where('membership_id', (int)$data['membershipId'])->update(['used' => 1]);

            return response()->json(['text' => '', 'error' => 0]);
        }
        else {
            return response()->json(['text' => 'Error - invalid code', 'error' => 1]);
        }
    }

    public function payFirstTimePost(Request $request) 
    { 
        $data = $request->all();
        $userPlanId = $request->membershipId;
        $userMembership = Meberships::where('id', $userPlanId)->first();
        $user_id = $request->user_id;
        $this->cartCheckout($userMembership, $user_id, $request);
        
        return redirect()->route('firstplan.paysucc');
    }

    public function paymentSuccessful()
    {
        return view('auth.final');
    }

    private function cartCheckout($userMembership, $user_id, $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $stripe_obj = Stripe\Charge::create ([
                "amount" => $userMembership->amount * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Your plan is upgrade."
        ]);

        // Saving user's payment in history
        $payment                 = new PaymentModel();
        $payment->token_id       = $request->stripeToken;
        $payment->user_id        = $user_id;
        $payment->charge_id      = $stripe_obj->id;
        $payment->currency       = 'USD';
        $payment->payment_method = 'Stripe';
        $payment->total = $userMembership->amount;
        $payment->save();

        User::where('id', $user_id)->update(['meberships_id' => $request->membershipId, 'edate' => Carbon::now()->addDays(30)]);
    }

    public function adminLoginForm($slug=null)
    {
        if (Auth::check()) {
            return redirect('dashboard');
        }
        $levels = Meberships::where('levelstatus',1)->get();
        $admin = User::where('slug',$slug)->whereNotNull('slug')->where('role_id',2)->first();
        return view('dashboard.pages.auth.admin-login', compact('levels','admin'));
    }

    public function userLoginForm()
    {
        if (Auth::check()) {
            return redirect('dashboard');
        }
        return view('dashboard.pages.auth.user-login');
    }
    public function registration($token=null, $groupId='NONE')
    {
        if (Auth::check()) {
            return redirect('dashboard');
        }
        $agreement = AdminSetting::where('sname', 'agreement')->first();
        $agreementText = isset($agreement) ? $agreement->svalue : "";
        if ($token) {
            if ($groupId && $groupId !== 'NONE') {
                Session::put('groupId', $groupId);
                $inviteUser = InviteGroupUser::where('token', $token)->first();
            }
            else {
                $inviteUser = InviteUser::where('token', $token)->first();
            }
            $inviteUserEmail = isset($inviteUser) ? $inviteUser['email'] : null;

            return view('dashboard.pages.auth.invite-registration', ['agreementText'=> $agreementText, 'inviteUserEmail' => $inviteUserEmail]);
        }
        return view('dashboard.pages.auth.registration', ['agreementText'=> $agreementText]);
    }

    /**
     * Login the admin.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $this->validator($request);

        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            //Authentication passed...
            $role_id = Auth::user()->role_id;
            if (Auth::user()->block == 0 ) {
                if ($role_id == 1) {
                    Session::flush();
                    Auth::logout();
                    return Redirect('super-admin-login')->with('error','Your account has been blocked please contact hapiom.');
                } else if ($role_id == 2) {
                    Session::flush();
                    Auth::logout();
                    return Redirect('admin')->with('error','Your account has been blocked please contact hapiom.');
                } else {
                    Session::flush();
                    Auth::logout();
                    return Redirect('user-login')->with('error','Your account has been blocked please contact hapiom.');
                }
            }
            // else if ( User::where('id',Auth::user()->customer_id )->value('block') == 0 && $role_id == 3)
            // {
            //     Session::flush();
            //     Auth::logout();
            //     return Redirect('user-login')->with('error','Your account has been blocked please contact hapiom.');
            // }
            // else if ($role_id == 2 && Auth::user()->edate < date('Y-m-d') ) {
            //     Session::flush();
            //     Auth::logout();
            //     return Redirect('admin')->with('error','Your account is put on hold you can not login untill pay.');
            // }
            if ($groupId = Session::get('groupId')) {
                $groupUser = new GroupUser();
                $groupUser->user_id  = Auth::user()->id;
                $groupUser->group_id = $groupId;
                $groupUser->status = 0;
                $groupUser->save();
                $inviteGroupUserOnUsers = InviteGroupUser::where('email', Auth::user()->email)->get();
                if ($inviteGroupUserOnUsers) {
                    foreach($inviteGroupUserOnUsers as $inviteGroupUserOnUser) {
                        $inviteGroupUserOnUser->delete();
                    }
                }
                return redirect()->route('group-users.show', $groupId);
            }
            $inviteUserOnUsers = InviteUser::where('email', Auth::user()->email)->get();
            if ($inviteUserOnUsers) {
                foreach($inviteUserOnUsers as $inviteUserOnUser) {
                    $inviteUserOnUser->delete();
                }
            }
            return redirect()
                ->intended('dashboard')
                ->with('status', 'You are Logged in as Admin!');
        }

        //Authentication failed...
        return $this->loginFailed();
    }

    public function userRegistration(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'optionsCheckboxes' => 'required',
        ]);

        $data = $request->all();
        if ($data['role'] == 2) {
            $check = $this->createAdminData($data);
        }
        else {
            $check = $this->create($data);
        }

        flashWebResponse('message', 'Successful Registration: Please check your email for Verification.');

        return redirect()->route('user-membership', ['id' => encrypt($check->id) ]);
        //return back();
        // return back()->withErrors(['These credentials do not match our records.']);
        // return redirect("dashboard")->withSuccess('You have signed-in');
    }

    public function create(array $data)
    {
          return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'name' => $data['first_name'].' '.$data['last_name'],
            'email' => $data['email'],
            'role_id' => $data['role'],
            'password' => Hash::make($data['password']),
            'customer_id' => $data['customer_id'] ?? NULL,
          ]);
    }

    public function createAdminData(array $data)
    {
          return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'name' => $data['first_name'].' '.$data['last_name'],
            'email' => $data['email'],
            'role_id' => $data['role'],
            'password' => Hash::make($data['password']),
            'company_name' => $data['company_name'],
            'slug' => str_replace(" ","_",$data['company_name']),
             'group_type' => $data['group_type'],

          ]);
    }

    /**
     * Logout the admin.
     *
     * @return \Illuminate\Http\RedirectResponse
     */

    public function signOut() {
        if (Auth::user()->role_id == 1) {
            Session::flush();
            Auth::logout();
            return Redirect('super-admin-login');
        } else if (Auth::user()->role_id == 2) {
            Session::flush();
            Auth::logout();
            return Redirect('admin-login');
        } else {
            Session::flush();
            Auth::logout();
            return Redirect('user-login');
        }

    }

    /**
     * Validate the form data.
     *
     * @param \Illuminate\Http\Request $request
     * @return
     */
    private function validator(Request $request)
    {
        //validation rules.
        $rules = [
            'email'    => 'required|email|exists:users|min:5|max:191',
            'password' => 'required|string|min:4|max:255',
        ];

        //custom validation error messages.
        $messages = [
            'email.exists' => 'These credentials do not match our records.',
        ];

        //validate the request.
        $request->validate($rules, $messages);
    }

    /**
     * Redirect back after a failed login.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function loginFailed()
    {
        return back()->withErrors(['These credentials do not match our records.']);
        return redirect()
            ->route('login')
            ->withInput()
            ->with('error', 'Login failed, please try again!');
    }
}
