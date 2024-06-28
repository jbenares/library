<script setup>
  import navigation from '../../Layouts/navigation.vue';
  import sidebar from '../../Layouts/sidebar.vue';
  import footer_view from '../../Layouts/footer.vue';
  import {onMounted, ref} from "vue";
  import { useRouter } from "vue-router"
  const router = useRouter()
	let form=ref({
    department_name:''
  })
	let error = ref('')
	let success = ref('')

  const onSave = () => {
    
		const formData= new FormData()
		formData.append('department_name', form.value.department_name)

      axios.post("/api/add_department",formData).then(function () {
        success.value='You have successfully added new data!'
        form.value.department_name=''
        document.getElementById("success").style.display="block"
        document.getElementById("error").style.display="none"
        setTimeout(() => {
          document.getElementById("success").style.display="none"
        }, 4000);
      }, function (err) {
        error.value = err.response.data.message;
        document.getElementById("error").style.display="block"
        document.getElementById("success").style.display="none"
        setTimeout(() => {
          document.getElementById("error").style.display="none"
        }, 4000);
      });

	}
</script>

<template>
 <div class="container-scroller">
  <navigation></navigation>
      <div class="container-fluid page-body-wrapper">
        <sidebar></sidebar>
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="hide-animate" v-if="success" id="success">
					<div class="alert alert-success alert-top my-2">
						<div class="d-flex  space-x-1">
							<div class="py-2 px-2" >
								<i class="mdi mdi-check-circle text-success icon-md"></i>
							</div> 
							<div class="py-1">
								<h6 class="font-bold text-success m-0">Success!</h6>
								<p class="text-sm m-0 text-gray"> {{ success }}</p>
							</div>
						</div>
					</div>
				</div>
				<div v-else id="success"></div>
				<div class="hide-animate" v-if="error" id="error">
					<div class="alert alert-danger alert-top my-2" >
						<div class="d-flex justify-start space-x-2">
							<div class="py-2 px-2" >
								<i class="fa fa-exclamation-triangle text-danger icon-md"></i>
							</div> 
							<div class="py-1">
								<h6 class="font-bold text-danger m-0">Warning!</h6>
								<p class="text-sm m-0 text-gray"> {{ error }}</p>
							</div>
						</div>
					</div>
				</div>
				<div v-else id="error"></div>
            <div class="page-header">
              <h3 class="page-title">
                Add New Department
              </h3>
              
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                    <a href='/department_list'>Department List</a>  /  Add new Department
                  </li>
                 
                </ul>
              </nav>
              
            </div>
         
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  
                
                      <div class="form-group">
                        <label >Department Name</label>
                        <input type="text" class="form-control" placeholder="Department Name" v-model="form.department_name">
                      </div>
                     
                      <button @click="onSave()" class="btn btn-primary mr-2 ">Submit</button>
                   
                  </div>
                </div>
              </div>
             
            </div>
          </div>
          <footer_view></footer_view>
        </div>
      </div>
    </div>
</template>