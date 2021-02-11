@extends('admin.parent')

@section('title', trans('general.documentation'))

@section('content')
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEAD-->
            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>User Manual</h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>
            <!-- END PAGE HEAD-->
            <!-- BEGIN PAGE BREADCRUMB -->
{{--            <ul class="page-breadcrumb breadcrumb">--}}
{{--                <li>--}}
{{--                    <a href="{{ route('dashboard') }}">{{ trans('admin.dashboard') }}</a>--}}
{{--                    <i class="fa fa-circle"></i>--}}
{{--                </li>--}}
{{--                <li>--}}
{{--                    <span class="active">{!! $page['title'] !!}</span>--}}
{{--                </li>--}}
{{--            </ul>--}}
{{--            <a href="{{ route('user.create') }}" class="btn btn-primary" style="margin-bottom: 5px"><i class="fa fa-plus"></i>{{ trans('general.add', ['button' => 'User']) }}</a>--}}
            <!-- END PAGE BREADCRUMB -->
            <!-- BEGIN PAGE BASE CONTENT -->
            <div class="row">
                <div class="col-md-12">
                    @if(Session::has('success_message'))
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            <strong>Success!</strong> {!! Session::get('success_message') !!}
                        </div>
                    @endif
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-file-text"></i>{{ trans('translation.general.user-manual') }}
                            </div>
                        </div>
                        <div class="portlet-body">

                        </div>
                    </div>
                </div>
            </div>
            <!-- END PAGE BASE CONTENT -->
        </div>
        <!-- END CONTENT BODY -->
    </div>
@endsection
