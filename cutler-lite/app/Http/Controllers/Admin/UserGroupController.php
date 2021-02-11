<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserGroupRequest;
use App\Http\Requests\UpdateUserGroupRequest;
use App\Models\Permission;
use App\Models\Setting;
use App\Models\UserGroup;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class UserGroupController extends Controller
{
    private $client;
    private $settings;
    private $camundaSource;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->settings = Setting::find(1);
        $this->camundaSource = $this->settings->camunda_ip.':'.$this->settings->camunda_port;
        $this->page['title'] = trans('admin.user-groups.user-groups');
        $this->page['sub_title'] = '';
    }

    public function index($parent_id = 0)
    {
        $page = $this->page;

        if ($parent_id == 0){
            $userGroups = UserGroup::whereParentId($parent_id)->get();
            $subGroups = false;
        }else{
            $userGroups = UserGroup::whereParentId($parent_id)->get();
            $subGroups = true;
        }
        return view('admin.user-group.index', compact('page', 'userGroups', 'subGroups', 'parent_id'));
    }

    public function create($parent_id)
    {
        $this->page['sub_title'] = 'Add Group';
        $page = $this->page;
        $permissions = Permission::all();
        $permissions = $permissions->groupBy('group')->toArray();
        return view('admin.user-group.create', compact('page', 'permissions', 'parent_id'));
    }

    public function store(CreateUserGroupRequest $request)
    {
        $data = $request->validated();
        $userGroup = new UserGroup();
        $userGroup->parent_id = $data['parent_id'];
        $userGroup->name = $data['name'];
        if (isset($request->permissions)){
            $userGroupPermissions = [];
            foreach ($request->permissions as $permission){
                array_push($userGroupPermissions, $permission);
            }
            $userGroup->permissions = $userGroupPermissions;
        }else{
            $userGroup->permissions = [];
        }
        $userGroup->save();

        $options = [
            'json' => [
                'id' => $userGroup->id,
                'name' => $userGroup->name,
                'type' => 'Sampaş Cutler'
            ]
        ];
        $this->client->request('POST',$this->camundaSource . '/engine-rest/group/create', $options);

        session_success(trans('translation.general.user-group-added'));
        return redirect()->route('user-group.index');
    }

    public function show($id)
    {
        //
    }

    public function edit(Request $request, $userGroupId)
    {
        $userGroup = UserGroup::find($userGroupId);
        $this->page['sub_title'] = $userGroup->name. ' Edit';
        $page = $this->page;
        $permissions = Permission::orderBy('name', 'ASC')->get();
        $permissions = $permissions->groupBy('group')->toArray();
        return view('admin.user-group.edit', compact('page', 'userGroup', 'permissions'));
    }

    public function update(UpdateUserGroupRequest $request, $userGroupId)
    {
        $userGroup = UserGroup::find($userGroupId);
        $data = $request->validated();
        $userGroup->name = $data['name'];
        $userGroup->parent_id = $data['parent_id'];
        if (isset($request->permissions)){
            $userGroupPermissions = [];
            foreach ($request->permissions as $permission){
                array_push($userGroupPermissions, $permission);
            }
            $userGroup->permissions = $userGroupPermissions;
        }else{
            $userGroup->permissions = [];
        }
        $userGroup->save();
        $options = [
            'json' => [
                'id' => $userGroup->id,
                'name' => $userGroup->name,
                'type' => 'Sampaş Cutler'
            ]
        ];
        $this->client->request('PUT',$this->camundaSource . '/engine-rest/group/'.$userGroupId, $options);
        session_success(trans('translation.general.user-group-updated'));
        return redirect()->route('user-group.index');
    }

    public function destroy(Request $request, $userGroupId)
    {
        UserGroup::find($userGroupId)->delete();
        session_success(trans('translation.general.user-group-deleted'));
        return redirect()->route('user-group.index');
    }
}
