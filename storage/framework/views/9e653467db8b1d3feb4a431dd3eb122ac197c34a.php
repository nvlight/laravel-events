<?php if($errors->any()): ?>
    <ul class="notification text-danger text-center">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <?php echo e($error); ?>

            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
<?php endif; ?><?php /**PATH C:\OpenServer3\domains\laravel_events\resources\views/errors.blade.php ENDPATH**/ ?>