<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    @if(!empty(config('services.gtag.key')))
      <!-- Google tag (gtag.js) -->
      <script async src="{{ config('services.gtag.src') }}"></script>
      <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', `{{ config('services.gtag.key') }}`);
    </script>
    @endif
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
    <script src="{{ mix('/js/app.js') }}" defer></script>
    @routes
  </head>
  <body>
    @inertia
  </body>
</html>