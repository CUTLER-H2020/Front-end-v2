@extends('admin.parent')

@section('title', trans('translation.sidebar.dashboard.dashboard'))

@section('sidebar')
    @include('admin.partials.sidebar', ['active' => 'dashboard'])
@endsection

@section('css')
<link href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
<link href="//cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css"/>
<link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css"/>
<link href="//cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css"/>


@endsection
@section('content')

    <!--

Tüm Kullanıcıların Sayıs  (Total User)
Aktif Kullanıcı Sayısı (Active User)

Sayfalarda kalma süreleri ;

Policies :
    - Kimler Giriş Yapmış
    - Giriş yapan kişiler bu sayfada ne kadar süre kalmış
Policies
Process :
Tasks :
Process Design:
Kafka Message :

Kullanıcıya Göre İstatistikler ;



Kimin girdiği
Giriş yapan kişinin hangi sayfalara tıkladığı
Giriş yapan kişinin hangi sayfa da ne kadar kaldığı
Giriş yapan kişinin ne kadar online olduğu (gün bazında )
Hangi sayfalara gezindiği
Sayfalarda ne kadar süre kaldığı
Hangi sayfalara kimin kaç kere tıkladığı

-->


    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>Cutler Dashboard
                        <small>{{trans('general.dashboard.statistics')}}</small>
                    </h1>
                </div>

                <!-- BEGIN PAGE TOOLBAR -->
                  <!--<div class="page-toolbar">
                  <div id="dashboard-report-range" data-display-range="0"
                         class="pull-right tooltips btn btn-fit-height green" data-placement="left"
                         data-original-title="Change dashboard date range">
                        <i class="icon-calendar"></i>&nbsp;
                        <span class="thin uppercase hidden-xs"></span>&nbsp;
                        <i class="fa fa-angle-down"></i>
                    </div>

                </div> -->
                <!-- END PAGE TOOLBAR -->
            </div>
            <!--<div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2 bordered">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-blue-sharp">
                                    <span data-counter="counterup">{{ $usersCount }}</span>
                                </h3>
                                <small>Total Users</small>
                            </div>
                            <div class="icon">
                                <i class="icon-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2 bordered">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-purple-soft">
                                    <span id="online_user_count" data-counter="counterup">0</span>
                                </h3>
                                <small>Current Active Users</small>
                            </div>
                            <div class="icon">
                                <i class="icon-user"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
<hr>

            <div class="row">
                <div class="col-md-12">
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"
                               id="data">
                            <thead>
                            <tr>
                                <th>{{ trans('general.dashboard.page') }}</th>
                                <th>{{ trans('general.statistic.stay-on-page') }}</th>
                             <!--   <th>Policy</th>
                                <th>Process</th>
                                <th>Task</th>
                                <th>Phase</th>-->
                                <!--
                                <th >Hangi sayfalara girdiği</th>
                                <th >Toplam online olduğu süre</th>
                                -->

                                <!--<th class="all">Extn.</th>-->
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($userStatistics as $groupName => $items)
                                <tr>
                                    <td>{{ $groupName }}</td>
                                    <td>
{{--                                            {{ \Carbon\Carbon::parse($userStatistic->entry_time)->diffForHumans($userStatistic->exit_time) }}--}}
                                            {{ $items->sum('seconds_of_stay') }} {{ trans('general.dashboard.seconds') }}
                                    </td>
                                  <!--  <td>{{ $userStatistic->policy->name ?? '-' }}</td>
                                    <td>{{ $userStatistic->process->xml_process_name ?? '-' }}</td>
                                    <td>{{ $userStatistic->task->xml_task_name ?? '-' }}</td>
                                    <td>{{ $userStatistic->phase ?? '-' }}</td>-->
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" type="text/javascript"></script>
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="//cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
<script src="//cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js" type="text/javascript"></script>
<script src="//cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
<script src="//cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="//cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        getOnlineUsersCount();
        // setInterval(function(){
        //     getOnlineUsersCount()
        // }, 3000);
    });

    function getOnlineUsersCount() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ route('getOnlineUsersCount')}}",
            type: "POST",
            timeout: 10000,
            data: {1: 1},
            success: function (response) {
                $("#online_user_count").html(response);
            }
        });
    }

$('#data').DataTable({
    dom: 'Bfrtip',
    buttons: [ 'print'
    ],
    pageLength: 10,
    ordering: true,

});
</script>
@endsection
