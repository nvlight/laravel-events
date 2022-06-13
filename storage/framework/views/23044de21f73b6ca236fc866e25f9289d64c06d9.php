<div class="search-bar pt-3">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <form action="<?php echo e($route); ?>" method="GET">
                    <div class="row">
                        <div class="col-md-11">
                            <div class="form-group">
                                <input type="text" class="form-control" name="text" value="<?php echo e(request('text')); ?>" placeholder="Search for...">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <button class="btn btn-light border" type="submit"><span class="fa fa-search"></span></button>
                            </div>
                        </div>
                    </div>

                    <?php if($category): ?>
                        <div class="row">
                            <?php $__currentLoopData = $category->allAttributes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($attribute->isSelect() || $attribute->isNumber()): ?>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-form-label"><?php echo e($attribute->name); ?></label>

                                            <?php if($attribute->isSelect()): ?>
                                                <select class="form-control" name="attrs[<?php echo e($attribute->id); ?>][equals]">
                                                    <option value=""></option>
                                                    <?php $__currentLoopData = $attribute->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($variant); ?>"<?php echo e($variant === request()->input('attrs.' . $attribute->id . '.equals') ? ' selected' : ''); ?>>
                                                            <?php echo e($variant); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>

                                            <?php elseif($attribute->isNumber()): ?>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="number" class="form-control" name="attrs[<?php echo e($attribute->id); ?>][from]" value="<?php echo e(request()->input('attrs.' . $attribute->id . '.from')); ?>" placeholder="From">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="number" class="form-control" name="attrs[<?php echo e($attribute->id); ?>][to]" value="<?php echo e(request()->input('attrs.' . $attribute->id . '.to')); ?>" placeholder="To">
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>

                </form>
            </div>
            <div class="col-md-3" style="text-align: right">
                <p><a href="<?php echo e(route('cabinet.adverts.create')); ?>" class="btn btn-success"><span class="fa fa-plus"></span> Add New Advertisement</a></p>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\OpenServer3\domains\laravel_events\resources\views/layouts/partials/search.blade.php ENDPATH**/ ?>