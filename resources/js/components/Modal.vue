<template>
    <div class="modal fade" tabindex="-1" role="dialog"  data-backdrop="static" data-keyboard="false" id="irsModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                        <div class="modal-body">
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                <i class="mdi mdi-flag mdi-6x text-irs"></i>
                                <h4 class="text-black font-weight-medium mb-4">{{ modal_title }}</h4>
                                <p>{{ modal_message }}</p>
                                <a :href="modal_href ? modal_href : ''" class="btn btn-irs btn-sm">Continue</a>
                            </div>
                        </div>
                </div>
            </div>
        </div>    
</template>

<script>
export default {
    props: ['modal_message', 'modal_type', 'modal_title', 'modal_href']
}
</script>

<style>

</style>
