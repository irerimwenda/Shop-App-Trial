<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="not-loading" v-if="!loadingData">

                    <div class="col-md-10 mx-auto" v-if="itemsAdded">
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Item</th>
                            <th scope="col">Description</th>
                            <th scope="col">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in items" :key="item.id">
                            <th scope="row">{{item.id}}</th>
                            <td>{{item.item_name}}</td>
                            <td>{{item.item_description}}</td>
                            <td>KSH {{item.price}}</td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>

                <div class="card" v-else>
                    <div class="card-body text-center">
                        <img style="width:50%; height:50%" src="./../../../public/images/add.png">

                        <div class="no-items-added mt-4">
                            <p class="font-weight-bold">No items added in the site. Navigate to the admin section to add items</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
       mounted() {
            //console.log('component mounted')
            this.showItemsCreated()
            Fire.$on('refreshItems', () => {
                    this.showItemsCreated();
                });
        },

        data() {
            return {
                items: [],
            }
        },

        computed: { 
            itemsAdded() {
                if(this.items.length > 0)
                    return true
                else
                return false
            },
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
        }
    }
</script>
