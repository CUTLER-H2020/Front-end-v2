@extends('admin.parent')

@section('title', trans('translation.general.user.users'))

@section('sidebar')
    @include('admin.partials.sidebar', ['active' => 'user.index'])
@endsection

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>{{ trans('translation.general.user.users') }}</h1>
                </div>
            </div>
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="{{ route('dashboard') }}">{{ trans('translation.admin.dashboard') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span class="active">{{ trans('translation.general.user.users') }}</span>
                </li>
            </ul>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="fa fa-plus font-red-sunglo"></i>
                                <span class="caption-subject bold uppercase">{{ trans('translation.general.user-create.user-create') }}</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            {!! Form::open(['route' => 'user.store']) !!}
                            @csrf
                            <div class="form-horizontal">
                                <div class="form-body">
                                <div class="row">
                                    <div class="form-group col-md-6 @if($errors->has('name')) has-error @endif">
                                        {!! Form::label('name', trans('translation.general.user-create.name'), ['class' => 'col-md-2 '])  !!}
                                        <div class="col-md-12">
                                            {!! Form::text('name', null, ['id' => 'shared_price', 'class' => 'form-control']) !!}
                                            @if($errors->has('name'))
                                                <label class="control-label">{{ $errors->first('name') }}</label>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 @if($errors->has('surname')) has-error @endif">
                                        {!! Form::label('surname', trans('translation.general.user-create.surname'), ['class' => 'col-md-2 '])  !!}
                                        <div class="col-md-12">
                                            {!! Form::text('surname', null, ['id' => 'shared_price', 'class' => 'form-control']) !!}
                                            @if($errors->has('surname'))
                                                <label class="control-label">{{ $errors->first('surname') }}</label>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 @if($errors->has('email')) has-error @endif">
                                        {!! Form::label('email', trans('translation.general.user-create.email'), ['class' => 'col-md-2 '])  !!}
                                        <div class="col-md-12">
                                            {!! Form::text('email', null, ['id' => 'shared_price', 'class' => 'form-control']) !!}
                                            @if($errors->has('email'))
                                                <label class="control-label">{{ $errors->first('email') }}</label>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 @if($errors->has('password')) has-error @endif">
                                        {!! Form::label('password', trans('translation.general.user-create.password'), ['class' => 'col-md-2 '])  !!}
                                        <div class="col-md-12">
                                            {!! Form::password('password', ['id' => 'shared_price', 'class' => 'form-control']) !!}
                                            @if($errors->has('password'))
                                                <label class="control-label">{{ $errors->first('password') }}</label>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 @if($errors->has('group_id')) has-error @endif">
                                        {!! Form::label('group_id', trans('translation.general.user-create.group'), ['class' => 'col-md-2 '])  !!}
                                        <div class="col-md-12">
                                            {!! Form::select('group_id', $userGroups, null, ['class' => 'form-control']) !!}
                                            @if($errors->has('group_id'))
                                                <label class="control-label">{{ $errors->first('group_id') }}</label>
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
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
