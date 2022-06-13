<ul class="nav nav-tabs mb-3">
    <li class="nav-item"><a class="nav-link<?php echo e($page === '' ? ' active' : ''); ?>" href="<?php echo e(route('admin.home')); ?>">Dashboard</a></li>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-adverts')): ?>
        <li class="nav-item"><a class="nav-link<?php echo e($page === 'adverts' ? ' active' : ''); ?>" href="<?php echo e(route('admin.adverts.adverts.index')); ?>">Adverts</a></li>
    <?php endif; ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-banners')): ?>
        <li class="nav-item"><a class="nav-link<?php echo e($page === 'banners' ? ' active' : ''); ?>" href="<?php echo e(route('admin.banners.index')); ?>">Banners</a></li>
    <?php endif; ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-regions')): ?>
        <li class="nav-item"><a class="nav-link<?php echo e($page === 'regions' ? ' active' : ''); ?>" href="<?php echo e(route('admin.regions.index')); ?>">Regions</a></li>
    <?php endif; ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-adverts-categories')): ?>
        <li class="nav-item"><a class="nav-link<?php echo e($page === 'adverts_categories' ? ' active' : ''); ?>" href="<?php echo e(route('admin.adverts.categories.index')); ?>">Categories</a></li>
    <?php endif; ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-users')): ?>
        <li class="nav-item"><a class="nav-link<?php echo e($page === 'users' ? ' active' : ''); ?>" href="<?php echo e(route('admin.users.index')); ?>">Users</a></li>
    <?php endif; ?>
</ul><?php /**PATH C:\OpenServer3\domains\laravel_events\resources\views/admin/_nav.blade.php ENDPATH**/ ?>