<header class="bg-dark row flex-nowrap" role="banner">
        <div class="position-relative col-md-2">
            <img src="{{ asset('assets/img/logo.svg') }}" alt="logo">
        </div>
        <div class="align-items-center position-relative col-md-9 m-auto">
            <div class="text-center">
                <div class="site-logo">
                    <h3 class="text-white my-2">SWD Admin Panel</h3>
                </div>
                <div class="ml-auto toggle-button d-inline-block d-lg-none"><a href="#" class="site-menu-toggle py-5 js-menu-toggle text-black"><span class="icon-menu h3 text-black"></span></a></div>
            </div>
        </div>
        <div class="col-md-1 m-auto">
            <form method="POST" action="{{ route('post_logout') }}">
                {{ csrf_field() }}
                <button class="btn btn-secondary" type="submit">Logout</button>
            </form>
        </div>
</header>
