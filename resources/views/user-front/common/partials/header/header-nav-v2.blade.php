<div class="header-navigation">
  <div class="container-fluid">
    <div class="site-menu d-flex align-items-center justify-content-between">
      <div class="logo">
        @if (!is_null($websiteInfo->logo))
              <a href="{{ route('front.user.detail.view', getParam()) }}">
                <img data-src="{{\App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_LOGO,$websiteInfo->logo,$userBs,'assets/front/img/'.$bs->logo)}}" class="lazy" alt="website logo">
              </a>
        @else
              <a href="{{ route('front.user.detail.view', getParam()) }}">
                  <img data-src="{{asset('assets/tenant/image/static/logo.png')}}" class="lazy" alt="website logo">
              </a>
        @endif
      </div>

      <div class="primary-menu">
        <div class="nav-menu">
          <!-- Navbar Close Icon -->
          <div class="navbar-close">
            <div class="cross-wrap"><i class="far fa-times"></i></div>
          </div>

          <!-- Nav Menu -->
          <nav class="main-menu">
              <ul>
                  @php
                      $links = json_decode($userMenus, true);
                  @endphp
                  @foreach ($links as $link)
                      @php
                          $href = getUserHref($link, $currentLanguageInfo->id);
                      @endphp

                      @if (!array_key_exists("children",$link))
                          {{--- Level1 links which doesn't have dropdown menus ---}}
                          <li><a href="{{$href}}" target="{{$link["target"]}}">{{$link["text"]}}</a></li>
                      @else
                          {{--- Level1 links which has dropdown menus ---}}
                          <li class="menu-item menu-item-has-children"><a href="{{$href}}" target="{{$link["target"]}}">{{$link["text"]}}</a>
                              <ul class="sub-menu">
                                  {{-- START: 2nd level links --}}
                                  @foreach ($link["children"] as $level2)
                                      @php
                                          $l2Href = getUserHref($level2, $currentLanguageInfo->id);
                                      @endphp
                                      <li><a href="{{$l2Href}}" target="{{$level2["target"]}}">{{$level2["text"]}}</a></li>
                                  @endforeach
                              </ul>
                          </li>
                      @endif
                  @endforeach
              </ul>
          </nav>
        </div>
      </div>

      <div class="navbar-item d-flex align-items-center justify-content-between">
        <div class="menu-btns">
          <ul>
            @guest('customer')
              <li><a href="{{route('customer.login', getParam())}}"><i class="fal fa-sign-in-alt"></i> <span>{{$keywords['login'] ?? __('Login') }}</span></a></li>
              <li><a href="{{route('customer.signup', getParam())}}"><i class="fal fa-user-plus"></i> <span>{{$keywords['signup'] ?? __('Signup') }}</span></a></li>
            @endguest

            @auth('customer')
              @php $authUserInfo = Auth::guard('customer')->user(); @endphp

              <li><a href="{{route('customer.dashboard', getParam())}}"><i class="fal fa-user"></i> <span>{{ $authUserInfo->username }}</span></a></li>
              <li><a href="{{route('customer.logout', getParam())}}"><i class="fal fa-sign-out-alt"></i> <span>{{$keywords['logout'] ?? __('Logout') }}</span></a></li>
            @endauth

            <li>
              <div class="navbar-toggler">
                <span></span><span></span><span></span>
              </div>
            </li>
          </ul>
        </div>

        <div class="menu-dropdown mobile-item mobile-hide">
          <form action="{{ route('changeUserLanguage', getParam()) }}" method="GET">
            <select class="wide" name="lang_code" onchange="this.form.submit()">
              @foreach ($allLanguageInfos as $languageInfo)
                <option value="{{ $languageInfo->code }}" {{ $languageInfo->code == $currentLanguageInfo->code ? 'selected' : '' }}>
                  {{ $languageInfo->name }}
                </option>
              @endforeach
            </select>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
