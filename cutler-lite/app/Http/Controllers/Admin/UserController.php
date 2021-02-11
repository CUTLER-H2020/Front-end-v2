<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Setting;
use App\Models\UserGroup;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $client;
    private $settings;
    private $camundaSource;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->settings = Setting::find(1);
        $this->camundaSource = $this->settings->camunda_ip.':'.$this->settings->camunda_port;
        $this->page['title'] = trans('admin.users.users');
        $this->page['sub_title'] = '';
    }

    public function index(Request $request)
    {
        $page = $this->page;
        $users = User::whereIsPassive(0)->orderBy('created_at', 'DESC')->withCount(['policies'])->get();
        return view('admin.user.index', compact('page', 'users'));
    }

    public function create(Request $request)
    {
        $this->page['sub_title'] = 'Add User';
        $page = $this->page;
        $userGroups = UserGroup::pluck('name', 'id');
        $userGroups = collect(['' => trans('translation.general.user-select')] + $userGroups->all());
        return view('admin.user.create', compact('page', 'userGroups'));
    }

    public function store(CreateUserRequest $request)
    {
        $data = $request->validated();
        $user = User::whereEmail($data['email'])->first();
        if ($user) {
            $user->name = $data['name'];
            $user->surname = $data['surname'];
            $user->password = Hash::make($data['password']);
            $user->group_id = $data['group_id'];
            $user->is_passive = 0;
            $user->save();
        }else{
            $user = new User();
            $user->name = $data['name'];
            $user->surname = $data['surname'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->group_id = $data['group_id'];
            $user->save();

            $options = [
                'profile' => [
                    'id' => $user->id,
                    'firstName' => $user->name,
                    'lastName' => $user->surname,
                    'email' => $user->email,
                ],
                'credentials' => [
                    'password' => $data['password']
                ]
            ];

            // Create a new cURL resource
            $ch = curl_init($this->camundaSource . '/engine-rest/user/create');
            $payload = json_encode($options);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
        }

        //$this->client->request('POST',$this->camundaSource . '/engine-rest/user/create', json_encode($options));

        session_success('User added');
        return redirect()->route('user.index');
    }

    public function show($id)
    {
        //
    }

    public function edit(Request $request, $userID)
    {
        $this->page['sub_title'] = 'User Edit';
        $page = $this->page;
        $userGroups = UserGroup::pluck('name', 'id');
        $userGroups = collect(['' => 'Seçiniz'] + $userGroups->all());
        $user = User::find($userID);
        return view('admin.user.edit', compact('user', 'page', 'userGroups'));
    }

    public function update(UpdateUserRequest $request, $userID)
    {
        $user = User::find($userID);
        $data = $request->validated();
        $user->name = $data['name'];
        $user->surname = $data['surname'];
        $user->email = $data['email'];
        //$user->password = $data['password'];
        $user->group_id = $data['group_id'];
        $user->save();

        $options = [
            'id' => $user->id,
            'firstName' => $user->name,
            'lastName' => $user->surname,
            'email' => $user->email,
        ];

        // Create a new cURL resource
        $ch = curl_init($this->camundaSource . '/engine-rest/user/'.$user->id.'/profile');
        $payload = json_encode($options);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        $result = curl_exec($ch);
        curl_close($ch);

        session_success('User updated');
        return redirect()->route('user.index');
    }

    public function destroy(Request $request, $userID)
    {
        User::whereId($userID)->update(['is_passive' => 1]);
        session_success("User deleted");
        return redirect()->route('user.index');
    }
}
