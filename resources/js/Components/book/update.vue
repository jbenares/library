<script setup>
  import navigation from '../../Layouts/navigation.vue';
  import sidebar from '../../Layouts/sidebar.vue';
  import footer_view from '../../Layouts/footer.vue';
  import {onMounted, ref, watch} from "vue";
  import { useRouter } from "vue-router"
  const router = useRouter()
	let form = ref([])
	let error = ref('')
	let success = ref('')
    let imageFile1=ref("");
    let imageUrl1=ref("");
    let error_image=ref('')

    
    const props = defineProps({
        id:{
            type:String,
            default:''
        }
    })

    

    const upload_image = (event) => {
        let file = event.target.files[0];
        if(event.target.files.length===0){
            imageFile1.value='';
            imageUrl1.value='';
            return;
        }else if(file['size'] < 1000000){
            imageFile1.value = event.target.files[0];
            error_image.value=''
        }else{
            error_image.value='File size can not be bigger than 1 MB'
            imageUrl1.value='';
        }
    }
    watch(imageFile1, (imageFile1) => {
        if(!(imageFile1 instanceof File)){
            return;
        }
        let fileReader1 = new FileReader();
        fileReader1.readAsDataURL(imageFile1)
        fileReader1.addEventListener("load", () => {
            imageUrl1.value=fileReader1.result
        })

     
    })

    onMounted(async () => {
        getBookDetails()
    })

    const getBookDetails = async() => {
         let response = await axios.get(`/api/get_details/${props.id}`)
       
        form.value = response.data

    }

  const onSave = () => {
    
		const formData= new FormData()
		formData.append('book_name', form.value.book_name)
        formData.append('author', form.value.author)
        formData.append('book_cover', imageFile1.value)
      

      axios.post(`/api/update_book/${props.id}`,formData,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(function () {
        success.value='You have successfully updated the data!'
       
        document.getElementById("image1").value=''
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
                Edit Book
              </h3>
              
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                    <a href='/'>Book List</a>  /  Edit Book
                  </li>
                 
                </ul>
              </nav>
              
            </div>
         
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  
                
                      <div class="form-group">
                        <label for="book_name">Book Name</label>
                        <input type="text" class="form-control" v-model="form.book_name">
                      </div>
                      <div class="form-group">
                        <label for="author">Author</label>
                        <input type="text" class="form-control" v-model="form.author">
                      </div>
                      <div class="form-group">
                        <label >Book Cover</label>
                        <p class="text-danger" v-if='error_image'>{{ error_image }}</p>
                        <input type="file" class="form-control" accept="image/*" id="image1" @change="upload_image">
                        <div class="mt-2" v-if="imageUrl1 == ''">
                            <img :src="`/books/`+form.book_cover" v-if="form.book_cover" class="rounded shadow-md border-white border " style="width:150px"/>
                            <img :src="'/books/default.png'" v-else class="rounded shadow-md border-white border " style="width:150px"/>
                        </div> 
                        <div class="mt-2" v-else>
                        <img :src="imageUrl1"  class="rounded shadow-md border-white border" style="width:150px"/> 
                        </div>
                      </div>
                     
                      <button @click="onSave()" class="btn btn-primary mr-2 ">Update Book</button>
                   
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