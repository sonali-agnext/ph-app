<!-- ======= Header ======= -->
<style>
  .bg-info{
    background: #d6f3f9 !important;
  }
  .blink_me {
    color: #ff0606c9 !important;
  animation: blinker 1s linear infinite;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}
</style>
<header id="header" class="header fixed-top d-flex align-items-center">
@php $image = \App\Models\AdminProfile::where('user_id', Auth::user()->id)->first();  @endphp
<div class="d-flex align-items-center justify-content-between">
  <a href="{{url('/')}}" class="logo d-flex align-items-center">
    <img src="{{ asset('img/apple-icon-72x72.png')}}" alt="">
    <span class="d-none d-lg-block">PH App</span>
  </a>
  <i class="bi bi-list toggle-sidebar-btn"></i>
</div><!-- End Logo -->

<!-- <div class="search-bar">
  <form class="search-form d-flex align-items-center" method="POST" action="#">
    <input type="text" name="query" placeholder="Search" title="Enter search keyword">
    <button type="submit" title="Search"><i class="bi bi-search"></i></button>
  </form>
</div> -->
<!-- End Search Bar -->

<nav class="header-nav ms-auto">
  <ul class="d-flex align-items-center">

    <!-- <li class="nav-item d-block d-lg-none">
      <a class="nav-link nav-icon search-bar-toggle " href="#">
        <i class="bi bi-search"></i>
      </a>
    </li> -->
    <!-- End Search Icon-->

    <li class="nav-item dropdown">

      <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
        <i class="bi bi-bell"></i>
      </a>
      <!-- End Notification Icon -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications ajax-dropdown" style="max-height: 350px;
    overflow: auto;">
        

      </ul><!-- End Notification Dropdown Items -->

    </li><!-- End Notification Nav -->

    <li class="nav-item dropdown">

      <!-- <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
        <i class="bi bi-chat-left-text"></i>
        <span class="badge bg-success badge-number">3</span>
      </a> -->
      <!-- End Messages Icon -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
        <li class="dropdown-header">
          You have 3 new messages
          <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li class="message-item">
          <a href="#">
            <img src="{{ asset('img/messages-1.jpg')}}" alt="" class="rounded-circle">
            <div>
              <h4>Maria Hudson</h4>
              <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
              <p>4 hrs. ago</p>
            </div>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li class="message-item">
          <a href="#">
            <img src="{{ asset('img/messages-2.jpg')}}" alt="" class="rounded-circle">
            <div>
              <h4>Anna Nelson</h4>
              <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
              <p>6 hrs. ago</p>
            </div>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li class="message-item">
          <a href="#">
            <img src="{{ asset('img/messages-3.jpg')}}" alt="" class="rounded-circle">
            <div>
              <h4>David Muldon</h4>
              <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
              <p>8 hrs. ago</p>
            </div>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li class="dropdown-footer">
          <a href="#">Show all messages</a>
        </li>

      </ul><!-- End Messages Dropdown Items -->

    </li><!-- End Messages Nav -->

    <li class="nav-item dropdown pe-3">

      <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
      @if(!empty($image->avatar))
                        
          @if(file_exists( public_path('storage/images/admin/'.$image->avatar)))
            <img src="{{asset('storage/images/admin/'.$image->avatar)}}" alt="Profile" class="rounded-circle">
          @else
          @endif
      @else
        <img src="{{ asset('img/no-user.png')}}" alt="Profile" class="rounded-circle">
      @endif
      
        <span class="d-none d-md-block dropdown-toggle ps-2">{{Auth::user()->name}}</span>
      </a><!-- End Profile Iamge Icon -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
        <li class="dropdown-header">
          <h6>{{Auth::user()->name}}</h6>
          @php $role = \App\Models\Role::where('id', Auth::user()->role_id)->pluck('name'); @endphp
          <span>{{$role[0]}}</span>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="{{route('admin-profile')}}">
            <i class="bi bi-person"></i>
            <span>My Profile</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <!-- <li>
          <a class="dropdown-item d-flex align-items-center" href="#">
            <i class="bi bi-gear"></i>
            <span>Account Settings</span>
          </a>
        </li> -->
        <li>
          <hr class="dropdown-divider">
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right"></i>
            <span>Sign Out</span>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
          </form>
        </li>

      </ul><!-- End Profile Dropdown Items -->
    </li><!-- End Profile Nav -->

  </ul>
</nav><!-- End Icons Navigation -->

</header><!-- End Header -->
@push('scripts')
<script>
  var interval = setInterval(counter, 2000);
  function counter(){
$.ajax({
        type: 'GET',
        url: "{{url('fetch-notification')}}",
        data: { },
        dataType: "json",
        success: function(resultData) {
          var html = '';
          if(resultData.data.length > 0){
            if(resultData.count){
              $('.bi-bell').addClass('blink_me');
            }else{
              $('.bi-bell').removeClass('blink_me');
            }
            // html += '<ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications show">';
            html += '<li class="dropdown-header">';
            html += 'You have '+resultData.count+' new notifications.'; if(resultData.count != 0) {html+=' <span class="badge rounded-pill bg-primary p-2 ms-2 mark-all">Mark Read</span>'};
            // html += '<a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>';
            
            $.each(resultData.data, function (key, val) {
              
              html += '</li>';            
              html += '<li>';
              html += '<hr class="dropdown-divider">';
              html += '</li>';
              if(val.read_status){
                html += '<li class="notification-item">';
                html += '<i class="bi bi-info-circle text-info"></i>';
                html += '<div>';
                // html += '<h4>Lorem Ipsum</h4>';
                html += '<p>'+val.message+'</p>';
                // html += '<p>'++'</p>';
                html += '</div>';
                html += '</li>';
              }else{
                html += '<li class="notification-item bg-info">';
                html += '<i class="bi bi-info-circle text-info"></i>';
                html += '<div>';
                // html += '<h4>Lorem Ipsum</h4>';
                html += '<p>'+val.message+'</p>';
                // html += '<p>'++'</p>';
                html += '</div>';
                html += '</li>';
              }
              
            });
 
            // html +='<li class="dropdown-footer">';
            // html +='<a href="#">Show all notifications</a>';
            // html +='</li>';

            // html +='</ul>';
            
          }else{
          }
          $('.ajax-dropdown').empty();
          $('.ajax-dropdown').append(html);
          $('.mark-all').on('click', function(){
            var user = {{auth()->user()->id}}
              $.ajax({
                  type: 'POST',
                  url: "{{url('notification')}}",
                  data: {'user_id': user,'save':1},
                  dataType: "json",
                  success: function() {
                    $('.bi-bell').removeClass('blink_me');
                  }
              });
            });
            console.log(resultData.data.length);
        }
    }); 
    
  }
    </script>
@endpush