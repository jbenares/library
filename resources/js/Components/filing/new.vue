<script setup>
  import navigation from '../../Layouts/navigation.vue';
  import sidebar from '../../Layouts/sidebar.vue';
  import footer_view from '../../Layouts/footer.vue';
  import {onMounted, ref} from "vue";
  import { useRouter } from "vue-router"
  const router = useRouter()
	let form=ref([])
	let error = ref('')
	let success = ref('')
  let rows = ref([])
  let imageFile1=ref([]);
  let error_image=ref([])
  let business_units=ref([]);
  let departments=ref([]);
  let document_types=ref([]);
  let locations=ref([]);
  let rooms=ref([]);
  let cabinets=ref([]);
  let racks=ref([]);
  let boxes=ref([]);
  let folders=ref([]);
  let attachment=ref([]);

  const props = defineProps({
        id:{
            type:String,
            default:''
        }
    })

    onMounted(async () => {
      documentForm(props.id)
      getAttachments(props.id)
      getDropdown()
      getDatalist()
    })

  const documentForm = async (id) => {
  
		let response = await axios.get(`/api/create_document_form/${id}`);
		form.value = response.data.formData
  
    //attachment.value = response.data.attach
    
	}
  const getAttachments = async (id) => {
   
		let response = await axios.get(`/api/get_attachments/${id}`);
		attachment.value = response.data;

	}
   
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

  const addRow= () =>{
       
       rows.value.push(
           {
              id:'',
              attached_file:'',
              remarks:''
           }
       );
   }
   
   const removeRow= (row, id) =>{
   
		if(confirm("Do you really want to delete this row?")){
			rows.value.splice(row,1)
		}
      
	}

  const removeAttach= (id, filename) =>{
   
    if(confirm("Do you really want to delete this row?")){
      axios.get(`/api/delete_attachment/${id}/${filename}`);
      getAttachments()
    }
      
  }

  const cancelFiling= () =>{
   
   if(confirm("Do you really want to cancel this transaction?")){
     axios.get(`/api/cancel_transaction/${props.id}`);
     error.value='';
     success.value='Transaction succesfully cancelled.'
     router.push('/filing_new/new')
               // create_files()
      form.value=[]
      rows.value=[]
      attachment.value=[]
   }
     
 }

    
  const upload_image = (event) => {
        let file = event.target.files[0];
        if(event.target.files.length===0){
            rows.value.attached_file='';
            imageFile1.value='';
            return;
        }else if(file['size'] < 1000000){
          imageFile1.value.push(event.target.files[0]);
           // imageFile1.value = event.target.files[0];
       
           // error_image.value=''
           error_image.value.push('')
        }else{
            //error_image.value='File size can not be bigger than 1 MB'
            error_image.value.push('File size can not be bigger than 1 MB')
        }
    }

  const onSave = () => {
   
		const formData= new FormData()
    let userid = localStorage.getItem('id')
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
    formData.append('user_id', userid)
    formData.append('remarks', JSON.stringify(rows.value))

   
    for (var i = 0; i < imageFile1.value.length; i++ ){
            let file = imageFile1.value[i];
            let rem = rows.value[i];
            formData.append('attachment[' + i + ']', file);
           
        }
       
        axios.post(`/api/save_filing/${props.id}`,formData,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(function (response) {
                error.value='';
                success.value='Files successfully uploaded!'
               // create_files()
               form.value=[]
                rows.value=[]
            }, function (err) {
                error.value = err.response.data.message;
                //error.value='Something went wrong. Please try again.';
                success.value=''
        });

	}

  const saveDraft = () => {
   
   const formData= new FormData()
   let userid = localStorage.getItem('id')
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
   formData.append('user_id', userid)
   formData.append('remarks', JSON.stringify(rows.value))

  
   for (var i = 0; i < imageFile1.value.length; i++ ){
           let file = imageFile1.value[i];
           let rem = rows.value[i];
           formData.append('attachment[' + i + ']', file);
          
       }
      
       axios.post(`/api/save_draft/${props.id}`,formData,{
               headers: {
                   'Content-Type': 'multipart/form-data'
               }
           }).then(function (response) {
               error.value='';
               success.value='Saved as draft'
               router.push('/filing_new/'+response.data)
               rows.value=[]
               documentForm(response.data)
               getAttachments(response.data)
           }, function (err) {
               error.value = err.response.data.message;
               //error.value='Something went wrong. Please try again.';
               success.value=''
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
                Add New Filing
              </h3>
              
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                       Add new Filing
                  </li>
                 
                </ul>
              </nav>
              
            </div>
         
            <div class="row">
                <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                  
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
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Remarks</label>
                            <textarea  class="form-control" row="5" v-model="form.remarks"></textarea>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-1">
                      </div>
                      <div class="col-md-10">
                          <table class="table" >
                            <thead>
                              <tr>
                                <th>File Upload</th>
                                <th>Remarks</th>
                                <td><button @click="addRow()"  type="button" class="btn btn-gradient-success btn-rounded btn-icon btn-sm">
                                  <i class="fa fa-plus-square icon-sm "></i>
                                  </button></td>
                              </tr>
                              </thead>
                              <tbody>
                                
                                <tr v-for="att in attachment">
                                  <td>
                                   
                                    <a target="_blank" :href="'/files/'+att.attached_file">{{ att.attached_file }}</a></td> 
                                  <!-- <td><a target="_blank" v-bind:href="'/files/'+ att.attached_file">{{ att.attached_file }}</a></td> -->
                                  <td>{{ att.remarks }}</td>
                                  <td>
                                    <button @click="removeAttach(att.id, att.attached_file)"  type="button" class="btn btn-gradient-danger btn-rounded btn-icon">
                                      <i class="fa fa-trash-o icon-sm  text-center"  ></i>
                                  </button></td>
                                </tr>
                                <tr v-for="(row, i) in rows">
                                  <td><input type="file" class="form-control" accept="image/*" id="image1" @change="upload_image($event, i)"/>
                                    <p class="text-danger" v-if='error_image[i]'>{{ error_image[i] }}</p></td>
                                  <td> <input type="text" class="form-control" v-model="row.remarks"/></td>
                                  <td>
                                    <button @click="removeRow(i, row.id)"  type="button" class="btn btn-gradient-danger btn-rounded btn-icon">
                                      <i class="fa fa-trash-o icon-sm  text-center"  ></i>
                                  </button></td>
                                </tr>
                              </tbody>
                          </table>
                      </div>
                      <div class="col-md-1">
                      </div>
                      </div>
                      
                  </div>
                  <div class="row">
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-6">
                          <div class="form-group template-demo">
                            
                            <button @click=cancelFiling() class="btn btn-danger btn-fw">Cancel</button>
                            <button @click=saveDraft() class="btn btn-warning btn-fw">Save as Draft</button>
                            <button @click=onSave() class="btn btn-success btn-fw">Save and Close</button>
                          </div>
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