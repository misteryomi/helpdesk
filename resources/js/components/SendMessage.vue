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
            <button type="submit" class="btn btn-sm btn-primary" :disabled="processing"><i class="fa fa-spin spin"></i> Send Message</button>
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
        props: ['submit_api_route', 'type', 'ticket_id'],
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
            }
        },
        methods: {
            async onSubmitTicket(e) {
                e.preventDefault();
                
                this.processing = true;

                let data = {
                    message: this.message,
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

        }
    }
</script>
