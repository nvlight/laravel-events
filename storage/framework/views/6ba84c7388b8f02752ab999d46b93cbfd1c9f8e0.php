<tr data-evento-id="<?php echo e($evento['evento']['evento_id']); ?>">
    <td class="evento_id"><?php echo e($evento['evento']['evento_id']); ?></td>
    <td class="category_td">
        <div class="categories_wrapper">
            <?php if(count($evento['categories'])): ?>
                <?php $__currentLoopData = $evento['categories']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="eventoCategoryDiv" data-eventoCategoryId="<?php echo e($category['evento_evento_category_id']); ?>" data-categoryId="<?php echo e($category['evento_category_id']); ?>">
                        <span class="categoryNameText" data-textValue="<?php echo e($category['evento_category_name']); ?>"><?php echo e($category['evento_category_name']); ?></span>
                        <a href=""
                           class="delete_category" data-categoryId="<?php echo e($category['evento_evento_category_id']); ?>">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg" role="button">
                                <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
                            </svg>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>

        
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus-square-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
             data-toggle="modal" data-target="#add-category-modal" role="button">
            <path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
        </svg>
    </td>
    <td class="">
        <div>
            <?php echo e($evento['evento']['evento_description']); ?>

        </div>
       <?php echo $__env->make('cabinet.evento._blocks.attachment', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </td>
    <td class=""><?php echo e($evento['evento']['date']); ?></td>

    <td class="tag_td">
        <div class="tags_wrapper">
            <?php if(count($evento['tags'])): ?>
                <?php $__currentLoopData = $evento['tags']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="eventoTagDiv" data-eventoTagId="<?php echo e($tag['evento_evento_tag_id']); ?>" data-tagId="<?php echo e($tag['evento_tag_id']); ?>">
                        <button class="btn btn-primary btn-sm mb-2" style="background-color: <?php echo e($tag['evento_tag_color']); ?>; border-color: <?php echo e($tag['evento_tag_color']); ?>;">
                            <span class="eventotag_name"><?php echo e($tag['evento_tag_name']); ?></span>
                            <?php if($tag['evento_evento_tag_value_value']): ?>
                                <span class="badge rounded-pill bg-secondary"><?php echo e($tag['evento_evento_tag_value_value']); ?></span>
                            <?php endif; ?>
                        </button>
                        <a href=""
                           class="delete_tag" data-tagId="<?php echo e($tag['evento_evento_tag_id']); ?>">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg" role="button">
                                <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
                            </svg>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>

        
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus-square-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
             data-toggle="modal" data-target="#add-tag-modal" role="button">
            <path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
        </svg>
    </td>
    <td class="border px-4 py-2">
        <a href="<?php echo e(route('cabinet.evento.show',    $evento['evento']['evento_id'] )); ?>" class="d-inline-block evento_get_ajax" title="show" style="text-decoration: none; color: green;">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chat-square-text" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h2.5a2 2 0 0 1 1.6.8L8 14.333 9.9 11.8a2 2 0 0 1 1.6-.8H14a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                <path fill-rule="evenodd" d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
            </svg>
        </a>
        <a href="<?php echo e(route('cabinet.evento.edit',    $evento['evento']['evento_id'] )); ?>" class="d-inline-block evento_edit_ajax" title="редактировать" style="text-decoration: none; color: mediumslateblue;">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pen-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M13.498.795l.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/>
            </svg>
        </a>
        <a href="<?php echo e(route('cabinet.evento.destroy', $evento['evento']['evento_id'] )); ?>" class="d-inline-block evento_delete" title="удалить" style="text-decoration: none; color: #C6443C;">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
            </svg>
        </a>
        <a href="<?php echo e(route('cabinet.evento.attachment.store_ajax', $evento['evento']['evento_id'] )); ?>" class="d-inline-block attachment_store_ajax" title="добавить вложение" data-evento-id="<?php echo e($evento['evento']['evento_id']); ?>">
            <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg"  fill="currentColor" class="bi bi-bookmark" viewBox="0 0 16 16"
                 data-toggle="modal" data-target="#add-attachment-modal" role="button">
                <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
            </svg>
        </a>
    </td>
</tr><?php /**PATH C:\OpenServer3\domains\laravel_events\resources\views/cabinet/evento/_inner/list/item.blade.php ENDPATH**/ ?>