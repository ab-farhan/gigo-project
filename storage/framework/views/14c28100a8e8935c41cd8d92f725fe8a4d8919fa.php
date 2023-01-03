<?php
if ($currentLang->popups()->count() > 0) {
    $popups = $currentLang->popups()->where('status', 1)->orderBy('serial_number', 'ASC')->get();
} else {
    $popups = [];
}
?>

<?php $__currentLoopData = $popups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $popup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $type = $popup->type;
    ?>
    <?php if($type == 1): ?>
        <div data-popup_delay="<?php echo e($popup->delay); ?>" data-popup_id="<?php echo e($popup->id); ?>" id="modal-popup<?php echo e($popup->id); ?>" class="popup-wrapper">
            <div>
                <img class="lazyload lazy-image" src="<?php echo e(asset('assets/front/img/popups/' . $popup->image)); ?>" alt="Popup Image" width="100%">
            </div>
        </div>
    <?php elseif($type == 2): ?>
        <div data-popup_delay="<?php echo e($popup->delay); ?>" data-popup_id="<?php echo e($popup->id); ?>" id="modal-popup<?php echo e($popup->id); ?>" class="popup-wrapper">
            <div class="popup-one bg_cover" style="background-image: url('<?php echo e(asset('assets/front/img/popups/' . $popup->background_image)); ?>');">
                <div class="popup_main-content"  style="background-color: #<?php echo e($popup->background_color); ?>; opacity: <?php echo e($popup->background_opacity); ?>;">
                    <h1><?php echo e($popup->title); ?></h1>
                    <p><?php echo e($popup->text); ?></p>

                    <?php if(!empty($popup->button_url) && !empty($popup->button_text)): ?>
                    <a href="<?php echo e($popup->button_url); ?>" class="popup-main-btn" style="background-color: #<?php echo e($popup->button_color); ?>;"><?php echo e($popup->button_text); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php elseif($type == 3): ?>
        <div data-popup_delay="<?php echo e($popup->delay); ?>" data-popup_id="<?php echo e($popup->id); ?>" id="modal-popup<?php echo e($popup->id); ?>" class="popup-wrapper">
            <div class="popup-two bg_cover" style="background-image: url('<?php echo e(asset('assets/front/img/popups/' . $popup->background_image)); ?>')">
                <div class="popup_main-content"  style="background-color: #<?php echo e($popup->background_color); ?>; opacity: <?php echo e($popup->background_opacity); ?>;">
                    <h1><?php echo e($popup->title); ?></h1>
                    <p><?php echo e($popup->text); ?></p>
                    <div class="subscribe-form">
                        <form id="popupSubscribe<?php echo e($popup->id); ?>" class="subscribeForm" action="<?php echo e(route('front.subscribe')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="form_group">
                                <input type="email" class="form_control" placeholder="<?php echo e(__('Email Address')); ?>" name="email" required>
                                <p id="erremail" class="text-white mb-3 err-email"></p>
                            </div>
                            <div class="form_group">
                                <button type="submit" class="popup-main-btn" style="background-color: #<?php echo e($popup->button_color); ?>;"><?php echo e($popup->button_text); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif($type == 4): ?>
        <div data-popup_delay="<?php echo e($popup->delay); ?>" data-popup_id="<?php echo e($popup->id); ?>" id="modal-popup<?php echo e($popup->id); ?>" class="popup-wrapper">
            <div class="popup-three">
                <div class="popup_main-content">
                    <div class="left-bg bg_cover" style="background-image: url('<?php echo e(asset('assets/front/img/popups/' . $popup->image)); ?>')"></div>
                    <div class="right-content">
                        <h1><?php echo e($popup->title); ?></h1>
                        <p><?php echo e($popup->text); ?></p>

                        <?php if(!empty($popup->button_url) && !empty($popup->button_text)): ?>
                        <a href="<?php echo e($popup->button_url); ?>" class="popup-main-btn" style="background-color: #<?php echo e($popup->button_color); ?>;"><?php echo e($popup->button_text); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif($type == 5): ?>
        <div data-popup_delay="<?php echo e($popup->delay); ?>" data-popup_id="<?php echo e($popup->id); ?>" id="modal-popup<?php echo e($popup->id); ?>" class="popup-wrapper">
            <div class="popup-four">
                <div class="popup_main-content">
                    <div class="left-bg bg_cover" style="background-image: url('<?php echo e(asset('assets/front/img/popups/' . $popup->image)); ?>');"></div>
                    <div class="right-content">
                        <h1><?php echo e($popup->title); ?></h1>
                        <p><?php echo e($popup->text); ?></p>
                        <div class="subscribe-form">
                            <form id="popupSubscribe<?php echo e($popup->id); ?>" class="subscribeForm" action="<?php echo e(route('front.subscribe')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="form_group">
                                    <input type="email" class="form_control" placeholder="<?php echo e(__('Email Address')); ?>" name="email" required>
                                    <p id="erremail" class="text-danger mb-3 err-email"></p>
                                </div>
                                <div class="form_group">
                                    <button type="submit" class="popup-main-btn" style="background-color: #<?php echo e($popup->button_color); ?>;"><?php echo e($popup->button_text); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif($type == 6): ?>
        <div data-popup_delay="<?php echo e($popup->delay); ?>" data-popup_id="<?php echo e($popup->id); ?>" id="modal-popup<?php echo e($popup->id); ?>" class="popup-wrapper">
            <div class="popup-five bg_cover" style="background-image: url('<?php echo e(asset('assets/front/img/popups/' . $popup->background_image)); ?>');">
                <div class="popup_main-content">
                    <h1><?php echo e($popup->title); ?></h1>
                    <h4><?php echo e($popup->text); ?></h4>
                    <div class="offer-timer" data-end_date="<?php echo e($popup->end_date); ?>" data-end_time="<?php echo e($popup->end_time); ?>"></div>
                    <?php if(!empty($popup->button_url) && !empty($popup->button_text)): ?>
                        <a href="<?php echo e($popup->button_url); ?>" class="popup-main-btn" style="background-color: #<?php echo e($popup->button_color); ?>;"><?php echo e($popup->button_text); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php elseif($type == 7): ?>
        <div data-popup_delay="<?php echo e($popup->delay); ?>" data-popup_id="<?php echo e($popup->id); ?>" id="modal-popup<?php echo e($popup->id); ?>" class="popup-wrapper">
            <div class="popup-six">
                <div class="popup_main-content" style="background-color: #<?php echo e($popup->background_color); ?>; opacity: <?php echo e($popup->background_opacity); ?>;">
                    <div class="left-bg bg_cover" style="background-image: url('<?php echo e(asset('assets/front/img/popups/' . $popup->image)); ?>');"></div>
                    <div class="right-content bg_cover" style="background-color: #<?php echo e($popup->background_color); ?>; background-image: url('<?php echo e(asset('assets/img/popup-7-bg.png')); ?>');">
                        <h1><?php echo e($popup->title); ?></h1>
                        <h4><?php echo e($popup->text); ?></h4>
                        <div class="offer-timer" data-end_date="<?php echo e($popup->end_date); ?>" data-end_time="<?php echo e($popup->end_time); ?>"></div>
                        <?php if(!empty($popup->button_url) && !empty($popup->button_text)): ?>
                            <a href="<?php echo e($popup->button_url); ?>" class="popup-main-btn" style="background-color: #<?php echo e($popup->button_color); ?>;"><?php echo e($popup->button_text); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /Users/samiulalimpratik/Sites/coursemat/coursemat/resources/views/front/partials/popups.blade.php ENDPATH**/ ?>