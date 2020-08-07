<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="/css/app.css">
</head>

<body class="scrollbar-lg">
    <div class="header">
        <div style="padding: 1em; position: fixed;">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="3em" height="3em" style="margin-left:auto; margin-right:auto;" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M9.973 18H11v-5h2v5h1.027c.132-1.202.745-2.194 1.74-3.277c.113-.122.832-.867.917-.973a6 6 0 1 0-9.37-.002c.086.107.807.853.918.974c.996 1.084 1.609 2.076 1.741 3.278zM10 20v1h4v-1h-4zm-4.246-5a8 8 0 1 1 12.49.002C17.624 15.774 16 17 16 18.5V21a2 2 0 0 1-2 2h-4a2 2 0 0 1-2-2v-2.5C8 17 6.375 15.774 5.754 15z" fill="white"/></svg>
            <br />
            <p style="color: white; margin-top: -15px;">MegaIDEAS</p>
        </div>
        <p style="padding: 1.5rem; color: white; font-size: 18px;">@yield('title')</p>
    </div>
    <div class="main">
        @yield('content')
    </div>
</body>
</html>
