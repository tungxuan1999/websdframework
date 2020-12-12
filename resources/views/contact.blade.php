<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('includes.head')
    <title>Contact</title>
</head>
<body>
    <header>
        <div class="siderbar">
          @include('includes.sidebar')
        </div>
      </header>

    <div class="Contact">
        @include('includes.contact')
    </div>
</body>
</html>
