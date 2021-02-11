@extends('admin.parent')

@section('title', trans('translation.general.user-group.user-groups'))

@section('sidebar')
    @include('admin.partials.sidebar', ['active' => 'user.group.index'])
@endsection

@section('content')
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEAD-->
            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>{{ trans('translation.general.user-group.user-groups') }}</h1>
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
                    <span class="active">{{ trans('translation.general.user-group.user-groups') }}</span>
                </li>
            </ul>
            <a href="{{ route('user-group.create', ['parent_id' => $parent_id]) }}" class="btn btn-primary" style="margin-bottom: 5px"><i class="fa fa-plus"></i>{{ trans('translation.general.add-group', ['button' => 'Group']) }}</a>
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
                                <i class="fa fa-users"></i>{{ trans('translation.general.user-group.user-groups') }}
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th> {{ trans('translation.general.user-group.group-name') }} </th>
                                        <th width="21%"> {{ trans('translation.general.user-group.transactions') }} </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if($userGroups->count() > 0)
                                            @foreach($userGroups as $userGroup)
                                                <tr>
                                                    <td> {{ $userGroup->name }} </td>
                                                    <td>
                                                        <a type="button" href="{{ route('user-group.edit', $userGroup->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i> {{ trans('translation.general.edit') }}</a>
                                                        @if($subGroups == false)
                                                        <a type="button" href="{{ route('user-group.subIndex', $userGroup->id) }}" class="btn btn-success"><i class="fa fa-pencil"></i> {{ trans('translation.admin.user-groups.sub-groups') }}</a>
                                                        @endif
                                                        <a type="button" href="{{ route('user-group.destroy', $userGroup->id) }}" class="btn btn-danger delete-button"><i class="fa fa-trash"></i> {{ trans('translation.general.delete') }}</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="2" class="text-center">{{ trans('translation.general.user-group.group-not-found') }}</td>
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
