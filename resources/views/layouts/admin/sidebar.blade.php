  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="{{ url('/dashboard') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        @php $route = \Request::route()->getName(); @endphp
        <a @if($route == 'manage-farmer' || $route == 'add-farmer' || $route == 'edit-farmer' || $route == 'update-farmer') class="nav-link" @else class="nav-link collapsed" @endif data-bs-target="#farmers-nav" data-bs-toggle="collapse" href="#" @if($route == 'manage-farmer' || $route == 'add-farmer' || $route == 'edit-farmer' || $route == 'update-farmer') aria-expanded="true" @endif>
          <i class="bi bi-menu-button-wide"></i><span>Manage Farmers</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="farmers-nav" @if($route == 'manage-farmer' || $route == 'add-farmer' || $route == 'edit-farmer' || $route == 'update-farmer') class="nav-content collapse show" @else class="nav-content collapse" @endif data-bs-parent="#sidebar-nav">
          <li>
            <a @if($route == 'manage-farmer' || $route == 'add-farmer' || $route == 'edit-farmer' || $route == 'update-farmer') class="active" @endif href="{{route('manage-farmer')}}">
              <i class="bi bi-circle"></i><span>List Farmers</span>
            </a>
          </li>
        </ul>
      </li><!-- End farmers Nav -->

      <li class="nav-item">
        <a @if($route == 'manage-city' || $route == 'add-city' || $route == 'edit-city' || $route == 'update-city' || $route == 'manage-tehsil' || $route == 'add-tehsil' || $route == 'edit-tehsil' || $route == 'update-tehsil' || $route == 'manage-district' || $route == 'add-district' || $route == 'edit-district' || $route == 'update-district') class="nav-link" @else class="nav-link collapsed" @endif data-bs-target="#district-tehsil-village-nav" data-bs-toggle="collapse" href="#"  @if($route == 'manage-city' || $route == 'add-city' || $route == 'edit-city' || $route == 'update-city' || $route == 'manage-tehsil' || $route == 'add-tehsil' || $route == 'edit-tehsil' || $route == 'update-tehsil' || $route == 'manage-district' || $route == 'add-district' || $route == 'edit-district' || $route == 'update-district') aria-expanded="true" @endif>
          <i class="bi bi-journal-text"></i><span>Manage District/ Tehsil/ Village</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="district-tehsil-village-nav" @if($route == 'manage-city' || $route == 'add-city' || $route == 'edit-city' || $route == 'update-city' || $route == 'manage-tehsil' || $route == 'add-tehsil' || $route == 'edit-tehsil' || $route == 'update-tehsil' || $route == 'manage-district' || $route == 'add-district' || $route == 'edit-district' || $route == 'update-district') class="nav-content collapse show" @else class="nav-content collapse " @endif data-bs-parent="#sidebar-nav">
          <li>
            <a @if($route == 'manage-district' || $route == 'add-district' || $route == 'edit-district' || $route == 'update-district') class="active" @endif href="{{route('manage-district')}}">
              <i class="bi bi-circle"></i><span>List Districts</span>
            </a>
          </li>
          <li>
            <a @if($route == 'manage-tehsil' || $route == 'add-tehsil' || $route == 'edit-tehsil' || $route == 'update-tehsil') class="active" @endif href="{{route('manage-tehsil')}}">
              <i class="bi bi-circle"></i><span>List Tehsil</span>
            </a>
          </li>
          <li>
            <a @if($route == 'manage-city' || $route == 'add-city' || $route == 'edit-city' || $route == 'update-city') class="active" @endif href="{{route('manage-city')}}">
              <i class="bi bi-circle"></i><span>List Village</span>
            </a>
          </li>
        </ul>
      </li><!-- End District Nav -->

      <li class="nav-item">
        <a @if($route == 'manage-caste-category') class="nav-link" @else class="nav-link collapsed" @endif data-bs-target="#caste-cat-nav" data-bs-toggle="collapse" href="#" @if($route == 'manage-caste-category') aria-expanded="true" @endif>
          <i class="bi bi-layout-text-window-reverse"></i><span>Manage Caste Category</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="caste-cat-nav" @if($route == 'manage-caste-category') class="nav-content collapse show" @else class="nav-content collapse" @endif data-bs-parent="#sidebar-nav">
          <li>
            <a @if($route == 'manage-caste-category') class="active" @endif href="{{route('manage-caste-category')}}">
              <i class="bi bi-circle"></i><span>List Caste Category</span>
            </a>
          </li>
        </ul>
      </li><!-- End Caste Category Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#applicant-type-nav" data-bs-toggle="collapse" href="#" @if($route == 'manage-applicant-type') aria-expanded="true" @endif>
          <i class="bi bi-bar-chart"></i><span>Manage Applicant Types</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="applicant-type-nav" @if($route == 'manage-applicant-type') class="nav-content collapse show" @else class="nav-content collapse " @endif data-bs-parent="#sidebar-nav">
          <li>
            <a @if($route == 'manage-applicant-type') class="active" @endif href="{{route('manage-applicant-type')}}">
              <i class="bi bi-circle"></i><span>List Applicant Type</span>
            </a>
          </li>          
        </ul>
      </li><!-- End Applicant Type Nav -->
      
      <li class="nav-item">
        <a @if($route == 'manage-pscheme' || $route == 'add-pscheme' || $route == 'edit-pscheme' || $route == 'update-pscheme' || $route == 'manage-scheme' || $route == 'add-scheme' || $route == 'edit-scheme' || $route == 'update-scheme' || $route == 'manage-scheme-category' || $route == 'add-scheme-category' || $route == 'edit-scheme-category' || $route == 'update-scheme-category' || $route == 'manage-scheme-subcategory' || $route == 'edit-scheme-subcategory' || $route == 'update-scheme-subcategory' || $route == 'add-scheme-subcategory') class="nav-link" @else class="nav-link collapsed" @endif data-bs-target="#manage-sheme-nav" data-bs-toggle="collapse" href="#" @if($route == 'manage-scheme' || $route == 'add-scheme' || $route == 'edit-scheme' || $route == 'update-scheme' || $route == 'manage-scheme-category' || $route == 'add-scheme-category' || $route == 'edit-scheme-category' || $route == 'update-scheme-category' || $route == 'manage-scheme-subcategory' || $route == 'edit-scheme-subcategory' || $route == 'update-scheme-subcategory' || $route == 'add-scheme-subcategory') aria-expanded="true" @endif>
          <i class="bi bi-gem"></i><span>Manage Schemes</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="manage-sheme-nav" @if($route == 'manage-pscheme' || $route == 'add-pscheme' || $route == 'edit-pscheme' || $route == 'update-pscheme' || $route == 'manage-scheme' || $route == 'add-scheme' || $route == 'edit-scheme' || $route == 'update-scheme' || $route == 'manage-scheme-category' || $route == 'add-scheme-category' || $route == 'edit-scheme-category' || $route == 'update-scheme-category' || $route == 'manage-scheme-subcategory' || $route == 'edit-scheme-subcategory' || $route == 'update-scheme-subcategory' || $route == 'add-scheme-subcategory') class="nav-content collapse show" @else class="nav-content collapse " @endif data-bs-parent="#sidebar-nav">
          <li>
            <a @if($route == 'manage-pscheme-category' || $route == 'add-pscheme-category' || $route == 'edit-pscheme-category' || $route == 'update-pscheme-category') class="active" @endif href="{{route('manage-pscheme-category')}}">
              <i class="bi bi-circle"></i><span>List Parent Scheme Category</span>
            </a>
          </li>
          <li>
            <a @if($route == 'manage-scheme-category' || $route == 'add-scheme-category' || $route == 'edit-scheme-category' || $route == 'update-scheme-category') class="active" @endif href="{{route('manage-scheme-category')}}">
              <i class="bi bi-circle"></i><span>List Scheme Category</span>
            </a>
          </li>
          <li>
            <a @if($route == 'manage-scheme-subcategory' || $route == 'edit-scheme-subcategory' || $route == 'update-scheme-subcategory' || $route == 'add-scheme-subcategory') class="active" @endif href="{{route('manage-scheme-subcategory')}}">
              <i class="bi bi-circle"></i><span>List Scheme Sub-Category</span>
            </a>
          </li>
          <li>
            <a @if($route == 'manage-scheme' || $route == 'add-scheme' || $route == 'edit-scheme' || $route == 'update-scheme') class="active" @endif href="{{route('manage-scheme')}}">
              <i class="bi bi-circle"></i><span>List Schemes</span>
            </a>
          </li>
        </ul>
      </li><!-- End Schemes Nav -->

    </ul>

  </aside><!-- End Sidebar-->