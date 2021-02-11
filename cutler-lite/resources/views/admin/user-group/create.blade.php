@extends('admin.parent')

@section('title', trans('translation.general.user-group.user-groups'))

@section('sidebar')
    @include('admin.partials.sidebar', ['active' => 'user.index'])
@endsection

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>{{ trans('translation.general.user-group.user-groups') }}</h1>
                </div>
            </div>
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="{{ route('dashboard') }}">{{ trans('translation.admin.dashboard') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span class="active">{{ trans('translation.general.user-group.user-groups') }}</span>
                </li>
            </ul>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="fa fa-plus font-red-sunglo"></i>
                                <span class="caption-subject bold uppercase">{{ trans('translation.general.user-group-create.add-group') }}</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            {!! Form::open(['route' => 'user-group.store']) !!}
                            @csrf
                            <div class="form-horizontal">
                                <div class="form-body">
                                    <input type="hidden" name="parent_id" value="{{ $parent_id }}" />
                                    <div class="form-group @if($errors->has('name')) has-error @endif">
                                        <label>{!! Form::label('name', trans('translation.general.user-group-create.name'), ['class' => 'col-md-2 control-label'])  !!}</label>
                                        <div class="col-md-12">
                                            {!! Form::text('name', null, ['class' => 'form-control', 'required' => true]) !!}
                                            @if($errors->has('name'))
                                                <label class="control-label">{{ $errors->first('name') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                       <h4> {!! Form::label('name', trans('translation.general.user-group-create.permissions'), ['class' => 'col-md-2 '])  !!}</h4>

                                        <div class="col-md-12">
                                        <hr>
                                        <div class="row">

                                            @foreach($permissions as $groupName => $permissions)
                                            <div class="col-md-12">
                                               <label><strong>"{{ $groupName }}" {{ trans('translation.general.user-group-create.module-permissions') }}</strong></label>
                                                <div style="margin-top:20px;">
                                                    @foreach($permissions as $permission)
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                {!! Form::checkbox('permissions[]', $permission['code'], false, ['id' => $permission['code']])!!}
                                                                <label for="{{ $permission['code'] }}">{{ $permission['name'] }}</label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                </div>
                                                <div class="col-md-12"><hr /></div>
                                            @endforeach

</div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn blue"><i class="fa fa-floppy-o"></i>{{ trans('translation.general.save') }}</button>
                                            <a href="{{ route('user-group.index') }}" class="btn default"><i class="fa fa-reply"></i>{{ trans('translation.general.cancel') }}</a>
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
