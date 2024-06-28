<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Game</title>
    <link rel="stylesheet" href="{{ asset('css/game.css') }}">
</head>
<body>
<section>
    <div class="container game-container">
        <h2>Welcome to the Game!</h2>

        <button class="button" id="sendRequestBtn">Spin</button>

        <div class="spinner" id="spinner">
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3"></div>
            <div class="rect4"></div>
            <div class="rect5"></div>
        </div>

        <div class="result" id="result">
            <div id="result-text"></div>
            <div class="result-values">
                <div id="result-number"></div>
                <div id="result-amount"></div>
            </div>
        </div>

        <button class="button" id="generateUrlBtn">Generate URL</button>

        <h2>URL List</h2>

        <ul class="url-list">
            @foreach($userUrls as $url)
                <li class="url-item">
                    <button class="button" onclick="changeStatus({{ $url->id }}, {{ $url->status }})">Change Status</button>
                    <a href="{{ $url->url }}" target="_blank" data-token="{{$url->id}}" class="{{ $url->status === 0 ? 'url-disabled' : '' }}">{{ $url->url }}</a>
                </li>
            @endforeach
        </ul>
    </div>
</section>
</body>
<script src="{{ asset('js/main.js') }}"></script>
</html>
