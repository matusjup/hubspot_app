<template>
    <div class="col-4">
        <div class="form-group">
            <label for="name">Name product *</label>
            <input type="email" class="form-control" id="name" placeholder="Name product" v-model="product.properties.name">
        </div>
        <div class="form-group pt-2">
            <label for="price">Price product</label>
            <input type="number" class="form-control" id="price" placeholder="Price" v-model="product.properties.price">
        </div>
        <div class="form-group pt-3">
            <button v-if="!progress_info" type="button" class="btn btn-primary btn-sm" @click="doAction( create ? 'create' : 'update')">Save product</button>
            <div v-if="progress_info" class="progress col-2">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: 'CreateOrEditProduct',

        props: {
            items: {
                type: Object
            },
            progress_info: {
                type: Boolean
            }
        },
        data() {
            return {
                create: this.items.create,
                product: {
                    properties: {
                        id: this.items.create ? '' : this.items.product.id,
                        name: this.items.create ? '' : this.items.product.properties.name,
                        price: this.items.create ? '' : this.items.product.properties.price
                    }
                }
            }
        },
        methods: {
            doAction( action ){
                this.$emit('actionButton', { action: action, data: this.product.properties })
            }
        }
    }
</script>
