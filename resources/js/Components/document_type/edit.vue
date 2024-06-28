<script setup>
  import navigation from '../../Layouts/navigation.vue';
  import sidebar from '../../Layouts/sidebar.vue';
  import footer_view from '../../Layouts/footer.vue';
  import { CheckCircleIcon, ExclamationCircleIcon } from '@heroicons/vue/24/solid';
  import {onMounted, ref} from "vue";
  import { useRouter } from "vue-router"
  const router = useRouter()
  let form = ref({
        id:''
    })
	let error = ref('')
	let success = ref('')

	const props = defineProps({
        id:{
            type:String,
            default:''
        }
    })

	onMounted(async () =>{
        getDocumentType()
    })

    const getDocumentType = async () => {
        let response = await axios.get(`/api/edit_documenttype/${props.id}`)
        form.value = response.data

        
    }

	
	const onEdit = (id) => {
		const formData= new FormData()
		formData.append('type_name', form.value.type_name)
		axios.post(`/api/update_documenttype/${form.value.id}`,formData).then(function () {
			success.value='You have successfully updated the data!'
			// form.value.unit_name=''
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
                Edit Document Type
              </h3>
              
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                    <a href='/documenttype_list'>Document type List</a>  /  Edit Document Type
                  </li>
                 
                </ul>
              </nav>
              
            </div>
         
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  
                  
                      <div class="form-group">
                        <label for="exampleInputName1">Document Type</label>
                        <input type="text" class="form-control" v-model="form.type_name">
                      </div>
                      <input type="hidden" v-model="form.id">
                      <button @click="onEdit(form.id)" class="btn btn-primary mr-2 ">Save Changes</button>
                  
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