<template>
    <div class="card bg-primary text-white" style="height:100%">
        <div class="card-header text-center">Menu</div>
        <button type="button" class="btn btn-primary btn-block text-white"
                v-bind:class="{'active':this.pageName==='sales'}"
                v-on:click.prevent="changePage('sales')"><i class="fas fa-box-open fa-lg mr-2"></i>Sales</button>
        <button type="button" class="btn btn-primary btn-block text-white"
                v-bind:class="{'active':this.pageName==='medicines'}"
                v-on:click.prevent="changePage('medicines')"><i class="fas fa-pills fa-lg mr-2"></i>Medicines</button>
        <button type="button" class="btn btn-primary btn-block text-white"
                v-bind:class="{'active':this.pageName==='companies'}"
                v-on:click.prevent="changePage('companies')"><i class="far fa-building fa-lg mr-2"></i>Companies</button>
        <!-- <button type="button" class="btn btn-primary btn-block text-white"
                v-bind:class="{'active':this.pageName==='orders'}"
                v-on:click.prevent="changePage('orders')"><i class="fas fa-box fa-lg mr-2"></i>Orders</button> -->
    </div>
</template>

<script>
    export default {
        props: {
            value:String        
        },
        data() {
            return {
                pageName:'',
                menuSelectedClass:'btn btn-primary btn-block active text-white',
                menuClass:'btn btn-primary btn-block text-white'
            }
        },
        methods: {
            changePage(page) {
                this.pageName=page;
                this.$emit('input',page);
            }
        },
        created() {
            this.pageName=this.value;
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
