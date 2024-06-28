
<script setup>
	import navigation from '../Layouts/navigation.vue';
  import sidebar from '../Layouts/sidebar.vue';
  import footer_view from '../Layouts/footer.vue';
	//import footerPage from '@/Components/footer.vue';
   	import {  EyeIcon} from '@heroicons/vue/24/solid';
     import DataTable from 'datatables.net-vue3';
    import DataTablesCore from 'datatables.net';
    DataTable.use(DataTablesCore);
	import {onMounted, ref} from "vue";
  import { useRouter } from "vue-router" 
   
  const router = useRouter() 
    let books = ref([])
    let searchBooks=ref([]);
    let form = ref('')
    let currentSort = 'book_name'
    let currentSortDir = 'asc'
    

    onMounted(async () => {
      getBooks()
    })

    const options = {
		 dom: 'Bftip',
		dom: "<'row'<'col-sm-8 col-lg-8 mb-2 pr-0 flex justify-end'B ><'col-sm-4 col-lg-4 mb-2 pl-1'f>>"+"<'row'<'col-sm-12 mb-2'tr>>"+"<'row'<'col-sm-6 mb-2'i><'col-sm-6 mb-2'p>>",
		select: true,	
		lengthMenu: [
			[10, 25, 50, -1],
			['10 rows', '25 rows', '50 rows', 'Show all']
		],
		buttons: [
			{
				title:'Items',
				extend: 'copy',
				exportOptions: {
					columns: [ 0, 1, 2, 3],
					orthogonal: null
				}
			},
			{
				title:'Items',
				extend: 'excel',
				exportOptions: {
					columns: [ 0, 1, 2, 3], 
					orthogonal: null
				},
				createEmptyCells: true,
                customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    var clRow = $('row', sheet);
                    clRow[0].children[0].remove(); // clear header cell
                    $( 'row c', sheet ).attr( 's', '25' );
                }
			},
			{
				title:'Items',
				extend: 'print',
				exportOptions: {
					columns: [ 0, 1, 2, 3],
					orthogonal: null
				}
			},
			{
				extend: 'pageLength'
			}
		]
		//buttons: ['copy','excel','csv','pageLength']
	};
   
    const getBooks = async (page = 1) => {

        const response = await axios.get(`/api/get_all_books?page=${page}&filter=${searchBooks.value}`);
        books.value = response.data
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
                      
                        <!-- <div class="col-lg-12 px-1">
                              <div class="flex justify-end mb-3">
                                  <a :href="'/export_books'" class="btn btn-sm btn-success">
                                      <div class="flex justify-between space-x-2" >
                                          <span>Export to Excel</span>
                                      </div>
                                  </a>
                              </div>
                          </div> -->
                        <DataTable :data="books" :options="options" class="display" width="100%">  
                      <thead>
                        <tr>
                            <th>Book Name </th>
                            <th> Author </th>
                        </tr>
                      </thead>
                   
                      <template #column-2="props">
                        <a  @click="openModel(props.rowData.id)" title="View Book"><i class="fa fa-eye icon-sm text-info text-center"  ></i></a>
                    
                      </template>
                      <template #column-3="props">
                        <a @click="onEdit(props.rowData.id)" title="Update Book"><i class="fa fa-pencil icon-sm text-info text-center m-2"  ></i></a>
                      </template>
                      <template #column-4="props">
                        <a @click="onDelete(props.rowData.id)" title="Delete Book"><i class="fa fa-trash icon-sm text-info text-center"  ></i></a>
                      </template>
                    </DataTable>
                      
                     
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