@extends('user.layout')

{{-- this style will be applied when the direction of language is right-to-left --}}
@includeIf('user.partials.rtl-style')

@section('content')
    <div class="page-header">
        <h4 class="page-title">{{ __('Video Section') }}</h4>
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
                <a href="#">{{ __('Video Section') }}</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="card-title">{{ __('Update Video Section') }}</div>
                        </div>

                        <div class="col-lg-2">
                            @includeIf('user.partials.languages')
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <form id="ajaxForm"
                                  action="{{ route('user.home_page.update_video_section', ['language' => request()->input('language')]) }}"
                                  method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="col-12 mb-2">
                                                <label for="image"><strong>{{ __('Image') . '*' }}</strong></label>
                                            </div>
                                            <div class="col-md-12 showImage mb-3">
                                                <img
                                                    src="{{isset($data->image) ? \App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_VIDEO_SECTION_IMAGE,$data->image,$userBs) : asset('assets/tenant/image/default.jpg')}}"
                                                    alt="..."
                                                    class="img-thumbnail">
                                            </div>
                                            <input type="file" name="image" id="image" class="form-control">
                                            <p id="errimage" class="mt-2 mb-0 text-danger em"></p>
                                            <p class="text-warning mb-0">Upload 1170 X 650 image for best quality</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">{{ __('Title') }}</label>
                                            <input type="text" class="form-control" name="title"
                                                   value="{{ empty($data->title) ? '' : $data->title }}"
                                                   placeholder="Enter Video Section Title">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">{{ __('Link') . '*' }}</label>
                                            <input type="url" class="form-control ltr" name="link"
                                                   value="{{ empty($data->link) ? '' : $data->link }}"
                                                   placeholder="Enter Video Link">
                                            <p id="errlink" class="mt-2 mb-0 text-danger em"></p>
                                        </div>
                                    </div>
                                </div>
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
