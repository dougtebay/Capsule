<nav class="header">
    <section>
        <a class="header-text" href="{{ url('/') }}">{{ config('app.name') }}</a>
    </section>
    @if (auth()->guest())
    <section>
        <a class="header-text" href="{{ url('/login') }}">Login</a>
    </section>
    @else
    <section>
        <form method="GET" action="/search">
            <input type="text" name="query">
            <button type="submit">Search</button>
        </form>
    </section>
    <section>
        <span class="header-text">{{ auth()->user()->name }}</span>
        <a class="header-text"
           href="{{ url('/logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>
        <form id="logout-form" class="hidden" method="POST" action="{{ url('/logout') }}">
            {{ csrf_field() }}
        </form>
    </section>
    @endif
</nav>
