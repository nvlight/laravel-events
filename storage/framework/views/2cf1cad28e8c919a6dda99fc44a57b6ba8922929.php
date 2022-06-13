<li class="nav-item">
    <div class="nav-link mr-3">
        <a href="<?php echo e(route('cabinet.evento.attachment.download', $attachment['evento_attachment_id'])); ?>" target="">
            <?php echo e($attachment['evento_attachment_originalname']); ?>

        </a>
        <a href="<?php echo e(route('cabinet.evento.attachment.destroyAndBack', $attachment['evento_attachment_id'])); ?>" class="ml-3 text-danger attachment_delete"
            data-attachmentId="<?php echo e($attachment['evento_attachment_id']); ?>"
        >
            delete
        </a>
    </div>
</li>
<?php /**PATH C:\OpenServer3\domains\laravel_events\resources\views/cabinet/evento/_blocks/attachment/item.blade.php ENDPATH**/ ?>