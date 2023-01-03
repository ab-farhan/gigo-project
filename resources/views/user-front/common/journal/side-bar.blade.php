<div class="col-lg-4 col-md-6 col-sm-8">
  <div class="blog-sidebar ml-10">
    <div class="blog-side-about white-bg mt-40">
      <div class="about-title">
        <h4 class="title">{{$keywords['search_blog'] ?? __('Search Blog') }}</h4>
      </div>
      <div class="blog-Search-content text-center">
        <form action="{{ route('front.user.blogs', getParam()) }}" method="GET">
          <div class="input-box">
            <input type="text" placeholder="{{$keywords['search_by_title'] ?? __('Search By Title') }}" name="title" value="{{ !empty(request()->input('title')) ? request()->input('title') : '' }}">
            <input type="hidden" name="category" value="{{ !empty(request()->input('category')) ? request()->input('category') : '' }}">
            <button type="submit"><i class="far fa-search"></i></button>
          </div>
        </form>
      </div>
    </div>

    <div class="blog-side-about white-bg mt-40">
      <div class="about-title">
        <h4 class="title">{{$keywords['Categories'] ?? __('Categories') }}</h4>
      </div>
      <div class="blog-categories-content mt-35">
        @if (count($categories) == 0)
          <h5>{{$keywords['no_category_found'] ?? __('No Category Found') . '!' }}</h5>
        @else
          <ul class="blog-categories">
            <li @if (empty(request()->input('category'))) class="active" @endif>
              <a href="#">{{$keywords['All'] ?? __('All') }} <span>{{ $allBlogs }}</span></a>
            </li>

            @foreach ($categories as $category)
              <li @if ($category->id == request()->input('category')) class="active" @endif>
                <a href="#" data-category_id="{{ $category->slug }}">{{ $category->name }} <span>{{ $category->blogCount }}</span></a>
              </li>
            @endforeach
          </ul>
        @endif
      </div>
    </div>
    @if (is_array($packagePermissions) && in_array('Advertisement',$packagePermissions))
        @if (!empty(showAd(1)))
            <div class="banner-add mt-40 text-center">
                {!! showAd(1) !!}
            </div>
        @endif
        @if (!empty(showAd(2)))
            <div class="banner-add mt-40 text-center">
                {!! showAd(2) !!}
            </div>
        @endif
    @endif
  </div>

  {{-- search form start --}}
  <form class="d-none" action="{{ route('front.user.blogs', getParam()) }}" method="GET">
    <input type="hidden" name="title" value="{{ !empty(request()->input('title')) ? request()->input('title') : '' }}">

    <input type="hidden" id="categoryKey" name="category">

    <button type="submit" id="submitBtn"></button>
  </form>
  {{-- search form end --}}
</div>
