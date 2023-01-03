<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/bootstrap-iconpicker.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php
$selLang = \App\Models\Language::where('code', request()->input('language'))->first();
?>
<?php if(!empty($selLang) && $selLang->rtl == 1): ?>
<?php $__env->startSection('styles'); ?>
<style>
    form:not(.modal-form) input,
    form:not(.modal-form) textarea,
    form:not(.modal-form) select,
    select[name='language'] {
        direction: rtl;
    }
    form:not(.modal-form) .note-editor.note-frame .note-editing-area .note-editable {
        direction: rtl;
        text-align: right;
    }
</style>
<?php $__env->stopSection(); ?>
<?php endif; ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h4 class="page-title"><?php echo e(__('Drag & Drop Menu Builder')); ?></h4>
    <ul class="breadcrumbs">
        <li class="nav-home">
            <a href="<?php echo e(route('admin.dashboard')); ?>">
                <i class="flaticon-home"></i>
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#"><?php echo e(__('Menu Builder')); ?></a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-10">
                        <div class="card-title"><?php echo e(__('Menu Builder')); ?></div>
                    </div>
                    <div class="col-lg-2">
                        <?php if(!empty($langs)): ?>
                        <select name="language" class="form-control" onchange="window.location='<?php echo e(url()->current() . '?language='); ?>'+this.value">
                            <option value="" selected disabled><?php echo e(__('Select a Language')); ?></option>
                            <?php $__currentLoopData = $langs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($lang->code); ?>" <?php echo e($lang->code == request()->input('language') ? 'selected' : ''); ?>><?php echo e($lang->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-body pt-5 pb-5">
                <div class="row no-gutters">
                    <div class="col-lg-4">
                        <div class="card border-primary mb-3">
                            <div class="card-header bg-primary text-white"><?php echo e(__('Pre-built Menus')); ?></div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item"><?php echo e(__('Home')); ?> <a data-text="<?php echo e(__('Home')); ?>" data-type="home" class="addToMenus btn btn-primary btn-sm float-right" href=""><?php echo e(__('Add to Menus')); ?></a></li>
                                    <li class="list-group-item"><?php echo e(__('Listings')); ?>

                                        <a data-text="<?php echo e(__('Listings')); ?>" data-type="listings" class="addToMenus btn btn-primary btn-sm float-right" href=""><?php echo e(__('Add to Menus')); ?></a>
                                    </li>
                                    <li class="list-group-item"><?php echo e(__('Pricing')); ?>

                                        <a data-text="<?php echo e(__('Pricing')); ?>" data-type="pricing" class="addToMenus btn btn-primary btn-sm float-right" href=""><?php echo e(__('Add to Menus')); ?></a>
                                    </li>
                                    <li class="list-group-item"><?php echo e(__('Blog')); ?>

                                        <a data-text="<?php echo e(__('Blog')); ?>" data-type="blog" class="addToMenus btn btn-primary btn-sm float-right" href=""><?php echo e(__('Add to Menus')); ?></a>
                                    </li>

                                    <li class="list-group-item"><?php echo e(__('FAQs')); ?> <a data-text="<?php echo e(__('FAQs')); ?>" data-type="faq" class="addToMenus btn btn-primary btn-sm float-right" href=""><?php echo e(__('Add to Menus')); ?></a></li>

                                    <li class="list-group-item"><?php echo e(__('Contact')); ?> <a data-text="<?php echo e(__('Contact')); ?>" data-type="contact" class="addToMenus btn btn-primary btn-sm float-right" href=""><?php echo e(__('Add to Menus')); ?></a></li>

                                    <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="list-group-item">
                                        <?php echo e($page->name); ?> <span class="badge badge-primary"><?php echo e(__('Custom Page')); ?></span>
                                        <a data-text="<?php echo e($page->name); ?>" data-type="<?php echo e($page->id); ?>" data-custom="yes" class="addToMenus btn btn-primary btn-sm float-right" href=""><?php echo e(__('Add to Menus')); ?></a>
                                    </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card border-primary mb-3">
                            <div class="card-header bg-primary text-white"><?php echo e(__('Add / Edit Menu')); ?></div>
                            <div class="card-body">
                                <form id="frmEdit" class="form-horizontal">
                                    <input class="item-menu" type="hidden" name="type" value="">

                                    <div id="withUrl">
                                        <div class="form-group">
                                            <label for="text"><?php echo e(__('Text')); ?></label>
                                            <input type="text" class="form-control item-menu" name="text" placeholder="<?php echo e(__('Text')); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="href"><?php echo e(__('URL')); ?></label>
                                            <input type="text" class="form-control item-menu" name="href" placeholder="<?php echo e(__('URL')); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="target"><?php echo e(__('Target')); ?></label>
                                            <select name="target" id="target" class="form-control item-menu">
                                                <option value="_self"><?php echo e(__('Self')); ?></option>
                                                <option value="_blank"><?php echo e(__('Blank')); ?></option>
                                                <option value="_top"><?php echo e(__('Top')); ?></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div id="withoutUrl" class="dis-none">
                                        <div class="form-group">
                                            <label for="text"><?php echo e(__('Text')); ?></label>
                                            <input type="text" class="form-control item-menu" name="text" placeholder="<?php echo e(__('Text')); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="href"><?php echo e(__('URL')); ?></label>
                                            <input type="text" class="form-control item-menu" name="href" placeholder="<?php echo e(__('URL')); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="target"><?php echo e(__('Target')); ?></label>
                                            <select name="target" class="form-control item-menu">
                                                <option value="_self"><?php echo e(__('Self')); ?></option>
                                                <option value="_blank"><?php echo e(__('Blank')); ?></option>
                                                <option value="_top"><?php echo e(__('Top')); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <button type="button" id="btnUpdate" class="btn btn-primary" disabled><i class="fas fa-sync-alt"></i> <?php echo e(__('Update')); ?></button>
                                <button type="button" id="btnAdd" class="btn btn-success"><i class="fas fa-plus"></i> <?php echo e(__('Add')); ?></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card mb-3">
                            <div class="card-header bg-primary text-white"><?php echo e(__('Website Menus')); ?></div>
                            <div class="card-body">
                                <ul id="myEditor" class="sortableLists list-group">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer pt-3">
                <div class="form">
                    <div class="form-group from-show-notify row">
                        <div class="col-12 text-center">
                            <button id="btnOutput" class="btn btn-success"><?php echo e(__('Update Menu')); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('scripts'); ?>
<script type="text/javascript" src="<?php echo e(asset('assets/admin/js/plugin/jquery-menu-editor/jquery-menu-editor.js')); ?>"></script>
<script>
    "use strict";
    var prevMenus = <?php echo json_encode($prevMenu) ?>;
    var langid = <?php echo e($lang_id); ?>;
    var menuUpdate = "<?php echo e(route('admin.menu_builder.update')); ?>";
</script>
<script type="text/javascript" src="<?php echo e(asset('assets/admin/js/menu-builder.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\gigo\resources\views/admin/menu_builder/index.blade.php ENDPATH**/ ?>