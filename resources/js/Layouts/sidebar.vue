
<template>
     <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="nav-profile-image">
                  <img src="../../../resources/images/faces/id.jpg" alt="profile" />
                  <span class="login-status online"></span>
                  <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                  <span class="font-weight-bold mb-2">Welcome!</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.html">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#masterfile" aria-expanded="false" aria-controls="masterfile">
                <span class="menu-title">Masterfile</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
              </a>
              <div class="collapse" id="masterfile">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="/businessunit_list">Business Units</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/department_list">Departments</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/documenttype_list">Document Type</a>
                  </li>
                </ul>
              </div>
            </li>
            
           
           
          </ul>
        </nav>
</template>