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
                    <h1>{{ trans('translation.language.translations') }}</h1>
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
                    <span class="active">{{ trans('translation.language.translations') }}</span>
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
                                {{ trans('translation.language.translations') }}
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th> {{ trans('translation.language.key') }} </th>
                                        @if($languages->count() > 0)
                                            @foreach($languages as $language)
                                                @if($language->status==1)
                                                    <th>{{ trans('translation.language.'.$language->code) }}</th>
                                                @endif
                                            @endforeach
                                        @endif
                                        <th> {{ trans('translation.language.options') }} </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($translations->count() > 0)
                                        @foreach($translations as $translation)
                                            <tr>
                                                <td>{{ $translation->key }}</td>
                                                @if($languages->count() > 0)
                                                    @foreach($languages as $language)
                                                        @if($language->status==1)
                                                            @php
                                                                $code = $language->code;
                                                            @endphp
                                                            <td>{{ $translation->$code }}</td>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                <td><a href="javascript:translationModal({{ $translation->id }})"
                                                       class="btn btn-primary"><i
                                                            class="fa fa-language"></i> {{ trans('translation.general.update') }}
                                                    </a></td>
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

    <div class="modal fade" id="translationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body translationBody">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ trans('translation.general.close') }}</button>
                </div>
            </div>
        </div>
    </div>
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

    <script>
        $(document).ready(function () {
            $('#datatable').DataTable({
                pageLength: 25
            });
        })
    </script>

    <script>
        function translationModal(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('language.translationModal')}}",
                type: "POST",
                data: {
                    id: id
                },
                success: function (response) {
                    $(".translationBody").html(response);
                    $("#translationModal").modal('show');
                }
            });
        }
    </script>
@endsection
