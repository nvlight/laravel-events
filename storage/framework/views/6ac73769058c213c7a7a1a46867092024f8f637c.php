<div class="attachments">
    <?php if(count($evento['attachments'])): ?>
        <nav class="navbar">
            <ul class="navbar-nav flex-row">
                <?php echo $__env->renderEach('cabinet.evento._blocks.attachment.item', $evento['attachments'], 'attachment'); ?>
            </ul>
        </nav>
    <?php endif; ?>
</div><?php /**PATH C:\OpenServer3\domains\laravel_events\resources\views/cabinet/evento/_blocks/attachment.blade.php ENDPATH**/ ?>