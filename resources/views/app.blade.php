<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <title>Oficina 2.0</title>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <!-- <meta type="text/css" href="./resources/views/app.css"> -->
    @vite("resources/js/app.js")
    @vite("resources/css/app.css")
    @inertiaHead
  </head>
  <body>
    @inertia
  </body>
</html>