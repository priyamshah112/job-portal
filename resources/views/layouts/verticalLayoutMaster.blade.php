<body class="vertical-layout vertical-menu-modern {{ $configData['showMenu'] === true ? '2-columns' : '1-column' }}
{{ $configData['blankPageClass'] }} {{ $configData['bodyClass'] }}
{{ $configData['verticalMenuNavbarType'] }}
{{ $configData['sidebarClass'] }} {{ $configData['footerType'] }}" data-menu="vertical-menu-modern"
     data-col="{{ $configData['showMenu'] === true ? '2-columns' : '1-column' }}"
     data-layout="{{ ($configData['theme'] === 'light') ? '' : $configData['layoutTheme'] }}"
     style="{{ $configData['bodyStyle'] }}" data-framework="laravel" data-asset-path="{{ asset('/')}}">

     {{-- Include Sidebar --}}
     @if((isset($configData['showMenu']) && $configData['showMenu'] === true))
     @include('panels.sidebar')
     @endif

     {{-- Include Navbar --}}
     @include('panels.navbar')

     <!-- BEGIN: Content-->
     <div class="app-content content {{ $configData['pageClass'] }}">
          <!-- BEGIN: Header-->
          <div class="content-overlay"></div>
          <div class="header-navbar-shadow"></div>

          @if(($configData['contentLayout']!=='default') && isset($configData['contentLayout']))
          <div class="content-area-wrapper {{ $configData['layoutWidth'] === 'boxed' ? 'container p-0' : '' }}">
               <div class="{{ $configData['sidebarPositionClass'] }}">
                    <div class="sidebar">
                         {{-- Include Sidebar Content --}}
                         @yield('content-sidebar')
                    </div>
               </div>
               <div class="{{ $configData['contentsidebarClass'] }}">
                    <div class="content-wrapper">
                         <div class="content-body">
                              {{-- Include Page Content --}}
                              @yield('content')
                         </div>
                    </div>
               </div>
          </div>
          @else
          <div class="content-wrapper {{ $configData['layoutWidth'] === 'boxed' ? 'container p-0' : '' }}">
               {{-- Include Breadcrumb --}}
               @if($configData['pageHeader'] === true && isset($configData['pageHeader']))
               @include('panels.breadcrumb')
               @endif

               <div class="content-body">
                    {{-- Include Page Content --}}
                    @yield('content')
               </div>
          </div>
          @endif

     </div>
     <!-- End: Content-->

     @if($configData['blankPage'] == false && isset($configData['blankPage']))
     @include('content/pages/customizer')

     @include('content/pages/buy-now')
     @endif

     <div class="sidenav-overlay"></div>
     <div class="drag-target"></div>

     {{-- include footer --}}
     @include('panels/footer')
     <script>
          window.laravel = {!! json_encode([
              'user' => auth()->check() ? auth()->user()->id : null,
          ]) !!};
      </script>
     {{-- include default scripts --}}
     @include('panels/scripts')<script src="{{ asset(mix('js/app.js')) }}"></script>
     <script type="text/javascript">
          if ( Notification.permission !== 'denied' || Notification.permission === 'default') 
          {
               Notification.requestPermission().then(result => {
                    // if (result === 'granted') {
                    //      const notification = new Notification(
                    //      'Awesome! You will start receiving notifications shortly'
                    //      );
                    // }
               });
          }
          
          const showNotification = data => {
               new Notification(data.title,{
                    "body" : data.description,
                    "silent": false,
                    "requireInteraction": true, 
               });
          };

          window.Echo.private('App.User.' + window.laravel.user)
          .listen('.SendNotification', (notification) => {
               showNotification(notification.data);
          });

          // window.Echo.private('App.User.' + window.laravel.user)
          // .notification((notification) => {
          //      showNotification(notification.message);
          // });
     </script>

     <script type="text/javascript">
     $(window).on('load', function() {
          if (feather) {
               feather.replace({
                    width: 14,
                    height: 14
               });
          }
     })
     </script>
</body>

</html>
