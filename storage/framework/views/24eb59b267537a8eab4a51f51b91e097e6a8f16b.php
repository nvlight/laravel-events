<?php $__env->startSection('content'); ?>

    <?php
    //echo \App\Debug::d($events);
    //echo \App\Debug::d($categories);
    //echo \App\Debug::d($types);
    /**
     * @var \App\Models\Event\Event $event
     */
    ?>

    <style>
        .dropdown-menu.show {
            transform: translate3d(0px, 0px, 0px) !important;
        }

        .dropdown-toggle.btn-light + .dropdown-menu{
            margin-top: 40px;
        }
    </style>

    <div class="row">
        <div class="col-md-6">
            <h3>Редактирование события</h3>
            <a href="<?php echo e(route('event.index')); ?>">Список событий</a>
            <h5 class="text-success"><?=session()->get('event_updated');?></h5>
            <?php
                //dump($event->toArray());
            ?>
            <form action="/event/<?php echo e($event->id); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>

                <div class="mb-3">
                    <label for="category_id">Категория</label>
                    <select data-live-search="true" class="form-control selectpicker" name="category_id" id="category_id">
                        <option value="" disabled>Не выбрано</option>
                        <?php if($categories->count()): ?>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($category->id == $event->category_id): ?>)
                                    <option value="<?php echo e($category->id); ?>" selected><?php echo e($category->name); ?></option>
                                <?php else: ?>
                                    <option value="<?php echo e($category->id); ?>" ><?php echo e($category->name); ?></option>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </select>
                    <?php echo $__env->make('errors_show_single', ['column' => 'category_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>

                <div class="mb-3">
                    <label for="type_id1">Тип</label>
                    <select data-live-search="true" class="form-control selectpicker" name="type_id" id="type_id">
                        <option value="" disabled>Не выбрано</option>
                        <?php if($types->count()): ?>
                            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($type->id === $event->type_id): ?>
                                    <option value="<?php echo e($type->id); ?>" selected><?php echo e($type->name); ?></option>
                                <?php else: ?>
                                    <option value="<?php echo e($type->id); ?>" ><?php echo e($type->name); ?></option>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </select>
                    <?php echo $__env->make('errors_show_single', ['column' => 'type_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>

                <div class="mb-3">
                    <label for="date">Дата</label>
                    <input data-provide="datepicker" class="form-control <?php echo e($errors->has('date') ? 'border-danger' : ''); ?> mg-date-maxw101" id="date" name="date" placeholder="<?=Date('d.m.Y')?>" value="<?php echo e($event->date); ?>" >
                    <?php echo $__env->make('errors_show_single', ['column' => 'date'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>

                <div class="mb-3">
                    <label for="description">Описание</label>
                    <textarea class="form-control <?php echo e($errors->has('description') ? 'border-danger' : ''); ?>" name="description" id="description" cols="30" rows="10"><?php echo e($event->description); ?></textarea>
                    <?php echo $__env->make('errors_show_single', ['column' => 'description'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>

                <div class="mb-3">
                    <label for="amount">Сумма</label>
                    <input class="form-control <?php echo e($errors->has('amount') ? 'border-danger' : ''); ?>" id="amount" name="amount" placeholder="500" value="<?php echo e($event->amount); ?>" >
                    <?php echo $__env->make('errors_show_single', ['column' => 'amount'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>

                <script>
                    $('#date').datepicker({
                        'format' : 'dd.mm.yyyy',
                        'language' : 'ru',
                        'zIndexOffset' : 1000,
                    });
                    $('#description').summernote({
                        placeholder: 'type description here...',
                        tabsize: 4,
                        height: 110
                    });
                </script>



                <div class="mb-3">
                    <button class="btn btn-success">Сохранить</button>
                </div>

            </form>
        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.event', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OpenServer3\domains\laravel_events\resources\views/event/edit.blade.php ENDPATH**/ ?>