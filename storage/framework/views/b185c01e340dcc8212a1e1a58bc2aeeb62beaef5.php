<?php if($errors->has($column)): ?>
    <ul class="notification text-danger text-center">
        <?php $__currentLoopData = $errors->get($column); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <?php echo e($error); ?>

            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
<?php endif; ?>
<?php /**PATH C:\OpenServer3\domains\laravel_events\resources\views/errors_show_single.blade.php ENDPATH**/ ?>