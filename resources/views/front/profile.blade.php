@extends('front.layout')

@section('pagename')
    - {{ __('Profile') }}
@endsection

@section('meta-description', !empty($seo) ? $seo->faqs_meta_description : '')
@section('meta-keywords', !empty($seo) ? $seo->faqs_meta_keywords : '')

@section('breadcrumb-title')
    {{ __('Profile') }}
@endsection
@section('breadcrumb-link')
    {{ __('Profile') }}
@endsection

@section('content')
    <!-- User Profile Start -->
    <section class="user-profile-area ptb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-6" data-aos="fade-up">
                    <div class="card mb-30">
                        <div class="icon">
                            <img src="{{ asset('') }}/assets/front/images/icon/user-1.png" alt="User">
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">John Doe</h4>
                            <div class="social-link">
                                <a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a>
                                <a href="https://www.dribbble.com/" target="_blank"><i class="fab fa-dribbble"></i></a>
                                <a href="https://www.twitter.com/" target="_blank"><i class="fab fa-twitter"></i></a>
                                <a href="https://www.youtube.com/" target="_blank"><i class="fab fa-youtube"></i></a>
                            </div>
                            <div class="btn-groups">
                                <a href="javaScript:void(0)" class="btn btn-sm btn-outline" title="View Profile"
                                    target="_self">View Profile</a>
                                <a href="javaScript:void(0)" class="btn btn-sm btn-primary" title="Follow Us"
                                    target="_self">Follow Us</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-up">
                    <div class="card mb-30">
                        <div class="icon">
                            <img src="{{ asset('') }}/assets/front/images/icon/user-2.png" alt="User">
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">John Doe</h4>
                            <div class="social-link">
                                <a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a>
                                <a href="https://www.dribbble.com/" target="_blank"><i class="fab fa-dribbble"></i></a>
                                <a href="https://www.twitter.com/" target="_blank"><i class="fab fa-twitter"></i></a>
                                <a href="https://www.youtube.com/" target="_blank"><i class="fab fa-youtube"></i></a>
                            </div>
                            <div class="btn-groups">
                                <a href="javaScript:void(0)" class="btn btn-sm btn-outline" title="View Profile"
                                    target="_self">View Profile</a>
                                <a href="javaScript:void(0)" class="btn btn-sm btn-primary" title="Follow Us"
                                    target="_self">Follow Us</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-up">
                    <div class="card mb-30">
                        <div class="icon">
                            <img src="{{ asset('') }}/assets/front/images/icon/user-3.png" alt="User">
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">John Doe</h4>
                            <div class="social-link">
                                <a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a>
                                <a href="https://www.dribbble.com/" target="_blank"><i class="fab fa-dribbble"></i></a>
                                <a href="https://www.twitter.com/" target="_blank"><i class="fab fa-twitter"></i></a>
                                <a href="https://www.youtube.com/" target="_blank"><i class="fab fa-youtube"></i></a>
                            </div>
                            <div class="btn-groups">
                                <a href="javaScript:void(0)" class="btn btn-sm btn-outline" title="View Profile"
                                    target="_self">View Profile</a>
                                <a href="javaScript:void(0)" class="btn btn-sm btn-primary" title="Follow Us"
                                    target="_self">Follow Us</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-up">
                    <div class="card mb-30">
                        <div class="icon">
                            <img src="{{ asset('') }}/assets/front/images/icon/user-1.png" alt="User">
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">John Doe</h4>
                            <div class="social-link">
                                <a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a>
                                <a href="https://www.dribbble.com/" target="_blank"><i class="fab fa-dribbble"></i></a>
                                <a href="https://www.twitter.com/" target="_blank"><i class="fab fa-twitter"></i></a>
                                <a href="https://www.youtube.com/" target="_blank"><i class="fab fa-youtube"></i></a>
                            </div>
                            <div class="btn-groups">
                                <a href="javaScript:void(0)" class="btn btn-sm btn-outline" title="View Profile"
                                    target="_self">View Profile</a>
                                <a href="javaScript:void(0)" class="btn btn-sm btn-primary" title="Follow Us"
                                    target="_self">Follow Us</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-up">
                    <div class="card mb-30">
                        <div class="icon">
                            <img src="{{ asset('') }}/assets/front/images/icon/user-2.png" alt="User">
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">John Doe</h4>
                            <div class="social-link">
                                <a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a>
                                <a href="https://www.dribbble.com/" target="_blank"><i class="fab fa-dribbble"></i></a>
                                <a href="https://www.twitter.com/" target="_blank"><i class="fab fa-twitter"></i></a>
                                <a href="https://www.youtube.com/" target="_blank"><i class="fab fa-youtube"></i></a>
                            </div>
                            <div class="btn-groups">
                                <a href="javaScript:void(0)" class="btn btn-sm btn-outline" title="View Profile"
                                    target="_self">View Profile</a>
                                <a href="javaScript:void(0)" class="btn btn-sm btn-primary" title="Follow Us"
                                    target="_self">Follow Us</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-up">
                    <div class="card mb-30">
                        <div class="icon">
                            <img src="{{ asset('') }}/assets/front/images/icon/user-3.png" alt="User">
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">John Doe</h4>
                            <div class="social-link">
                                <a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a>
                                <a href="https://www.dribbble.com/" target="_blank"><i class="fab fa-dribbble"></i></a>
                                <a href="https://www.twitter.com/" target="_blank"><i class="fab fa-twitter"></i></a>
                                <a href="https://www.youtube.com/" target="_blank"><i class="fab fa-youtube"></i></a>
                            </div>
                            <div class="btn-groups">
                                <a href="javaScript:void(0)" class="btn btn-sm btn-outline" title="View Profile"
                                    target="_self">View Profile</a>
                                <a href="javaScript:void(0)" class="btn btn-sm btn-primary" title="Follow Us"
                                    target="_self">Follow Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="pagination-nav" data-aos="fade-up">
                <ul class="pagination justify-content-center mb-0">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <i class="far fa-angle-left"></i>
                        </a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <i class="far fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </section>
    <!-- User Profile End -->
@endsection
