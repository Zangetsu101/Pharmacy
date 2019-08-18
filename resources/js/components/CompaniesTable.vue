<template>
    <div>
        <div class="pt-2 mb-3 text-center">
            <h3 v-show=!edit>Add New Company</h3>
            <h3 v-show=edit>Edit Company</h3>
        </div>
        <form class="mb-3">
            <div class="form-row">
                <div class="col">
                    <input type="text" v-model="name" class="form-control" placeholder="Name">
                </div>
            </div>
            <div v-if=!edit class="d-flex mt-1">
                <button v-on:click.prevent="addRow" class="btn btn-primary ml-auto"
                        v-bind:disabled="!isCompanyValid">Add</button>
            </div>
            <div v-if=edit class="d-flex mt-1">
                <button v-on:click.prevent="editRow" class="btn btn-primary ml-auto"
                        v-bind:disabled="!isCompanyValid">Submit</button>
                <button class="btn btn-primary ml-2" v-on:click.prevent="reset">Reset</button>
            </div>
        </form>
        <my-table 
            url="api/companies" 
            v-bind:isEditable=true
            v-bind:columns="columns"
            v-on:edit="showEditForm">
        </my-table>
    </div>
</template>

<script>
    import MyTable from './baseComponents/MyTable.vue';
    export default {
        components: {
            'my-table':MyTable
        },
        data() {
            return {
                columns:[
                    {
                        name:'Id',
                        key:'id'
                    },
                    {
                        name:'Name',
                        key:'name'
                    }
                ],
                edit:false,
                id:0,
                name:''
            }
        },
        methods: {
            addRow() {
                fetch('api/companies',{
                    method:'POST',
                    headers: {
                        'Content-type':'application/json'
                    },
                    body: JSON.stringify({
                        'name':this.name
                    })
                })
                .then(res=>res.json())
                .then(res=> {
                    this.$emit('add-row',res.data);
                });
                this.reset();
                alert("Company Added Successfully");
            },
            showEditForm(row) {
                this.id=row.id;
                this.name=row.name;
                this.edit=true;
            },
            editRow() {
                fetch(`api/companies/${this.id}`,{
                    method:'PUT',
                    headers: {
                        'Content-type':'application/json'
                    },
                    body: JSON.stringify({
                        'id':this.id,
                        'name':this.name
                    })
                })
                .then(res=>res.json())
                .then(res=> {
                    this.$emit('edit-row',res.data);
                });
                this.reset();
                alert("Company Edited Successfully");
            },
            reset()
            {
                this.id=0;
                this.name='';
                this.edit=false;
            }
        },
        computed: {
            isCompanyValid() {
                if(!this.name)
                    return false;
                return true;
            }
        }
    }
</script>

<style>
</style>