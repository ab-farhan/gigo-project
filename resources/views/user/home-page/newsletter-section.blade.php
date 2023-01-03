@extends('user.layout')

{{-- this style will be applied when the direction of language is right-to-left --}}
@includeIf('user.partials.rtl-style')

@section('content')
    <div class="page-header">
        <h4 class="page-title">{{ __('Newsletter Section') }}</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{route('user-dashboard')}}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">{{ __('Home Page') }}</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">{{ __('Newsletter Section') }}</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="card-title">{{ __('Update Newsletter Section') }}</div>
                        </div>

                        <div class="col-lg-2">
                            @includeIf('user.partials.languages')
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">
                            <form id="ajaxForm" action="{{ route('user.home_page.update_newsletter_section', ['language' => request()->input('language')]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if ($themeInfo->theme_version == 1 || $themeInfo->theme_version == 3)
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <div class="col-12 mb-2">
                                                    <label
                                                        for="image"><strong>{{ __('Background Image') . '*' }}</strong></label>
                                                </div>
                                                <div class="col-md-12 showBackgroundImage mb-3">
                                                    <img
                                                        src="{{isset($data->background_image) ? \App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_NEWSLETTER_SECTION_IMAGE,$data->background_image,$userBs) : asset('assets/tenant/image/default.jpg')}}"
                                                        alt="..."
                                                        class="img-thumbnail">
                                                </div>
                                                <input type="file" name="background_image" id="backgroundImage"
                                                       class="form-control">
                                                <p id="errbackground_image" class="mt-2 mb-0 text-danger em"></p>
                                                <p class="text-warning mb-0">Upload 475 X 880 image for best quality</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($themeInfo->theme_version == 1)
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <div class="col-12 mb-2">
                                                    <label for="image"><strong>{{ __('Image') . '*' }}</strong></label>
                                                </div>
                                                <div class="col-md-12 showImage mb-3">
                                                    <img
                                                        src="{{isset($data->image) ? \App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_NEWSLETTER_SECTION_IMAGE,$data->image,$userBs) : asset('assets/tenant/image/default.jpg')}}"
                                                        alt="..."
                                                        class="img-thumbnail">
                                                </div>
                                                <input type="file" name="image" id="image" class="form-control">
                                                <p id="errimage" class="mt-2 mb-0 text-danger em"></p>
                                                <p class="text-warning mb-0">Upload 520 X 640 image for best quality</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label for="">{{ __('Title') }}</label>
                                    <input type="text" class="form-control" name="title" value="{{ empty($data->title) ? '' : $data->title }}" placeholder="Enter Newsletter Section Title">
                                </div>

                                @if ($themeInfo->theme_version == 1)
                                    <div class="form-group">
                                        <label for="">{{ __('Text') }}</label>
                                        <textarea class="form-control" name="text" placeholder="Enter Newsletter Section Text" rows="5">{{ empty($data->text) ? '' : $data->text }}</textarea>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-12 text-center">
                            <button type="submit" id="submitBtn" class="btn btn-success">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
