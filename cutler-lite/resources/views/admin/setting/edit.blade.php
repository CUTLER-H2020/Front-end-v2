@extends('admin.parent')

@section('title', trans('translation.general.settings.settings'))

@section('sidebar')
    @include('admin.partials.sidebar', ['active' => 'user.index'])
@endsection

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>{{ trans('translation.general.settings.settings') }}</h1>
                </div>
            </div>
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="{{ route('dashboard') }}">{{ trans('translation.admin.dashboard') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span class="active">{{ trans('translation.general.settings.settings') }}</span>
                </li>
            </ul>


            <div class="row">
                <div class="col-md-12">
                    @if(Session::has('success_message'))
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            <strong>{{ trans('translation.general.success') }}</strong> {!! Session::get('success_message') !!}
                        </div>
                    @endif
                {!! Form::open(['route' => ['settings.update', $setting->id], 'files' => true]) !!}
                @csrf
                <!--Start -->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="fa fa-plus font-red-sunglo"></i>
                                <span
                                    class="caption-subject bold uppercase">{{ trans('translation.general.settings.kibana-settings') }}</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="form-horizontal">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label class="col-md-12"> {{ trans('translation.general.settings.ip') }}</label>
                                                <div class="col-md-12">
                                                    {!! Form::text('kibana_ip', $setting->kibana_ip, ['id' => 'shared_price', 'class' => 'form-control', 'required']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="col-md-12"> {{ trans('translation.general.settings.port') }}</label>
                                                <div class="col-md-12">
                                                    {!! Form::text('kibana_port', $setting->kibana_port, ['id' => 'shared_price', 'class' => 'form-control', 'required']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label
                                                    class="col-md-12">{{ trans('translation.general.settings.username') }}</label>
                                                <div class="col-md-12">
                                                    {!! Form::text('kibana_username', $setting->kibana_username, ['id' => 'shared_price', 'class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-12">{{ trans('translation.general.settings.pass') }}</label>
                                                <div class="col-md-12">
                                                    {!! Form::text('kibana_pass', $setting->kibana_pass, ['id' => 'shared_price', 'class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-12"> {{ trans('translation.general.settings.kibana_widget_url') }}</label>
                                                <div class="col-md-12">
                                                    {!! Form::text('kibana_widget_url', $setting->kibana_widget_url, ['id' => 'kibana_widget_url', 'class' => 'form-control', 'required']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-12"> {{ trans('translation.general.settings.kibana_preview_url') }}</label>
                                                <div class="col-md-12">
                                                    {!! Form::text('kibana_preview_url', $setting->kibana_preview_url, ['id' => 'kibana_preview_url', 'class' => 'form-control', 'required']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn blue"><i
                                                    class="fa fa-refresh"></i> {{ trans('translation.general.update') }}
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End-->
                    <!--Start -->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="fa fa-plus font-red-sunglo"></i>
                                <span
                                    class="caption-subject bold uppercase">{{ trans('translation.general.settings.kafka-settings') }}</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="form-horizontal">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label
                                                    class="col-md-12"> {{ trans('translation.general.settings.ip') }}</label>
                                                <div class="col-md-12">
                                                    {!! Form::text('kafka_ip', $setting->kafka_ip, ['id' => 'shared_price', 'class' => 'form-control', 'required']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label
                                                    class="col-md-12"> {{ trans('translation.general.settings.port') }}</label>
                                                <div class="col-md-12">
                                                    {!! Form::text('kafka_port', $setting->kafka_port, ['id' => 'shared_price', 'class' => 'form-control', 'required']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label
                                                    class="col-md-12"> {{ trans('translation.general.settings.topic') }}</label>
                                                <div class="col-md-12">
                                                    {!! Form::text('kafka_topic', $setting->kafka_topic, ['id' => 'shared_price', 'class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn blue"><i
                                                    class="fa fa-refresh"></i> {{ trans('translation.general.update') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End-->

                    <!-- Start -->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="fa fa-plus font-red-sunglo"></i>
                                <span
                                    class="caption-subject bold uppercase">{{ trans('translation.general.settings.camunda-settings') }}</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="form-horizontal">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label
                                                    class="col-md-12"> {{ trans('translation.general.settings.ip') }}</label>
                                                <div class="col-md-12">
                                                    {!! Form::text('camunda_ip', $setting->camunda_ip, ['id' => 'shared_price', 'class' => 'form-control', 'required']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label
                                                    class="col-md-12"> {{ trans('translation.general.settings.port') }}</label>
                                                <div class="col-md-12">
                                                    {!! Form::text('camunda_port', $setting->camunda_port, ['id' => 'shared_price', 'class' => 'form-control', 'required']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn blue"><i
                                                    class="fa fa-refresh"></i> {{ trans('translation.general.update') }}
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- End -->


                    <!-- Start -->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="fa fa-plus font-red-sunglo"></i>
                                <span
                                    class="caption-subject bold uppercase">Lınk Settıngs</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="form-horizontal">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label
                                                    class="col-md-12">Title for 1</label>
                                                <div class="col-md-12">
                                                    {!! Form::text('link_title_1', $setting->link_title_1, ['id' => 'shared_price', 'class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label
                                                    class="col-md-12">Link 1</label>
                                                <div class="col-md-12">
                                                    {!! Form::text('link_1', $setting->link_1, ['id' => 'shared_price', 'class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label
                                                    class="col-md-12">Title for 2</label>
                                                <div class="col-md-12">
                                                    {!! Form::text('link_title_2', $setting->link_title_2, ['id' => 'shared_price', 'class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label
                                                    class="col-md-12">Link 2</label>
                                                <div class="col-md-12">
                                                    {!! Form::text('link_2', $setting->link_2, ['id' => 'shared_price', 'class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label
                                                    class="col-md-12">Title for 3</label>
                                                <div class="col-md-12">
                                                    {!! Form::text('link_title_3', $setting->link_title_3, ['id' => 'shared_price', 'class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label
                                                    class="col-md-12">Link 3</label>
                                                <div class="col-md-12">
                                                    {!! Form::text('link_3', $setting->link_3, ['id' => 'shared_price', 'class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn blue"><i
                                                    class="fa fa-refresh"></i> {{ trans('translation.general.update') }}
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- End -->

                    <!-- Start -->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="fa fa-plus font-red-sunglo"></i>
                                <span
                                    class="caption-subject bold uppercase">{{ trans('translation.general.settings.smtp-settings') }}</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="form-horizontal">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label
                                                    class="col-md-12">{{ trans('translation.general.settings.smtp-server-name') }}</label>
                                                <div class="col-md-12">
                                                    {!! Form::text('smtp_server_name', $setting->smtp_server_name, ['id' => 'shared_price', 'class' => 'form-control', 'required']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label
                                                    class="col-md-12">{{ trans('translation.general.settings.smtp-port-number') }}</label>
                                                <div class="col-md-12">
                                                    {!! Form::text('smtp_port_number', $setting->smtp_port_number, ['id' => 'shared_price', 'class' => 'form-control', 'required']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label
                                                    class="col-md-12">{{ trans('translation.general.settings.smtp-user-name') }}</label>
                                                <div class="col-md-12">
                                                    {!! Form::text('smtp_username', $setting->smtp_username, ['id' => 'shared_price', 'class' => 'form-control', 'required']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label
                                                    class="col-md-12">{{ trans('translation.general.settings.smtp-pass') }}</label>
                                                <div class="col-md-12">
                                                    {!! Form::text('smtp_pass', $setting->smtp_pass, ['id' => 'shared_price', 'class' => 'form-control', 'required']) !!}
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn blue"><i
                                                    class="fa fa-refresh"></i> {{ trans('translation.general.update') }}
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End -->

                    <!-- Start -->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="fa fa-plus font-red-sunglo"></i>
                                <span
                                    class="caption-subject bold uppercase">{{ trans('translation.general.settings.general-settings') }}</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="form-horizontal">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if($setting->login_bg!='')
                                                <label>{{ trans('translation.general.settings.current-login-background-image') }}</label><br />
                                                <img src="{{ asset('uploads/settings/'.$setting->login_bg) }}"
                                                     style="height: 100px;"/>
                                            @endif
                                            <div
                                                class="form-group @if($errors->has('image')) has-error @endif">
                                                {!! Form::label('image', trans('translation.general.settings.login-background-image'), ['class' => 'col-md-12'])  !!}
                                                <div class="col-md-12">
                                                    <input type="file" name="login_bg" accept="image/*"/>
                                                    @if($errors->has('login_bg'))
                                                        <label
                                                            class="control-label">{{ $errors->first('login_bg') }}</label>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn blue"><i
                                                    class="fa fa-refresh"></i> {{ trans('translation.general.update') }}
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End -->

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
