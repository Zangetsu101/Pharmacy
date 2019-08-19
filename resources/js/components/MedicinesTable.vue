<template>
    <div>
        <div class="pt-2 mb-3 text-center">
            <h3 v-show=!edit>Add New Medicine</h3>
            <h3 v-show=edit>Edit Medicine</h3>
        </div>
        <form class="mb-3">
            <div class="form-row">
                <div class="col-2">
                    <input type="text" v-model="name" class="form-control" placeholder="Name">
                </div>
                <div>
                    <select name="company" v-model="company" class="form-control">
                        <option v-bind:value="{id:null}" disabled>Select a company</option>
                        <option v-for="comp in companies"
                                v-bind:key="comp.id"
                                v-bind:value="comp">
                            {{comp.name}}
                        </option>
                    </select>
                </div>
                <div class="col-3">
                    <auto-complete v-model="generic_name" field="name" placeholder="Generic Name" 
                                   v-bind:data="generic_names"></auto-complete>
                </div>
                <div class="col">
                    <auto-complete v-model="dosage_form" field="name" placeholder="Dosage Form" 
                                   v-bind:data="dosage_forms"></auto-complete>
                </div>
                <div class="col">
                    <input type="text" v-model="wholesale_price" class="form-control" placeholder="Wholesale Price">
                </div>
                <div class="col">
                    <input type="text" v-model="retail_price" class="form-control" placeholder="Retail Price">
                </div>
            </div>
            <div v-if=!edit class="d-flex mt-1">
                <button v-on:click.prevent="addRow" class="btn btn-primary ml-auto"
                        v-bind:disabled="!isMedicineValid">Add</button>
            </div>
            <div v-if=edit class="d-flex mt-1">
                <button v-on:click.prevent="editRow" class="btn btn-primary ml-auto"
                        v-bind:disabled="!isMedicineValid">Submit</button>
                <button v-on:click.prevent="reset" class="btn btn-primary ml-2">Reset</button>
            </div>
        </form>
        <my-table 
            url="api/medicines" 
            v-bind:isEditable=true
            v-bind:columns="columns"
            v-on:edit="showEditForm">
        </my-table>
    </div>
</template>

<script>
    import MyTable from './baseComponents/MyTable.vue';
    import AutoComplete from './baseComponents/AutoComplete.vue';
    export default {
        components: {
            'my-table':MyTable,
            'auto-complete':AutoComplete
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
                    },
                    {
                        name:'Company Name',
                        key:'company_name'
                    },
                    {
                        name:'Generic Name',
                        key:'generic_name'
                    },
                    {
                        name:'Dosage Form',
                        key:'dosage_form'
                    },
                    {
                        name:'Wholesale Price',
                        key:'wholesale_price'
                    },
                    {
                        name:'Retail Price',
                        key:'retail_price'
                    }
                ],
                companies:[],
                generic_names:[],
                dosage_forms:[],
                edit:false,
                id:0,
                name:'',
                company:{},
                generic_name:{},
                dosage_form:{},
                wholesale_price:'',
                retail_price:''
            }
        },
        created() {
            this.fetchCompanies();
            this.fetchGenericNames();
            this.fetchDosageForms();
            this.reset();
        },
        methods: {
            fetchCompanies() {
                fetch('api/companies')
                    .then(res=>res.json())
                    .then(res=> {
                        this.companies=res.data;
                    });
            },
            fetchGenericNames() {
                fetch('api/generic_names')
                    .then(res=>res.json())
                    .then(res=>this.generic_names=res.data);
            },
            fetchDosageForms() {
                fetch('api/dosage_forms')
                    .then(res=>res.json())
                    .then(res=>this.dosage_forms=res.data);
            },
            addRow() {
                let dos=!this.dosage_form.id?true:false;
                let gen=!this.generic_name.id?true:false;
                fetch('api/medicines',{
                    method:'POST',
                    headers: {
                        'Content-type':'application/json'
                    },
                    body: JSON.stringify({
                        'name':this.name,
                        'company_id':this.company.id,
                        'generic_name_id':this.generic_name.id,
                        'generic_name':this.generic_name.name,
                        'dosage_form_id':this.dosage_form.id,
                        'dosage_form':this.dosage_form.name,
                        'wholesale_price':this.wholesale_price,
                        'retail_price':this.retail_price
                    })
                })
                .then(res=>res.json())
                .then(res=> {
                    this.$emit('add-row',res.data);
                    if(gen)
                        this.fetchGenericNames();
                    if(dos)
                        this.fetchDosageForms();
                });
                this.reset();
                alert("Medicine Added Successfully");
            },
            showEditForm(row) {
                this.id=row.id;
                this.name=row.name;
                this.company={
                    id:row.company_id,
                    name:row.company_name
                };
                this.generic_name={
                    id:row.generic_name_id,
                    name:row.generic_name
                };
                this.dosage_form={
                    id:row.dosage_form_id,
                    name:row.dosage_form
                };
                this.wholesale_price=row.wholesale_price;
                this.retail_price=row.retail_price;
                this.edit=true;
            },
            editRow() {
                let dos=!this.dosage_form.id?true:false;
                let gen=!this.generic_name.id?true:false;
                fetch(`api/medicines/${this.id}`,{
                    method:'PUT',
                    headers: {
                        'Content-type':'application/json'
                    },
                    body: JSON.stringify({
                        'name':this.name,
                        'company_id':this.company.id,
                        'generic_name_id':this.generic_name.id,
                        'generic_name':this.generic_name.name,
                        'dosage_form_id':this.dosage_form.id,
                        'dosage_form':this.dosage_form.name,
                        'wholesale_price':this.wholesale_price,
                        'retail_price':this.retail_price
                    })
                })
                .then(res=>res.json())
                .then(res=> {
                    this.$emit('edit-row',res.data);
                    if(gen)
                        this.fetchGenericNames();
                    if(dos)
                        this.fetchDosageForms();
                });
                this.reset();
                alert("Medicine Edited Successfully");
            },
            reset()
            {
                this.id=0;
                this.name='';
                this.company={id:null};
                this.generic_name={id:null};
                this.dosage_form={id:null};
                this.wholesale_price='';
                this.retail_price='';
                this.edit=false;
            },
            isFloat(n) {
                return n != "" && !isNaN(n) && Math.round(n) != n;
            }
        },
        computed: {
            isMedicineValid() {
                if(!this.name||!this.company.id||!this.generic_name.name||!this.dosage_form.name||
                    (!this.isFloat(parseFloat(this.wholesale_price))&&!Number.isInteger(parseInt(this.wholesale_price)))||
                    (!this.isFloat(parseFloat(this.retail_price))&&!Number.isInteger(parseInt(this.retail_price)))||
                    parseFloat(this.wholesale_price)>=parseFloat(this.retail_price))
                    return false;
                return true;
            }
        }
    }
</script>

<style>
</style