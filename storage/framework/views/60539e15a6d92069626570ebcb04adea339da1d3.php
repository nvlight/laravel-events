<?php if(!is_null($events) && $events->count()): ?>
    <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event_key => $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($event->id); ?></td>
            <td><?php echo e($event->category_name); ?></td>
            <td><?php echo strip_tags($event->description); ?></td>
            <td><?php echo e($event->amount); ?></td>
            <td class="mg-date-nowrap"><?php echo e($event->date); ?></td>
            <td>
                <button class="btn" style="background-color: #<?php echo e($event->color); ?>; color: #ffffff;">
                    <?php echo e($event->type_name); ?>

                </button>
            </td>
            <td class="td-btn-flex-1">

                <a href="/event/<?php echo e($event->id); ?>">
                    <button class="mg-btn-1" type="submit" title="просмотреть">
                        <svg height="25" class="mg-btn-show" viewBox="0 0 12 16" version="1.1" width="28" aria-hidden="true"><path fill-rule="evenodd" d="M6 5H2V4h4v1zM2 8h7V7H2v1zm0 2h7V9H2v1zm0 2h7v-1H2v1zm10-7.5V14c0 .55-.45 1-1 1H1c-.55 0-1-.45-1-1V2c0-.55.45-1 1-1h7.5L12 4.5zM11 5L8 2H1v12h10V5z"></path></svg>
                    </button>
                </a>

                <a href="/event/<?php echo e($event->id); ?>/edit">
                    <button class="mg-btn-1" type="submit" title="редактировать">
                        <svg height="22" viewBox="0 0 14 16" version="1.1" width="28" aria-hidden="true" class="mg-btn-edit"><path fill-rule="evenodd" d="M0 12v3h3l8-8-3-3-8 8zm3 2H1v-2h1v1h1v1zm10.3-9.3L12 6 9 3l1.3-1.3a.996.996 0 0 1 1.41 0l1.59 1.59c.39.39.39 1.02 0 1.41z"></path></svg>
                    </button>
                </a>

                <form action="/event/<?php echo e($event->id); ?>" class="delete-event-by-id" method="POST" style="">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button class="mg-btn-1" type="submit" title="удалить">
                        <svg viewBox="0 0 12 16" version="1.1" aria-hidden="true" width="28" class="mg-btn-delete"  height="29"><path fill-rule="evenodd" d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48L7.48 8z"></path></svg>
                    </button>
                </form>

                <form action="/event_copy/<?php echo e($event->id); ?>" class="copy-event-by-id" method="POST" style="">
                    <?php echo csrf_field(); ?>
                    <button class="mg-btn-1" type="submit" title="копировать">
                        <svg class="mg-btn-copy" xmlns="http://www.w3.org/2000/svg" width="28" height="29" viewBox="0 0 16 16" fill="currentColor"><path fill-rule="evenodd" d="M15 1H6c-.55 0-1 .45-1 1v2H1c-.55 0-1 .45-1 1v6c0 .55.45 1 1 1h1v3l3-3h4c.55 0 1-.45 1-1V9h1l3 3V9h1c.55 0 1-.45 1-1V2c0-.55-.45-1-1-1zM9 11H4.5L3 12.5V11H1V5h4v3c0 .55.45 1 1 1h3v2zm6-3h-2v1.5L11.5 8H6V2h9v6z"/></svg>
                    </button>
                </form>

            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
    <tr>
        <td class="">Список пуст</td>
    </tr>
<?php endif; ?>

<?php /**PATH C:\OpenServer3\domains\laravel_events\resources\views/events-table-data.blade.php ENDPATH**/ ?>