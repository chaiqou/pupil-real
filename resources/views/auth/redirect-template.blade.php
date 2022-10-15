<!DOCTYPE html>
<html class="h-full bg-gray-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $header }} | PupilPay</title>
    <link rel="stylesheet" href="<?php echo asset('css/app.css'); ?>" type="text/css">
</head>

<body class="h-full">
    <div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8"
    data-sal="slide-up"
        data-sal-duration="500"
        data-sal-delay="200">
        <div class="w-full max-w-md space-y-8">
            <div>
                <img class="mx-auto h-12 w-auto" src="https://pupilpay.hu/resc/img/pupilpay-black-color.svg"
                    alt="PupilPay" />
                <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">{{ $title }}</h2>
                <p class="mt-2 text-center text-lg font-semibold text-gray-700">
                    {{ $description }}
                </p>
                <p class="mt-2 text-center text-xs text-gray-600">
                    {{ $small_description }}
                </p>
            </div>

        </div>
    </div>
    <script src="<?php echo asset('js/sal.js') ?>"></script>
<script>
sal({
    threshold: 0,
    once: true,
});
</script>
</body>

</html>
