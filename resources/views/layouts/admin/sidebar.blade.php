  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="{{ url('/dashboard') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
      @php $route = \Request::route()->getName(); $role_id = Auth::user()->role_id; @endphp
      @if($role_id != 5)
      <li class="nav-item">
        
        <a @if($route == 'manage-district-officer' || $route == 'add-district-officer' || $route == 'edit-district-officer' || $route == 'update-district-officer' || $route == 'manage-tehsil-officer' || $route == 'add-tehsil-officer' || $route == 'edit-tehsil-officer' || $route == 'update-tehsil-officer' || $route == 'manage-state-officer' || $route == 'add-state-officer' || $route == 'edit-state-officer' || $route == 'update-state-officer') class="nav-link" @else class="nav-link collapsed" @endif data-bs-target="#officer-nav" data-bs-toggle="collapse" href="#" @if($route == 'manage-district-officer' || $route == 'add-district-officer' || $route == 'edit-district-officer' || $route == 'update-district-officer' || $route == 'manage-tehsil-officer' || $route == 'add-tehsil-officer' || $route == 'edit-tehsil-officer' || $route == 'update-tehsil-officer' || $route == 'manage-state-officer' || $route == 'add-state-officer' || $route == 'edit-state-officer' || $route == 'update-state-officer') aria-expanded="true" @endif>
          <i class="bi bi-menu-button-wide"></i><span>Manage Officers</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="officer-nav" @if($route == 'manage-district-officer' || $route == 'add-district-officer' || $route == 'edit-district-officer' || $route == 'update-district-officer' || $route == 'manage-tehsil-officer' || $route == 'add-tehsil-officer' || $route == 'edit-tehsil-officer' || $route == 'update-tehsil-officer' || $route == 'manage-state-officer' || $route == 'add-state-officer' || $route == 'edit-state-officer' || $route == 'update-state-officer') class="nav-content collapse show" @else class="nav-content collapse" @endif data-bs-parent="#sidebar-nav">
          @if($role_id == 1)
          <li>
            <a @if($route == 'manage-state-officer' || $route == 'add-state-officer' || $route == 'edit-state-officer' || $route == 'update-state-officer') class="active" @endif href="{{route('manage-state-officer')}}">
              <i class="bi bi-circle"></i><span>Manage State Officers</span>
            </a>
          </li>
          @endif
          <li>
            <a @if($route == 'manage-district-officer' || $route == 'add-district-officer' || $route == 'edit-district-officer' || $route == 'update-district-officer') class="active" @endif href="{{route('manage-district-officer')}}">
              <i class="bi bi-circle"></i><span>Manage District Officers</span>
            </a>
          </li>
          <li>
            <a @if($route == 'manage-tehsil-officer' || $route == 'add-tehsil-officer' || $route == 'edit-tehsil-officer' || $route == 'update-tehsil-officer') class="active" @endif href="{{route('manage-tehsil-officer')}}">
              <i class="bi bi-circle"></i><span>Manage Block Officers</span>
            </a>
          </li>
        </ul>
      </li>
      <!-- End Users nav -->
      @endif
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

@if($role_id == 1)
      <li class="nav-item">
        <a @if($route == 'manage-city' || $route == 'add-city' || $route == 'edit-city' || $route == 'update-city' || $route == 'manage-block' || $route == 'add-tehsil' || $route == 'edit-block' || $route == 'update-tehsil' || $route == 'manage-district' || $route == 'add-district' || $route == 'edit-district' || $route == 'update-district') class="nav-link" @else class="nav-link collapsed" @endif data-bs-target="#district-tehsil-village-nav" data-bs-toggle="collapse" href="#"  @if($route == 'manage-city' || $route == 'add-city' || $route == 'edit-city' || $route == 'update-city' || $route == 'manage-block' || $route == 'add-tehsil' || $route == 'edit-block' || $route == 'update-tehsil' || $route == 'manage-district' || $route == 'add-district' || $route == 'edit-district' || $route == 'update-district') aria-expanded="true" @endif>
          <i class="bi bi-journal-text"></i><span>Manage District/ Block/ Village</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="district-tehsil-village-nav" @if($route == 'manage-city' || $route == 'add-city' || $route == 'edit-city' || $route == 'update-city' || $route == 'manage-block' || $route == 'add-tehsil' || $route == 'edit-block' || $route == 'update-tehsil' || $route == 'manage-district' || $route == 'add-district' || $route == 'edit-district' || $route == 'update-district') class="nav-content collapse show" @else class="nav-content collapse " @endif data-bs-parent="#sidebar-nav">
          <li>
            <a @if($route == 'manage-district' || $route == 'add-district' || $route == 'edit-district' || $route == 'update-district') class="active" @endif href="{{route('manage-district')}}">
              <i class="bi bi-circle"></i><span>List Districts</span>
            </a>
          </li>
          <li>
            <a @if($route == 'manage-block' || $route == 'add-tehsil' || $route == 'edit-block' || $route == 'update-tehsil') class="active" @endif href="{{route('manage-block')}}">
              <i class="bi bi-circle"></i><span>List Block</span>
            </a>
          </li>
          <li>
            <a @if($route == 'manage-city' || $route == 'add-city' || $route == 'edit-city' || $route == 'update-city') class="active" @endif href="{{route('manage-city')}}">
              <i class="bi bi-circle"></i><span>List Village/City</span>
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
        <a @if( $route == 'manage-pscheme-category' || $route == 'add-pscheme-category' || $route == 'edit-pscheme-category' || $route == 'update-pscheme-category' || $route == 'manage-scheme-subcomponent' || $route == 'edit-scheme-subcomponent' || $route == 'update-scheme-subcategory' || $route == 'add-scheme-subcomponent' || $route == 'manage-scheme-component' || $route == 'edit-scheme-component' || $route == 'update-scheme-component' || $route == 'add-scheme-component' || $route == 'manage-pscheme' || $route == 'add-pscheme' || $route == 'edit-pscheme' || $route == 'update-pscheme' || $route == 'manage-scheme' || $route == 'add-scheme' || $route == 'edit-scheme' || $route == 'update-scheme' || $route == 'manage-scheme-category' || $route == 'add-scheme-category' || $route == 'edit-scheme-category' || $route == 'update-scheme-category' || $route == 'manage-scheme-subcategory' || $route == 'edit-scheme-subcategory' || $route == 'update-scheme-subcategory' || $route == 'add-scheme-subcategory') class="nav-link" @else class="nav-link collapsed" @endif data-bs-target="#manage-sheme-nav" data-bs-toggle="collapse" href="#" @if( $route == 'manage-pscheme-category' || $route == 'add-pscheme-category' || $route == 'edit-pscheme-category' || $route == 'update-pscheme-category' || $route == 'manage-scheme' || $route == 'add-scheme' || $route == 'edit-scheme' || $route == 'update-scheme' || $route == 'manage-scheme-category' || $route == 'add-scheme-category' || $route == 'edit-scheme-category' || $route == 'update-scheme-category' || $route == 'manage-scheme-subcategory' || $route == 'edit-scheme-subcategory' || $route == 'update-scheme-subcategory' || $route == 'add-scheme-subcategory' || $route == 'manage-scheme-component' || $route == 'edit-scheme-component' || $route == 'update-scheme-component' || $route == 'add-scheme-component' || $route == 'manage-scheme-subcomponent' || $route == 'edit-scheme-subcomponent' || $route == 'update-scheme-subcategory' || $route == 'add-scheme-subcomponent') aria-expanded="true" @endif>
          <i class="bi bi-gem"></i><span>Manage Schemes</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="manage-sheme-nav" @if( $route == 'manage-pscheme-category' || $route == 'add-pscheme-category' || $route == 'edit-pscheme-category' || $route == 'update-pscheme-category' || $route == 'manage-scheme-subcomponent' || $route == 'edit-scheme-subcomponent' || $route == 'update-scheme-subcategory' || $route == 'add-scheme-subcomponent' || $route == 'manage-scheme-component' || $route == 'edit-scheme-component' || $route == 'update-scheme-component' || $route == 'add-scheme-component' || $route == 'manage-pscheme' || $route == 'add-pscheme' || $route == 'edit-pscheme' || $route == 'update-pscheme' || $route == 'manage-scheme' || $route == 'add-scheme' || $route == 'edit-scheme' || $route == 'update-scheme' || $route == 'manage-scheme-category' || $route == 'add-scheme-category' || $route == 'edit-scheme-category' || $route == 'update-scheme-category' || $route == 'manage-scheme-subcategory' || $route == 'edit-scheme-subcategory' || $route == 'update-scheme-subcategory' || $route == 'add-scheme-subcategory') class="nav-content collapse show" @else class="nav-content collapse " @endif data-bs-parent="#sidebar-nav">
          <li>
            <a @if( $route == 'manage-pscheme-category' || $route == 'add-pscheme-category' || $route == 'edit-pscheme-category' || $route == 'update-pscheme-category') class="active" @endif href="{{route('manage-pscheme-category')}}">
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
              <i class="bi bi-circle"></i><span>List Scheme Component Type</span>
            </a>
          </li>
          <li>
            <a @if($route == 'manage-scheme-component' || $route == 'edit-scheme-component' || $route == 'update-scheme-component' || $route == 'add-scheme-component') class="active" @endif href="{{route('manage-scheme-component')}}">
              <i class="bi bi-circle"></i><span>List Scheme Component</span>
            </a>
          </li>
          <li>
            <a @if($route == 'manage-scheme-subcomponent' || $route == 'edit-scheme-subcomponent' || $route == 'update-scheme-subcategory' || $route == 'add-scheme-subcomponent') class="active" @endif href="{{route('manage-scheme-subcomponent')}}">
              <i class="bi bi-circle"></i><span>List Scheme Sub Component</span>
            </a>
          </li>
          <li>
            <a @if($route == 'manage-scheme' || $route == 'add-scheme' || $route == 'edit-scheme' || $route == 'update-scheme') class="active" @endif href="{{route('manage-scheme')}}">
              <i class="bi bi-circle"></i><span>List Scheme Crops/Items</span>
            </a>
          </li>
        </ul>
      </li>
      @endif 
      <li class="nav-item">
        <a @if($route == 'manage-applied-scheme') class="nav-link" @else class="nav-link collapsed" @endif data-bs-target="#manage-applied-nav" data-bs-toggle="collapse" href="#" @if( $route == 'manage-applied-scheme') aria-expanded="true" @endif>
          <i class="bi bi-gem"></i><span>Manage Applied Schemes</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="manage-applied-nav" @if($route == 'manage-applied-scheme') class="nav-content collapse show" @else class="nav-content collapse " @endif data-bs-parent="#sidebar-nav">
          <li class="nav-item">
            <a @if($route == 'manage-applied-scheme') class="active" @endif href="{{route('manage-applied-scheme')}}">
            <i class="bi bi-circle"></i><span>Manage Applied Scheme</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a @if($route == 'manage-subsidy-state' || $route == 'manage-subsidy-district') class="nav-link" @else class="nav-link collapsed" @endif data-bs-target="#manage-subsidy-nav" data-bs-toggle="collapse" href="#" @if($route == 'manage-subsidy-state' || $route == 'manage-subsidy-district') aria-expanded="true" @endif>
          <i class="bi bi-gem"></i><span>Manage Subsidy</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="manage-subsidy-nav" @if($route == 'manage-subsidy-state'|| $route == 'manage-subsidy-district') class="nav-content collapse show" @else class="nav-content collapse " @endif data-bs-parent="#sidebar-nav">
          @if($role_id == 3 || $role_id == 1)
          <li>
            <a @if($route == 'manage-subsidy-state') class="active" @endif href="{{route('manage-subsidy-state')}}">
              <i class="bi bi-circle"></i><span>List Subsidy target for state</span>
            </a>
          </li>
          @endif
          @if($role_id == 4 || $role_id == 3)
          <li>
            <a @if($route == 'manage-subsidy-district') class="active" @endif href="{{route('manage-subsidy-district')}}">
              <i class="bi bi-circle"></i><span>List Subsidy target for district</span>
            </a>
          </li>
          @endif
          @if($role_id == 4 || $role_id == 5)
          <li>
            <a @if($route == 'manage-subsidy-block') class="active" @endif href="{{route('manage-subsidy-block')}}">
              <i class="bi bi-circle"></i><span>List Subsidy target for block</span>
            </a>
          </li>
          @endif
        </ul>
      </li>
      
      <!-- End Schemes Nav -->

    </ul>

  </aside><!-- End Sidebar-->