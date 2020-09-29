
      
    <div class="c-wrapper">
      <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
        <button class="c-header-toggler c-class-toggler d-lg-none mr-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show"><span class="c-header-toggler-icon"></span></button>
          <a class="c-header-brand d-sm-none" href="#">
            <img class="c-header-brand-full c-d-dark-none" src="/img/yuma.png" width="118" height="46" alt="Yuma non stop">
            <img class="c-header-brand-minimized c-d-dark-none" src="/img/yuma.png" width="46" height="46" alt="Yuma non stop">
            <img class="c-header-brand-full c-d-light-none" src="/img/yuma.png" width="118" height="46" alt="Yuma non stop">
            <img class="c-header-brand-minimized c-d-light-none" src="/img/yuma.png" width="46" height="46" alt="Yuma non stop">
          </a>
        <button class="c-header-toggler c-class-toggler ml-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true"><span class="c-header-toggler-icon"></span></button>
        <?php
            use App\MenuBuilder\FreelyPositionedMenus;
            if(isset($appMenus['top menu'])){
                FreelyPositionedMenus::render( $appMenus['top menu'] , 'c-header-', 'd-md-down-none');
            }
        ?>       
        <ul class="c-header-nav ml-auto">
          <li class="c-header-nav-item">
              <form id="select-locale-form" action="/locale" method="GET">
                <select name="locale" id="select-locale" class="form-control">
                    @foreach($locales as $locale)
                        @if($locale->short_name == $appLocale)
                            <option value="{{ $locale->short_name }}" selected>{{ $locale->name }}</option>
                        @else
                            <option value="{{ $locale->short_name }}">{{ $locale->name }}</option>
                        @endif
                    @endforeach
                </select>
              </form>
          </li>
          <li class="c-header-nav-item px-3">
            <button class="c-class-toggler c-header-nav-btn" type="button" id="header-tooltip" data-target="body" data-class="c-dark-theme" data-toggle="c-tooltip" data-placement="bottom" title="Toggle Light/Dark Mode">
				<i class="c-icon c-d-dark-none cil-sun"></i>
				<i class="c-icon  c-d-default-none cil-moon"></i>
            </button>
          </li>
        </ul>
        <ul class="c-header-nav">
		{{--
          <li class="c-header-nav-item dropdown d-md-down-none mx-2"><a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
              <svg class="c-icon">
                <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-bell"></use>
              </svg><span class="badge badge-pill badge-danger">5</span></a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg pt-0">
              <div class="dropdown-header bg-light"><strong>You have 5 notifications</strong></div><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2 text-success">
                  <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-user-follow"></use>
                </svg> New user registered</a><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2 text-danger">
                  <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-user-unfollow"></use>
                </svg> User deleted</a><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2 text-info">
                  <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-chart"></use>
                </svg> Sales report is ready</a><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2 text-success">
                  <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-basket"></use>
                </svg> New client</a><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2 text-warning">
                  <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-speedometer"></use>
                </svg> Server overloaded</a>
              <div class="dropdown-header bg-light"><strong>Server</strong></div><a class="dropdown-item d-block" href="#">
                <div class="text-uppercase mb-1"><small><b>CPU Usage</b></small></div><span class="progress progress-xs">
                  <div class="progress-bar bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </span><small class="text-muted">348 Processes. 1/4 Cores.</small>
              </a><a class="dropdown-item d-block" href="#">
                <div class="text-uppercase mb-1"><small><b>Memory Usage</b></small></div><span class="progress progress-xs">
                  <div class="progress-bar bg-warning" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                </span><small class="text-muted">11444GB/16384MB</small>
              </a><a class="dropdown-item d-block" href="#">
                <div class="text-uppercase mb-1"><small><b>SSD 1 Usage</b></small></div><span class="progress progress-xs">
                  <div class="progress-bar bg-danger" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                </span><small class="text-muted">243GB/256GB</small>
              </a>
            </div>
          </li>
          <li class="c-header-nav-item dropdown d-md-down-none mx-2"><a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
              <svg class="c-icon">
                <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-list-rich"></use>
              </svg><span class="badge badge-pill badge-warning">15</span></a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg pt-0">
              <div class="dropdown-header bg-light"><strong>You have 5 pending tasks</strong></div><a class="dropdown-item d-block" href="#">
                <div class="small mb-1">Upgrade NPM & Bower<span class="float-right"><strong>0%</strong></span></div><span class="progress progress-xs">
                  <div class="progress-bar bg-info" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </span>
              </a><a class="dropdown-item d-block" href="#">
                <div class="small mb-1">ReactJS Version<span class="float-right"><strong>25%</strong></span></div><span class="progress progress-xs">
                  <div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </span>
              </a><a class="dropdown-item d-block" href="#">
                <div class="small mb-1">VueJS Version<span class="float-right"><strong>50%</strong></span></div><span class="progress progress-xs">
                  <div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </span>
              </a><a class="dropdown-item d-block" href="#">
                <div class="small mb-1">Add new layouts<span class="float-right"><strong>75%</strong></span></div><span class="progress progress-xs">
                  <div class="progress-bar bg-info" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </span>
              </a><a class="dropdown-item d-block" href="#">
                <div class="small mb-1">Angular 8 Version<span class="float-right"><strong>100%</strong></span></div><span class="progress progress-xs">
                  <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </span>
              </a><a class="dropdown-item text-center border-top" href="#"><strong>View all tasks</strong></a>
            </div>
          </li>
          <li class="c-header-nav-item dropdown d-md-down-none mx-2"><a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
              <svg class="c-icon">
                <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-envelope-open"></use>
              </svg><span class="badge badge-pill badge-info">7</span></a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg pt-0">
              <div class="dropdown-header bg-light"><strong>You have 4 messages</strong></div><a class="dropdown-item" href="#">
                <div class="message">
                  <div class="py-3 mr-3 float-left">
                    <div class="c-avatar"><img class="c-avatar-img" src="/assets/img/avatars/7.jpg" alt="user@email.com"><span class="c-avatar-status bg-success"></span></div>
                  </div>
                  <div><small class="text-muted">John Doe</small><small class="text-muted float-right mt-1">Just now</small></div>
                  <div class="text-truncate font-weight-bold"><span class="text-danger">!</span> Important message</div>
                  <div class="small text-muted text-truncate">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</div>
                </div>
              </a><a class="dropdown-item" href="#">
                <div class="message">
                  <div class="py-3 mr-3 float-left">
                    <div class="c-avatar"><img class="c-avatar-img" src="/assets/img/avatars/6.jpg" alt="user@email.com"><span class="c-avatar-status bg-warning"></span></div>
                  </div>
                  <div><small class="text-muted">John Doe</small><small class="text-muted float-right mt-1">5 minutes ago</small></div>
                  <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div>
                  <div class="small text-muted text-truncate">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</div>
                </div>
              </a><a class="dropdown-item" href="#">
                <div class="message">
                  <div class="py-3 mr-3 float-left">
                    <div class="c-avatar"><img class="c-avatar-img" src="/assets/img/avatars/5.jpg" alt="user@email.com"><span class="c-avatar-status bg-danger"></span></div>
                  </div>
                  <div><small class="text-muted">John Doe</small><small class="text-muted float-right mt-1">1:52 PM</small></div>
                  <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div>
                  <div class="small text-muted text-truncate">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</div>
                </div>
              </a><a class="dropdown-item" href="#">
                <div class="message">
                  <div class="py-3 mr-3 float-left">
                    <div class="c-avatar"><img class="c-avatar-img" src="/assets/img/avatars/4.jpg" alt="user@email.com"><span class="c-avatar-status bg-info"></span></div>
                  </div>
                  <div><small class="text-muted">John Doe</small><small class="text-muted float-right mt-1">4:03 PM</small></div>
                  <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div>
                  <div class="small text-muted text-truncate">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</div>
                </div>
              </a><a class="dropdown-item text-center border-top" href="#"><strong>View all messages</strong></a>
            </div>
          </li>
		  --}}
			  {{--
          <li class="c-header-nav-item dropdown"><a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
              <div class="c-avatar"><img class="c-avatar-img" src="/assets/img/avatars/6.jpg" alt="user@email.com"></div>
            </a>
            <div class="dropdown-menu dropdown-menu-right pt-0">
              <div class="dropdown-header bg-light py-2"><strong>Account</strong></div><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-bell"></use>
                </svg> Updates<span class="badge badge-info ml-auto">42</span></a><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-envelope-open"></use>
                </svg> Messages<span class="badge badge-success ml-auto">42</span></a><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-task"></use>
                </svg> Tasks<span class="badge badge-danger ml-auto">42</span></a><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-comment-square"></use>
                </svg> Comments<span class="badge badge-warning ml-auto">42</span></a>
              <div class="dropdown-header bg-light py-2"><strong>Settings</strong></div><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-user"></use>
                </svg> Profile</a><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-settings"></use>
                </svg> Settings</a><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-credit-card"></use>
                </svg> Payments<span class="badge badge-secondary ml-auto">42</span></a><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-file"></use>
                </svg> Projects<span class="badge badge-primary ml-auto">42</span></a>
              <div class="dropdown-divider"></div><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-lock-locked"></use>
                </svg> Lock Account</a>
				<a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-account-logout"></use>
                </svg> <form action="/logout" method="POST"> @csrf <button type="submit" class="btn btn-ghost-dark btn-block uk-dark">Logout</button></form></a>
            </div>
				--}}
			<li class="c-header-nav-item px-3">
				<form action="/logout" method="POST"> @csrf <button type="submit" class="btn btn-ghost-dark btn-block light">Logout</button></form>
			</li>
          <li class="c-header-nav-item px-3">
			@role('user')
			Balance {{ Auth::user()->plafond }} €
			@endrole
          </li>
			{{--
          <li class="c-header-nav-item px-3">
            <button class="c-class-toggler c-header-nav-btn" type="button" data-target="#aside" data-class="c-sidebar-show">
              <svg class="c-icon c-icon-lg mr-2">
                <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-applications-settings"></use>
              </svg>
            </button>
          </li>
			--}}
          </li>
        </ul>




        <div class="c-subheader px-3">
          <!-- Breadcrumb-->
          <ol class="breadcrumb border-0 m-0">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
            <?php $segments = ''; ?>
            @for($i = 1; $i <= count(Request::segments()); $i++)
                <?php $segments .= '/'. Request::segment($i); ?>
                @if($i < count(Request::segments()))
                    <li class="breadcrumb-item">{{ Request::segment($i) }}</li>
                @else
                    <li class="breadcrumb-item active">{{ Request::segment($i) }}</li>
                @endif
            @endfor
            <!-- Breadcrumb Menu-->
          </ol>
		  {{--
          <div class="c-header-nav ml-auto d-md-down-none mr-2"><a class="c-header-nav-link" href="#">
              <svg class="c-icon">
                <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-speech"></use>
              </svg></a><a class="c-header-nav-link" href="#">
              <svg class="c-icon">
                <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-graph"></use>
              </svg>  Dashboard</a><a class="c-header-nav-link" href="#">
              <svg class="c-icon">
                <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-settings"></use>
              </svg>  Settings</a></div>
		  --}}
        </div>
      </header>