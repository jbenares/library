<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Bookstore Library Admin</title>
          @vite('resources/css/app.css')
          @vite('resources/css/figtreeFont.css')
          @vite('resources/css/mdi/css/materialdesignicons.min.css')
          @vite('resources/css/ti-icons/css/themify-icons.css')
          @vite('resources/css/font-awesome/css/font-awesome.min.css')
          @vite('resources/css/bootstrap-datepicker/bootstrap-datepicker.min.css')
          @vite('node_modules/jquery/dist/jquery.min.js?commonjs-entry')

    </head>
    
    <body >
       
        <div id="app">
            
        </div>
        @vite('resources/js/app.js')
       
        @vite('resources/js/vendor.bundle.base.js')
        @vite('resources/js/bootstrap-datepicker.min.js')
        @vite('resources/js/chart.umd.js')
        @vite('resources/js/misc.js')
      
        @vite('resources/js/jquery.cookie.js')
        @vite('resources/js/dashboard.js')
       
    </body>
</html>
