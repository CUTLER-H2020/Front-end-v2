@extends('admin.parent')

@section('title', trans('translation.general.change-password'))

@section('sidebar')
    @include('admin.partials.sidebar', ['active' => 'user.index'])
@endsection

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>{{ trans('translation.general.change-password') }}</h1>
                </div>
            </div>
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="{{ route('dashboard') }}">{{ trans('translation.admin.dashboard') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span class="active">{{ trans('translation.general.change-password') }}</span>
                </li>
            </ul>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="fa fa-plus font-red-sunglo"></i>
                                <span class="caption-subject bold uppercase">{{ trans('translation.general.change-password') }}</span>
                            </div>
                        </div>
                        @if(Session::has('success_message'))
                            <div class="alert alert-success">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                <strong>{{ trans('general.success') }}</strong> {!! Session::get('success_message') !!}
                            </div>
                        @endif
                        <div class="portlet-body form">
                            {!! Form::open(['route' => 'change-password-update']) !!}
                            @csrf
                            <div class="form-horizontal">
                                <div class="form-body">
                                <div class="row">
                                    <div class="form-group col-md-12 @if($errors->has('name')) has-error @endif">
                                        {!! Form::label('old_password',  trans('translation.general.password.old-password'), ['class' => 'col-md-2 '])  !!}
                                        <div class="col-md-12">
                                            {!! Form::password('old_password', ['class' => 'form-control']) !!}
                                            @if($errors->has('old_password'))
                                                <label class="control-label">{{ $errors->first('old_password') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 @if($errors->has('name')) has-error @endif">
                                        {!! Form::label('new_password', trans('translation.general.password.new-password'), ['class' => 'col-md-2 '])  !!}
                                        <div class="col-md-12">
                                            {!! Form::password('new_password', ['id' => 'new_password', 'class' => 'form-control']) !!}
                                            @if($errors->has('new_password'))
                                                <label class="control-label">{{ $errors->first('new_password') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 @if($errors->has('name')) has-error @endif">
                                        {!! Form::label('new_password_confirm', trans('translation.general.password.re-password'), ['class' => 'col-md-2 '])  !!}
                                        <div class="col-md-12">
                                            {!! Form::password('new_password_confirm', ['id' => 'new_password_confirm', 'class' => 'form-control']) !!}
                                            @if($errors->has('new_password_confirm'))
                                                <label class="control-label">{{ $errors->first('new_password_confirm') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn blue"><i class="fa fa-floppy-o"></i>{{ trans('translation.general.save') }}</button>
                                        <a href="{{route('user.index')}}" class="btn default"><i class="fa fa-reply"></i>{{ trans('translation.general.cancel') }}</a>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
