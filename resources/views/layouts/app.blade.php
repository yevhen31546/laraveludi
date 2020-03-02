<!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', app_name())</title>
        <meta name="description" content="@yield('meta_description', 'Laravel')">
        @yield('meta')

        @stack('before-styles')

        {{ style('fonts/material-icon/css/material-design-iconic-font.min.css') }}
        {{ style('css/bootstrap.min.css') }}
        {{ style('css/style.css') }}
       <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.css"/>
        @stack('after-styles')
    </head>
    <body>
        <div class="main">
            <div class="content">
                <div class="container">
                    @include('includes.common.messages')
                </div>
                @yield('content')
            </div><!-- content -->
        </div><!-- #main -->

        <!-- Scripts -->
        @stack('before-scripts')
        {!! script('js/jquery.min.js') !!}
        {!! script('js/popper.min.js') !!}
        {!! script('js/bootstrap.min.js') !!}
        {!! script('js/common.js') !!}
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            window.baseUrl='{{ url('/') }}/';
        </script>
        
        <script src="https://cdn.jsdelivr.net/npm/scandit-sdk@4.x"></script>
        @stack('after-scripts')

    </body>
</html>
