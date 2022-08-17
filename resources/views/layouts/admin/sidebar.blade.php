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
        <a class="nav-link collapsed" data-bs-target="#farmers-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Manage Farmers</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="farmers-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('manage-farmer')}}">
              <i class="bi bi-circle"></i><span>List Farmers</span>
            </a>
          </li>
        </ul>
      </li><!-- End farmers Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#district-tehsil-village-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Manage District/ Tehsil/ Village</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="district-tehsil-village-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('manage-district')}}">
              <i class="bi bi-circle"></i><span>List Districts</span>
            </a>
          </li>
          <li>
            <a href="{{route('manage-tehsil')}}">
              <i class="bi bi-circle"></i><span>List Tehsil</span>
            </a>
          </li>
          <li>
            <a href="{{route('manage-city')}}">
              <i class="bi bi-circle"></i><span>List Village</span>
            </a>
          </li>
        </ul>
      </li><!-- End District Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#caste-cat-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Manage Caste Category</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="caste-cat-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('manage-caste-category')}}">
              <i class="bi bi-circle"></i><span>List Caste Category</span>
            </a>
          </li>
        </ul>
      </li><!-- End Caste Category Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#applicant-type-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>Manage Applicant Types</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="applicant-type-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('manage-applicant-type')}}">
              <i class="bi bi-circle"></i><span>List Applicant Type</span>
            </a>
          </li>          
        </ul>
      </li><!-- End Applicant Type Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#manage-sheme-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gem"></i><span>Manage Schemes</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="manage-sheme-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('manage-scheme-category')}}">
              <i class="bi bi-circle"></i><span>List Scheme Category</span>
            </a>
          </li>
          <li>
            <a href="{{route('manage-scheme-subcategory')}}">
              <i class="bi bi-circle"></i><span>List Scheme Sub-Category</span>
            </a>
          </li>
          <li>
            <a href="{{route('manage-scheme')}}">
              <i class="bi bi-circle"></i><span>List Schemes</span>
            </a>
          </li>
        </ul>
      </li><!-- End Schemes Nav -->

    </ul>

  </aside><!-- End Sidebar-->