<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Swd</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('/documentation/css/swagger-ui.css') }}">
    <link href="{{ asset('assets/img/logo.svg') }}" sizes="any" type="image/svg+xml" id="favicon" rel="icon">
</head>
<body>
<div id="swagger-ui" data-source="{{ route('documentation-swagger-collection') }}"></div>
<script src="{{ asset('/documentation/js/swagger-ui.js') }}" charset="UTF-8"></script>
</body>
</html>
