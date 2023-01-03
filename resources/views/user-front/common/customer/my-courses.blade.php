@extends('user-front.common.layout')

@section('pageHeading')
  {{$keywords['my_courses'] ?? __('My Courses') }}
@endsection

@section('content')
  @includeIf('user-front.common.partials.breadcrumb', ['breadcrumb' => $bgImg->breadcrumb, 'title' => $keywords['my_courses'] ?? __('My Courses')])

  <!-- Start User Enrolled Course Section -->
  <section class="user-dashboard">
    <div class="container">
      <div class="row">
        @includeIf('user-front.common.customer.common.side-navbar')

        <div class="col-lg-9">
          <div class="row">
            <div class="col-lg-12">
              <div class="account-info">
                <div class="title">
                  <h4>{{$keywords['all_courses'] ?? __('All Courses') }}</h4>
                </div>

                <div class="main-info">
                  <div class="main-table">
                    @if (count($enrolments) == 0)
                      <h5 class="text-center mt-3">{{$keywords['no_course_found'] ?? __('No Course Found') . '!' }}</h5>
                    @else
                      <div class="table-responsive">
                        <table id="erolled-course-table" class="dataTables_wrapper dt-responsive table-striped dt-bootstrap4 w-100">
                          <thead>
                            <tr>
                              <th>{{$keywords['course'] ?? __('Course') }}</th>
                              <th>{{$keywords['duration'] ?? __('Duration') }}</th>
                              <th>{{$keywords['price'] ?? __('Price') }}</th>
                              <th>{{$keywords['action'] ?? __('Action') }}</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($enrolments as $enrolment)
                              <tr>
                                <td width="35%">
                                  <a target="_blank" href="{{ route('front.user.course.details', [getParam(), 'slug' => $enrolment->slug]) }}">
                                    {{ $enrolment->title }}
                                  </a>
                                </td>

                                @php
                                  $period = $enrolment->course->duration;
                                  $array = explode(':', $period);
                                  $hour = $array[0];
                                  $courseDuration = \Carbon\Carbon::parse($period);
                                @endphp

                                <td>{{ $hour == '00' ? '00' : $courseDuration->format('h') }}h {{ $courseDuration->format('i') }}m</td>
                                <td>
                                  @if (!is_null($enrolment->course_price))
                                    {{ $enrolment->currency_symbol_position == 'left' ? $enrolment->currency_symbol : '' }}{{ $enrolment->course_price }}{{ $enrolment->currency_symbol_position == 'right' ? $enrolment->currency_symbol : '' }}
                                  @else
                                    {{ __('Free') }}
                                  @endif
                                </td>

                                <td><a href="{{ route('customer.my_course.curriculum', [getParam(),'id' => $enrolment->course_id, 'lesson_id' => $enrolment->lesson_id]) }}" class="btn">{{$keywords['curriculum'] ??  __('Curriculum') }}</a></td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End User Enrolled Course Section -->
@endsection
