<?php $__env->startSection('content'); ?>

    <?php
    //echo \App\Debug::d($events);
    //echo \App\Debug::d($categories->toArray());
    //echo \App\Debug::d($category_id);
    //echo \App\Debug::d($types);
    //echo \App\Debug::d($_GET);
    //echo \App\Debug::d($events->count(),'$events->count()');
    //echo \App\Debug::d($vld->fails(),'fails',2);
    //echo \App\Debug::d($events);
    //dd($events);
    ?>

    <a href="/event">Список событий</a>

    <div class="row">

        <div class="col-md-9">
            <h3>Результаты поиска</h3>
            <?php if(($events_count)): ?>
                <p>Найдено записей: <?php echo e(($events_count)); ?></p>
            <?php endif; ?>
            <table class="table table-bordered table-striped table-responsive">
                <tr>
                    <th>№</th>
                    <th>Категория</th>
                    <th>Описание</th>
                    <th>Сумма</th>
                    <th>Дата</th>
                    <th>Тип</th>
                    <th>Действия</th>
                </tr>

                <?php echo $__env->make('events-table-data', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            </table>

            <?php
                //echo \App\Debug::d($_SERVER);
                if (mb_strpos($_SERVER['QUERY_STRING'], '&') ){

                    $qs = explode('&', $_SERVER['QUERY_STRING']);
                    //echo \App\Debug::d($qs); die;
                    $sqr = []; $sqr2 = []; $sqr3 = [];
                    if (is_array($qs))
                        foreach($qs as $k => $v){
                            $sqr[] = explode('=', $v);
                        }

                    // процентики в урле, вместо [] для массивов, убираю
                    foreach($sqr as $k => &$v)
                        $v[0] = urldecode($v[0]);
                    unset($v);

                    // делаю массив для категорий и типов
                    foreach($sqr as $k => $v)
                    $sqr2[$v[0]][] = $v[1];

                    // убираю сам знак массива
                    foreach(array_keys($sqr2) as $v){
                        if (mb_strpos('[', $v) === false){
                            $sqr3[str_replace('[]', '', $v)] = $sqr2[$v];
                        }else{
                            $sqr3[$v] = $sqr2[$v][0];
                        }
                    }
                }
                //echo \App\Debug::d($sqr3);
                //echo \App\Debug::d(\request('category_id'));
            ?>

            <?php if(!is_null($events)): ?>
                <?php
                //$events->appends(['chich' => ['marin','yeaw'] ]); //$_SERVER['QUERY_STRING']
                //$events->appends(['chich[]' => 'Ori']); //$_SERVER['QUERY_STRING']
                //$events->fragment($_SERVER['QUERY_STRING']);
                //echo \App\Debug::d(array_keys($sqr3));
                $needed_array_keys = ['category_id', 'type_id'];
                ?>
                <?php $__currentLoopData = array_keys($sqr3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(in_array($v, $needed_array_keys)): ?>
                        <?php $events->appends([$v.'[]' => $sqr3[$v][0]]); ?>
                    <?php else: ?>
                        <?php $events->appends([$v => $sqr3[$v][0] ]); ?>

                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php echo e($events->links()); ?>

            <?php endif; ?>
        </div>

        <div class="col-md-3">
            <h3>Фильтр событий</h3>

            <form action="" method="GET">
                <div class="mb-3 ">

                    <div>
                        <label for="category_id">Категория</label>
                        <select class="form-control" name="category_id[]" id="category_id" multiple="multiple">
                            <option value="0" >Выбрать все</option>
                            <?php if($categories->count()): ?>

                                <?php if(!$vld->fails()): ?>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <?php $f = false; ?>
                                        <?php $__currentLoopData = $category_id; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ctg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if( $category->id == $ctg->id ): ?>
                                                <?php $f = true; ?>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <?php if( $f == true ): ?>
                                            <option selected value="<?php echo e($category->id); ?>" >
                                                <span>
                                                    <svg height="32" class="octicon octicon-check" viewBox="0 0 12 16" version="1.1" width="24" aria-hidden="true"><path fill-rule="evenodd" d="M12 5l-8 8-4-4 1.5-1.5L4 10l6.5-6.5L12 5z"></path></svg>
                                                </span>
                                                <?php echo e($category->name); ?>

                                            </option>
                                        <?php else: ?>
                                            <option value="<?php echo e($category->id); ?>" ><?php echo e($category->name); ?></option>
                                        <?php endif; ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" ><?php echo e($category->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>

                            <?php endif; ?>
                        </select>
                    </div>


                </div>

                <div class="mb-3">
                    <label for="type_id">Тип</label>
                    <select class="form-control" name="type_id[]" id="type_id" multiple>
                        <option value="0" >Выбрать все</option>
                        <?php if($types->count()): ?>

                            <?php if(!$vld->fails()): ?>
                                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                    <?php $f = false; ?>
                                    <?php $__currentLoopData = $type_id; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if( $type->id == $tp->id ): ?>
                                            <?php $f = true; ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php if( $f == true ): ?>
                                        <option selected value="<?php echo e($type->id); ?>" >
                                                <span>
                                                    <svg height="32" class="octicon octicon-check" viewBox="0 0 12 16" version="1.1" width="24" aria-hidden="true"><path fill-rule="evenodd" d="M12 5l-8 8-4-4 1.5-1.5L4 10l6.5-6.5L12 5z"></path></svg>
                                                </span>
                                            <?php echo e($type->name); ?>

                                        </option>
                                    <?php else: ?>
                                        <option value="<?php echo e($type->id); ?>" ><?php echo e($type->name); ?></option>
                                    <?php endif; ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($type->id); ?>" ><?php echo e($type->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                        <?php endif; ?>
                    </select>
                </div>


                <div class="mb-3 dts-start-end">

                    <div>
                        <label for="date">Начало периода</label>
                        <input data-provide="datepicker" class="form-control <?php echo e($errors->has('date') ? 'border-danger' : ''); ?> mg-date-maxw101" id="date1" name="date1" placeholder="<?=Date('d.m.Y')?>" value="<?php !$vld->fails() ? $out = $date_etalon1 : $out = Date('d.m.Y'); echo $out; ?>" >
                    </div>

                    <div>
                        <label for="date">Конец периода</label>
                        <input data-provide="datepicker" class="form-control <?php echo e($errors->has('date') ? 'border-danger' : ''); ?> mg-date-maxw101" id="date2" name="date2" placeholder="<?=Date('d.m.Y')?>" value="<?php !$vld->fails() ? $out = $date_etalon2 : $out = Date('d.m.Y'); echo $out; ?>" >
                    </div>

                </div>


                <div class="mb-3 amounts-start-end">
                    <div>
                        <label for="amount">Сумма начальная</label>
                        <input class="form-control <?php echo e($errors->has('amount') ? 'border-danger' : ''); ?>" id="amount1" name="amount1" placeholder="0"   value="<?php !$vld->fails() ? $out = $amount1 : $out = 0;    echo $out; ?>" >
                    </div>
                    <div>
                        <label for="amount">Сумма конечная</label>
                        <input class="form-control <?php echo e($errors->has('amount') ? 'border-danger' : ''); ?>" id="amount2" name="amount2" placeholder="500" value="<?php !$vld->fails() ? $out = $amount2 : $out = 57000; echo $out; ?>" >
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description">Описание</label>
                    <input class="form-control <?php echo e($errors->has('description') ? 'border-danger' : ''); ?>" id="description" name="description" placeholder="cool!" value="<?php echo e($description); ?>" >
                </div>


                <script>
                    $('#date1').datepicker({
                        'format' : 'dd.mm.yyyy',
                        'language' : 'ru',
                        'zIndexOffset' : 1000,
                    });
                    $('#date2').datepicker({
                        'format' : 'dd.mm.yyyy',
                        'language' : 'ru',
                        'zIndexOffset' : 1000,
                    });

                </script>

                <?php echo $__env->make('errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <div class="filter-controls-do-flex">
                    <div class="mb-3">
                        <button class="btn btn-success">Искать</button>
                    </div>

                    <div class="mb-3">
                        <a href="/event-filter" class="btn btn-primary">Сбросить</a>
                    </div>
                </div>

            </form>
        </div>

    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.event', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OpenServer3\domains\laravel_events\resources\views/event/filter.blade.php ENDPATH**/ ?>