@extends('user.layout')

{{-- this style will be applied when the direction of language is right-to-left --}}
@includeIf('user.partials.rtl-style')

@section('content')
    <div class="page-header">
        <h4 class="page-title">{{ __('Testimonials Section') }}</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{route('admin.dashboard')}}">
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
                <a href="#">{{ __('Testimonials Section') }}</a>
            </li>
        </ul>
    </div>

    @if ($data->theme_version == 1)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <div class="card-title">{{ __('Testimonials Section Image') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 offset-lg-3">
                                <form id="featureSectionForm"
                                      action="{{ route('user.home_page.update_testimonial_section_image') }}"
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
                                                        src="{{\App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_TESTIMONIAL_SECTION_IMAGE,$data->testimonials_section_image,$userBs)}}"
                                                        alt="..."
                                                        class="img-thumbnail">
                                                </div>
                                                <input type="file" name="image" id="image"
                                                       class="form-control">
                                                <p id="errimage" class="mt-2 mb-0 text-danger em"></p>
                                                <p class="text-warning mb-0">Upload 1920 X 815 image for best quality</p>
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
                                <button type="submit" id="submitFeatureSectionBtn" class="btn btn-success">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card-title">{{ __('Testimonials') }}</div>
                        </div>

                        <div class="col-lg-3">
                            @includeIf('user.partials.languages')
                        </div>

                        <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
                            <a href="#" data-toggle="modal" data-target="#createModal"
                               class="btn btn-primary btn-sm float-lg-right float-left"><i
                                    class="fas fa-plus"></i> {{ __('Add') }}</a>

                            <button class="btn btn-danger btn-sm float-right mr-2 d-none bulk-delete"
                                    data-href="{{ route('user.home_page.bulk_delete_testimonial') }}">
                                <i class="flaticon-interface-5"></i> {{ __('Delete') }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            @if (count($testimonials) == 0)
                                <h3 class="text-center mt-2">{{ __('NO TESTIMONIAL FOUND') . '!' }}</h3>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped mt-3" id="basic-datatables">
                                        <thead>
                                        <tr>
                                            <th scope="col">
                                                <input type="checkbox" class="bulk-check" data-val="all">
                                            </th>
                                            <th scope="col">{{ __('Image') }}</th>
                                            <th scope="col">{{ __('Name') }}</th>
                                            <th scope="col">{{ __('Occupation') }}</th>
                                            <th scope="col">{{ __('Serial Number') }}</th>
                                            <th scope="col">{{ __('Actions') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($testimonials as $testimonial)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="bulk-check"
                                                           data-val="{{ $testimonial->id }}">
                                                </td>
                                                <td>
                                                    <img
                                                        src="{{ \App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_TESTIMONIAL_CLIENT_IMAGE,$testimonial->image,$userBs) }}"
                                                        alt="client" width="50">
                                                </td>
                                                <td>{{ $testimonial->name }}</td>
                                                <td>{{ $testimonial->occupation }}</td>
                                                <td>{{ $testimonial->serial_number }}</td>
                                                <td>
                                                    <a class="btn btn-secondary btn-sm mr-1 editbtn" href="#"
                                                       data-toggle="modal" data-target="#editModal"
                                                       data-id="{{ $testimonial->id }}"
                                                       data-image="{{ \App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_TESTIMONIAL_CLIENT_IMAGE,$testimonial->image,$userBs) }}"
                                                       data-name="{{ $testimonial->name }}"
                                                       data-occupation="{{ $testimonial->occupation }}"
                                                       data-comment="{{ $testimonial->comment }}"
                                                       data-serial_number="{{ $testimonial->serial_number }}">
                              <span class="btn-label">
                                <i class="fas fa-edit"></i>
                              </span>
                                                        {{ __('Edit') }}
                                                    </a>

                                                    <form class="deleteform d-inline-block"
                                                          action="{{ route('user.home_page.delete_testimonial', ['id' => $testimonial->id]) }}"
                                                          method="post">
                                                        
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger btn-sm deletebtn">
                                <span class="btn-label">
                                  <i class="fas fa-trash"></i>
                                </span>
                                                            {{ __('Delete') }}
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-footer"></div>
            </div>
        </div>
    </div>

    {{-- create modal --}}
    @include('user.home-page.testimonial-section.create')

    {{-- edit modal --}}
    @include('user.home-page.testimonial-section.edit')
@endsection
