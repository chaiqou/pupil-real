<!DOCTYPE html>
<html class="h-full bg-gray-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Select Student | PupilPay</title>
    <link rel="stylesheet" href="<?php echo asset('css/app.css'); ?>" type="text/css">

</head>

<body id='app' class="h-full">
    <select-students :students='{{ json_encode($students) }}'></select-students>
</body>

</html>
<script src="{{ mix('js/app.js') }}"></script>
