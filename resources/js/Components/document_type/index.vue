<script setup>
    import navigation from '../../Layouts/navigation.vue';
    import sidebar from '../../Layouts/sidebar.vue';
    import footer_view from '../../Layouts/footer.vue';
    import {onMounted, ref} from "vue";
    import { useRouter } from "vue-router" 

  const router = useRouter() 
  let documenttype = ref([])
  let searchDocumentType=ref([]);

  onMounted(async () => {
    getDocumentType()
  })

  const getDocumentType = async (page = 1) => {
    
        const response = await axios.get(`/api/get_all_documenttypes?page=${page}&filter=${searchDocumentType.value}`);
        documenttype.value = response.data
    }

  const search = async () => {
        let response = await fetch('/api/search_documenttype?filter='+searchDocumentType.value);
        documenttype.value = await response.json();
  }

  const onEdit = (id) =>{
    router.push('/documenttype_edit/'+id)
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
                Document Types
              </h3>
              
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Document Type List 
                  </li>
                 
                </ul>
              </nav>
              
            </div>
         
            <div class="row">
                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive">
                        <div >
                            <a href="/documenttype_new" class="btn btn-gradient-primary btn-fw">Add New Document Type</a>
                            </div>
                        <div class="d-flex justify-between pb-2 mb-2" style=" float:right !important;" >
                            <div class=" justify-right  w-80" >
                                <div class="input-group border" >
                                    <div class="input-group-prepend" >
                                        <div class="input-group-icon py-3 px-2">
                                            <i class="fa fa-search "></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control border-0 pl-0" id="search" placeholder="Type to search..." @keyup="search()" v-model="searchDocumentType">
                                </div>
                            </div>
                        </div>
                       
                        <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Document Type</th>
                          <th class="text-center">Action</th>
                        </tr>
                      </thead>
                     
                      <tbody>
                        <tr v-for="d in documenttype.data">
                          <td>{{ d.type_name }}</td>
                          <td class="text-center"><a @click="onEdit(d.id)" title="Update Document Type"><i class="fa fa-pencil icon-sm text-info text-center"  ></i></a>
                            
                          </td>
                        </tr>
                      </tbody>
                      
                    </table>
                    <div class="d-flex justify-end p-2 border-t">
                        <nav aria-label="Page navigation">
                            <TailwindPagination
                                :data="documenttype"
                                :limit="1"
                                @pagination-change-page="getDocumentType"
                            />
                        </nav>
                    </div>
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