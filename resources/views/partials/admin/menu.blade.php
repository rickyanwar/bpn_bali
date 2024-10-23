@php
    use App\Models\Utility;
    //  $logo=asset(Storage::url('uploads/logo/'));
    $logo = \App\Models\Utility::get_file('uploads/logo/');
    $company_logo = Utility::getValByName('company_logo_dark');
    $company_logos = Utility::getValByName('company_logo_light');
    $company_small_logo = Utility::getValByName('company_small_logo');
    $setting = \App\Models\Utility::colorset();
    $mode_setting = \App\Models\Utility::mode_layout();
    //$emailTemplate = \App\Models\EmailTemplate::first();
    //$lang = Auth::user()->lang;
@endphp

@if (isset($setting['cust_theme_bg']) && $setting['cust_theme_bg'] == 'on')
    <nav class="dash-sidebar light-sidebar transprent-bg">
    @else
        <nav class="dash-sidebar light-sidebar ">
@endif
<div class="navbar-wrapper">
    <div class="m-header main-logo">
        <a href="#" class="b-brand">
            <img src="{{ asset('assets/images/smart_logo.png') }}" alt="{{ env('APP_NAME') }}" class="logo logo-lg" />

            {{-- @if ($mode_setting['cust_darklayout'] && $mode_setting['cust_darklayout'] == 'on')
                <img src="{{ $logo . '/' . (isset($company_logos) && !empty($company_logos) ? $company_logos : 'logo-dark.png') }}"
                    alt="{{ config('app.name', 'ERPGo-SaaS') }}" class="logo logo-lg">
            @else
                <img src="{{ $logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') }}"
                    alt="{{ config('app.name', 'ERPGo-SaaS') }}" class="logo logo-lg">
            @endif --}}

        </a>
    </div>
    <div class="navbar-content">

        <ul class="dash-navbar">
            <li class="dash-item {{ Request::segment(1) == 'dashboard' ? ' active dash-trigger' : '' }}">

                <a href="{{ route('dashboard.index') }}" class="dash-link "><span class="dash-micon"><i
                            class="ti ti-message-report"></i></span><span
                        class="dash-mtext">{{ __('Dashboard') }}</span><span class="dash-arrow"><i
                            data-feather="chevron-right"></i></span></a>
            </li>
            @if (Gate::check('manage user') || Gate::check('manage role') || Gate::check('manage client'))
                <li
                    class="dash-item dash-hasmenu {{ Request::segment(1) == 'users' ||
                    Request::segment(1) == 'roles' ||
                    Request::segment(1) == 'clients' ||
                    Request::segment(1) == 'userlogs'
                        ? ' active dash-trigger'
                        : '' }}">

                    <a href="#!" class="dash-link "><span class="dash-micon"><i
                                class="ti ti-users"></i></span><span
                            class="dash-mtext">{{ __('User Management') }}</span><span class="dash-arrow"><i
                                data-feather="chevron-right"></i></span></a>
                    <ul class="dash-submenu">
                        @can('manage user')
                            <li
                                class="dash-item {{ Request::route()->getName() == 'users.index' || Request::route()->getName() == 'users.create' || Request::route()->getName() == 'users.edit' || Request::route()->getName() == 'user.userlog' ? ' active' : '' }}">
                                <a class="dash-link" href="{{ route('users.index') }}">{{ __('User') }}</a>
                            </li>
                        @endcan
                        @can('manage role')
                            <li
                                class="dash-item {{ Request::route()->getName() == 'roles.index' || Request::route()->getName() == 'roles.create' || Request::route()->getName() == 'roles.edit' ? ' active' : '' }} ">
                                <a class="dash-link" href="{{ route('roles.index') }}">{{ __('Role') }}</a>
                            </li>
                        @endcan

                    </ul>
                </li>
            @endif
            <li class="dash-item  {{ Request::segment(1) == 'permohonan' ? ' active dash-trigger' : '' }}">
                <a href="#" class="dash-link "><span class="dash-micon"><i
                            class="ti ti-message-report"></i></span><span
                        class="dash-mtext">{{ __('Pelayanan') }}</span><span class="dash-arrow"><i
                            data-feather="chevron-right"></i></span></a>

                <ul class="dash-submenu">
                    <li class="dash-item {{ Request::route()->getName() == 'permohonan' ? ' active' : '' }}">
                        <a class="dash-link" href="{{ route('permohonan.index') }}">Tugas</a>
                    </li>
                    <li class="dash-item {{ Request::route()->getName() == 'permohonan/get-all' ? ' active' : '' }} ">
                        <a class="dash-link" href="{{ route('permohonan.all') }}">Semua Permohonan</a>
                    </li>
                </ul>
            </li>

            <li class="dash-item  {{ Request::segment(1) == 'audit' ? ' active dash-trigger' : '' }}">
                <a href="{{ route('audit.index') }}" class="dash-link "><span class="dash-micon"><i
                            class="ti ti-history"></i></span><span
                        class="dash-mtext">{{ __('Audit Trail') }}</span><span class="dash-arrow"><i
                            data-feather="chevron-right"></i></span></a>
            </li>
            <li class="dash-item  {{ Request::segment(1) == 'report' ? ' active dash-trigger' : '' }}">
                <a href="#" class="dash-link "><span class="dash-micon"><i class="ti ti-print"></i></span><span
                        class="dash-mtext">{{ __('Report') }}</span><span class="dash-arrow"><i
                            data-feather="chevron-right"></i></span></a>
                <ul class="dash-submenu">

                    <li class="dash-item {{ Request::route()->getName() == 'permohonan/get-all' ? ' active' : '' }} ">
                        <a class="dash-link" href="{{ route('report.jadwal_pengukuran') }}">Jadwal Pengukuran</a>
                    </li>
                    <li class="dash-item {{ Request::route()->getName() == 'permohonan/get-all' ? ' active' : '' }} ">
                        <a class="dash-link" href="{{ route('report.setor_berkas') }}">Setor Berkas</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
</nav>
