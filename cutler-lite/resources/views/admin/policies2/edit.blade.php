@extends('admin.parent')

@section('title', trans('translation.general.policies.policies'))

@section('sidebar')
    @include('admin.partials.sidebar', ['active' => 'user.index'])
@endsection

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>{!! $page['title'] !!}</h1>
                </div>
            </div>
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="{{ route('dashboard') }}">{{ trans('translation.admin.dashboard') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ route('policy.index') }}">{{ trans('translation.general.policy-edit.policies') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span class="active">{!! $page['sub_title'] !!}</span>
                </li>
            </ul>
            <div class="row">
                <div class="col-md-5 col-md-offset-2">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="fa fa-plus font-red-sunglo"></i>
                                <span class="caption-subject bold uppercase">{{ $page['sub_title'] }}</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            {!! Form::open(['route' => ['policy.update', $policy->id]]) !!}
                            @csrf
                            <div class="form-horizontal">
                                <div class="form-body">
                                    <div class="form-group @if($errors->has('name')) has-error @endif">
                                        {!! Form::label('name', trans('translation.general.policy-edit.name'), ['class' => 'col-md-2 control-label'])  !!}
                                        <div class="col-md-10">
                                            {!! Form::text('name', $policy->name, ['id' => 'shared_price', 'class' => 'form-control']) !!}
                                            @if($errors->has('name'))
                                                <label class="control-label">{{ $errors->first('name') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group @if($errors->has('feature')) has-error @endif">
                                        {!! Form::label('feature', trans('translation.general.policy-edit.feature'), ['class' => 'col-md-2 control-label'])  !!}
                                        <div class="col-md-10">
                                            {!! Form::textarea('feature', $policy->feature, ['id' => '', 'class' => 'form-control', 'style' => 'resize:none', 'cols' => '30', 'rows' => '3'])!!}
                                            @if($errors->has('feature'))
                                                <label class="control-label">{{ $errors->first('feature') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group @if($errors->has('goal')) has-error @endif">
                                        {!! Form::label('goal', trans('translation.general.policy-edit.goal'), ['class' => 'col-md-2 control-label'])  !!}
                                        <div class="col-md-10">
                                            {!! Form::textarea('goal', $policy->goal, ['id' => '', 'class' => 'form-control', 'style' => 'resize:none', 'cols' => '30', 'rows' => '3'])!!}
                                            @if($errors->has('goal'))
                                                <label class="control-label">{{ $errors->first('goal') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group @if($errors->has('action')) has-error @endif">
                                        {!! Form::label('action', trans('translation.general.policy-edit.action'), ['class' => 'col-md-2 control-label'])  !!}
                                        <div class="col-md-10">
                                            {!! Form::textarea('action', $policy->action, ['id' => '', 'class' => 'form-control', 'style' => 'resize:none', 'cols' => '30', 'rows' => '3'])!!}
                                            @if($errors->has('action'))
                                                <label class="control-label">{{ $errors->first('action') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group @if($errors->has('impact')) has-error @endif"">
                                        {!! Form::label('impact', trans('translation.general.policy-edit.impact'), ['class' => 'col-md-2 control-label'])  !!}
                                        <div class="col-md-10">
                                            {!! Form::textarea('impact', $policy->impact, ['id' => '', 'class' => 'form-control', 'style' => 'resize:none', 'cols' => '30', 'rows' => '3'])!!}
                                            @if($errors->has('impact'))
                                                <label class="control-label">{{ $errors->first('impact') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-md-10">
                                            <button type="submit" class="btn blue"><i class="fa fa-refresh"></i> {{ trans('translation.general.update') }}</button>
                                            <a href="{{ route('policy.index') }}" class="btn default"><i class="fa fa-reply"></i> {{ trans('translation.general.cancel') }}</a>
                                        </div>
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
