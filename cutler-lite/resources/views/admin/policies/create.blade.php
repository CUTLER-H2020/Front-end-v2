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
                    <h1>{{ trans('translation.general.policies.policies') }}</h1>
                </div>
            </div>
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="{{ route('dashboard') }}">{{ trans('translation.admin.dashboard') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ route('policy.index') }}">{{ trans('translation.general.policy-create.policies') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span class="active">{{ trans('translation.general.policies.policies') }}</span>
                </li>
            </ul>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="fa fa-plus font-red-sunglo"></i>
                                <span
                                    class="caption-subject bold uppercase">{{ trans('translation.general.policies.add-new-policy') }}</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            {!! Form::open(['route' => 'policy.store', 'files' => true]) !!}
                            @csrf
                            <div class="form-horizontal">
                                <div class="form-body">

                                    <div class="row">
                                        <div class="form-group col-md-6 @if($errors->has('name')) has-error @endif">
                                            {!! Form::label('name', trans('translation.general.policy-create.policies'), ['class' => 'col-md-12'])  !!}
                                            <div class="col-md-12">
                                                {!! Form::text('name', null, ['id' => 'shared_price', 'class' => 'form-control']) !!}
                                                @if($errors->has('name'))
                                                    <label class="control-label">{{ $errors->first('name') }}</label>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6 @if($errors->has('feature')) has-error @endif">
                                            {!! Form::label('feature', trans('translation.general.policy-create.feature'), ['class' => 'col-md-12'])  !!}
                                            <div class="col-md-12">
                                                {!! Form::textarea('feature', null, ['id' => '', 'class' => 'form-control', 'style' => 'resize:none', 'cols' => '30', 'rows' => '3'])!!}
                                                @if($errors->has('feature'))
                                                    <label class="control-label">{{ $errors->first('feature') }}</label>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6 @if($errors->has('goal')) has-error @endif">
                                            {!! Form::label('goal', trans('translation.general.policy-create.goal'), ['class' => 'col-md-12'])  !!}
                                            <div class="col-md-12">
                                                {!! Form::textarea('goal', null, ['id' => '', 'class' => 'form-control', 'style' => 'resize:none', 'cols' => '30', 'rows' => '3'])!!}
                                                @if($errors->has('goal'))
                                                    <label class="control-label">{{ $errors->first('goal') }}</label>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6 @if($errors->has('action')) has-error @endif">
                                            {!! Form::label('action', trans('translation.general.policy-create.action'), ['class' => 'col-md-12'])  !!}
                                            <div class="col-md-12">
                                                {!! Form::textarea('action', null, ['id' => '', 'class' => 'form-control', 'style' => 'resize:none', 'cols' => '30', 'rows' => '3'])!!}
                                                @if($errors->has('action'))
                                                    <label class="control-label">{{ $errors->first('action') }}</label>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6 @if($errors->has('impact')) has-error @endif">
                                            {!! Form::label('impact', trans('translation.general.policy-create.impact'), ['class' => 'col-md-12'])  !!}
                                            <div class="col-md-12">
                                                {!! Form::textarea('impact', null, ['id' => '', 'class' => 'form-control', 'style' => 'resize:none', 'cols' => '30', 'rows' => '3'])!!}
                                                @if($errors->has('impact'))
                                                    <label class="control-label">{{ $errors->first('impact') }}</label>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6 @if($errors->has('image')) has-error @endif">
                                            {!! Form::label('image', trans('translation.general.policies.image'), ['class' => 'col-md-12'])  !!}
                                            <div class="col-md-12">
                                                <input type="file" name="image" accept="image/*" />
                                                @if($errors->has('image'))
                                                    <label class="control-label">{{ $errors->first('image') }}</label>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn blue"><i
                                                    class="fa fa-floppy-o"></i> {{ trans('translation.general.save') }}</button>
                                            <a href="{{route('policy.index')}}" class="btn default"><i
                                                    class="fa fa-reply"></i> {{ trans('translation.general.cancel') }}</a>
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
