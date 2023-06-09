{{-- Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4 & Angular 8
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project. --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {{ Metronic::printAttrs('html') }}
    {{ Metronic::printClasses('html') }}>

<head>
    <meta charset="utf-8" />

    {{-- Title Section --}}
    <title>{{ config('app.name') }} | @yield('title', $page_title ?? '')</title>

    {{-- Meta Data --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="@yield('page_description', $page_description ?? '')" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}" />

    {{-- Fonts --}}
    {{ Metronic::getGoogleFontsInclude() }}

    {{-- Global Theme Styles (used by all pages) --}}
    @foreach (config('layout.resources.css') as $style)
        <link href="{{ config('layout.self.rtl') ? asset(Metronic::rtlCssPath($style)) : asset($style) }}"
            rel="stylesheet" type="text/css" />
    @endforeach

    {{-- Layout Themes (used by all pages) --}}
    @foreach (Metronic::initThemes() as $theme)
        <link href="{{ config('layout.self.rtl') ? asset(Metronic::rtlCssPath($theme)) : asset($theme) }}"
            rel="stylesheet" type="text/css" />
    @endforeach

    {{-- Includable CSS --}}
    @yield('styles')
</head>

<body {{ Metronic::printAttrs('body') }} {{ Metronic::printClasses('body') }}>

    @if (config('layout.page-loader.type') != '')
        @include('layout.partials._page-loader')
    @endif

    @include('layout.base._layout')



    {{-- Global Config (global config for global JS scripts) --}}
    <script>
        var KTAppSettings = {
            !!json_encode(config('layout.js'), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!
        };
    </script>

    {{-- Global Theme JS Bundle (used by all pages) --}}
    @foreach (config('layout.resources.js') as $script)
        <script src="{{ asset($script) }}" type="text/javascript"></script>
    @endforeach
    <script src="{{ asset('js/pages/crud/forms/widgets/bootstrap-datepicker.js') }}"></script>
    {{-- Includable JS --}}
    @stack('script')
    @yield('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            // startConnection();
            $("form").submit(function() {
                KTApp.block('#kt_blockui_card', {
                    overlayColor: '#000000',
                    state: 'primary',
                    message: 'Processing...',

                });
            });

            $('.password, .opass, .cpass, .pass').on('copy paste cut', function(e) {
                e.preventDefault();
            });

            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            $('.deleteBtn').click(function(e) {
                e.preventDefault();
                var $this = $(this);
                swal.fire({
                    title: "Delete!",
                    text: "Are you sure you want to delete this?",
                    icon: "question",
                    buttonsStyling: false,
                    confirmButtonText: "Yes I'm sure",
                    showCancelButton: true,
                    cancelButtonText: "No",
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-default"
                    }
                }).then(function(result) {
                    console.log(result);
                    if (result.hasOwnProperty('value')) {
                        $this.parents('form').submit();
                    }
                });
            });
            $('.transactiondeleteBtn').click(function(e) {
                e.preventDefault();
                var $this = $(this);
                swal.fire({
                    title: "Delete!",
                    text: "Are you sure you want to delete this transaction?",
                    icon: "question",
                    buttonsStyling: false,
                    confirmButtonText: "Yes I'm sure",
                    showCancelButton: true,
                    cancelButtonText: "No",
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-default"
                    }
                }).then(function(result) {
                    console.log(result);
                    if (result.hasOwnProperty('value')) {
                        $this.parents('form').submit();
                    }
                });
            });
            $('.deleteBtnforcustomer').click(function(e) {
                e.preventDefault();
                var $this = $(this);
                swal.fire({
                    title: "Delete!",
                    text: "Vehicles Assigned To This Coustmer Will be Unlinked, Are You Sure You want to Delete?",
                    icon: "question",
                    buttonsStyling: false,
                    confirmButtonText: "Yes I'm sure",
                    showCancelButton: true,
                    cancelButtonText: "No",
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-default"
                    }
                }).then(function(result) {
                    console.log(result);
                    if (result.hasOwnProperty('value')) {
                        $this.parents('form').submit();
                    }
                });
            });

            $('.disableRole').click(function(e) {
                e.preventDefault();
                var $this = $(this);
                swal.fire({
                    title: "Disable!",
                    text: "Are you sure you want to disable?",
                    icon: "question",
                    buttonsStyling: false,
                    confirmButtonText: "Yes I'm sure",
                    showCancelButton: true,
                    cancelButtonText: "No",
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-default"
                    }
                }).then(function(result) {
                    console.log(result);
                    if (result.hasOwnProperty('value')) {
                        $this.parents('form').submit();
                    }
                });
            });

            $('.enableRole').click(function(e) {
                e.preventDefault();
                var $this = $(this);
                swal.fire({
                    title: "Enable!",
                    text: "Are you sure you want to enable?",
                    icon: "question",
                    buttonsStyling: false,
                    confirmButtonText: "Yes I'm sure",
                    showCancelButton: true,
                    cancelButtonText: "No",
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-default"
                    }
                }).then(function(result) {
                    console.log(result);
                    if (result.hasOwnProperty('value')) {
                        $this.parents('form').submit();
                    }
                });
            });
        });

        function addWalletAddressField() {
            var total_wallet_address = $('#wallet_address_collection').find($("input"));
            if (total_wallet_address.length < 5) {
                $('#wallet_address_collection').append('<div class="input-group mb-3">' +
                    '<input name="wallet_address[]" type="text"' +
                    'class="form-control form-control-solid"' +
                    'placeholder="Enter another wallet address" required ' +
                    'autocomplete="off" />' +
                    '<button class="btn btn-icon btn-danger btn-sm mx-2" type="button" ' +
                    'onclick="removeWalletAddressField(this)">' +
                    '<i class="fa fa-minus"></i>' +
                    '</button>' +
                    '</div>');
            } else {
                var error_msg = '<h6 class="bg-danger text-white p-4">You can only add 5 wallet address at max.</h6>';
                $('#maximum_wallet_capacity_error_box').html(error_msg);
            }
        }

        function removeWalletAddressField(elem) {
            var error_msg = '';
            $('#maximum_wallet_capacity_error_box').html(error_msg);
            $(elem).closest('.input-group').remove();
        }
    </script>

</body>

</html>
