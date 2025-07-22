<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Vocal language application</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <link href="{{ asset('css/site.css?v3') }}" rel="stylesheet">
    <!-- Javascript -->
    <script type="text/javascript" src="/js/vocal.js?v1"></script>

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            @if (!Auth::guest())
                @include('partials.nav')
            @endif

            <!-- Branding Image -->
            <form id="headerForm" action="" method="POST" class="form-horizontal">
                <a class="navbar-brand" onclick="goHome('headerForm', '{{ url("/home") }}');">
                    Home
                </a>
                <a class="navbar-brand" onclick="goHome('headerForm', '{{ url("/admin") }}');">
                    Admin
                </a>
            </form>

            @include('partials.header')
        </div>

    </div>
</nav>

@yield('content')

<div class="modal" id="popup-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <center>
                            <h2 style="color: rgba(96,96,96,0.68)">
                                <i class=""></i>
                                <embed id="embedId" src="" width="500" height="400"
                                       type="application/pdf" allowfullscreen allow="fullscreen"></embed>
                            </h2>
                            <hr>

                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        <!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
@yield('page-scripts')
@yield('global-scripts')

<script type="text/javascript">
    // Delete the cookie for testing purposes
    //    document.cookie = "cookieWarningAccepted=; Max-Age=0; path=/;";
    //    document.cookie = "cookieLoadAll=; Max-Age=0; path=/;";
    //    document.cookie = "loadAll=; Max-Age=0; path=/;";
    //console.log(document.cookie);
    // Function to set a cookie
    function setCookie(name, value, days) {
        const d = new Date();
        d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
        const expires = "expires=" + d.toUTCString();
        document.cookie = name + "=" + value + ";" + expires + ";path=/";
    }

    // Function to check if a cookie exists
    function checkCookie(name) {
        const nameEQ = name + "=";
        const ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length); // Trim whitespace
            if (c.indexOf(nameEQ) == 0) return true; // Cookie found
        }
        return false; // Cookie not found
    }

    /**
     * Change the current language
     */
    function changeLanguage(languageCode)
    {
        // Set a cookie to remember that the user wishes a new language
        setCookie("languageCode", languageCode, 7); // Cookie expires in 7 days
        document.location = ("{{config('app.base_url')}}" + "/");
    }

</script>
</body>
</html>