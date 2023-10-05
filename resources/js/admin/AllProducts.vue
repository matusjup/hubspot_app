<template>
    <div>
        <div class="col-auto mt-3">
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th scope="col-1">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th style="width:15%">
                            <v-select
                                :reduce="products => products.id"
                                label="id"
                                :options="products"
                                :placeholder="`Filtering by ID`"
                                v-model="filter.id">
                            </v-select>
                        </th>
                        <td>
                            <v-select
                                :reduce="products => products"
                                label="name"
                                :options="productNames"
                                :placeholder="`Filtering by name`"
                                v-model="filter.name">
                            </v-select>
                        </td>
                        <td></td>
                    </tr>
                    <tr v-for="product in products" :key="product.id">
                        <th scope="row" style="width:10%">{{ product.id }}</th>
                        <td>{{ product.properties.name }}</td>
                        <td>
                            <span class="btn btn-outline-primary btn-sm me-3 pe-pointer" @click="doAction('edit_btn', product)">
                                <IconSvg :icon="`edit`" :key="product.id" /> Edit
                            </span>
                            <span class="btn btn-outline-danger btn-sm pe-pointer" data-bs-toggle="modal" data-bs-target="#popUpModal" @click="doAction('delete_btn', product)">
                                <IconSvg :icon="`delete`" :key="product.id" /> Delete
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import IconSvg from '../components/IconSvg.vue'
    import vSelect from 'vue-select'

    export default {
        name: 'AllProducts',
        components: {
            IconSvg,
            vSelect
        },
        props: {
            items: {
                type: Object
            },
            searchProducts: {
                type: Object
            }
        },
        data() {
            return {
                filter: {
                    id: '',
                    name: ''
                },
                products: this.items.products,
            }
        },
        computed: {
            productNames() {
                return this.products.map( product => product.properties.name )
            },
        },
        methods: {
            doAction( action, product ){
                this.$emit('actionButton', {action: action, data: product })
            }
        },
        watch: {
            'searchProducts': {
                handler: function ( items ) {

                    if( items.length > 0 ) {
                        this.products = items
                    } else {
                        this.products = this.items
                    }

                },
                deep: true
            },
            'filter.id': {
                handler: function ( items ) {
                    this.$emit('actionButton', {
                        action: 'filter',
                        data: {
                            by: 'id',
                            value: items
                        }
                    })
                },
                deep: true
            },
            'filter.name': {
                handler: function ( item ) {
                    this.$emit('actionButton', {
                        action: 'filter',
                        data: {
                            by: 'name',
                            value: item
                        }
                    })
                },
                deep: true
            },
        }
    }
</script>
