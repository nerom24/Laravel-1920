<nav class="navbar navbar-expand-lg navbar">
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
        <a class="nav-link" href="{{route('admin.users.create')}}" title="Nuevo usuario">Nuevo <span class="sr-only">(current)</span></a>
        </li>
        {{-- <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li> --}}
      </ul>
      <form class="form-inline my-2 my-lg-0" action="{{route('admin.users.index')}}" method="GET">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" name="search" aria-label="Search">
        <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit">Buscar</button>
      </form>
    </div>
</nav>