<div class="col-md-4">
    <div class="card">
        <div class="card-body text-center">
            <img src="{{ $user->profileImage ? $user->profileImage : $user->getProfileAvatar(150) }}" class="rounded-circle object-fit-cover" width=150 height=150 alt="Profile Picture">
            <h3 class="mt-3">{{ $user->name }} {{ $user->surname }}</h3>
            <p>{{ $user->phone_number }}</p>
            <div class="list-group">
                <a href="{{ route('profile.show') }}" class="list-group-item list-group-item-action {{ request()->is('profile') ? 'active' : '' }}">Profile Information</a>
                <a href="{{ route('profile.order') }}" class="list-group-item list-group-item-action {{ request()->is('profile/orders') ? 'active' : '' }}">Orders</a>
                <a href="{{ route('profile.setting') }}" class="list-group-item list-group-item-action {{ request()->is('profile/setting') ? 'active' : '' }}">Profile Setting</a>
                <a href="{{ route('profile.change.password') }}" class="list-group-item list-group-item-action {{ request()->is('profile/change-password') ? 'active' : '' }}">Change password</a>
                <a href="{{ route('logout') }}" class="list-group-item list-group-item-action" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
