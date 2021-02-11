<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePolicyRequest;
use App\Http\Requests\UpdatePolicyRequest;
use App\Models\Policy;
use App\Models\Process;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class PoliciesController extends Controller
{
    public function __construct()
    {
        $this->page['title'] = 'Policies';
        $this->page['sub_title'] = '';
    }

    public function index(Request $request)
    {
        $policies = Policy::orderBy('id', 'DESC')->with(['startedProcesses'])->get();
        return view('admin.policies.index', compact('policies'))->with('page', $this->page);
    }

    public function create(Request $request)
    {
        $this->page['sub_title'] = 'Add New Polıcy';
        return view('admin.policies.create')->with('page', $this->page);
    }

    public function store(CreatePolicyRequest $request)
    {
        $data = $request->validated();
        if (!empty($data['image'])){
            if (! File::exists(public_path("uploads/policy/"))) {
                File::makeDirectory(public_path("uploads/policy/"), '0755', true);
            }

            $data['image'] = date("Ymd-His").'-'.rand(1111,9999).'.'.$request->image->extension();
            $request->image->move(public_path('uploads/policy'), $data['image']);
        }else{
            $data['image'] = null;
        }

        $policy = new Policy();
        $policy->user_id = Auth::user()->id;
        $policy->user_group_id = Auth::user()->group->id;
        $policy->name = $data['name'];
        $policy->feature = $data['feature'];
        $policy->goal = $data['goal'];
        $policy->action = $data['action'];
        $policy->impact = $data['impact'];
        $policy->image = $data['image'];
        $policy->save();
        session_success(trans('translation.general.policy-added'));
        return redirect()->route('policy.index');
    }

    public function edit(Request $request, $policyId)
    {
        $userList = User::pluck('name', 'id');
        $this->page['sub_title'] = 'Edit Policy';
        $policy = Policy::find($policyId);
        return view('admin.policies.edit', compact('policy', 'userList'))->with('page', $this->page);
    }

    public function update(UpdatePolicyRequest $request, $policyId)
    {
        if (! File::exists(public_path("uploads/policy/"))) {
            File::makeDirectory(public_path("uploads/policy/"), '0755', true);
        }

        $policy = Policy::find($policyId);
        $data = $request->validated();
        $policy->user_id = $data['user_id'];
        $policy->user_group_id = Auth::user()->group->id;
        $policy->name = $data['name'];
        $policy->feature = $data['feature'];
        $policy->goal = $data['goal'];
        $policy->action = $data['action'];
        $policy->impact = $data['impact'];

        if($request->hasFile('image')){
            if($policy->image!=''){
                @unlink(public_path('uploads/policy/').$policy->image);
            }

            $data['image'] = date("Ymd-His").'-'.rand(1111,9999).'.'.$request->image->extension();
            $request->image->move(public_path('uploads/policy'), $data['image']);

            $policy->image = $data['image'];
        }

        $policy->save();
        session_success(trans('translation.general.policy-updated'));
        return redirect()->route('policy.index');
    }

    public function destroy($policyId)
    {
        Policy::find($policyId)->delete();
        session_success(trans('translation.general.policy-deleted'));
        return redirect()->route('policy.index');
    }

    public function goToProcess(Request $request, $policyId, $policyName)
    {
        sleep(1);
        Session::put('policyId', $policyId);
        Session::put('policyName', $policyName);
        $processes = Process::wherePolicyId($policyId)->whereUserId(Auth::user()->id)->orderBy('created_at', 'DESC')->get();
        return view('admin.policies.process', compact('processes'))->with(['page' =>  $this->page, 'policyId' => $policyId, 'policyName' => $policyName]);
    }
}
