<div class="footer-item mt-30">
  <div class="footer-title item-3">
    <i class="fal fa-paper-plane"></i>
    <h4 class="title">{{$keywords['Contact_Us'] ?? __('Contact Us') }}</h4>
  </div>

  <div class="footer-list-area">
    <div class="footer-list d-block d-sm-flex">
      <ul>
        <li><a href="{{ 'mailto:' . $userBs->email_address }}"><i class="fal fa-envelope"></i> {{ $userBs->email_address }}</a></li>
        <li><a href="{{ 'tel:' . $userBs->contact_number }}"><i class="fal fa-phone-office"></i> {{ $userBs->contact_number }}</a></li>
        <li><a href="{{ "//maps.google.com/?ll=$userBs->latitude,$userBs->longitude" }}"><i class="fal fa-map-marker-alt"></i> {{ $userBs->address }}</a></li>
      </ul>
    </div>
  </div>
</div>
