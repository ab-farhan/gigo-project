<div class="header-navigation">
  <div class="container-fluid">
    <div class="site-menu d-flex align-items-center justify-content-between">
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

        <!-- Navbar Toggler -->
        <div class="navbar-toggler">
          <span></span><span></span><span></span>
        </div>
      </div>

      <div class="navbar-item d-flex align-items-center justify-content-end">
        <div class="menu-dropdown">
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

        @if (count($socialMediaInfos) > 0)
          <div class="menu-icon mobile-item mobile-hide">
            <ul>
              @foreach ($socialMediaInfos as $socialMediaInfo)
                <li><a href="{{ $socialMediaInfo->url }}"><i class="{{ $socialMediaInfo->icon }}"></i></a></li>
              @endforeach
            </ul>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
