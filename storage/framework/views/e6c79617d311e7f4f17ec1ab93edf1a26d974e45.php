<!DOCTYPE html>
<html lang="en" <?php if($rtl == 1): ?> dir="rtl" <?php endif; ?>>

<head>
    <!--====== Required meta tags ======-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo $__env->yieldContent('meta-description'); ?>">
    <meta name="keywords" content="<?php echo $__env->yieldContent('meta-keywords'); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <?php echo $__env->yieldContent('og-meta'); ?>
    <!--====== Title ======-->
    <title><?php echo e($bs->website_title); ?> <?php echo $__env->yieldContent('pagename'); ?></title>
    <link rel="icon" href="<?php echo e(asset('assets/front/img/' . $bs->favicon)); ?>">
    

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('/assets/front/css/bootstrap.min.css')); ?>">
    <!-- Fontawesome Icon CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('/assets/front/fonts/fontawesome/css/all.min.css')); ?>">
    <!-- Kreativ Icon -->
    <link rel="stylesheet" href="<?php echo e(asset('/assets/front/fonts/icomoon/style.css')); ?>">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('/assets/front/css/magnific-popup.min.css')); ?>">
    <!-- Swiper Slider -->
    <link rel="stylesheet" href="<?php echo e(asset('/assets/front/css/swiper-bundle.min.css')); ?>">
    <!-- AOS Animation CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('/assets/front/css/aos.min.css')); ?>">
    <!-- Nice Select -->
    <link rel="stylesheet" href="<?php echo e(asset('/assets/front/css/nice-select.css')); ?>">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('/assets/front/css/style.css')); ?>">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?php echo e(asset('/assets/front/css/toastr.min.css')); ?>">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('/assets/front/css/responsive.css')); ?>">


    <?php if($rtl == 1): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/front/css/rtl-style.css')); ?>">
    <?php endif; ?>
    <!-- base color change -->

    <?php echo $__env->yieldContent('styles'); ?>

    <?php if($bs->is_whatsapp == 1 || $bs->is_tawkto == 1): ?>
        
    <?php endif; ?>

    

</head>

<body>


    <?php if($bs->preloader_status == 1): ?>
        <!--====== Start Preloader ======-->
        

        <div id="preLoader">
            <div class="loader">
                <svg viewBox="0 0 80 80">
                    <rect x="8" y="8" width="64" height="64"></rect>
                </svg>
            </div>
        </div>
        <!--====== End Preloader ======-->
    <?php endif; ?>




    <?php echo $__env->make('front.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php if(!request()->routeIs('front.index')): ?>
        <!--====== Start Breadcrumbs-section ======-->

        

        <!-- Page title start-->
        <div class="page-title-area bg-primary-light">
            <div class="container">
                <div class="content text-center">
                    <h2><?php echo $__env->yieldContent('breadcrumb-title'); ?></h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('front.index')); ?>"><?php echo e(__('Home')); ?></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo $__env->yieldContent('breadcrumb-link'); ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Bg Overlay -->
            <img class="lazyload bg-overlay-1" data-src="<?php echo e(asset('')); ?>/assets/front/images/shadow-1.png"
                alt="Bg">
            <img class="lazyload bg-overlay-2" data-src="<?php echo e(asset('')); ?>/assets/front/images/shadow-2.png"
                alt="Bg">

            <!-- Bg Shape -->
            <div class="shape">
                <img class="shape-1" src="<?php echo e(asset('')); ?>/assets/front/images/shape/shape-4.png" alt="Shape">
                <img class="shape-2" src="<?php echo e(asset('')); ?>/assets/front/images/shape/shape-5.png" alt="Shape">
                <img class="shape-3" src="<?php echo e(asset('')); ?>/assets/front/images/shape/shape-6.png" alt="Shape">
                <img class="shape-4" src="<?php echo e(asset('')); ?>/assets/front/images/shape/shape-7.png" alt="Shape">
                <img class="shape-5" src="<?php echo e(asset('')); ?>/assets/front/images/shape/shape-8.png" alt="Shape">
                <img class="shape-6" src="<?php echo e(asset('')); ?>/assets/front/images/shape/shape-9.png" alt="Shape">
            </div>
        </div>
        <!--====== End Breadcrumbs-section ======-->
    <?php endif; ?>

    <?php echo $__env->yieldContent('content'); ?>

    
    <?php if ($__env->exists('front.partials.footer')) echo $__env->make('front.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="go-top"><i class="fal fa-angle-double-up"></i></div>

    <?php if($be->cookie_alert_status == 1): ?>
        <div class="cookie">
            <?php echo $__env->make('cookie-consent::index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    <?php endif; ?>

    
    
    

    <!-- Magic Cursor -->
    <div class="cursor"></div>
    <!-- Magic Cursor -->

    
    

    

    <!-- Jquery JS -->
    <script src="<?php echo e(asset('/assets/front/js/jquery.min.js')); ?>"></script>
    <!-- Bootstrap JS -->
    <script src="<?php echo e(asset('/assets/front/js/bootstrap.min.js')); ?>"></script>
    <!-- Nice Select JS -->
    <script src="<?php echo e(asset('/assets/front/js/jquery.nice-select.min.js')); ?>"></script>
    <!-- Magnific Popup JS -->
    <script src="<?php echo e(asset('/assets/front/js/jquery.magnific-popup.min.js')); ?>"></script>
    <!-- Swiper Slider JS -->
    <script src="<?php echo e(asset('/assets/front/js/swiper-bundle.min.js')); ?>"></script>
    <!-- Lazysizes -->
    <script src="<?php echo e(asset('/assets/front/js/lazysizes.min.js')); ?>"></script>
    <!-- Toastr JS -->
    <script src="<?php echo e(asset('assets/front/js/toastr.min.js')); ?>"></script>
    <!-- AOS JS -->
    <script src="<?php echo e(asset('/assets/front/js/aos.min.js')); ?>"></script>
    <!-- Main script JS -->
    <script src="<?php echo e(asset('/assets/front/js/script.js')); ?>"></script>

    <script>
        "use strict";
        var rtl = <?php echo e($rtl); ?>;
    </script>

    <?php echo $__env->yieldContent('scripts'); ?>

    <?php echo $__env->yieldContent('vuescripts'); ?>


    <?php if(session()->has('success')): ?>
        <script>
            "use strict";
            toastr['success']("<?php echo e(__(session('success'))); ?>");
        </script>
    <?php endif; ?>

    <?php if(session()->has('error')): ?>
        <script>
            "use strict";
            toastr['error']("<?php echo e(__(session('error'))); ?>");
        </script>
    <?php endif; ?>

    <?php if(session()->has('warning')): ?>
        <script>
            "use strict";
            toastr['warning']("<?php echo e(__(session('warning'))); ?>");
        </script>
    <?php endif; ?>
    <script>
        "use strict";

        function handleSelect(elm) {
            window.location.href = "<?php echo e(route('changeLanguage', '')); ?>" + "/" + elm.value;
        }
    </script>

    
    <?php if($bs->is_whatsapp == 1): ?>
        <script type="text/javascript">
            "use strict";
            var whatsapp_popup = <?php echo e($bs->whatsapp_popup); ?>;
            var whatsappImg = "<?php echo e(asset('assets/front/img/whatsapp.svg')); ?>";
            $(function() {
                $('#WAButton').floatingWhatsApp({
                    phone: "<?php echo e($bs->whatsapp_number); ?>", //WhatsApp Business phone number
                    headerTitle: "<?php echo e($bs->whatsapp_header_title); ?>", //Popup Title
                    popupMessage: `<?php echo !empty($bs->whatsapp_popup_message) ? nl2br($bs->whatsapp_popup_message) : ''; ?>`, //Popup Message
                    showPopup: whatsapp_popup == 1 ? true : false, //Enables popup display
                    buttonImage: '<img src="' + whatsappImg + '" />', //Button Image
                    position: "right" //Position: left | right

                });
            });
        </script>
    <?php endif; ?>

    <?php if($bs->is_tawkto == 1): ?>
        <?php
            $directLink = str_replace('tawk.to', 'embed.tawk.to', $bs->tawkto_chat_link);
            $directLink = str_replace('chat/', '', $directLink);
        ?>
        <!--Start of Tawk.to Script-->
        <script type="text/javascript">
            "use strict";
            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = '<?php echo e($directLink); ?>';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
        </script>
        <!--End of Tawk.to Script-->
    <?php endif; ?>

</body>

</html>
<?php /**PATH D:\laragon\www\coursemat\resources\views/front/layout.blade.php ENDPATH**/ ?>