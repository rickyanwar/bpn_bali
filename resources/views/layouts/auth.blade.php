<!DOCTYPE html>
@php
    use App\Models\Utility;

    $logo = asset(Storage::url('uploads/logo/'));
    $logo = \App\Models\Utility::get_file('uploads/logo/');
    $company_logo = Utility::getValByName('company_logo_dark');
    $company_logos = Utility::getValByName('company_logo_light');
    $company_favicon = Utility::getValByName('company_favicon');
    $setting = \App\Models\Utility::colorset();
    $mode_setting = \App\Models\Utility::mode_layout();
    $color = !empty($setting['color']) ? $setting['color'] : 'theme-1';
    $company_logo = \App\Models\Utility::GetLogo();
    $SITE_RTL = isset($setting['SITE_RTL']) ? $setting['SITE_RTL'] : 'off';
    $lang = \App::getLocale('lang');
    if ($lang == 'ar' || $lang == 'he') {
        $setting['SITE_RTL'] = 'on';
    } else {
        $setting['SITE_RTL'] = 'off';
    }

    //$getseo = App\Models\Utility::getSeoSetting();
    //$metatitle = isset($getseo['meta_title']) ? $getseo['meta_title'] : '';
    //$metsdesc = isset($getseo['meta_desc']) ? $getseo['meta_desc'] : '';
    //$meta_image = \App\Models\Utility::get_file('uploads/meta/');
    //$meta_logo = isset($getseo['meta_image']) ? $getseo['meta_image'] : '';
    //$get_cookie = \App\Models\Utility::getCookieSetting();

@endphp

{{-- <html lang="en" dir="{{$SITE_RTL == 'on' ? 'rtl' : '' }}"> --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ isset($setting['SITE_RTL']) && $setting['SITE_RTL'] == 'on' ? 'rtl' : '' }}">

<head>
    <title>
        {{--  // {{ Utility::getValByName('title_text') ? Utility::getValByName('title_text') : config('app.name', 'ERP SBS') }}  --}}
        - @yield('page-title')</title>



    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

    <!-- vendor css -->

    {{--  @if ($setting['SITE_RTL'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}" id="main-style-link">
    @endif
    @if ($setting['cust_darklayout'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    @endif  --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">

    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

</head>

<body class="theme-4">
    <div class="auth-wrapper auth-v3">
        <div class="bg-auth-side bg-primary"></div>
        <div class="auth-content">

            <div class="card">
                <div class="row align-items-center text-start">
                    <div class="col-xl-6">
                        <div class="card-body">
                            @yield('content')
                        </div>
                    </div>
                    <div class="col-xl-6 img-card-side">
                        <div class="auth-img-content">
                            <img src="{{ asset('assets/images/auth/img-auth-3.svg') }}" alt=""
                                class="img-fluid" />
                            <h3 class="text-white mb-4 mt-5">
                                “Attention is the new currency”
                            </h3>
                            <p class="text-white">
                                The more effortless the writing looks, the more effort the
                                writer actually put into the process.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="auth-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-0"> &copy;
                                {{ date('Y') }}

                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ auth-signup ] end -->

    <!-- Required Js -->
    <script src="{{ asset('assets/js/vendor-all.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script>
        feather.replace();
    </script>

    {{--  @if (\App\Models\Utility::getValByName('cust_darklayout') == 'on')
        <style>
            .g-recaptcha {
                filter: invert(1) hue-rotate(180deg) !important;
            }
        </style>
    @endif  --}}



    <script>
        feather.replace();
        var pctoggle = document.querySelector("#pct-toggler");
        if (pctoggle) {
            pctoggle.addEventListener("click", function() {
                if (
                    !document.querySelector(".pct-customizer").classList.contains("active")
                ) {
                    document.querySelector(".pct-customizer").classList.add("active");
                } else {
                    document.querySelector(".pct-customizer").classList.remove("active");
                }
            });
        }

        var themescolors = document.querySelectorAll(".themes-color > a");
        for (var h = 0; h < themescolors.length; h++) {
            var c = themescolors[h];

            c.addEventListener("click", function(event) {
                var targetElement = event.target;
                if (targetElement.tagName == "SPAN") {
                    targetElement = targetElement.parentNode;
                }
                var temp = targetElement.getAttribute("data-value");
                removeClassByPrefix(document.querySelector("body"), "theme-");
                document.querySelector("body").classList.add(temp);
            });
        }



        var custthemebg = document.querySelector("#cust-theme-bg");
        custthemebg.addEventListener("click", function() {
            if (custthemebg.checked) {
                document.querySelector(".dash-sidebar").classList.add("transprent-bg");
                document
                    .querySelector(".dash-header:not(.dash-mob-header)")
                    .classList.add("transprent-bg");
            } else {
                document.querySelector(".dash-sidebar").classList.remove("transprent-bg");
                document
                    .querySelector(".dash-header:not(.dash-mob-header)")
                    .classList.remove("transprent-bg");
            }
        });

        {{-- var custdarklayout = document.querySelector("#cust-darklayout"); --}}
        {{-- custdarklayout.addEventListener("click", function () { --}}
        {{--    if (custdarklayout.checked) { --}}
        {{--        document --}}
        {{--            .querySelector(".m-header > .b-brand > .logo-lg") --}}
        {{--            .setAttribute("src", "{{ asset('assets/images/logo.svg') }}"); --}}
        {{--        document --}}
        {{--            .querySelector("#main-style-link") --}}
        {{--            .setAttribute("href", "{{ asset('assets/css/style-dark.css') }}"); --}}
        {{--    } else { --}}
        {{--        document --}}
        {{--            .querySelector(".m-header > .b-brand > .logo-lg") --}}
        {{--            .setAttribute("src", "{{ asset('assets/images/logo-dark.png') }}"); --}}
        {{--        document --}}
        {{--            .querySelector("#main-style-link") --}}
        {{--            .setAttribute("href", "{{ asset('assets/css/style.css') }}"); --}}
        {{--    } --}}
        {{-- }); --}}

        var custdarklayout = document.querySelector("#cust_darklayout");
        custdarklayout.addEventListener("click", function() {
            if (custdarklayout.checked) {
                document
                    .querySelector("#main-style-link")
                    .setAttribute("href", "{{ asset('assets/css/style-dark.css') }}");
                document
                    .querySelector(".m-header > .b-brand > .logo-lg")
                    .setAttribute("src", "{{ asset('/storage/uploads/logo/logo-light.png') }}");
            } else {
                document
                    .querySelector("#main-style-link")
                    .setAttribute("href", "{{ asset('assets/css/style.css') }}");
                document
                    .querySelector(".m-header > .b-brand > .logo-lg")
                    .setAttribute("src", "{{ asset('/storage/uploads/logo/logo-dark.png') }}");
            }
        });


        function removeClassByPrefix(node, prefix) {
            for (let i = 0; i < node.classList.length; i++) {
                let value = node.classList[i];
                if (value.startsWith(prefix)) {
                    node.classList.remove(value);
                }
            }
        }
    </script>
    @stack('custom-scripts')


    {{--  @if ($get_cookie['enable_cookie'] == 'on')
        @include('layouts.cookie_consent')
    @endif  --}}
</body>

</html>
