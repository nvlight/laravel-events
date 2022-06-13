<?php if(session('status')): ?>
    <div class="alert alert-success">
        <?php echo e(session('status')); ?>

    </div>
<?php endif; ?>

<?php if(session('success')): ?>
    <div class="alert alert-success">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger">
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>

<?php if(session('info')): ?>
    <div class="alert alert-info">
        <?php echo e(session('info')); ?>

    </div>
<?php endif; ?><?php /**PATH C:\OpenServer3\domains\laravel_events\resources\views/layouts/partials/flash.blade.php ENDPATH**/ ?>