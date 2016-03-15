<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300|Noto+Sans' rel='stylesheet' type='text/css'>
    <style>
        .login-form {
            width: 90%;
            max-width: 500px;
            margin: 60px auto 0;
        }

        svg {
            display: block;
            margin: 30px auto;
        }

        input {
            height: 32px;
            line-height: 32px;
            padding-left: 5px;
            font-family: 'Noto Sans', sans-serif;
            width: 100%;
        }

        label {
            color: #fb1655;
            text-transform: uppercase;
            font-size: 90%;
            font-family: 'Noto Sans', sans-serif;
            padding-top: 20px;
            display: block;
        }

        .submit-btn {
            width: 100%;
            height: 32px;
            margin: 1em auto;
            text-transform: uppercase;
            text-align: center;
            background: #fb1655;
            color: white;
            border: none;
            outline: none;
        }
    </style>
</head>
<body>
<form action="/login" method="POST" class="login-form">
    {!! csrf_field() !!}
    <svg
            xmlns:svg="http://www.w3.org/2000/svg"
            xmlns="http://www.w3.org/2000/svg"
            version="1.0"
            width="124"
            height="171"
            id="svg6700">
        <defs
                id="defs6703" />
        <path
                d="M 34.272792,168.74752 L 104.92176,168.74752 L 121.12152,123.29818 L 121.12152,70.648951 C 121.12152,63.32795 97.271872,58.119526 97.271872,62.099076 L 97.271872,78.298839 L 97.271872,54.899181 C 97.271872,50.63179 73.549337,47.398034 73.549337,54.899181 L 73.549337,72.448924 L 73.549337,8.5498578 C 67.005561,-2.7842939 50.022562,2.6459339 50.022562,8.5498578 L 50.022562,73.798905 L 50.022562,54.449187 C 50.022562,48.609481 26.22282,48.735743 26.22282,54.449187 L 26.22282,104.39846 L 26.22282,78.72622 C 26.32241,71.969226 3.6180734,71.240435 3.2232454,78.72622 L 3.2232454,105.74844 L 34.272792,168.74752 z "
                style="fill:white;fill-opacity:1;fill-rule:evenodd;stroke:#fb1655;stroke-width:3.86915421;stroke-linecap:butt;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                id="path6709" />
    </svg>
    <div class="form-group">
        <label for="email">Your Email: </label>
        <input type="email" name="email" value="{{ old('email') }}">
    </div>
    <div class="form-group">
        <label for="password">Password: </label>
        <input type="password" name="password">
    </div>
    <div class="form-group">
        <button type="submit" class="submit-btn">Login</button>
    </div>
</form>
</body>
</html>