<?php $__env->startSection('content'); ?>

    <form method="POST" action="<?php echo e(route('login.phone')); ?>">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label for="token" class="col-form-label">SMS Code</label>
            <input id="token" class="form-control<?php echo e($errors->has('token') ? ' is-invalid' : ''); ?>" name="token" value="<?php echo e(old('token')); ?>" required>
            <?php if($errors->has('token')): ?>
                <span class="invalid-feedback"><strong><?php echo e($errors->first('token')); ?></strong></span>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Verify</button>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OpenServer3\domains\laravel_events\resources\views/auth/phone.blade.php ENDPATH**/ ?>