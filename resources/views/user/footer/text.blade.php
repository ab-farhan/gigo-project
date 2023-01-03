@extends('user.layout')

{{-- this style will be applied when the direction of language is right-to-left --}}
@includeIf('user.partials.rtl-style')

@section('content')
    <div class="page-header">
        <h4 class="page-title">{{ __('Footer Content') }}</h4>
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
                <a href="#">{{ __('Footer') }}</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">{{ __('Footer Content') }}</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="card-title">{{ __('Update Footer Content') }}</div>
                        </div>

                        <div class="col-lg-2">
                            @includeIf('user.partials.languages')
                        </div>
                    </div>
                </div>

                <div class="card-body pt-5">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">
                            <form id="ajaxForm" action="{{ route('user.footer.update_content', ['language' => request()->input('language')]) }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>{{ __('Footer Background Color') . '*' }}</label>
                                    <input class="jscolor form-control ltr" name="footer_background_color" value="{{ !is_null($data) ? $data->footer_background_color : '' }}">
                                    <p id="errfooter_background_color" class="em text-danger mt-2 mb-0"></p>
                                </div>

                                @if ($themeInfo->theme_version != 2)
                                    <div class="form-group">
                                        <label>{{ __('About Company') . '*' }}</label>
                                        <textarea class="form-control" name="about_company" rows="5" cols="80">{{ !is_null($data) ? $data->about_company : '' }}</textarea>
                                        <p id="errabout_company" class="em text-danger mt-2 mb-0"></p>
                                    </div>
                                @endif

                                @if ($themeInfo->theme_version == 2)
                                    <div class="form-group">
                                        <label>{{ __('Copyright Background Color') . '*' }}</label>
                                        <input class="jscolor form-control ltr" name="copyright_background_color" value="{{ !is_null($data) ? $data->copyright_background_color : '' }}">
                                        <p id="errcopyright_background_color" class="em text-danger mt-2 mb-0"></p>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label>{{ __('Copyright Text') . '*' }}</label>
                                    <textarea id="copyrightSummernote" class="form-control summernote" name="copyright_text" data-height="80">{{ !is_null($data) ? replaceBaseUrl($data->copyright_text, 'summernote') : '' }}</textarea>
                                    <p id="errcopyright_text" class="em text-danger mt-2 mb-0"></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-12 text-center">
                            <button type="button" id="submitBtn" class="btn btn-success">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
