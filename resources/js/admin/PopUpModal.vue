<template>
    <div class="modal fade" id="popUpModal" tabindex="-1" aria-labelledby="popUpModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="popUpModalLabel">{{ title }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span v-if="!success_message">Confirm deletion of product "{{ product.properties.name }}"?</span>
                <div v-if="success_message" class="alert alert-success col-md-4 py-2" role="alert">
                    {{ success_message }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button v-if="!progress_info" type="button" class="btn btn-primary" @click="doAction('delete')">Confirm</button>
                <div v-if="progress_info" class="progress col-2">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                </div>
            </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: 'PopUpModal',

        props: {
            data: {
                type: Object
            },
            progress_info: {
                type: Boolean
            },
            success_message: {
                type: String
            }
        },
        data() {
            return {
                product: {
                    properties: {
                        id: '' ,
                        name: '',
                    }
                },
                title: ''
            }
        },
        methods: {
            doAction( action ){
                this.$emit('actionButton', { action: action, data: this.product.properties.id })
            }
        },
        watch: {
            data: {
                handler( newData ) {
                    this.$nextTick(() => {
                        this.product.properties.id = newData && newData.product.id ? newData.product.id : ''
                        this.product.properties.name = newData && newData.product.properties.name ? newData.product.properties.name : ''
                        this.title = newData && newData.title ? newData.title : ''
                    })
                },
                deep: true,
            },
        },
    }
</script>

