@if ($footerSecStatus == 1)
  <footer class="footer-area footer-area-2">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div class="footer-item mt-30">
            <div class="footer-content">
              @if (!empty($newsletterTitle))
                <h3 class="title">{{ $newsletterTitle }}</h3>
              @endif

              <form class="subscriptionForm" action="{{route('front.user.subscriber',getParam())}}" method="POST">
                @csrf
                <div class="input-box">
                  <input type="email" placeholder="{{$keywords['enter_your_email'] ?? __('Enter Your Email Address') }}" name="email">
                  <i class="fal fa-envelope"></i>
                </div>
                <button type="submit">{{$keywords['Subscribe'] ?? __('Subscribe') }}</button>
              </form>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="footer-item mt-30">
            <div class="footer-title">
              <i class="fal fa-link"></i>
              <h4 class="title">{{$keywords['useful_links'] ?? __('Useful Links') }}</h4>
            </div>

            <div class="footer-list-area">
              @if (count($quickLinkInfos) == 0)
                <h6 class="text-light">{{$keywords['no_link_found'] ?? __('No Link Found') . '!' }}</h6>
              @else
                <div class="footer-list">
                  <ul>
                    @foreach ($quickLinkInfos as $quickLinkInfo)
                      <li><a href="{{ $quickLinkInfo->url }}" target="_blank"><i class="fal fa-angle-right"></i> {{ $quickLinkInfo->title }}</a></li>
                    @endforeach
                  </ul>
                </div>
              @endif
            </div>
          </div>
        </div>
          @if (is_array($packagePermissions) && in_array('Blog',$packagePermissions))
              <div class="col-lg-4">
                  @includeIf('user-front.common.partials.footer.latest-blogs')
              </div>
          @endif
      </div>
    </div>

    <div class="footer-dot">
      <img data-src="{{ asset('assets/tenant/image/shapes/footer-dot.png') }}" class="lazy" alt="footer dot">
    </div>
  </footer>

  <div class="text-center py-4 copyright-part-two">
    <div class="row">
      <div class="col">
        <p class="text-light">
          {!! !empty($footerInfo->copyright_text) ? $footerInfo->copyright_text : '' !!}
        </p>
      </div>
    </div>
  </div>
@endif
