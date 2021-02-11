@extends('admin.parent')

@section('title', 'Kafka')

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
                    <h1>{{ trans('translation.general.kafka-topics.topics') }}</h1>
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
                    <span class="active">{{ trans('translation.general.kafka-topics.topics') }}</span>
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
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-users"></i>{{ trans('translation.general.kafka-topics.topics') }}
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>{{ trans('translation.general.kafka-topics.kafka-active-topics') }}</th>
                                        <th>{{ trans('translation.general.kafka-topics.status') }}</th>
                                        <th width="21%">{{ trans('translation.general.kafka-topics.transactions') }} </th>
                                    </tr>
                                    </thead>
                                    <tbody id="data">

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

@section('js')
<script>
    window.onload=function(){
        var xmlHttp = new XMLHttpRequest();
        var url = "http://127.0.0.1:3000/topicsList";
        xmlHttp.onreadystatechange = function () {
            var topics = JSON.parse(this.responseText);
            var rows = "";
            for(i = 0; i < topics.length; i++){
                rows += "<tr>\n" +
                    "<td> "+ topics[i] +" </td>\n" +
                    "<td> {{ trans('translation.general.kafka-topics.listening') }} </td>\n" +
                    "<td width=\"25%\">\n" +
                    "<a type=\"button\" href=\"\" class=\"btn btn-primary\"><i class=\"fa fa-pencil\"></i> {{ trans('translation.general.filter') }}</a>\n" +
                    "<a type=\"button\" href=\"\" class=\"btn btn-primary\"><i class=\"fa fa-pencil\"></i> {{ trans('translation.general.edit') }}</a>\n" +
                    "<a type=\"button\" href=\"\" class=\"btn btn-danger delete-button\"><i class=\"fa fa-trash\"></i> {{ trans('translation.general.delete') }}</a>\n" +
                    "</td>\n" +
                    "</tr>"
            }
            $('#data').html(rows);
        };
        xmlHttp.open("GET", url, true);
        xmlHttp.send();
    };
</script>
@endsection
