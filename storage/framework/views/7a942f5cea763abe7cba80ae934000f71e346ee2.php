<?php $__env->startSection('content'); ?>

    <?php
    //echo \App\Debug::d($events);
    //echo \App\Debug::d($categories);
    //echo \App\Debug::d($types);
    ?>

    <div class="row">
        <div class="col-md-12">
            <h3>Графики для событий</h3>
            <div>
                <a href="/event">Список событий</a>
            </div>
            <div>
                Фильтр по годам:
                <?php $__currentLoopData = $eventYears; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(\Illuminate\Support\Facades\URL::to('/events-graphics?year='.$year)); ?>"><?php echo e($year); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div id="chart2"></div>
            <div id="chart1"></div>

            <?php echo $chart2; ?>

            <?php echo $chart1; ?>

        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.event', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OpenServer3\domains\laravel_events\resources\views/event/graphics.blade.php ENDPATH**/ ?>