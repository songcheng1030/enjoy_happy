<?php

namespace App\Http\Controllers\Web\Dashboard\Groupmaster;

use App\Http\Controllers\Controller;
use App\Http\DataProviders\Web\Dashboard\Groupmaster\IndexDataProvider;
use App\Http\Requests\Web\Dashboard\Groupmaster\EditRequest;
use App\Http\Requests\Web\Dashboard\Groupmaster\IndexRequest;
use App\Http\Requests\Web\Dashboard\Groupmaster\CreateRequest;
use App\Http\Requests\Web\Dashboard\Groupmaster\StoreRequest;
use App\Http\Requests\Web\Dashboard\Groupmaster\UpdateRequest;
use App\Http\Requests\Web\Dashboard\Groupmaster\DestroyRequest;
use Illuminate\Http\Request; 
use App\Models\Groupmaster;
use Session;
use App\Models\GroupUser;
use Auth;

class GroupMasterController extends Controller
{

    public function index(Request $request, IndexDataProvider $provider)
    {  
        if (Auth::user()->role_id != 1) {
            echo "<h1>ERROR - You are not authorized to be here</h1>";
            exit;
        }
        $search = $request->query('search');

    	return view('dashboard.pages.groupmaster.index',$provider->meta($search));
    }
    public function create(CreateRequest $request)
    {
        return view('dashboard.pages.groupmaster.create', $request->getAdmin());
    } 

    public function store(StoreRequest $request)
    {
    	if ($request->persist()->getGroup()) {
            flashWebResponse('created', 'Group');
            return redirect()->route('group');
        }
        flashWebResponse('error');
        return redirect()->back();
    }

    public function showGroupUsers($groupId)
    {
        $results = GroupUser::where('group_id', $groupId)->get();
        //return $results;
        if (Session::get('groupId')) {
            Session::forget('groupId');
        }
    	return view('dashboard.pages.groupmaster.group-member-list', ['results' => $results]);
    }
    
    public function edit(EditRequest $request,$id)
    {   
        if (Auth::user()->role_id != 1) {
            echo "<h1>ERROR - You are not authorized to be here</h1>";
            exit;
        }
        return view('dashboard.pages.groupmaster.edit',$request->getData());
    }

    public function update(UpdateRequest $request, Groupmaster $group)
    {   
        if ($update = $request->persist()->getGroup()) {
            flashWebResponse('updated', 'Group');
            return redirect()->route('group-edit', $update->id);
        }
        flashWebResponse('error');
        return redirect()->back();
    }

    public function destroy(DestroyRequest $request, Groupmaster $group)
    {
        if (request()->ajax()) {
            flashWebResponse('trashed', 'Group');
            return ($request->persist()->getMsg()) ? trashedWebResponse('level') : errorWebResponse();
        }
        return httpWebResponse();
    }
}
