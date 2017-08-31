<head>
    <link href="/img/company-icon.png" rel="shortcut icon" type="image/x-icon" />
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title> {{ trans('strings.app-name') }} - @yield('title') </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="stylesheet" href="{{ asset(elixir('css/app.css')) }}">
    <link rel="stylesheet" href="{{ asset('datatables/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('iCheck/skins/all.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
