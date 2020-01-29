<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <!--Loading animation-->
                <div class="text-center" v-if="loadingData">
                    <h6 class="font-weight-bold cyan">We are loading your data. Please wait...</h6>
                    <div class="spinner-border text-primary mt-3 mb-3" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <!--//End Loading animation-->

                <div class="not-loading" v-if="!loadingData">

                    <div class="col-md-10 mx-auto" v-if="itemsAdded">
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Item</th>
                            <th scope="col">Description</th>
                            <th scope="col">Price</th>
                            <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in items" :key="item.id">
                            <th scope="row">{{item.id}}</th>
                            <td>{{item.item_name}}</td>
                            <td>{{item.item_description}}</td>
                            <td>KSH {{item.price}}</td>
                            <td class="text-center">
                                <a @click="editItem(item)"><i class="fa fa-pencil blue"></i></a>
                                <a href=""><i class="fa fa-trash pl-2 red"></i></a>
                            </td>
                            </tr>
                        </tbody>
                        </table>

                        <div class="add-another-btn">
                            <button class="btn btn-primary btn-sm" @click="addItem">Add another item</button>
                        </div>
                    </div>

                    <div class="card" v-else>
                        <div class="card-body text-center">
                            <img style="width:50%; height:50%" src="./../../../public/images/shop.png">

                            <div class="no-items-added mt-4">
                                <p class="font-weight-bold">No items added. Get started now!</p>
                            </div>

                            <div class="add-btn mt-3">
                                <button class="btn btn-primary btn-sm" @click="addItem">Add an item</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!--Add Item Modal-->
            <sweet-modal ref="addItemModal">
                <h4 v-show="!editmode" class="pt-4" slot="title">Add Item</h4>
                <h4 v-show="editmode" class="pt-4" slot="title">Edit Item</h4>

                <div class="container pl-0 pb-0 pl-2" slot="default">
                    <div class="col-md-10 mx-auto">
                        <div class="row">
                            <p>Add a shopping item.</p>
                        </div>
                            <hr class="pt-0 pb-0 mt-0">
                        <form @submit.prevent="editmode ? updateItem() : createItem()">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Item Name</label>
                                    <input v-model="form.item_name" type="text" name="item_name" id="item_name"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('item_name') }">
                                    <has-error :form="form" field="item_name"></has-error>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Item Description</label>
                                    <textarea v-model="form.item_description" type="text" name="item_description" id="item_description" class="form-control" :class="{ 'is-invalid': form.errors.has('item_description') }" rows="6"></textarea>
                                    <has-error :form="form" field="item_description"></has-error>
                                    <small class="form-text text-muted">This is optional.</small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Item Price</label>
                                    <vue-numeric v-model="form.price" 
                                    currency="Ksh" 
                                    separator=","
                                    class="form-control"
                                    decimal-separator="true"
                                    :class="{ 'is-invalid': form.errors.has('price') }">
                                    </vue-numeric>
                                    <has-error :form="form" field="price"></has-error>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <button v-show="!editmode" type="submit" class="btn btn-primary">Add Item</button>
                                    <button v-show="editmode" type="submit" class="btn btn-success">Update Item Details</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </sweet-modal>
        <!--//End Add Item Modal-->
    </div>
</template>

<script>
import { SweetModal, SweetModalTab } from 'sweet-modal-vue'

export default {
    mounted() {
        //console.log('component mounted')
        this.showItemsCreated()
        Fire.$on('refreshItems', () => {
                this.showItemsCreated();
            });
    },

    computed: { 
        itemsAdded() {
            if(this.items.length > 0)
                return true
            else
             return false
        },
    },

    data() {
        return {
            loadingData: true,
            editmode: false,
            items: [],
            form: new Form({
                id: '',
                item_name: '',
                item_description: '',
                price: '',
            })
        }
    },

    components: {
        SweetModal,SweetModalTab
    },

    methods: {
        showItemsCreated() {
            axios.get('api/items-created')
                .then(response => {
                    //console.log(response)
                    this.items = response.data
                    this.loadingData = false
                })
                .catch(() => {

                })
        },
        addItem() {
            this.editmode = false;
            //this.form.clear()
            this.$refs.addItemModal.open()
        },

        editItem(item) {
            this.editmode = true;
            this.form.clear();
            this.$refs.addItemModal.open()
            this.form.fill(item);
        },

        createItem() {
                this.form.post('api/save-item')
                .then(() => {
                    Fire.$emit('refreshItems');
                    Toast.fire({
                        type: 'success',
                        title: 'Item added successfully'
                        })
                    
                    this.$refs.addItemModal.close()
                    this.form.reset();
                })
                .catch(() => {
                    Toast.fire({
                        type: 'error',
                        title: 'Something went wrong. Try again...'
                    })
                });
                
            }
    }
    
}
</script>