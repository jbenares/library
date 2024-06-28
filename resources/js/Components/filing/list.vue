<script setup>
    import navigation from '../../Layouts/navigation.vue';
    import sidebar from '../../Layouts/sidebar.vue';
    import footer_view from '../../Layouts/footer.vue';
    import {onMounted, ref} from "vue";
    import { useRouter } from "vue-router" 

  const router = useRouter() 
  let records = ref([])
  let form=ref({
    type_id:'',
    unit_id:'',
    department_id:'',
    subject:'',
    document_date:'',
    person_name:'',
    keywords:'',
    location:'',
    room:'',
    cabinet:'',
    rack:'',
    box:'',
    folder:'',
  })
  let error=ref([])
  let success=ref([])
  let business_units=ref([]);
  let departments=ref([]);
  let document_types=ref([]);
  let locations=ref([]);
  let rooms=ref([]);
  let cabinets=ref([]);
  let racks=ref([]);
  let boxes=ref([]);
  let folders=ref([]);

  onMounted(async () => {
    getRecords()
    getDropdown()
    getDatalist()
  })

  const getDropdown = async () => {
    let response = await axios.get(`/api/dropdown_data`);
		business_units.value = response.data.businessunits;
    departments.value = response.data.departments;
    document_types.value = response.data.documenttypes;
  }

  const getDatalist = async () => {
    let response = await axios.get(`/api/get_datalist`);
		locations.value = response.data.location;
    rooms.value = response.data.room;
    cabinets.value = response.data.cabinet;
    racks.value = response.data.rack;
    boxes.value = response.data.box;
    folders.value = response.data.folder;
  }


  const getRecords = async () => {
    
        const response = await axios.get(`/api/get_records`);
        records.value = response.data
    }

 

  const filter = ()=>{
    const formData= new FormData()
    formData.append('unit_id', form.value.unit_id)
    formData.append('type_id', form.value.type_id)
    formData.append('department_id', form.value.department_id)
    formData.append('document_date', form.value.document_date)
    formData.append('person_name', form.value.person_name)
    formData.append('subject', form.value.subject)
    formData.append('keywords', form.value.keywords)
    formData.append('location', form.value.location)
    formData.append('room', form.value.room)
    formData.append('cabinet', form.value.cabinet)
    formData.append('rack', form.value.rack)
    formData.append('box', form.value.box)
    formData.append('folder', form.value.folder)

    
    axios.post(`/api/filter_record`,formData).then(function (response) {
            records.value = response.data
            closeModal()
               //router.push('/filing_new/'+response.data)
              //  rows.value=[]
              //  documentForm(response.data)
              //  getAttachments(response.data)
           }, function (err) {
               error.value = err.response.data.message;
               //error.value='Something went wrong. Please try again.';
               success.value=''
       });

  }

  const onView = (id) =>{
    router.push('/filing_view/'+id)
  }

  const reset = () =>{
    form.value=''
  }
    const showModal = ref(false)
    const hideModal = ref(true)
    const openModel = () => {
    
      showModal.value = !showModal.value
     
   
    }
    const closeModal = () => {
      showModal.value = !hideModal.value
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
                Filing Records
              </h3>
              
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Filing Records 
                  </li>
                 
                </ul>
              </nav>
              
            </div>
         
            <div class="row">
                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive">
                      <div class="d-flex justify-between pb-2 mb-2" style=" float:right !important;" >
                            <div class=" justify-right  w-100" >
                                <div class="input-group border" >

                                    <button  @click="openModel()" class="btn btn-sm py-1.5 btn-success w-32">Filter Record</button>
                                </div>
                            </div>
                        </div>

                        <div >
                          
                            </div>
                       
                       
                        <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Document Date</th>
                          <th>Subject</th>
                          <th>Business Unit</th>
                          <th>Department</th>
                          <th>Document Type</th>
                          <th>Person Name</th>
                          <th>Keywords</th>
                          <th class="text-center">Action</th>
                        </tr>
                      </thead>
               
                      <tbody v-if="records.length > 0">
                        <tr v-for="d in records">
                          <td>{{ d.document_date }}</td>
                          <td>{{ d.subject }}</td>
                          <td>{{ d.business_unit.unit_name }}</td>
                          <td>{{ d.department.department_name }}</td>
                          <td>{{ d.document_type.type_name }}</td>
                          <td>{{ d.person_name }}</td>
                          <td>{{ d.keywords }}</td>
                          <td class="text-center">
                            <!-- <a @click="onEdit(d.id)" title="Update Record"><i class="fa fa-pencil icon-sm px-2 text-info text-center"  ></i></a> -->
                            <a @click="onView(d.id)" title="View Record"><i class="fa fa-eye icon-sm text-info text-center"  ></i></a>
                            
                          </td>
                        </tr>
                      </tbody>
                      <tbody v-else>
                        <tr >
                          <td colspan="9" class="text-center">No available data.</td>
                          
                        </tr>
                      </tbody>
                      
                    </table>
                    
                  </div>
                </div>
            </div>
            
                    

            </div>
          </div>

          <footer_view></footer_view>
        </div>
      </div>
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
                            <strong>Filter Record</strong>
                            </div>
                          </div>
                          
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Business Unit</label>
                                <select class="form-select" v-model="form.unit_id">
                                <option v-for="bu in business_units" :value="bu.id">{{ bu.unit_name }}</option>
                              </select>
                           
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Department</label>
                                <select class="form-select" v-model="form.department_id">
                                <option v-for="dept in departments" :value="dept.id">{{ dept.department_name }}</option>
                              </select>
                           
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Document Type</label>
                                <select class="form-select" v-model="form.type_id">
                                <<option v-for="doc in document_types" :value="doc.id">{{ doc.type_name }}</option>
                              </select>
                           
                          </div>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Subject</label>
                            <input type="text" class="form-control" v-model="form.subject"/>
                            
                           
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Document Date</label>
                            <input type="date" class="form-control" v-model="form.document_date"/>
                           
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Person Name</label>
                            <input type="text" class="form-control" v-model="form.person_name"/>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Keywords</label>
                            <input type="text" class="form-control" v-model="form.keywords"/>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Location</label>
                            <input type="datalist"  class="form-control" id='location' list="locationlist" v-model="form.location"> 	
														<datalist id="locationlist">
															<option :value="loc.location"  v-for="loc in locations"></option>
														</datalist>
                           
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Room</label>
                            <input type="datalist"  class="form-control" id='room' list="roomlist" v-model="form.room"> 	
														<datalist id="roomlist">
															<option :value="r.room"  v-for="r in rooms"></option>
														</datalist>
                           
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Cabinet</label>
                            <input type="datalist"  class="form-control" id='cabinet' list="cabinetlist" v-model="form.cabinet"> 	
														<datalist id="cabinetlist">
															<option :value="cab.cabinet"  v-for="cab in cabinets"></option>
														</datalist>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Rack</label>
                            <input type="datalist"  class="form-control" id='rack' list="racklist" v-model="form.rack"> 	
														<datalist id="racklist">
															<option :value="rc.rack"  v-for="rc in racks"></option>
														</datalist>
                            
                           
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Box Label</label>
                            <input type="datalist"  class="form-control" id='box' list="boxlist" v-model="form.box"> 	
														<datalist id="boxlist">
															<option :value="bx.box"  v-for="bx in boxes"></option>
														</datalist>
                           
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Folder Label</label>
                            <input type="datalist"  class="form-control" id='folder' list="folderlist" v-model="form.folder"> 	
														<datalist id="folderlist">
															<option :value="fld.folder"  v-for="fld in folders"></option>
														</datalist>
                          </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <button @click=reset() class="btn btn-warning btn-fw mx-1" >Reset</button>
                            <button @click=filter() class="btn btn-success btn-fw" >Filter Record</button>
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
