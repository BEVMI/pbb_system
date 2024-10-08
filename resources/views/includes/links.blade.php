<ul class="list-group list-group-flush">
    <li class="list-group-item">
      <a class="nav-link " href="{{route('mrp.index')}}">
        <i class="fa-solid fa-file-invoice text-primary text-sm opacity-10" style="color:rgb(247, 2, 247);"></i>
        <span class="nav-link-text ms-1 pt-2" style="margin-left: 5% !IMPORTANT;">MRP</span>
      </a>
    </li>

    <li class="list-group-item">
      <a class="nav-link " href="{{route('forecast.index')}}">
        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
        <span class="nav-link-text ms-1" style="margin-left: 4% !IMPORTANT;">FORECAST</span>
      </a>
    </li>

    <li class="list-group-item">
      <a class="nav-link " href="{{route('pocompliance.index')}}">
        <i class="fa-solid fa-book-open-reader text-sm opacity-10"  style="color:rgb(149, 2, 247);"></i>
        <span class="nav-link-text ms-1" style="margin-left: 4% !IMPORTANT;">PO COMP.</span>
      </a>
    </li>

    <li class="list-group-item">
      <a class="nav-link " href="{{route('inventoryfg.index')}}">
        <i class="fa-regular fa-clipboard text-sm opacity-10"  style="color:rgb(2, 247, 239);"></i>
        <span class="nav-link-text ms-1" style="margin-left: 5% !IMPORTANT;">INVENTORY FG</span>
      </a>
    </li>

    <li class="list-group-item">
      <a class="nav-link " href="{{route('inventorymaterials.index')}}">
        <i class="fa-solid fa-money-bill text-sm opacity-10"  style="color:rgb(2, 169, 247);"></i>
        <span class="nav-link-text ms-1" style="margin-left: 4% !IMPORTANT;">INVENTORY PM</span>
      </a>
    </li>
    @if($user_auth->is_admin='1')
      <li class="list-group-item">
        <a class="nav-link " href="{{route('users.index')}}">
          <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
          <span class="nav-link-text ms-1" style="margin-left: 4% !IMPORTANT;">USERS</span>
        </a>
      </li>
    @endif
  </ul>