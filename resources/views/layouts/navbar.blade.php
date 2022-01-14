<nav class="navbar-ku navbar navbar-expand-lg navbar-dark bg-dark fixed-top" aria-label="Ninth navbar example">
  <div class="container-xl">
    <a class="navbar-brand d-flex" href="#"><div class="fw-bold me-2 text-danger">HK</div> DECORATION</a>
    <button class="navbar-toggler-ku navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample07XL" aria-controls="navbarsExample07XL" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample07XL">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center ">
        <li class="nav-item ">
          <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" aria-current="page" href="{{ route('home') }}">HOME</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('decoration') ? 'active' : '' }}" href="{{ route('decoration') }}">DECORATION</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('partern') ? 'active' : '' }}" href="{{ route('partern') }}">PARTERN</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('gallery*') ? 'active' : '' }}" href="{{ route('galery') }}">GALLERY</a>
        </li>
        <li class="nav-item dropdown">
          @if(@auth()->user()->role == 'user')
          <a class="nav-link" href="#" id="dropdown07XL" data-bs-toggle="dropdown" aria-expanded="false">
            @if(@auth()->user()->customer()->first()->fotoProfil)
              <img src="{{asset('storage/' . auth()->user()->customer()->first()->fotoProfil)}}" alt="mdo" width="40" height="40" class="rounded-circle" style="border: 2px solid white;">
            @else
              <i class="bi bi-person fs-5"></i>
            @endif
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown07XL">
            <li><a class="dropdown-item" href="/profile">Profile</a></li>
            <li><a class="dropdown-item" href="/chat">Pesan</a></li>
            <li><a class="dropdown-item" href="/cart">Cart</a></li>
            <li><a class="dropdown-item" href="/myorder">My order</a></li>
            <li><hr class="dropdown-divider"></li>
            <form action="/logout" method="post">
              @csrf
              <li><button type="submit" class="dropdown-item" href="#">Logout</button></li>
            </form>
          </ul>
          
          @else
          <a class="nav-link" href="#" id="dropdown07XL" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person fs-5"></i>
            <!-- <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle"> -->
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown07XL">
            <li><a class="dropdown-item" href="/login">Login</a></li>
            <li><a class="dropdown-item" href="/register">Register</a></li>
          </ul>
          @endif
        </li>
      </ul>
    </div>
  </div>
</nav>