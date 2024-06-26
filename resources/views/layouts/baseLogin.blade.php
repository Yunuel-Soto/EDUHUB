<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EDUHUB - @yield('title', 'title_doc')</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/libro.png') }}">
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/styles/login.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/spinner.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/home.css') }}">

    {{-- External links --}}
    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    {{-- SweeftAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Modals --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</head>

<body class="login_body">
    @yield('content')
</body>

</html>
