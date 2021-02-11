@extends('admin.parent')

@section('title', trans('translation.general.user.users'))

@section('sidebar')
    @include('admin.partials.sidebar', ['active' => 'user.index'])
@endsection

@section('content')
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEAD-->
            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>{{ trans('translation.general.user.users') }}</h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>
            <!-- END PAGE HEAD-->
            <!-- BEGIN PAGE BREADCRUMB -->
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="{{ route('dashboard') }}">{{ trans('translation.admin.dashboard') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span class="active">{{ trans('translation.general.user.users') }}</span>
                </li>
            </ul>
            <a href="{{ route('user.create') }}" class="btn btn-primary" style="margin-bottom: 5px"><i class="fa fa-plus"></i>{{ trans('translation.general.add', ['button' => 'User']) }}</a>
            <!-- END PAGE BREADCRUMB -->
            <!-- BEGIN PAGE BASE CONTENT -->
            <div class="row">
                <div class="col-md-12">
                    @if(Session::has('success_message'))
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            <strong>{{ trans('translation.general.success') }}</strong> {!! Session::get('success_message') !!}
                        </div>
                    @endif
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-users"></i>{{ trans('translation.general.user.users') }}
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th> {{ trans('translation.general.user.name-surname') }} </th>
                                        <th> {{ trans('translation.general.user.mail-address') }} </th>
                                        <th> {{ trans('translation.general.user.group') }} </th>
                                        <th width="21%">{{ trans('translation.general.user.transactions') }} </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($users->count() > 0)
                                        @foreach($users as $user)
                                            <tr>
                                                <td> {{ $user->name .' '. $user->surname }}</td>
                                                <td> {{ $user->email }} </td>
                                                <td> {{ $user->group->name ?? '-' }} </td>
                                                <td>
                                                    <a type="button" href="{{ route('user.edit', $user->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i> {{ trans('translation.general.edit') }}</a>
                                                    <span @if($user->policies_count > 0) class="tooltips" data-placement="top" data-original-title="This policy cannot be deleted because it is assigned to a user.Please assign the policy first to an another user." @endif>
                                                        <a type="button" href="{{ route('user.destroy', $user->id) }}" class="btn btn-danger delete-button @if($user->policies_count > 0) disabled @endif"><i class="fa fa-trash"></i> {{ trans('translation.general.delete') }}</a>
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center">{{ trans('translation.general.user.user-not-found') }}</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PAGE BASE CONTENT -->
        </div>
        <!-- END CONTENT BODY -->
    </div>
@endsection
