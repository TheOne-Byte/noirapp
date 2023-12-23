<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/home">NOIR</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ $active === 'home' ? 'active' : '' }}" aria-current="page"
                            href="/home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $active === 'game' ? 'active' : '' }}" href="/game">Game</a>
                    </li>

                </ul>


                @auth
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a href="/cart/{{ auth()->user()->username }}" class="btn">
                                <i class="bi bi-cart-fill"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $active === 'top_up' ? 'active' : '' }}" href="/top_up">Top Up</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Welcome back, {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                @if (in_array(auth()->user()->role_id, [1, 2]))
                                    <!-- Periksa role_id -->
                                    <li>
                                        <a href="/order-request" style="text-decoration: none">
                                            <button type="button" class="dropdown-item">
                                                <i class="bi bi-arrow-down-left-square"></i> Order Request
                                            </button>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/transactions" style="text-decoration: none">
                                            <button type="button" class="dropdown-item">
                                                <i class="bi bi-cart-check"></i> Order history
                                            </button>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/usertransaction" style="text-decoration: none">
                                            <button type="button" class="dropdown-item">
                                                <i class="bi bi-clipboard2-check"></i> Your Transactions
                                            </button>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/withdrawal" style="text-decoration: none">
                                            <button type="button" class="dropdown-item">
                                                <i class="bi bi-cash-coin"></i> Gatcha withdrawal
                                            </button>
                                        </a>
                                    </li>
                                    {{-- <li>
                                        <a href="/updatesingleuser" style="text-decoration: none">
                                            <button type="button" class="dropdown-item">
                                                <i class="bi bi-arrow-up-right-square"></i> Edit Displayed Item
                                            </button></a>
                                    </li> --}}
                                    <li>
                                        <a href="/editavailabletimes" style="text-decoration: none">
                                            <button type="button" class="dropdown-item">
                                                <i class="bi bi-arrow-down-left-square"></i> Edit Available Times
                                            </button>
                                        </a>
                                    </li>
                                    <li>
                                <a href="/sellerschedule" style="text-decoration: none">
                                    <button type="button" class="dropdown-item">
                                        <i class="bi bi-arrow-up-right-square"></i> Schedule
                                    </button>
                                </a>
                            </li>
                            <li>
                                        <a href="/history" style="text-decoration: none">
                                            <button type="button" class="dropdown-item">
                                                <i class="bi bi-clock-history"></i> History
                                            </button>
                                        </a>
                                    </li>


                                @endif
                                @if (auth()->user()->role_id == 4)
                                    <li>
                                        <a href="/usertransaction" style="text-decoration: none">
                                            <button type="button" class="dropdown-item">
                                                <i class="bi bi-clipboard2-check"></i> Your Transactions
                                            </button>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/history" style="text-decoration: none">
                                            <button type="button" class="dropdown-item">
                                                <i class="bi bi-clock-history"></i> History
                                            </button>
                                        </a>
                                    </li>

                                    {{-- <li>
                                        <a href="/userschedule" style="text-decoration: none">
                                            <button type="button" class="dropdown-item">
                                                <i class="bi bi-arrow-up-right-square"></i> Schedule
                                            </button>
                                        </a>
                                    </li> --}}
                        @endif
                                <li>
                                    <a href="/role/request" style="text-decoration: none">
                                        <button type="" class="dropdown-item">
                                            <i class="bi bi-file-person"></i> Request Role
                                        </button>
                                    </a>
                                </li>

                                <li>
                                    <form action="/logout" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-arrow-up-right-square"></i>
                                            Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item mt-2">
                            <img src="/img/gatcha.png" style="height:30px" alt="" />
                            <a href="/top_up" style="text-decoration: none; color: white">
                                @if (auth()->user()->points)
                                    {{ auth()->user()->points }} POINT
                                @else
                                    0 POINT
                                @endif
                            </a>
                        </li>
                    </ul>
                @else
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ $active === 'login' ? 'active' : '' }}" href="/login"><i
                                    class="bi bi-box-arrow-in-right"></i>LOGIN</a>
                        </li>
                    </ul>
                @endauth

            </div>
    </div>
</nav>
