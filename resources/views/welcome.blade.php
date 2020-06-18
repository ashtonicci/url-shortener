<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Url Shortener</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" >
        <link rel="stylesheet" href="{{ asset('css/app.css')  }}">
    </head>
    <header>
        <img id="hallnet-logo" src="http://s3.hallnet.co.uk/interview/task/hn-bit-logo.png" height="125px" />
    </header>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <form id="url-form" method="POST" action="/urls">
                    <div class="form-row">
                        <div class="col">
                            <input type="text" class="form-control" id="full-url" placeholder="Long URL (required)" name="full_url">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" id="description" placeholder="Description (optional)" name="description">
                        </div>                        
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                <h1>Recent Links</h1>
                @foreach ($urls as $url)
                    <div data-url-id="{{ $url->id }}" class="url-card">
                        <div class="d-block">
                            <a class="shortened-url" href="{{ $url->full_url }}">{{ $url->short_url }}</a>
                        </div>
                        <div class="d-block">
                            <span>{{ $url->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="d-block">
                            <span>{{ $url->description }}</span>
                        </div>
                        <i>Times Accessed: <span class="times-used">{{ $url->times_used }}<span></i>
                    </div>
                @endforeach
            </div>
        </div>
    </body>
    <footer>
        <script src="{{ asset('js/app.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/AjaxSubmitUrl.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/AjaxVisitUrl.js') }}"></script>
    </footer>
</html>
