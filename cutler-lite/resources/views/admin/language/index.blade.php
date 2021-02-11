@extends('admin.parent')

@section('title', trans('translation.general.sidebar.languages'))

@section('css')
    <link href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="//cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css"/>
@endsection

@section('sidebar')
    @include('admin.partials.sidebar', ['active' => 'policies.index'])
@endsection

@section('content')
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEAD-->
            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>{{ trans('translation.language.language-settings') }}</h1>
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
                    <span class="active">{{ trans('translation.language.language-settings') }}</span>
                </li>
            </ul>

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
                        @if(Session::has('error_message'))
                            <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                <strong>{{ trans('translation.general.error') }}</strong> {!! Session::get('error_message') !!}
                            </div>
                        @endif
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                {{ trans('translation.language.language-settings') }}
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table display nowrap" id="data1" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th> {{ trans('translation.language.name') }} </th>
                                        <th> {{ trans('translation.language.settings') }} </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($languages->count() > 0)
                                        @foreach($languages as $language)
                                            <tr>
                                                <td> {{ $language->name }} </td>
                                                <td>
                                                    @if($language->status==0)
                                                        <a href="{{ route('language.statusChange', ['id' => $language->id, 1]) }}"
                                                           class="btn btn-success"> {{ trans('translation.language.set-active') }}</a>
                                                    @elseif($language->status==1)
                                                        <a href="{{ route('language.statusChange', ['id' => $language->id, 0]) }}"
                                                           class="btn btn-danger"> {{ trans('translation.language.set-passive') }}</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9"
                                                class="text-center">{{ trans('general.policies.policy-not-found') }}</td>
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
    <div id="start-new-process-modal-div"></div>
@endsection

@section('js')
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="//cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js" type="text/javascript"></script>
    <script src="//cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js" type="text/javascript"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
    <script src="//cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js" type="text/javascript"></script>
    <script src="//cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js" type="text/javascript"></script>
@endsection
