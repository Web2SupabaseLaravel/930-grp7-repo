{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title', 'Online Clinic')</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
  @yield('content')
</body>
</html>
