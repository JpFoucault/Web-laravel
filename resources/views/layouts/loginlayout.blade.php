<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlowDesk</title> 
    <link rel="stylesheet" href="{{ asset('styles.css') }}" />
    <link rel="icon" type="image/png" sizes="32x32"  href="{{asset('./../assets/Onlylogo.png')}}">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f3f4f6;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('./../assets/DSCF0997.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
        }
    </style>
</head>

<body>
    @yield('content')

    @yield('scripts')
</body>
</html>