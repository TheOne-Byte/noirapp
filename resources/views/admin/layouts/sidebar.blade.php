<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
    <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarMenuLabel">Company name</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
      </div>

      <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
        <ul class="nav flex-column">
          <li class="nav-item"  style="background-color: wheat;">
            <a  class="nav-link {{ $active == 'dashboard' ? 'active' : ''}}" href="/dashboard">
              <svg class="bi" ><use xlink:href="#house-fill"/></svg>
              Dashboard
            </a>
          </li>
          

          <li class="nav-item" style="background-color: #cde8e6;">
            <a class="nav-link  {{ $active == 'dashcategory' ? 'active' : ''}}" href="/dashboard/categories">
              <svg class="bi"><use xlink:href="#file-earmark"/></svg>
              Categories
            </a>
          </li>

          <li class="nav-item" style="background-color: #e0bbe4;">
            <a class="nav-link  {{ $active == 'dashboardrole' ? 'active' : ''}}" href="/dashboard/role">
              <svg class="bi"><use xlink:href="#file-earmark"/></svg>
              Role Request
            </a>
          </li>

          <li class="nav-item" style="background-color: #ffee93;">
            <a class="nav-link  {{ $active == 'dashboardidcard' ? 'active' : ''}}" href="/dashboard/idcard">
              <svg class="bi"><use xlink:href="#file-earmark"/></svg>
              Id Card Number Request
            </a>
          </li>
         
        </ul>

        @can('admin') 
        {{-- ini dari appserviceprovider yakni gates --}}
          
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>ADMINISTRATOR</span>
        </h6>

        <ul class="nav flex-column">
          <li class="nav-item">
            <a  class="nav-link {{ $active == 'dashboardcategories' ? 'active' : ''}}" href="/dashboard/categories">
              <i class="bi bi-box-fill"></i>              
              POST CATEGORIES
            </a>
          </li>
        </ul>

       
        @endcan

        {{-- <a href="/dash" class="nav-link {{ (request()->is('dashboard/posts')) ? 'active' : ''}}">ven</a> --}}
       

        <hr class="my-3">

      
      </div>
    </div>
  </div>