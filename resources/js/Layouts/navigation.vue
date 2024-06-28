
<script setup>
    import { onMounted, ref } from 'vue';
    import { useRouter } from "vue-router";
    const router = useRouter()
    
    const logout = () => {
      if(confirm("Are you sure you want to logout?")){
        localStorage.removeItem('token')
        router.push('/')
      }
    }
    </script>
    <template>
    
       <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
          <h4 class="text-primary m-5">Bookstore <br> Library Admin</h4>
          <!-- <a class="navbar-brand brand-logo" href="index.html"><img src="../../../resources/images/logo.svg" alt="logo" /></a>
          <a class="navbar-brand brand-logo-mini" href="index.html"><img src="../../../resources/images/logo-mini.svg" alt="logo" /></a> -->
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
         
         
          <ul class="navbar-nav navbar-nav-right">
          
           
           
            <li class="nav-item nav-logout d-none d-lg-block">
              <button class="nav-link"  @click="logout">
                <i class="mdi mdi-power"></i>
              </button>
            </li>
          
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>

      <!-- partial -->
</template>