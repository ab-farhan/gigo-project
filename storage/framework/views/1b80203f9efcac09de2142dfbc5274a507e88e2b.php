<?php $__env->startSection('content'); ?>
<div class="page-header">
   <h4 class="page-title"><?php echo e(__('Plugins')); ?></h4>
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
         <a href="#"><?php echo e(__('Basic Settings')); ?></a>
      </li>
      <li class="separator">
         <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
         <a href="#"><?php echo e(__('Plugins')); ?></a>
      </li>
   </ul>
</div>
<div class="row">
   <div class="col-md-12">
      <form id="scriptForm" class="" action="<?php echo e(route('admin.script.update')); ?>" method="post">
         <?php echo csrf_field(); ?>
         <div class="row">

            <div class="col-lg-4">
                <div class="card">
                   <div class="card-header">
                      <div class="card-title">
                         <?php echo e(__('Google Recaptcha')); ?>

                      </div>
                   </div>
                   <div class="card-body">
                      <div class="form-group">
                         <label><?php echo e(__('Google Recaptcha Status')); ?></label>
                         <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                            <input type="radio" name="is_recaptcha" value="1" class="selectgroup-input" <?php echo e($data->is_recaptcha == 1 ? 'checked' : ''); ?>>
                            <span class="selectgroup-button"><?php echo e(__('Active')); ?></span>
                            </label>
                            <label class="selectgroup-item">
                            <input type="radio" name="is_recaptcha" value="0" class="selectgroup-input" <?php echo e($data->is_recaptcha == 0 ? 'checked' : ''); ?>>
                            <span class="selectgroup-button"><?php echo e(__('Deactive')); ?></span>
                            </label>
                         </div>
                         <?php if($errors->has('is_recaptcha')): ?>
                         <p class="mb-0 text-danger"><?php echo e($errors->first('is_recaptcha')); ?></p>
                         <?php endif; ?>
                      </div>
                      <div class="form-group">
                         <label><?php echo e(__('Google Recaptcha Site key')); ?></label>
                         <input class="form-control" name="google_recaptcha_site_key" value="<?php echo e($data->google_recaptcha_site_key); ?>">
                         <?php if($errors->has('google_recaptcha_site_key')): ?>
                         <p class="mb-0 text-danger"><?php echo e($errors->first('google_recaptcha_site_key')); ?></p>
                         <?php endif; ?>
                      </div>
                      <div class="form-group">
                         <label><?php echo e(__('Google Recaptcha Secret key')); ?></label>
                         <input class="form-control" name="google_recaptcha_secret_key" value="<?php echo e($data->google_recaptcha_secret_key); ?>">
                         <?php if($errors->has('google_recaptcha_secret_key')): ?>
                         <p class="mb-0 text-danger"><?php echo e($errors->first('google_recaptcha_secret_key')); ?></p>
                         <?php endif; ?>
                      </div>
                   </div>
                </div>
             </div>

             <div class="col-lg-4">
                <div class="card">
                   <div class="card-header">
                      <div class="card-title"><?php echo e(__('Disqus')); ?></div>
                   </div>
                   <div class="card-body">
                      <div class="form-group">
                         <label><?php echo e(__('Disqus Status (Website Blog Details)')); ?></label>
                         <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                            <input type="radio" name="is_disqus" value="1" class="selectgroup-input" <?php echo e($data->is_disqus == 1 ? 'checked' : ''); ?>>
                            <span class="selectgroup-button"><?php echo e(__('Active')); ?></span>
                            </label>
                            <label class="selectgroup-item">
                            <input type="radio" name="is_disqus" value="0" class="selectgroup-input" <?php echo e($data->is_disqus == 0 ? 'checked' : ''); ?>>
                            <span class="selectgroup-button"><?php echo e(__('Deactive')); ?></span>
                            </label>
                         </div>
                         <?php if($errors->has('is_disqus')): ?>
                         <p class="mb-0 text-danger"><?php echo e($errors->first('is_disqus')); ?></p>
                         <?php endif; ?>
                      </div>
                      <div class="form-group">
                         <label><?php echo e(__('Disqus Status (User Profile Blog Details)')); ?></label>
                         <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                            <input type="radio" name="is_user_disqus" value="1" class="selectgroup-input" <?php echo e($data->is_user_disqus == 1 ? 'checked' : ''); ?>>
                            <span class="selectgroup-button"><?php echo e(__('Active')); ?></span>
                            </label>
                            <label class="selectgroup-item">
                            <input type="radio" name="is_user_disqus" value="0" class="selectgroup-input" <?php echo e($data->is_user_disqus == 0 ? 'checked' : ''); ?>>
                            <span class="selectgroup-button"><?php echo e(__('Deactive')); ?></span>
                            </label>
                         </div>
                         <?php if($errors->has('is_user_disqus')): ?>
                         <p class="mb-0 text-danger"><?php echo e($errors->first('is_user_disqus')); ?></p>
                         <?php endif; ?>
                      </div>
                      <div class="form-group">
                         <label><?php echo e(__('Disqus Shortname')); ?></label>
                         <input class="form-control" name="disqus_shortname" value="<?php echo e($data->disqus_shortname); ?>">
                         <?php if($errors->has('disqus_shortname')): ?>
                         <p class="mb-0 text-danger"><?php echo e($errors->first('disqus_shortname')); ?></p>
                         <?php endif; ?>
                      </div>
                   </div>
                </div>
             </div>

             <div class="col-lg-4">
                <div class="card">
                   <div class="card-header">
                      <div class="card-title"><?php echo e(__('Tawk.to')); ?></div>
                   </div>
                   <div class="card-body">
                      <div class="form-group">
                         <label><?php echo e(__('Tawk.to Status')); ?></label>
                         <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                            <input type="radio" name="is_tawkto" value="1" class="selectgroup-input" <?php echo e($data->is_tawkto == 1 ? 'checked' : ''); ?>>
                            <span class="selectgroup-button"><?php echo e(__('Active')); ?></span>
                            </label>
                            <label class="selectgroup-item">
                            <input type="radio" name="is_tawkto" value="0" class="selectgroup-input" <?php echo e($data->is_tawkto == 0 ? 'checked' : ''); ?>>
                            <span class="selectgroup-button"><?php echo e(__('Deactive')); ?></span>
                            </label>
                         </div>
                         <p class="mb-0 text-warning"><?php echo e(__('If you enable Tawk.to, then WhatsApp must be disabled.')); ?></p>
                         <?php if($errors->has('is_tawkto')): ?>
                         <p class="mb-0 text-danger"><?php echo e($errors->first('is_tawkto')); ?></p>
                         <?php endif; ?>
                      </div>
                      <div class="form-group">
                         <label><?php echo e(__('Tawk.to Direct Chat Link')); ?></label>
                         <input class="form-control" name="tawkto_chat_link" value="<?php echo e($data->tawkto_chat_link); ?>">
                         <?php if($errors->has('tawkto_chat_link')): ?>
                         <p class="mb-0 text-danger"><?php echo e($errors->first('tawkto_chat_link')); ?></p>
                         <?php endif; ?>
                      </div>
                   </div>
                </div>
             </div>
             <div class="col-lg-4">
                <div class="card">
                   <div class="card-header">
                      <div class="card-title"><?php echo e(__('WhatsApp Chat Button')); ?></div>
                   </div>
                   <div class="card-body">
                      <div class="form-group">
                         <label><?php echo e(__('Status')); ?></label>
                         <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                            <input type="radio" name="is_whatsapp" value="1" class="selectgroup-input" <?php echo e($data->is_whatsapp == 1 ? 'checked' : ''); ?>>
                            <span class="selectgroup-button"><?php echo e(__('Active')); ?></span>
                            </label>
                            <label class="selectgroup-item">
                            <input type="radio" name="is_whatsapp" value="0" class="selectgroup-input" <?php echo e($data->is_whatsapp == 0 ? 'checked' : ''); ?>>
                            <span class="selectgroup-button"><?php echo e(__('Deactive')); ?></span>
                            </label>
                         </div>
                         <p class="text-warning mb-0"><?php echo e(__('If you enable WhatsApp, then Tawk.to must be disabled.')); ?></p>
                      </div>
                      <div class="form-group">
                         <label><?php echo e(__('WhatsApp Number')); ?></label>
                         <input class="form-control" type="text" name="whatsapp_number" value="<?php echo e($data->whatsapp_number); ?>">
                         <p class="text-warning mb-0"><?php echo e(__('Enter Phone number with Country Code')); ?></p>
                      </div>
                      <div class="form-group">
                         <label><?php echo e(__('WhatsApp Header Title')); ?></label>
                         <input class="form-control" type="text" name="whatsapp_header_title" value="<?php echo e($data->whatsapp_header_title); ?>">
                         <?php if($errors->has('whatsapp_header_title')): ?>
                         <p class="mb-0 text-danger"><?php echo e($errors->first('whatsapp_header_title')); ?></p>
                         <?php endif; ?>
                      </div>
                      <div class="form-group">
                         <label><?php echo e(__('WhatsApp Popup Message')); ?></label>
                         <textarea class="form-control" name="whatsapp_popup_message" rows="2"><?php echo e($data->whatsapp_popup_message); ?></textarea>
                         <?php if($errors->has('whatsapp_popup_message')): ?>
                         <p class="mb-0 text-danger"><?php echo e($errors->first('whatsapp_popup_message')); ?></p>
                         <?php endif; ?>
                      </div>
                      <div class="form-group">
                         <label><?php echo e(__('Popup')); ?></label>
                         <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                            <input type="radio" name="whatsapp_popup" value="1" class="selectgroup-input" <?php echo e($data->whatsapp_popup == 1 ? 'checked' : ''); ?>>
                            <span class="selectgroup-button"><?php echo e(__('Active')); ?></span>
                            </label>
                            <label class="selectgroup-item">
                            <input type="radio" name="whatsapp_popup" value="0" class="selectgroup-input" <?php echo e($data->whatsapp_popup == 0 ? 'checked' : ''); ?>>
                            <span class="selectgroup-button"><?php echo e(__('Deactive')); ?></span>
                            </label>
                         </div>
                         <?php if($errors->has('whatsapp_popup')): ?>
                         <p class="mb-0 text-danger"><?php echo e($errors->first('whatsapp_popup')); ?></p>
                         <?php endif; ?>
                      </div>
                   </div>
                </div>
             </div>
         </div>
         <div class="card">
            <div class="card-footer">
               <div class="form">
                  <div class="form-group from-show-notify row">
                     <div class="col-12 text-center">
                        <button type="submit" form="scriptForm" class="btn btn-success"><?php echo e(__('Update')); ?></button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\coursemat\resources\views/admin/basic/scripts.blade.php ENDPATH**/ ?>