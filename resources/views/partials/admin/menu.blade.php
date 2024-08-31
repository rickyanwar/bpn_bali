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

            @if (
                \Auth::user()->type != 'super admin' &&
                    (Gate::check('manage user') || Gate::check('manage role') || Gate::check('manage client')))
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
                        {{--  @can('manage client')
                            <li
                                class="dash-item {{ Request::route()->getName() == 'clients.index' || Request::segment(1) == 'clients' || Request::route()->getName() == 'clients.edit' ? ' active' : '' }}">
                                <a class="dash-link" href="{{ route('clients.index') }}">{{ __('Client') }}</a>
                            </li>
                        @endcan  --}}
                        {{--                                    @can('manage user') --}}
                        {{--                                        <li class="dash-item {{ (Request::route()->getName() == 'users.index' || Request::segment(1) == 'users' || Request::route()->getName() == 'users.edit') ? ' active' : '' }}"> --}}
                        {{--                                            <a class="dash-link" href="{{ route('user.userlog') }}">{{__('User Logs')}}</a> --}}
                        {{--                                        </li> --}}
                        {{--                                    @endcan --}}
                    </ul>
                </li>
            @endif

            <!--------------------- End User Managaement System----------------------------------->

            <li
                class="dash-item dash-hasmenu {{ Request::segment(1) == 'users' ||
                Request::segment(1) == 'roles' ||
                Request::segment(1) == 'clients' ||
                Request::segment(1) == 'userlogs'
                    ? ' active dash-trigger'
                    : '' }}">

                <a href="#!" class="dash-link "><span class="dash-micon"><i
                            class="ti ti-message-report"></i></span><span
                        class="dash-mtext">{{ __('Pelayanan') }}</span><span class="dash-arrow"><i
                            data-feather="chevron-right"></i></span></a>
                <ul class="dash-submenu">
                    @can('manage user')
                        <li
                            class="dash-item {{ Request::route()->getName() == 'penggabungan.index' || Request::route()->getName() == 'penggabungan.create' || Request::route()->getName() == 'penggabungan.edit' || Request::route()->getName() == 'user.userlog' ? ' active' : '' }}">
                            <a class="dash-link" href="{{ route('penggabungan.index') }}">
                                {{ __('Penggabungan') }}</a>
                        </li>
                    @endcan

                    {{--  @can('manage client')
                    <li
                        class="dash-item {{ Request::route()->getName() == 'clients.index' || Request::segment(1) == 'clients' || Request::route()->getName() == 'clients.edit' ? ' active' : '' }}">
                        <a class="dash-link" href="{{ route('clients.index') }}">{{ __('Client') }}</a>
                    </li>
                @endcan  --}}
                    {{--                                    @can('manage user') --}}
                    {{--                                        <li class="dash-item {{ (Request::route()->getName() == 'users.index' || Request::segment(1) == 'users' || Request::route()->getName() == 'users.edit') ? ' active' : '' }}"> --}}
                    {{--                                            <a class="dash-link" href="{{ route('user.userlog') }}">{{__('User Logs')}}</a> --}}
                    {{--                                        </li> --}}
                    {{--                                    @endcan --}}
                </ul>
            </li>
        </ul>


    </div>
</div>
</nav>
