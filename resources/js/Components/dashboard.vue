<script setup>
	import navigation from '../Layouts/navigation.vue';
  import sidebar from '../Layouts/sidebar.vue';
  import footer_view from '../Layouts/footer.vue';
	//import footerPage from '@/Components/footer.vue';
   	import {  EyeIcon} from '@heroicons/vue/24/solid';
	import {onMounted, ref} from "vue";
  import { useRouter } from "vue-router" 
   
  const router = useRouter() 
    let books = ref([])
    let searchBooks=ref([]);
    let form = ref('')

    onMounted(async () => {
      getBooks()
    })

    const getBooks = async (page = 1) => {

        const response = await axios.get(`/api/get_all_books?page=${page}&filter=${searchBooks.value}`);
        books.value = response.data
    }

    const search = async () => {
          let response = await fetch('/api/search_books?filter='+searchBooks.value);
          books.value = await response.json();
    }

    const onEdit = (id) => {
      router.push('/update_book/'+id)
    }

    const onDelete = (id) => {
      if(confirm('Are you sure you want to delete this book?')){
        axios.get(`/api/delete_book/${id}`);
        getBooks()
      }
   
    }

    const showModal = ref(false)
    const hideModal = ref(true)
    const openModel = (id) => {
    
      showModal.value = !showModal.value
      getBookDetails(id)
   
    }
    const closeModal = () => {
      showModal.value = !hideModal.value
    }

    const getBookDetails = async(id) => {
      
         let response = await axios.get(`/api/get_details/`+id)
         form.value = response.data
    }
</script>

<template>
 <div class="container-scroller">
     
  <navigation></navigation>
      <div class="container-fluid page-body-wrapper">
        <sidebar></sidebar>
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> Dashboard
              </h3>
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                  </li>
                </ul>
              </nav>
            </div>
          
            
            <div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Book List</h4>
                    <div class="table-responsive">
                      <div >
                            <a href="/add_book" class="btn btn-gradient-primary btn-fw">Add New Book</a>
                            </div>
                        <div class="d-flex justify-between pb-2 mb-2" style=" float:right !important;" >
                            <div class=" justify-right  w-80" >
                                <div class="input-group border" >
                                    <div class="input-group-prepend" >
                                        <div class="input-group-icon py-3 px-2">
                                            <i class="fa fa-search "></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control border-0 pl-0" id="search" placeholder="Type to search..." @keyup="search()" v-model="searchBooks" >
                                </div>
                            </div>
                        </div>
                      <table class="table">
                        <thead>
                          <tr>
                            <th> # </th>
                            <th> Book Name </th>
                            <th> Author </th>
                            <th> Book Cover </th>
                            <th>Action </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(b,x) in books.data">
                            <td>{{ x+1 }}</td>
                            <td>{{ b.book_name }}</td>
                            <td>{{ b.author }}</td>
                            <td>
                              <img :src="`/books/`+b.book_cover"></img>
                            </td>
                            <td>
                              <a  @click="openModel(b.id)" title="View Book"><i class="fa fa-eye icon-sm text-info text-center"  ></i></a>
                              <a @click="onEdit(b.id)" title="Update Book"><i class="fa fa-pencil icon-sm text-info text-center m-2"  ></i></a>
                              <a @click="onDelete(b.id)" title="Delete Book"><i class="fa fa-trash icon-sm text-info text-center"  ></i></a>
                              </td>
                          </tr>
                        </tbody>
                      </table>
                      <div class="d-flex justify-end p-2 border-t">
                        <nav aria-label="Page navigation">
                            <TailwindPagination
                                :data="books"
                                :limit="1"
                                @pagination-change-page="getBooks"
                            />
                        </nav>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
             
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer_view></footer_view>
          
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
  
    <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        > 
        
        <div class="modal pt-4 px-3" :class="{ show:showModal }">
				
				<div class="modal__content w-full">
          <div @click="closeModal">X</div>
					<div class="modal_s_items">
						
                <div class="card">
                  <div class="card-body">
                   
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <h2>Book Details</h2>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Book Name: {{ form.book_name }} </label>
                         
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Author: {{ form.author }} </label>
                         
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Book Cover: <img :src="`/books/`+form.book_cover" class="w-100"></img> </label>
                         
                          </div>
                        </div>
                    </div>
                 </div>
                 
              </div>
            </div>
            </div>
          </div>
		
    </Transition>


</template>