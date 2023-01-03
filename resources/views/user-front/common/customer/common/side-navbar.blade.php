<div class="col-lg-3">
    <div class="user-sidebar">
        <ul class="links">
            <li>
                <a href="{{ route('customer.dashboard', getParam()) }}" class="{{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">{{$keywords['dashboard'] ?? __('Dashboard') }}</a>
            </li>

            <li>
                <a href="{{ route('customer.my_courses', getParam()) }}" class="{{ request()->routeIs('customer.my_courses') ? 'active' : '' }}">{{$keywords['my_courses'] ?? __('My Courses') }}</a>
            </li>

            <li>
              <a href="{{ route('customer.purchase_history', getParam()) }}" target="_blank">
                {{$keywords['Purchase_History'] ?? __('Purchase History') }}
              </a>
            </li>

            <li>
                <a href="{{ route('customer.edit_profile', getParam()) }}" class="{{ request()->routeIs('customer.edit_profile') ? 'active' : '' }}">{{$keywords['edit_profile'] ?? __('Edit Profile') }}</a>
            </li>

            <li>
                <a href="{{ route('customer.change_password', getParam()) }}" class="{{ request()->routeIs('customer.change_password') ? 'active' : '' }}">{{$keywords['change_password'] ?? __('Change Password') }}</a>
            </li>

            <li>
                <a href="{{ route('customer.logout', getParam()) }}">{{$keywords['logout'] ?? __('Logout') }}</a>
            </li>
        </ul>
    </div>
</div>
