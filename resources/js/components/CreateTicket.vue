<template>
    <div class="grid">
        <div class="grid-body">
        <div class="item-wrapper">
            <p v-if="errors.length">
                <b>Oops! There are some errors found with your form inputs</b>
            </p>
            <form v-on:submit.prevent="onSubmitTicket" method="POST">
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="department">Department</label>
                    <select class="form-control" :disabled="departments.length == 0" name="department" v-model="selectedDepartment">
                        <option value="">Select a Department</option>
                        <option v-for="(department, index) in departments" :key="index" :value="department.id">{{ department.name }}</option>
                    </select>       
                    <p class="invalid-feedback" v-show="errors.department_id">{{errors.department_id && errors.department_id[0]}}</p>
                </div>
                <div class="col-md-4">
                    <label for="unit">Unit</label>
                    <select class="form-control" :disabled="units.length == 0" name="unit" v-model="selectedUnit">
                        <option value="">Select a Unit</option>
                        <option v-for="(unit, index) in units" :key="index" :value="unit.id">{{ unit.name }}</option>
                    </select>       
                    <p class="invalid-feedback" v-show="errors.unit_id">{{errors.unit_id && errors.unit_id[0]}}</p>
                </div>
                <div class="col-md-4">
                    <label for="priority">Priority</label>
                    <select class="form-control" name="priority" v-model="selectedPriority">
                        <option selected>Low</option>
                        <option>Medium</option>
                        <option>High</option>
                    </select>       
                    <p class="invalid-feedback" v-show="errors.priority">{{errors.priority && errors.priority[0]}}</p>
                </div>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                    <select class="form-control" :disabled="categories.length == 0" name="category" v-model="selectedCategory">
                        <option value="">Select a Category</option>
                        <option v-for="(category, index) in categories" :key="index" :value="category.id">{{ category.name }}</option>
                    </select>       
                    <p class="invalid-feedback" v-show="errors.category_id">{{errors.category_id && errors.category_id[0]}}</p>
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" placeholder="Ticket title" v-model="title">
                <p class="invalid-feedback" v-show="errors.title">{{errors.title && errors.title[0]}}</p>
            </div>                        
            <div class="form-group">
                <label for="inputPassword1">Message</label>
                <textarea rows="10" placeholder="Enter your message" name="message" class="form-control" v-model="message"></textarea>
                <p class="invalid-feedback" v-show="errors.message">{{errors.message && errors.message[0]}}</p>
            </div>

            <div class="form-group">
                <label for="inputPassword1">Are you creating this ticket on behalf of someone else?</label><br/>
                <input type="radio" value="false" v-model="isOnBehalf" />No
                <input type="radio" value="true" v-model="isOnBehalf" />Yes
            </div>

            <div class="form-group" v-show="isOnBehalf">
                <label for="category">Select User</label>
                    <select class="form-control" name="user" v-model="selectedUser">
                        <option value="">Select User</option>
                        <option v-for="(user, index) in users" :key="index" :value="user.id">{{ user.name }}</option>
                    </select>       
                    <p class="invalid-feedback">Please note: The selected user would have to approve the ticket before it can be active.</p>
            </div>
            <button type="submit" class="btn btn-sm btn-primary" :disabled="processing">
                <div class="spinner-grow spinner-grow-md mr-1 animate-this" v-show="processing" role="status"><span class="sr-only">Loading...</span></div> 
                    Create Ticket</button>
          </form>

          <modal 
                :modal_title="modalTitle"
                :modal_message="modalMessage"
                :modal_type="modalType"     
                :modal_href="modalHref"           
                />
        </div>    
        </div>        
    </div>
</template>

<script>
    export default {
        props: ['dept_api_route', 'submit_api_route', 'users_api_route'],
        data() {
            return {
                departments: [],
                categories: [],
                units: [],
                errors: [],
                users: [],
                selectedDepartment: '',
                selectedUnit: '',
                selectedCategory: '',
                selectedPriority: 'Low',
                selectedUser: '',
                title: '',
                message: '',
                displayModal: true,
                modalMessage: '',
                modalType: '',
                modalTitle: '',
                modalHref: '',
                processing: false,
                isOnBehalf: false,
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
            }
        },
        methods: {
             async fetchDepartments() {
                try {
                    let response = await axios.get(this.dept_api_route);
                    let data = response.data.data;
                    this.departments = data;
                } catch(e) {
                    console.log('error', e);
                }
            },
            async fetchUsers() {
                try {
                    let response = await axios.get(this.users_api_route);
                    let data = response.data.data;
                    this.users = data;
                } catch(e) {
                    console.log('error', e);
                }
            },
            async onSubmitTicket(e) {
                e.preventDefault();
                
                this.processing = true;

                let data = {
                    title: this.title,
                    department_id: this.selectedDepartment,
                    unit_id: this.selectedUnit,
                    category_id: this.selectedCategory,
                    priority: this.selectedPriority,
                    message: this.message,
                }

                if(this.selectedUser != '' && this.isOnBehalf) {
                    data.is_on_behalf = true;
                    data.selected_user = this.selectedUser;
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
            this.fetchUsers();
        }
    }
</script>
