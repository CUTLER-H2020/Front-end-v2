<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-dashboard"></i>
                    <span class="title">{{ trans('translation.sidebar.dashboard.transactions') }}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu" style="display: block">
                    @if(hasPermission('policy.index'))
                        <li class="nav-item">
                            <a href="{{ route('policy.index') }}" class="nav-link ">
                                <span class="title">{{ trans('translation.general.sidebar.policies') }}</span>
                            </a>
                        </li>
                    @endif
                    @if(hasPermission('process-design.index'))
                        <li class="nav-item">
                            <a href="{{ route('process-design2.index') }}" class="nav-link ">
                                <span class="title">{{ trans('translation.general.sidebar.process-design') }}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
            @if(hasPermission('user.index') || hasPermission('user-group.index'))
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-users"></i>
                        <span class="title">{{ trans('translation.general.sidebar.user-management') }}</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        @if(hasPermission('user.index'))
                            <li class="nav-item">
                                <a href="{{ route('user.index') }}" class="nav-link ">
                                    <span class="title">{{ trans('translation.general.sidebar.users') }}</span>
                                </a>
                            </li>
                        @endif
                        @if(hasPermission('user-group.index'))
                            <li class="nav-item">
                                <a href="{{ route('user-group.index') }}" class="nav-link ">
                                    <span class="title">{{ trans('translation.general.sidebar.user-groups') }}</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if(hasPermission('settings.edit'))
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-cogs"></i>
                        <span class="title">{{ trans('translation.general.sidebar.settings-management') }}</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        @if(hasPermission('settings.edit'))
                            <li class="nav-item">
                                <a href="{{ route('settings.edit') }}" class="nav-link ">
                                    <span class="title">{{ trans('translation.general.sidebar.settings') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('language.index') }}" class="nav-link ">
                                    <span class="title">{{ trans('translation.general.sidebar.languages') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('language.translations') }}" class="nav-link ">
                                    <span class="title">{{ trans('translation.general.sidebar.translations') }}</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif


        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
