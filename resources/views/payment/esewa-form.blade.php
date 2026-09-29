<!DOCTYPE html>
<html>
<head>
    <title>Redirecting to eSewa...</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body onload="document.getElementById('esewaForm').submit()">
    <div style="font-family:sans-serif;text-align:center;padding:60px">
        <p style="font-size:2rem">💚</p>
        <p>Redirecting to eSewa secure payment...</p>
        <p style="color:#888;font-size:.9rem">Please do not close this window.</p>
    </div>
    <form id="esewaForm" method="POST" action="{{ $endpoint }}">
        @foreach($params as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    </form>
</body>
</html>
