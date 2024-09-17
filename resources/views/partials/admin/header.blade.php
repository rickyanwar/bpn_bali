@php
    $users = \Auth::user();
    $profile = \App\Models\Utility::get_file('uploads/avatar/');
    $languages = \App\Models\Utility::languages();

    $lang = isset($users->lang) ? $users->lang : 'en';
    if ($lang == null) {
        $lang = 'en';
    }
    // $LangName = \App\Models\Language::where('code',$lang)->first();

    $setting = \App\Models\Utility::colorset();
    $mode_setting = \App\Models\Utility::mode_layout();

    //$unseenCounter = App\Models\ChMessage::where('to_id', Auth::user()->id)->where('seen', 0)->count();

@endphp
@if (isset($setting['cust_theme_bg']) && $setting['cust_theme_bg'] == 'on')
    <header class="dash-header transprent-bg">
    @else
        <header class="dash-header">
@endif
<div class="header-wrapper">
    <div class="me-auto dash-mob-drp">
        <ul class="list-unstyled">
            <li class="dash-h-item mob-hamburger">
                <a href="#!" class="dash-head-link" id="mobile-collapse">
                    <div class="hamburger hamburger--arrowturn">
                        <div class="hamburger-box">
                            <div class="hamburger-inner"></div>
                        </div>
                    </div>
                </a>
            </li>

            <li class="dropdown dash-h-item drp-company">
                <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="theme-avtar">
                        <img src="{{ asset('assets/images/avatar.png') }}" alt="{{ env('APP_NAME') }}"
                            class="img-fluid rounded-circle">
                    </span>
                    <span class="hide-mob ms-2">{{ Auth::user()->name }}

                        - {{ Auth::user()->roles->pluck('name')[0] ?? '' }}

                    </span>
                    <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                </a>
                <div class="dropdown-menu dash-h-dropdown">

                    <a href="#" class="dropdown-item">
                        <i class="ti ti-user text-dark"></i><span>{{ __('Profile') }}</span>
                    </a>


                    <form action="{{ route('logout') }}" method="POST">
                        {{ csrf_field() }}
                        <button href="#" class="dropdown-item">
                            <i class="ti ti-power text-dark"></i><span>{{ __('Logout') }}</span>
                        </button>
                    </form>
                </div>
            </li>

        </ul>
    </div>
    <div class="ms-auto">
        <ul class="list-unstyled">


            <li class="dropdown dash-h-item drp-language">
                <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="ti ti-world nocolor"></i>
                    {{--  <span class="drp-text hide-mob">{{ ucfirst($LangName->full_name) }}</span>  --}}
                    <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                </a>
                <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                    {{--  @foreach (App\Models\Utility::languages() as $code => $language)
                        <a href="{{ route('change.language', $code) }}"
                            class="dropdown-item {{ $lang == $code ? 'text-primary' : '' }}">
                            <span>{{ ucFirst($language) }}</span>
                        </a>
                    @endforeach  --}}

                    <h></h>
                    {{--  @if (\Auth::user()->type == 'super admin')
                        <a data-url="{{ route('create.language') }}" class="dropdown-item text-primary"
                            data-ajax-popup="true" data-title="{{ __('Create New Language') }}">
                            {{ __('Create Language') }}
                        </a>
                        <a class="dropdown-item text-primary"
                            href="{{ route('manage.language', [isset($lang) ? $lang : 'english']) }}">{{ __('Manage Language') }}</a>
                    @endif  --}}
                </div>
            </li>
        </ul>
    </div>
</div>
</header>
