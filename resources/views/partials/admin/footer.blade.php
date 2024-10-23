@php
    use App\Models\Utility;
    $get_cookie = \App\Models\Utility::getCookieSetting();

@endphp
<!-- [ Main Content ] end -->
<footer class="dash-footer">
    <div class="footer-wrapper">
        <div class="py-1">
            <p class="mb-0 text-muted"> &copy;
                {{ date('Y') }}
                {{ Utility::getValByName('footer_text') ? Utility::getValByName('footer_text') : config('app.name', 'ERPGo') }}
            </p>
        </div>
    </div>
</footer>


<!-- Warning Section Ends -->
<!-- Required Js -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery.form.js') }}"></script>
<script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>


<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/dash.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>

<script src="{{ asset('assets/js/plugins/bootstrap-switch-button.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/sweetalert.min.js') }}"></script>


<script src="{{ asset('assets/js/plugins/simple-datatables.js') }}"></script>

<!-- Apex Chart -->
<script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/main.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-button/jszip.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-button/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-button/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-button/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-button/buttons.print.min.js') }}"></script>
<script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js">
    < /script <
    script src = "https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js" >
</script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@stack('scripts')
<script src="{{ asset('js/jscolor.js') }}"></script>

<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js"
    integrity="sha512-WFN04846sdKMIP5LKNphMaWzU7YpMyCU245etK3g/2ARYbPK9Ub18eG+ljU96qKRCWh+quCY7yefSmlkQw1ANQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function ajaxRequest(url_, method_ = 'GET', data_) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var ajax_ = $.ajax({
            processData: false,
            dataType: 'json',
            contentType: false,
            async: false,
            url: url_,
            method: method_,
            data: data_,
            error: function(xhr, status, error) {
                show_toastr('error', xhr.responseJSON?.message);
            }
        });

        return ajax_;
    }
</script>

{{-- <script src="{{ asset ('js/bootstrap.min.js') }}"></script> --}}

<script>
    var site_currency_symbol_position = '{{ \App\Models\Utility::getValByName('site_currency_symbol_position') }}';
    var site_currency_symbol = '{{ \App\Models\Utility::getValByName('site_currency_symbol') }}';
</script>
<script src="{{ asset('js/custom.js') }}"></script>

@if ($message = Session::get('success'))
    <script>
        show_toastr('success', '{!! $message !!}');
    </script>
@endif
@if ($message = Session::get('error'))
    <script>
        show_toastr('error', '{!! $message !!}');
    </script>
@endif
@if ($get_cookie['enable_cookie'] == 'on')
    @include('layouts.cookie_consent')
@endif
@stack('script-page')

@stack('old-datatable-js')

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

    {{--  var custthemebg = document.querySelector("#cust-theme-bg");
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
    });  --}}
    {{--
    var custdarklayout = document.querySelector("#cust-darklayout");
    custdarklayout.addEventListener("click", function() {
        if (custdarklayout.checked) {

            document
                .querySelector("#main-style")
                .setAttribute("href", "{{ asset('assets/css/style-dark.css') }}");

            document
                .querySelector(".m-header > .b-brand > .logo-lg")
                .setAttribute("src", "{{ asset('/storage/uploads/logo/logo-light.png') }}");
        } else {
            document
                .querySelector("#main-style")
                .setAttribute("href", "{{ asset('assets/css/style.css') }}");
            document
                .querySelector(".m-header > .b-brand > .logo-lg")
                .setAttribute("src", "{{ asset('/storage/uploads/logo/logo-dark.png') }}");
        }
    });  --}}


    function removeClassByPrefix(node, prefix) {
        for (let i = 0; i < node.classList.length; i++) {
            let value = node.classList[i];
            if (value.startsWith(prefix)) {
                node.classList.remove(value);
            }
        }
    }

    function goToPage(url) {
        console.log('goToPage click')
        window.open(url, "_self")
    }

    function submitDeleteForm() {
        console.log('submit Delet from')
    }
</script>
