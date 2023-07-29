<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"
            rel="stylesheet"
            crossorigin="anonymous"/>
            <link href="{{ asset('/css/app.css') }}" rel="stylesheet" />
        <title>@yield('title', 'Online Store')</title>
    </head>
    <body>
        <!-- header -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-secondary py-4">
            <div class="container">
                @auth
                     <span style="float: left; position:relative; margin-right:10em; color:#8cbbe4"> Your balance is: USD {{ Auth::user()->getBalance() }}</span>
                @endauth
                <a class="navbar-brand" href="#">Online Store</a>
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNavAltMarkup"
                    aria-controls="navbarNavAltMarkup"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav ms-auto">
                        <a class="nav-link active" href="{{ route('home.index') }}">Home</a>| 
                        <a class="nav-link active" href="{{ route('product.index') }}">Products</a>
                        <a class="nav-link active" href="{{ route('cart.index') }}">Cart</a>
                        <a class="nav-link active" href="{{ route('home.about') }}">About</a>
                        <div class="vr bg-white mx-2 d-none d-lg-block"></div>
                        @guest
                            <a class="nav-link active" href="{{ route('login') }}">Login</a>
                            <a class="nav-link active" href="{{ route('register') }}">Register</a>
                        @else
                            <a class="nav-link active" href="{{ route('myaccount.orders') }}">My Orders</a>
                            <form id="logout" action="{{ route('logout') }}" method="POST">
                            <a role="button" class="nav-link active"
                            onclick="document.getElementById('logout').submit();">Logout</a>
                            @csrf
                            </form>
                        @endguest

                    </div>
                </div>
            </div>
        </nav>
        <header class="masthead bg-primary text-white text-center py-4">
            <div class="container d-flex align-items-center flex-column">
                <h2>@yield('subtitle', 'A Laravel Online Store')</h2>
            </div>
        </header>
        <!-- header -->

        <!-- footer -->
        <div class="copyright py-4 text-center text-white">
            <div class="container">
                <small>
                    Copyright -
                    Víctor Méndez - Following Daniel Correa and Paola Vallejo's course on "Practical Laravel" <a href="https://www.amazon.com/Practical-Laravel-Develop-clean-applications/dp/B09S69MHRB"> Book. </a>
                    <br>
                    Original code can be found <a href="https://github.com/vicanmendez/Practical-Laravel.git">here</a>.
                    <br>
                    Some modifications have been made by me in this version of the project (Adding order controls, email notifications, etc)
                </small>
            </div>
        </div>
        <!-- footer -->
        <div class="container my-4">
            @yield('content')
        </div>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
            crossorigin="anonymous"></script>
    </body>
</html>