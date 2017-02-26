<nav class="header">
    <section>
        <a class="header-text" href="{{ url('/') }}">{{ config('app.name') }}</a>
    </section>
    <section>
        @if (auth()->guest())
            <a href="{{ url('/login') }}">Login</a>
        @else
            <span class="header-text">{{ auth()->user()->name }}</span>
            <a class="header-text"
               href="{{ url('/logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form class="hidden" id="logout-form" method="POST" action="{{ url('/logout') }}">
                {{ csrf_field() }}
            </form>
        @endif
    </section>
</nav>
