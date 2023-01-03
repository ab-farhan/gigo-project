@extends('admin.layout')

@php
    use App\Models\Language;
    $setLang = Language::where('code', request()->input('language'))->first();
@endphp
@if(!empty($setLang->language) && $setLang->language->rtl == 1)
@section('styles')
    <style>
        form input,
        form textarea,
        form select {
            direction: rtl;
        }

        form .note-editor.note-frame .note-editing-area .note-editable {
            direction: rtl;
            text-align: right;
        }
    </style>
@endsection
@endif

@section('content')
    <div class="page-header">
        <h4 class="page-title">{{__('Edit package')}}</h4>
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
                <a href="#">{{__('Packages')}}</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">{{__('Edit')}}</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title d-inline-block">{{__('Edit package')}}</div>
                        <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.package.index')}}">
                            <span class="btn-label">
                              <i class="fas fa-backward"></i>
                            </span>
                            {{__('Back')}}
                        </a>
                </div>
                <div class="card-body pt-5 pb-5">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">
                            <form id="ajaxForm" class="" action="{{route('admin.package.update')}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="package_id" value="{{$package->id}}">
                                <div class="form-group">
                                    <label for="title">{{__('Package title')}}*</label>
                                    <input id="title" type="text" class="form-control" name="title" value="{{$package->title}}"
                                           placeholder="{{__('Enter name')}}">
                                    <p id="errtitle" class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group">
                                    <label for="price">{{__('Price')}} ({{$bex->base_currency_text}})*</label>
                                    <input id="price" type="number" class="form-control" name="price"
                                           placeholder="{{__('Enter Package price')}}" value="{{$package->price}}">
                                    <p class="text-warning"><small>{{__('If price is 0 , than it will appear as free')}}</small></p>
                                    <p id="errprice" class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group">
                                    <label for="plan_term">{{__('Package term')}}*</label>
                                    <select id="plan_term" name="term" class="form-control">
                                        <option value="" selected disabled>{{__('Select a Term')}}</option>
                                        <option
                                            value="monthly" {{$package->term == "monthly" ? "selected" : ""}}>{{__('monthly')}}</option>
                                        <option
                                            value="yearly" {{$package->term == "yearly" ? "selected" : ""}}>{{__('yearly')}}</option>
                                        <option value="lifetime" {{$package->term == "lifetime" ? "selected" : ""}}>{{'lifetime'}}</option>
                                    </select>
                                    <p id="errterm" class="mb-0 text-danger em"></p>
                                </div>
                                @php
                                    $permissions = $package->features;
                                    if (!empty($package->features)) {
                                      $permissions = json_decode($permissions, true);
                                    }
                                @endphp

                                <div class="form-group">
                                    <label class="form-label">{{__('Package Features')}}</label>
                                    <div class="selectgroup selectgroup-pills">
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Custom Domain" class="selectgroup-input" @if(is_array($permissions) && in_array('Custom Domain', $permissions)) checked @endif>
                                            <span class="selectgroup-button">{{__('Custom Domain')}}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Subdomain" class="selectgroup-input" @if(is_array($permissions) && in_array('Subdomain', $permissions)) checked @endif>
                                            <span class="selectgroup-button">{{__('Subdomain')}}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Amazon AWS s3" class="selectgroup-input" @if(is_array($permissions) && in_array('Amazon AWS s3', $permissions)) checked @endif>
                                            <span class="selectgroup-button">{{__('Amazon AWS s3')}}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input id="storage" type="checkbox" name="features[]" value="Storage Limit" class="selectgroup-input" @if(is_array($permissions) && in_array('Storage Limit', $permissions)) checked @endif>
                                            <span class="selectgroup-button">{{__('Storage Limit')}}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="vCard" class="selectgroup-input" @if(is_array($permissions) && in_array('vCard', $permissions)) checked @endif>
                                            <span class="selectgroup-button">{{__('vCard')}}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="QR Builder" class="selectgroup-input" @if(is_array($permissions) && in_array('QR Builder', $permissions)) checked @endif>
                                            <span class="selectgroup-button">{{__('QR Builder')}}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Follow/Unfollow" class="selectgroup-input" @if(is_array($permissions) && in_array('Follow/Unfollow', $permissions)) checked @endif>
                                            <span class="selectgroup-button">{{__('Follow/Unfollow')}}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Course Completion Certificate" class="selectgroup-input" @if(is_array($permissions) && in_array('Course Completion Certificate', $permissions)) checked @endif>
                                            <span class="selectgroup-button">{{__('Course Completion Certificate')}}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Coupon" class="selectgroup-input" @if(is_array($permissions) && in_array('Coupon', $permissions)) checked @endif>
                                            <span class="selectgroup-button">{{__('Coupon')}}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Blog" class="selectgroup-input" @if(is_array($permissions) && in_array('Blog', $permissions)) checked @endif>
                                            <span class="selectgroup-button">{{__('Blog')}}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Advertisement" class="selectgroup-input" @if(is_array($permissions) && in_array('Advertisement', $permissions)) checked @endif>
                                            <span class="selectgroup-button">{{__('Advertisement')}}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Custom Page" class="selectgroup-input" @if(is_array($permissions) && in_array('Custom Page', $permissions)) checked @endif>
                                            <span class="selectgroup-button">{{__('Custom Page')}}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" id="storage_input">
                                    <label for="storage_limit">{{__('Storage Limit')}}*</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="storage_limit"
                                               placeholder="{{__('Enter Storage Limit')}}" value="{{$package->storage_limit}}">
                                        <span class="input-group-text" id="basic-addon2">MB</span>
                                        <p id="errstorage_limit" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="course_categories">{{__('Number Of Course Categories Limit')}}*</label>
                                    <input id="course_categories" type="number" class="form-control" name="course_categories_limit"
                                           placeholder="{{__('Enter course categories limit')}}" value="{{$package->course_categories_limit}}">
                                    <p class="text-warning"><small>{{__('Enter 999999 , than it will appear as unlimited')}}</small></p>
                                    <p id="errcourse_categories_limit" class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group">
                                    <label for="featured_course">{{__('Number Of Featured Course Limit')}}*</label>
                                    <input id="featured_course" type="number" class="form-control" name="featured_course_limit"
                                           placeholder="{{__('Enter course limit')}}" value="{{$package->featured_course_limit}}">
                                    <p class="text-warning"><small>{{__('Enter 999999 , than it will appear as unlimited')}}</small></p>
                                    <p id="errfeatured_course_limit" class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group">
                                    <label for="courses">{{__('Number Of Course Limit')}}*</label>
                                    <input id="courses" type="number" class="form-control" name="course_limit"
                                           placeholder="{{__('Enter course limit')}}" value="{{$package->course_limit}}">
                                    <p class="text-warning"><small>{{__('Enter 999999 , than it will appear as unlimited')}}</small></p>
                                    <p id="errcourse_limit" class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group">
                                    <label for="modules">{{__('Number Of Module Limit')}}*</label>
                                    <input id="modules" type="number" class="form-control" name="module_limit"
                                           placeholder="{{__('Enter module limit')}}" value="{{$package->module_limit}}">
                                    <p class="text-warning"><small>{{__('Enter 999999 , than it will appear as unlimited')}}</small></p>
                                    <p id="errmodule_limit" class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group">
                                    <label for="lesson">{{__('Number Of Lesson Limit')}}*</label>
                                    <input id="lesson" type="number" class="form-control" name="lesson_limit"
                                           placeholder="{{__('Enter lesson limit')}}" value="{{$package->lesson_limit}}">
                                    <p class="text-warning"><small>{{__('Enter 999999 , than it will appear as unlimited')}}</small></p>
                                    <p id="errlesson_limit" class="mb-0 text-danger em"></p>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">{{__('Featured')}} *</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="featured" value="1" class="selectgroup-input" {{$package->featured == 1 ? "checked": ""}}>
                                            <span class="selectgroup-button">{{__('Yes')}}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="featured" value="0" class="selectgroup-input" {{$package->featured == 0 ? "checked": ""}}>
                                            <span class="selectgroup-button">{{__('No')}}</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">{{__('Trial')}} *</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="is_trial" value="1" class="selectgroup-input" {{$package->is_trial == 1 ? "checked": ""}}>
                                            <span class="selectgroup-button">{{__('Yes')}}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="is_trial" value="0" class="selectgroup-input" {{$package->is_trial == 0 ? "checked": ""}}>
                                            <span class="selectgroup-button">{{__('No')}}</span>
                                        </label>
                                    </div>
                                </div>


                                @if($package->is_trial == 1)
                                    <div class="form-group dis-block" id="trial_day">
                                        <label for="trial_days_2">{{__('Trial days')}}*</label>
                                        <input id="trial_days_2" type="number"  class="form-control" name="trial_days" placeholder="{{__('Enter trial days')}}" value="{{$package->trial_days}}">
                                    </div>
                                @else
                                    <div class="form-group dis-none" id="trial_day">
                                        <label for="trial_days_1">{{__('Trial days')}}*</label>
                                        <input id="trial_days_1" type="number"  class="form-control" name="trial_days" placeholder="{{__('Enter trial days')}}" value="{{$package->trial_days}}">
                                    </div>
                                @endif
                                <p id="errtrial_days" class="mb-0 text-danger em"></p>
                                
                                <div class="form-group">
                                    <label class="form-label">Recommended *</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="recommended" value="1" class="selectgroup-input"{{$package->recommended == 1 ? "checked": ""}}>
                                            <span class="selectgroup-button">Yes</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="recommended" value="0" class="selectgroup-input" {{$package->recommended == 0 ? "checked": ""}}>
                                            <span class="selectgroup-button">No</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Icon **</label>
                                    <div class="btn-group d-block">
                                        <button type="button" class="btn btn-primary iconpicker-component"><i class="{{$package->icon}}"></i></button>
                                        <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle"
                                                data-selected="fa-car" data-toggle="dropdown">
                                        </button>
                                        <div class="dropdown-menu"></div>
                                    </div>
                                    <input id="inputIcon" type="hidden" name="icon" value="{{$package->icon}}">
                                    @if ($errors->has('icon'))
                                        <p class="mb-0 text-danger">{{$errors->first('icon')}}</p>
                                    @endif
                                    <div class="mt-2">
                                        <small>NB: click on the dropdown sign to select an icon.</small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="status">{{__('Status')}}*</label>
                                    <select id="status" class="form-control ltr" name="status">
                                        <option value="" selected disabled>{{__('Select a status')}}</option>
                                        <option value="1" {{$package->status == "1" ? "selected" : ""}}>{{__('Active')}}</option>
                                        <option value="0" {{$package->status == "0" ? "selected" : ""}}>{{__('Deactive')}}</option>
                                    </select>
                                    <p id="errstatus" class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group">
                                    <label for="meta_keywords">{{ __('Meta Keywords') }}</label>
                                    <input id="meta_keywords" type="text" class="form-control" name="meta_keywords"
                                           value="{{$package->meta_keywords}}" data-role="tagsinput">
                                </div>
                                <div class="form-group">
                                    <label for="meta_description">{{ __('Meta Description') }}</label>
                                    <textarea id="meta_description" type="text" class="form-control" name="meta_description"
                                              rows="5">{{$package->meta_description}}</textarea>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="form">
                        <div class="form-group from-show-notify row">
                            <div class="col-12 text-center">
                                <button type="submit" id="submitBtn" class="btn btn-success">{{__('Update')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
    <script>
		"use strict";
        var permission = @php echo json_encode($permissions) @endphp;
    </script>
    <script src="{{asset('assets/admin/js/edit-package.js')}}"></script>
@endsection
