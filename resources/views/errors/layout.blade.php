<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Error Page')</title>
    <link rel="stylesheet" href="{{ asset('/css/error.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/404.css') }}">
    <style>
        body {
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: #333;
            text-align: center;
        }
        .error-page {
            max-width: 600px;
            padding: 20px;
        }
        .error-page img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
        .error-page h1 {
            font-size: 80px;
            margin-bottom: 10px;
        }
        .error-page h2 {
            font-size: 24px;
            margin-bottom: 15px;
        }
        .error-page p {
            font-size: 16px;
            line-height: 1.5;
        }
        .error-page a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
        .error-page a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="error-page">
        @yield('content')
    </div>
</body>
</html>
