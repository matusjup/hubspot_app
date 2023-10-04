<template>
    <div>
        <div v-if="error.message && !success.message" class="alert alert-danger col-md-4 py-2" role="alert">
            {{ error.message }}
        </div>
        <div v-if="success.message && !error.message" class="alert alert-success col-md-4 py-2" role="alert">
            {{ success.message }}
        </div>
        <div class="col-auto d-flex justify-content-between">
            <div class="col-md-4 pb-3">
                <span class="btn btn-primary btn-sm" v-if="activeTab === 0" @click="activeTab = 1">Add new product</span>
                <span class="btn btn-secondary btn-sm" v-if="activeTab !== 0" @click="activeTab = 0, error.message = ''">Back to list</span>
            </div>
        </div>

        <component
            :is="tabs[ activeTab ].component"
            :items="tabs[ activeTab ].data"
            :search_products="searchedProducts"
            :progress_info="progressInfo" @actionButton="actionButton($event)"
        />

        <PopUpModal
            :data="modalData"
            :progress_info="progressInfo"
            :success_message="success.message"
            @actionButton="actionButton($event)"
        />
    </div>
</template>

<script>
    import AllProducts from './AllProducts.vue'
    import CreateOrEditProduct from './CreateOrEditProduct.vue'
    import PopUpModal from './PopUpModal.vue'

    export default {
        name: 'HomePage',
        components: {
            AllProducts,
            CreateOrEditProduct,
            PopUpModal,
        },
        props: {
            api: {
                type: String
            },
            products: {
                type: Object
            }
        },
        data() {
            return {
                searchedProducts: [],
                modalData: [],
                error: {
                    message: '',
                },
                success: {
                    message: '',
                },
                validateMsg: {
                    name: 'Name product is required!'
                },
                progressInfo: false,
                activeTab: 0,
                tabs: [
                    {
                        id: 1,
                        name: 'All products',
                        component: 'AllProducts',
                        data: {
                            products: this.products.results,
                            api: `${this.api}`,
                        }
                    },
                    {
                        id: 2,
                        name: 'Add new product',
                        component: 'CreateOrEditProduct',
                        data: {
                            create: true,
                            api: `${this.api}/store`
                        }
                    },
                    {
                        id: 3,
                        name: 'Edit product',
                        component: 'CreateOrEditProduct',
                        data: {
                            create: false,
                            api: `${this.api}/show`,
                            product: []
                        }
                    }
                ],
            }
        },
        methods: {
            actionButton( items ){

                let action = items.action
                let data = items.data ? items.data : data

                switch (action) {
                    case 'create':
                        this.progressInfo = true
                        this.createProduct( data )
                        break;
                    case 'update':
                        this.progressInfo = true
                        this.updateProduct( data )
                        break;
                    case 'edit_btn':
                        this.activeTab = 2
                        this.tabs[ this.activeTab ].data.product = data
                        break;
                    case 'delete':
                        this.progressInfo = true
                        this.deleteProduct( data )
                        break;
                    case 'delete_btn':
                        this.showModal( 'Delete product', data )
                        break;
                    case 'filter':
                        setTimeout(() => {
                            this.searchProducts( data )
                        }, 400);
                        break;
                    default:
                        break;
                }

            },
            searchProducts( data ) {

                axios.post(this.api, { filter: data })
                .then( response => {
                    this.searchedProducts = response.data.products.results
                }).catch( e => {
                    this.failedAction( e.message )
                })

            },
            createProduct( data ) {

                if ( !data.name || data.name == '') {
                    this.failedAction( this.validateField( data.name, this.validateMsg.name ) )
                    return
                }

                axios.post(`${this.api}/store`, data)
                .then( response => {
                    this.successAction( 'Product created!' )
                }).catch( e => {
                    this.failedAction( e.message )
                })

            },
            updateProduct( data ) {

                if ( !data.name || data.name == '') {
                    this.failedAction( this.validateField( data.name, this.validateMsg.name ) )
                    return
                }

                axios.post(`${this.api}/update/${data.id}`, data)
                .then( response => {
                    this.successAction( 'Product updated!' )
                }).catch( e => {
                    this.failedAction( e.message )
                })

            },
            deleteProduct( id ) {

                axios.get(`${this.api}/destroy/${id}`)
                .then( response => {
                    this.successAction( 'Product deleted!' )
                }).catch( e => {
                    this.failedAction( e.message )
                })

            },
            showModal( title, data ){

                this.modalData = {
                    show: true,
                    title: title,
                    product: data,
                }

            },
            successAction( message ){

                this.success.message = message

                setTimeout(() => {
                    this.progressInfo = false
                    location.reload()
                }, 1000);

            },
            failedAction( message ){

                this.error.message = message
                this.progressInfo = false
                
            }
        }
    }
</script>
