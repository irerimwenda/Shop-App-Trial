<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body text-center">
                        <img style="width:50%; height:50%" src="./../../../public/images/add.png">

                        <div class="no-items-added mt-4">
                            <p class="font-weight-bold">No items added in the site. Navigate to the admin section to add items</p>
                        </div>

                        <div class="add-btn mt-3">
                            <button class="btn btn-primary btn-sm" @click="addItem">Add an item</button>
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
        console.log('component mounted')
    },

    data() {
        return {
            editmode: false,
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
        addItem() {
            this.editmode = false;
            //this.form.clear()
            this.$refs.addItemModal.open()
        }
    }
    
}
</script>