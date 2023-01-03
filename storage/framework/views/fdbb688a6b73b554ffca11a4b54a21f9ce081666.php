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
   <h4 class="page-title"><?php echo e(__('Blog')); ?></h4>
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
         <a href="#"><?php echo e(__('Blog Page')); ?></a>
      </li>
      <li class="separator">
         <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
         <a href="#"><?php echo e(__('Blog')); ?></a>
      </li>
   </ul>
</div>
<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-header">
            <div class="row">
               <div class="col-lg-4">
                  <div class="card-title d-inline-block"><?php echo e(__('Blog')); ?></div>
               </div>
               <div class="col-lg-3">
                  <?php if(!empty($langs)): ?>
                  <select name="language" class="form-control" onchange="window.location='<?php echo e(url()->current() . '?language='); ?>'+this.value">
                     <option value="" selected disabled><?php echo e(__('Select a Language')); ?></option>
                     <?php $__currentLoopData = $langs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <option value="<?php echo e($lang->code); ?>" <?php echo e($lang->code == request()->input('language') ? 'selected' : ''); ?>><?php echo e($lang->name); ?></option>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                  <?php endif; ?>
               </div>
               <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
                  <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> <?php echo e(__('Add Blog')); ?></a>
                  <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete" data-href="<?php echo e(route('admin.blog.bulk.delete')); ?>"><i class="flaticon-interface-5"></i> <?php echo e(__('Delete')); ?></button>
               </div>
            </div>
         </div>
         <div class="card-body">
            <div class="row">
               <div class="col-lg-12">
                  <?php if(count($blogs) == 0): ?>
                  <h3 class="text-center"><?php echo e(__('NO BLOG FOUND')); ?></h3>
                  <?php else: ?>
                  <div class="table-responsive">
                     <table class="table table-striped mt-3" id="basic-datatables">
                        <thead>
                           <tr>
                              <th scope="col">
                                 <input type="checkbox" class="bulk-check" data-val="all">
                              </th>
                              <th scope="col"><?php echo e(__('Image')); ?></th>
                              <th scope="col"><?php echo e(__('Category')); ?></th>
                              <th scope="col"><?php echo e(__('Title')); ?></th>
                              <th scope="col"><?php echo e(__('Publish Date')); ?></th>
                              <th scope="col"><?php echo e(__('Serial Number')); ?></th>
                              <th scope="col"><?php echo e(__('Actions')); ?></th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr>
                              <td>
                                 <input type="checkbox" class="bulk-check" data-val="<?php echo e($blog->id); ?>">
                              </td>
                              <td><img src="<?php echo e(asset('assets/front/img/blogs/'.$blog->main_image)); ?>" alt="" width="80"></td>
                              <td><?php echo e($blog->bcategory->name); ?></td>
                              <td width="20%">
                                <?php echo e($blog->title); ?>

                              </td>
                              <td>
                                 <?php
                                 $date = \Carbon\Carbon::parse($blog->created_at);
                                 ?>
                                 <?php echo e($date->translatedFormat('jS F, Y')); ?>

                              </td>
                              <td><?php echo e($blog->serial_number); ?></td>
                              <td>
                                 <a class="btn btn-secondary btn-sm" href="<?php echo e(route('admin.blog.edit', $blog->id) . '?language=' . request()->input('language')); ?>">
                                 <span class="btn-label">
                                 <i class="fas fa-edit"></i>
                                 </span>
                                 <?php echo e(__('Edit')); ?>

                                 </a>
                                 <form class="deleteform d-inline-block" action="<?php echo e(route('admin.blog.delete')); ?>" method="post">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="blog_id" value="<?php echo e($blog->id); ?>">
                                    <button type="submit" class="btn btn-danger btn-sm deletebtn">
                                    <span class="btn-label">
                                    <i class="fas fa-trash"></i>
                                    </span>
                                    <?php echo e(__('Delete')); ?>

                                    </button>
                                 </form>
                              </td>
                           </tr>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                     </table>
                  </div>
                  <?php endif; ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Create Blog Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Add Blog')); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <form id="ajaxForm" enctype="multipart/form-data" class="modal-form" action="<?php echo e(route('admin.blog.store')); ?>" method="POST">
               <?php echo csrf_field(); ?>
               <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <div class="col-12 mb-2">
                        <label for="image"><strong><?php echo e(__('Image')); ?></strong></label>
                      </div>
                      <div class="col-md-12 showImage mb-3">
                        <img src="<?php echo e(asset('assets/admin/img/noimage.jpg')); ?>" alt="..." class="img-thumbnail">
                      </div>
                      <input type="file" name="image" id="image" class="form-control">
                      <p id="errimage" class="mb-0 text-danger em"></p>
                      <p class="text-warning mb-0"><?php echo e(__('Upload 900 X 570 image for best quality')); ?></p>
                    </div>
                  </div>
                </div>

               <div class="form-group">
                  <label for=""><?php echo e(__('Language')); ?> **</label>
                  <select id="language" name="language_id" class="form-control">
                     <option value="" selected disabled><?php echo e(__('Select a language')); ?></option>
                     <?php $__currentLoopData = $langs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <option value="<?php echo e($lang->id); ?>"><?php echo e($lang->name); ?></option>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                  <p id="errlanguage_id" class="mb-0 text-danger em"></p>
               </div>
               <div class="form-group">
                  <label for=""><?php echo e(__('Title')); ?> **</label>
                  <input type="text" class="form-control" name="title" placeholder="<?php echo e(__('Enter title')); ?>" value="">
                  <p id="errtitle" class="mb-0 text-danger em"></p>
               </div>
               <div class="form-group">
                  <label for=""><?php echo e(__('Category')); ?> **</label>
                  <select id="bcategory" class="form-control" name="category" disabled>
                     <option value="" selected disabled><?php echo e(__('Select a category')); ?></option>
                  </select>
                  <p id="errcategory" class="mb-0 text-danger em"></p>
               </div>
               <div class="form-group">
                  <label for=""><?php echo e(__('Content')); ?> **</label>
                  <textarea class="form-control summernote" name="content" rows="8" cols="80" placeholder="Enter content"></textarea>
                  <p id="errcontent" class="mb-0 text-danger em"></p>
               </div>

               <div class="form-group">
                  <label for=""><?php echo e(__('Serial Number')); ?> **</label>
                  <input type="number" class="form-control ltr" name="serial_number" value="" placeholder="<?php echo e(__('Enter Serial Number')); ?>">
                  <p id="errserial_number" class="mb-0 text-danger em"></p>
                  <p class="text-warning mb-0"><small><?php echo e(__('The higher the serial number is, the later the blog will be shown.')); ?></small></p>
               </div>
               <div class="form-group">
                  <label for=""><?php echo e(__('Meta Keywords')); ?></label>
                  <input type="text" class="form-control" name="meta_keywords" value="" data-role="tagsinput">
               </div>
               <div class="form-group">
                  <label for=""><?php echo e(__('Meta Description')); ?></label>
                  <textarea type="text" class="form-control" name="meta_description" rows="5"></textarea>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
            <button id="submitBtn" type="button" class="btn btn-primary"><?php echo e(__('Submit')); ?></button>
         </div>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\coursemat\resources\views/admin/blog/blog/index.blade.php ENDPATH**/ ?>