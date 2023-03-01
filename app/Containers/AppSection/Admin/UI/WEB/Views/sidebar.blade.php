<div class="sidebar">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 d-none d-sm-inline">Menu</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100" id="menu">
                        @foreach($menu_items as $name => $item)
                            <li class="nav-item w-100">
                                <a href="{{ route($item['route']) }}" class="align-middle px-0 btn @if(Route::is($item['route'])) btn-secondary @else btn-outline-secondary @endif w-100  d-flex justify-content-start my-2" @if(isset($item['target'])) target="{{ $item['target'] }}" @endif>
                                    <div class="w-25"><i class="{{ $item['icon'] }}"></i></div>
                                    <div class="w-75 d-flex justify-content-start">{{ $name }}</div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col py-3">
                @yield('content')
            </div>
        </div>
</div>
