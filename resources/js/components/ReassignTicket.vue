<template>
        <div class="item-wrapper">
            <p v-if="errors.length">
                <b>Oops! There are some errors found with your form inputs</b>
            </p>
            <form v-on:submit.prevent="onSubmitTicket" method="POST">
            <div class="form-group">
                    <label for="department">Department</label>
                    <select class="form-control" :disabled="departments.length == 0" name="department" v-model="selectedDepartment">
                        <option value="">Select a Department</option>
                        <option v-for="(department, index) in departments" :key="index" :value="department.id">{{ department.name }}</option>
                    </select>       
                    <p class="invalid-feedback" v-show="errors.department_id">{{errors.department_id && errors.department_id[0]}}</p>
            </div>
            <div class="form-group">
                    <label for="unit">Unit</label>
                    <select class="form-control" :disabled="units.length == 0" name="unit" v-model="selectedUnit">
                        <option value="">Select a Unit</option>
                        <option v-for="(unit, index) in units" :key="index" :value="unit.id">{{ unit.name }}</option>
                    </select>       
                    <p class="invalid-feedback" v-show="errors.unit_id">{{errors.unit_id && errors.unit_id[0]}}</p>
            </div>
            <div class="form-group">
                    <label for="category">Staff</label>
                        <select class="form-control" :disabled="units.length == 0" name="category" v-model="selectedStaff">
                            <option value="">Select a staff</option>
                            <option v-for="(staff, index) in staffs" :key="index" :value="staff.id">{{ staff.name }}</option>
                        </select>       
                        <p class="invalid-feedback" v-show="errors.user_id">{{errors.user_id && errors.user_id[0]}}</p>
            </div>
            <button type="submit" class="btn btn-sm btn-primary" :disabled="processing">
                <div class="spinner-grow spinner-grow-md mr-1 animate-this" v-show="processing" role="status"><span class="sr-only">Loading...</span></div> 
                    Reassign Ticket</button>
          </form>

          <modal 
                :modal_title="modalTitle"
                :modal_message="modalMessage"
                :modal_type="modalType"     
                :modal_href="modalHref"           
                />
        </div>    
</template>

<script>
    export default {
        props: ['dept_api_route', 'submit_api_route'],
        data() {
            return {
                departments: [],
                staffs: [],
                units: [],
                errors: [],
                selectedDepartment: '',
                selectedUnit: '',
                selectedStaff: '',
                title: '',
                message: '',
                displayModal: true,
                modalMessage: '',
                modalType: '',
                modalTitle: '',
                modalHref: '',
                processing: false,
            }
        },
        watch: {
            //Update list of units onchange of department value
            selectedDepartment(value) {
                this.units = this.departments.filter(item => item.id == value)[0].units;
            },
            //Update list of categories onchange of unit value
            selectedUnit(value) {
               this.categories = this.units.filter(item => item.id == value)[0].categories;
               this.staffs = this.units.filter(item => item.id == value)[0].staff;
            },
        },
        methods: {
             async fetchDepartments() {
                try {
                    let response = await axios.get(this.dept_api_route);
                    let data = response.data.data;
                    this.departments = data;
                } catch(e) {
                    console.log('error',e);
                }
            },
            async onSubmitTicket(e) {
                e.preventDefault();
                
                this.processing = true;

                let data = {
                    staff_id: this.selectedStaff,
                }

                try {
                    let response = await axios.post(this.submit_api_route, data);
                    response = response.data;

                    $('#irsModal').modal('show');
                    this.modalType = 'success',
                    this.modalMessage = response.message;
                    this.modalTitle = 'Successful!';
                    this.modalHref = response.redirectsTo; 
                    this.processing = false;
                    
                } catch(e) {
                    if(e.response.status == 422) {
                        this.errors = e.response.data.errors
                        this.processing = false;
     //                   console.log(e.response.data.errors);    
                    }
                }
            },

        },
        mounted() {
            this.fetchDepartments();
        }
    }
</script>
