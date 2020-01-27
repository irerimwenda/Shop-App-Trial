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
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
