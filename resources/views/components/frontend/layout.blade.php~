<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>{{$title ?? 'TheGazette - News Magazine HTML5 Template | Home'}}</title>

    <!-- Favicon  -->
    <link rel="icon" href="{{asset('assets/frontend/img/core-img/favicon.ico')}}">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="{{asset('assets/frontend/css/core-style.css')}}">
    <!-- Responsive CSS -->
    <link href="{{asset('assets/frontend/css/responsive.css')}}" rel="stylesheet">

</head>

<body>
<!-- Header Area Start -->
<x-frontend.header.index :breakingNews="$breakingNews" :categories="$categories"/>
<!-- Header Area End -->

{{ $slot }}

<!-- Footer Area Start -->
<x-frontend.footer.index/>
<!-- Footer Area End -->

<!-- jQuery (Necessary for All JavaScript Plugins) -->
<script src="{{asset('assets/frontend/js/jquery/jquery-2.2.4.min.js')}}"></script>
<!-- Popper js -->
<script src="{{asset('assets/frontend/js/popper.min.js')}}"></script>
<!-- Bootstrap js -->
<script src="{{asset('assets/frontend/js/bootstrap.min.js')}}"></script>
<!-- Plugins js -->
<script src="{{asset('assets/frontend/js/plugins.js')}}"></script>
<!-- Active js -->
<script src="{{asset('assets/frontend/js/active.js')}}"></script>

</body>

</html>
