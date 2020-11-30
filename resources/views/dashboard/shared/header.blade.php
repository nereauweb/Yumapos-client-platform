

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
            <button id="trigger-switch">
              <i class="c-icon c-d-dark-none cil-sun"></i>
				      <i class="c-icon  c-d-default-none cil-moon"></i>
            </button>
          </li>
        </ul>
        <ul class="c-header-nav">
            @hasanyrole('sales|user')
            <li class="c-header-nav-item px-3">
                Balance {{ Auth::user()->plafond }} €
            </li>
            <li class="c-header-nav-item-px-3">
                <a href="{{ route('users.payments.create') }}" class="btn btn-success">Payment</a>
            </li>
            @endrole
			<li class="c-header-nav-item px-3">
				<form action="/logout" method="POST"> @csrf <button type="submit" class="btn btn-ghost-dark btn-block light">Logout</button></form>
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
        </div>
      </header>
      <style>
        button#trigger-switch {
          background: unset;
          border: unset;
        }
      </style>
      <script>
        document.body.classList.remove('c-dark-theme');
        document.body.classList.add(localStorage.getItem('theme'));

        const switcher = document.querySelector('#trigger-switch');
        switcher.onclick = () => {
          if (document.body.classList.contains('c-dark-theme')) {
            document.body.classList.remove('c-dark-theme');
            document.body.classList.add('c-dark-theme-false');
            localStorage.setItem('theme', 'c-dark-theme-false');
          } else {
            document.body.classList.remove('c-dark-theme-false');
            document.body.classList.add('c-dark-theme');
            localStorage.setItem('theme', 'c-dark-theme');
          }
        };
      </script>
