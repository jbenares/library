<script setup>
    import { reactive, ref } from "vue"
    import { useRouter } from "vue-router" //use if link is used inside the page
    import { ExclamationCircleIcon, CubeIcon } from '@heroicons/vue/24/solid'
    const router = useRouter() //use if link is used inside the page

    let form = reactive({
        email:'',
        password:'',
    })

    let error = ref('')

    const login = async () =>{
        await axios.post('/api/login_process', form)
            .then(response =>{
                //alert(response.data.message)
               if(response.data.message == 'User login successfully'){
                 localStorage.setItem('token', response.data.data.token)
                 localStorage.setItem('id', response.data.data.id)
                 router.push('/dashboard')
               } else {
                  error.value = response.data.message;
               }
            })
    }
    
</script>
<template>
  <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
               <div class="brand-logo">
                  <!--<img src="../../../resources/images/logo.svg">-->
                  <h4 class="text-primary">Bookstore Library Admin</h4>
                </div>
                <!-- <h4>Hello! let's get started</h4> -->
                <h6 class="font-weight-light">Sign in to continue.</h6>
                <div class="alert alert-danger" v-if="error">
                      <Transition
                          enter-active-class="transition ease-out duration-250"
                          enter-from-class="opacity-0 h-1/2"
                          enter-to-class="opacity-100 h-full"
                          leave-active-class="transition ease-in duration-100"
                          leave-from-class="opacity-100 h-full"
                          leave-to-class="opacity-0 h-1/2"
                      >
                      <div class="flex justify-start space-x-2">
                          <div>
                              <ExclamationCircleIcon fill="none" viewBox="0 0 12 12" stroke-width="1.5" stroke="currentColor" class="w-2 h-2"></ExclamationCircleIcon>
                          </div> 
                          <div class="text-base"> {{ error }} </div>
                      </div>
                      </Transition>
                  </div>
                <form class="pt-3" @submit.prevent="login">
                  <div class="form-group">
                    <input type="email" class="form-control form-control-lg" placeholder="Email" v-model="form.email">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" placeholder="Password" v-model="form.password">
                  </div>
                  <div class="mt-3 d-grid gap-2">
                    <input type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" value="SIGN IN">
                  </div>
                  <!-- <div class="my-2 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                      <label class="form-check-label text-muted">
                        <input type="checkbox" class="form-check-input"> Keep me signed in </label>
                    </div>
                    <a href="#" class="auth-link text-primary">Forgot password?</a>
                  </div>
                  <div class="mb-2 d-grid gap-2">
                    <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                      <i class="mdi mdi-facebook me-2"></i>Connect using facebook </button>
                  </div>
                  <div class="text-center mt-4 font-weight-light"> Don't have an account? <a href="register.html" class="text-primary">Create</a>
                  </div> -->
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
</template>