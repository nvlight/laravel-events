<?php if(session()->has('crud_message')): ?>
    <div class="<?php echo e(session()->get('crud_message')['class']); ?>">
        <?php echo e(session()->get('crud_message')['message']); ?>

    </div>
<?php endif; ?><?php /**PATH C:\OpenServer3\domains\laravel_events\resources\views/cabinet/evento/_blocks/flash_message.blade.php ENDPATH**/ ?>