<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!--External CSS and scss -->
        <link rel="stylesheet" type="text/css" href="css/index.css" />
        <link rel="stylesheet" type="text/scss" href="css/index.scss" />

        <!--Sweet Alert -->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



        <title>Spiral Test</title>


    </head>
    <body>
        <div id="app">
        </div>


        <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
    </body>
</html>
