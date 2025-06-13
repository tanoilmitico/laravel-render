<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
<head>
    @include ('partials.head', ['pageTitle'=> '$pageTitle', 'metaTitle' => '$metaTitle'])
</head>
<title>@yield('title', 'App')</title>
    <body>
@include ('partials.menu')
<div> 
    @yield ('content')
</div>

</body>
</html>
