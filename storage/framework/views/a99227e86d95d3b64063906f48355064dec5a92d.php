<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'Laravel-Evento')); ?></title>
    <link href="<?php echo e(asset('bootstrap-5.0.0-alpha2-dist/css/bootstrap.css')); ?>" rel="stylesheet">

    <?php echo $__env->yieldPushContent('header_styles'); ?>
</head>
<body>
    <div id="app">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <script src="<?php echo e(asset('bootstrap-5.0.0-alpha2-dist/js/bootstrap.js')); ?>"></script>

    <?php echo $__env->make('cabinet.evento._inner.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->yieldPushContent('footer_js'); ?>
</body>
</html><?php /**PATH C:\OpenServer3\domains\laravel_events\resources\views/layouts/evento.blade.php ENDPATH**/ ?>