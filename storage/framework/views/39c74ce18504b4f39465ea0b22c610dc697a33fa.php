<?php $__env->startSection('content'); ?>

    <?php
    //echo \App\Debug::d($events);
    //echo \App\Debug::d($categories);
    //echo \App\Debug::d($types);
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
            <h3>Создание события</h3>
            <a href="/event">Список событий</a>
            <form action="/event" method="POST">
                <?php echo csrf_field(); ?>

                <div class="mb-3">
                    <label for="category_id">Категория</label>
                    <select data-live-search="true" class="form-control selectpicker" name="category_id" id="category_id">
                        <?php if( !old('category_id')): ?>
                            <option value="" selected>Не выбрано</option>
                        <?php endif; ?>
                        <?php if($categories->count()): ?>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($category->id == old('category_id')): ?>
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
                    <label for="type_id">Тип</label>
                    <select data-live-search="true" class="form-control selectpicker" name="type_id" id="type_id">
                        <?php if( !old('type_id')): ?>
                            <option value="" selected>Не выбрано</option>
                        <?php endif; ?>
                        <?php if($types->count()): ?>
                            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($type->id == old('type_id')): ?>
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
                    <input data-provide="datepicker" class="form-control <?php echo e($errors->has('date') ? 'border-danger' : ''); ?> mg-date-maxw101" id="date" name="date" placeholder="<?=Date('d.m.Y')?>" value="<?=Date('d.m.Y')?>" >
                    <?php echo $__env->make('errors_show_single', ['column' => 'date'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>

                <div class="mb-3">
                    <label for="description">Описание</label>
                    <textarea class="form-control <?php echo e($errors->has('description') ? 'border-danger' : ''); ?>" name="description" id="description" cols="30" rows="10"><?php echo e(old('description')); ?></textarea>
                    <?php echo $__env->make('errors_show_single', ['column' => 'description'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>

                <div class="mb-3">
                    <label for="amount">Сумма</label>
                    <input class="form-control <?php echo e($errors->has('amount') ? 'border-danger' : ''); ?>" id="amount" name="amount" placeholder="500" value="<?php echo e(old('amount')); ?>" >
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
                    <button class="btn btn-success">Создать</button>
                </div>

            </form>
        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.event', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OpenServer3\domains\laravel_events\resources\views/event/create.blade.php ENDPATH**/ ?>