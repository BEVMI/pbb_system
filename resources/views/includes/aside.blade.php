<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0">
        <img src="{{asset('images/PBB_LOGO.png')}}" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">PBB SYSTEM</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
   
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item text-center">
          <b>{{$user_auth->name}}</b>
          <br>
          <hr style="background-color: black; height: 1px; border: 0;">
        </li> 
        
        @if($user_auth->line_1 =='1')
          <li class="nav-item">
            <a class="nav-link " href="{{route('plan_line1.index')}}">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-1 text-sm opacity-10"  style="color:rgb(2, 31, 247);"></i>
              </div>
              <span class="nav-link-text ms-1" style="margin-top:8px;">LINE 1</span>
            </a>
          </li>
        @endif

        @if($user_auth->line_2 == '1')
          <li class="nav-item">
            <a class="nav-link " href="{{route('plan_line2.index')}}">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-2 text-sm opacity-10"  style="color:rgb(2, 31, 247);"></i>
              </div>
              <span class="nav-link-text ms-1" style="margin-top:8px;">LINE 2</span>
            </a>
          </li>
        @endif

        @if($user_auth->injection == '1')
          <li class="nav-item">
            <a class="nav-link " href="{{route('injection.index')}}">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-3 text-sm opacity-10"  style="color:rgb(2, 31, 247);"></i>
              </div>
              <span class="nav-link-text ms-1" style="margin-top:8px;">INJECTION</span>
            </a>
          </li>
        @endif

        @if($user_auth->is_pm='1')
          <li class="nav-item">
            <a class="nav-link " href="{{route('pm.index')}}">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-sheet-plastic text-sm opacity-10"  style="color:rgb(2, 31, 247);"></i>
              </div>
              <span class="nav-link-text ms-1" style="margin-top:8px;">PM</span>
            </a>
          </li>
        @endif

        <li class="nav-item">
          <a class="nav-link " href="{{route('job.index')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-bars-progress text-sm opacity-10"  style="color:rgb(218, 2, 247);"></i>
            </div>
            <span class="nav-link-text ms-1" style="margin-top:8px;">JOB</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link " href="{{route('reject.index')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-eject text-sm opacity-10"  style="color:rgb(247, 227, 2);"></i>
            </div>
            <span class="nav-link-text ms-1" style="margin-top:8px;">REJECTS</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link " href="{{route('logout')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-right-from-bracket text-sm opacity-10"  style="color:red;"></i>
            </div>
            <span class="nav-link-text ms-1" style="margin-top:8px;">LOGOUT</span>
          </a>
        </li>
        
      </ul>
    </div>
    <div class="sidenav-footer mx-3 ">
      <button href="javascript:;" class="btn btn-outline-secondary fixed-plugin-button-nav cursor-pointer" style="width:100%;">
        MORE LINK
      </button>
    </div>
  </aside>