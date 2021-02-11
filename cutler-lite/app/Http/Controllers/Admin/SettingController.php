<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->page['title'] = 'Ayarlar';
        $this->page['sub_title'] = '';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit(Request $request)
    {
//        newAnalytics($request);
        $setting = Setting::find(1);
        $this->page['sub_title'] = 'Ayar Düzenle';
        return view('admin.setting.edit',compact('setting'))->with('page', $this->page);
    }


    public function update(Request $request)
    {
        if (! File::exists(public_path("uploads/settings/"))) {
            File::makeDirectory(public_path("uploads/settings/"), '0755', true);
        }

        $setting = Setting::find(1);
        $setting->kibana_ip = $request->kibana_ip;
        $setting->kibana_port = $request->kibana_port;
        $setting->kibana_username = $request->kibana_username;
        $setting->kibana_pass = $request->kibana_pass;
        $setting->kibana_widget_url = $request->kibana_widget_url;
        $setting->kibana_preview_url = $request->kibana_preview_url;
        $setting->kafka_ip = $request->kafka_ip;
        $setting->kafka_port = $request->kafka_port;
        $setting->kafka_topic = $request->kafka_topic;
        $setting->camunda_ip = $request->camunda_ip;
        $setting->camunda_port = $request->camunda_port;
        $setting->link_title_1 = $request->link_title_1;
        $setting->link_1 = $request->link_1;
        $setting->link_title_2 = $request->link_title_2;
        $setting->link_2 = $request->link_2;
        $setting->link_title_3 = $request->link_title_3;
        $setting->link_3 = $request->link_3;
        $setting->smtp_server_name = $request->smtp_server_name;
        $setting->smtp_port_number = $request->smtp_port_number;
        $setting->smtp_username = $request->smtp_username;
        $setting->smtp_pass = $request->smtp_pass;

        if($request->hasFile('login_bg')){
            @unlink('uploads/settings/'.$setting->login_bg);
            $data['image'] = date("Ymd-His").'-'.rand(1111,9999).'.'.$request->login_bg->extension();
            $request->login_bg->move(public_path('uploads/settings'), $data['image']);
            $setting->login_bg = $data['image'];
        }

        $setting->save();
        session_success(trans('translation.general.settings-updated'));
        return redirect()->route('settings.edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
