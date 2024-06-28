<script setup>
    import navigation from '../../Layouts/navigation.vue';
    import sidebar from '../../Layouts/sidebar.vue';
    import footer_view from '../../Layouts/footer.vue';
    import {onMounted, ref} from "vue";
    import { useRouter } from "vue-router" 

  const router = useRouter() 
  let drafts = ref([])
  let searchDrafts=ref([]);

  onMounted(async () => {
    getDrafts()
  })

  const getDrafts = async (page = 1) => {
    
        const response = await axios.get(`/api/get_drafts?page=${page}&filter=${searchDrafts.value}`);
        drafts.value = response.data
    }

  const search = async () => {
        let response = await fetch('/api/search_drafts?filter='+searchDrafts.value);
        drafts.value = await response.json();
  }

  const onEdit = (id) =>{
    router.push('/filing_new/'+id)
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
                Drafts
              </h3>
              
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Draft List 
                  </li>
                 
                </ul>
              </nav>
              
            </div>
         
            <div class="row">
                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive">
                       
                        <div class="d-flex justify-between pb-2 mb-2" style=" float:right !important;" >
                            <div class=" justify-right  w-80" >
                                <div class="input-group border" >
                                    <div class="input-group-prepend" >
                                        <div class="input-group-icon py-3 px-2">
                                            <i class="fa fa-search "></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control border-0 pl-0" id="search" placeholder="Type to search..." @keyup="search()" v-model="searchDrafts">
                                </div>
                            </div>
                        </div>
                       
                      <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Document Date</th>
                          <th>Subject</th>
                          <th>Person Name</th>
                          <th>Keywords</th>
                          <th class="text-center">Action</th>
                        </tr>
                      </thead>
                     
                      <tbody>
                        <tr v-for="d in drafts.data">
                          <td>{{ d.document_date }}</td>
                          <td>{{ d.subject }}</td>
                          <td>{{ d.person_name }}</td>
                          <td>{{ d.keywords }}</td>
                          <td class="text-center"><a @click="onEdit(d.id)" title="View Transaction"><i class="fa fa-pencil icon-sm text-info text-center"  ></i></a>
                            
                          </td>
                        </tr>
                      </tbody>
                      
                    </table>
                    <div class="d-flex justify-end p-2 border-t">
                        <nav aria-label="Page navigation">
                            <TailwindPagination
                                :data="drafts"
                                :limit="1"
                                @pagination-change-page="getDrafts"
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