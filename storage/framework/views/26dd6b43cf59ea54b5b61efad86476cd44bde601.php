<?php $__env->startSection('breadcrumbs', ''); ?>

<?php $__env->startSection('content'); ?>
<div class="container">

    <div class="card card-default mb-3">
        <div class="card-header">
            All Categories
        </div>
        <div class="card-body pb-0" style="color: #aaa">
            <div class="row">
                <?php $__currentLoopData = array_chunk($categories, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-3">
                        <ul class="list-unstyled">
                            <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $current): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <li><a href="<?php echo e(route('adverts.index', adverts_path(null, $current))); ?>"><?php echo e($current->name); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    <div class="card card-default mb-3">
        <div class="card-header">
            All Regions
        </div>
        <div class="card-body pb-0" style="color: #aaa">
            <div class="row">
                <?php $__currentLoopData = array_chunk($regions, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-3">
                        <ul class="list-unstyled">
                            <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $current): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <li><a href="<?php echo e(route('adverts.index', adverts_path($current, null))); ?>"><?php echo e($current->name); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.adverts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OpenServer3\domains\laravel_events\resources\views/home.blade.php ENDPATH**/ ?>