<template>
    <div class="grid">
        <div class="grid-body">
        <div class="item-wrapper">
            <p v-if="errors.length">
                <b>Oops! There are some errors found with your form inputs</b>
            </p>
            <form v-on:submit.prevent="onSubmitTicket" method="POST">                   
            <div class="form-group">
                <label for="inputPassword1">Message</label>
                <textarea rows="10" placeholder="Enter your message" name="message" class="form-control" v-model="message"></textarea>
                <p class="invalid-feedback" v-show="errors.message">{{errors.message && errors.message[0]}}</p>
            </div>
            <!-- <div class="form-group row" v-if="type == 'staff'" >
                <div class="col-md-4">
                    <label for="department">Ticket Status:</label>
                    <select class="form-control" name="status" v-model="selectedStatus">
                        <option v-for="(status, index) in JSON.parse(statuses)" :key="index" :value="status.id">{{ status.name }}</option>
                    </select>       
                    <p class="invalid-feedback" v-show="errors.status_id">{{errors.status && errors.status[0]}}</p>
                </div>
            </div> -->
            <button type="submit" class="btn btn-sm btn-primary" :disabled="processing">
                <div class="spinner-grow spinner-grow-md mr-1 animate-this" v-show="processing" role="status"><span class="sr-only">Loading...</span></div> 
                Reply Ticket
            </button>
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
        props: ['submit_api_route', 'type', 'ticket_id', 'statuses'],
        data() {
            return {
                message: '',
                displayModal: true,
                modalMessage: '',
                modalType: '',
                modalTitle: '',
                modalHref: '',
                processing: false,
                errors: [],
                selectedStatus: '',
            }
        },
        methods: {
            async onSubmitTicket(e) {
                e.preventDefault();
                
                this.processing = true;

                let data = {
                    message: this.message,
                }

                // if(this.type == 'staff') {
                //     data.status_id = this.selectedStatus;
                // }

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
                    //    console.log(e.response.data.errors);    
                    }
                    this.processing = false;
                }
            },

        },
        mounted() {
            this.selectedStatus = JSON.parse(this.statuses)[0].id; //default first element as selected, since :selected refused to work.
        }
    }
</script>
