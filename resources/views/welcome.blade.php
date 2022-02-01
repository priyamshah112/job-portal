<!DOCTYPE html>

<head>
    <title>NaukriWala</title>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.6.22/dist/css/uikit.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;
        var pusher = new Pusher('413ecacd820970cac574', {
            cluster: 'ap2'
        });
        var channel = pusher.subscribe('my-channel');
        channel.bind('App\\Events\\MyEvent', function(data) {
            console.log(data)
            alert(JSON.stringify(data));
        });

    </script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.6.22/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.6.22/dist/js/uikit-icons.min.js"></script>
</head>

<body>
    <nav class="uk-navbar-container" uk-navbar>

        <div class="uk-navbar-left">

            <ul class="uk-navbar-nav">
                <li class="uk-active">
                    <a href="#">
                        <img src="{{ asset('images/logo/job_portal_logo.png') }}" alt="Logo" style="width: 160px;">
                    </a>
                </li>
            </ul>

        </div>

        <div class="uk-navbar-right">

            <ul class="uk-navbar-nav">
                <li class="uk-active"><a href="{{ url('login') }}">Login</a></li>
            </ul>

        </div>

    </nav>
    <div>
        <img src="{{ asset('images/banner/coming_soon.png') }}" alt="" style="width: 100vw;">
    </div>
</body>
