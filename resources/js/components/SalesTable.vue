<template>
    <div>
        <div class="pt-2 mb-3 text-center">
            <h3 v-show=!edit>Add New Sale</h3>
            <h3 v-show=edit>Edit Sale</h3>
        </div>
        <form class="mb-3">
            <div class="form-row">
                <div class="col">
                    <date-picker v-model="date" placeholder="Date"
                                 v-bind:bootstrap-styling=true
                                 v-bind:disabled-dates=disabledDates
                                 format="yyyy-MM-dd"></date-picker>
                </div>
                <div class="col">
                    <auto-complete v-model="medicine" 
                                   v-bind:data="medicines" 
                                   v-bind:weak=false field="name" placeholder="Name"></auto-complete>
                </div>
                <div class="col">
                    <input type="text" v-model="quantity" class="form-control" placeholder="Quantity">
                </div>
                <div class="col">
                    <input type="text" v-model="price" class="form-control" placeholder="Price" readonly>
                </div>
            </div>
            <div v-if=!edit class="d-flex mt-1">
                <button v-on:click.prevent="addRow" class="btn btn-primary ml-auto"
                        v-bind:disabled="!isSaleValid">Add</button>
            </div>
            <div v-if=edit class="d-flex mt-1">
                <button v-on:click.prevent="editRow" class="btn btn-primary ml-auto"
                        v-bind:disabled="!isSaleValid">Submit</button>
                <button class="btn btn-primary ml-2" v-on:click.prevent="reset">Reset</button>
            </div>
        </form>
        <my-table 
            url="api/sales" 
            v-bind:isEditable=true
            v-bind:columns="columns"
            v-on:edit="showEditForm">
        </my-table>
    </div>
</template>

<script>
    import MyTable from './baseComponents/MyTable.vue';
    import AutoComplete from './baseComponents/AutoComplete.vue';
    import Datepicker from 'vuejs-datepicker';
    export default {
        components: {
            'my-table':MyTable,
            'auto-complete':AutoComplete,
            'date-picker':Datepicker
        },
        data() {
            return {
                columns:[
                    {
                        name:'Id',
                        key:'id'
                    },
                    {
                        name:'Date',
                        key:'date'
                    },
                    {
                        name:'Name',
                        key:'medicine_name'
                    },
                    {
                        name:'Company Name',
                        key:'company_name'
                    },
                    {
                        name:'Quantity',
                        key:'quantity'
                    },
                    {
                        name:'Price',
                        key:'price'
                    }                
                ],
                edit:false,
                disabledDates:{
                    from:new Date()
                },
                id:0,
                medicine:{},
                medicines:[],
                today:new Date(),
                date:'',
                quantity:'',
                price:''            
            }
        },
        watch:{
            quantity(newVal) {
                if(Number.isInteger(parseInt(newVal))&&this.medicine.retail_price)
                    this.price=this.medicine.retail_price*newVal;
                else
                    this.price='';
            },
            medicine(newVal) {
                if(Number.isInteger(parseInt(this.quantity))&&newVal.retail_price)
                    this.price=this.quantity*newVal.retail_price;
                else
                    this.price='';
            }
        },
        created() {
            fetch('api/medicines_sorted')
                .then(res=>res.json())
                .then(res=>this.medicines=res.data);
            this.date=this.today;
        },
        methods: {
            addRow() {
                fetch('api/sales',{
                    method:'POST',
                    headers: {
                        'Content-type':'application/json'
                    },
                    body: JSON.stringify({
                        'medicine_id':this.medicine.id,
                        'date':this.date.getUTCFullYear() + "-" +
                                ("0" + (this.date.getUTCMonth()+1)).slice(-2) + "-" +
                                ("0" + this.date.getUTCDate()).slice(-2),
                        'quantity':this.quantity,
                        'price':this.price
                    })
                })
                .then(res=>res.json())
                .then(res=> {
                    this.$emit('add-row',res.data);
                });
                this.reset();
                alert("Sale Added Successfully");
            },
            showEditForm(row) {
                this.id=row.id;
                this.medicine=this.medicines.find(item=> {
                    if(item.id===row.medicine_id)
                        return true;
                });
                this.date=new Date(row.date);
                this.quantity=row.quantity;
                this.edit=true;
            },
            editRow() {
                fetch(`api/sales/${this.id}`,{
                    method:'PUT',
                    headers: {
                        'Content-type':'application/json'
                    },
                    body: JSON.stringify({
                        'medicine_id':this.medicine.id,
                        'date':this.date.getUTCFullYear() + "-" +
                                ("0" + (this.date.getUTCMonth()+1)).slice(-2) + "-" +
                                ("0" + this.date.getUTCDate()).slice(-2),
                        'quantity':this.quantity,
                        'price':this.price
                    })
                })
                .then(res=>res.json())
                .then(res=> {
                    this.$emit('edit-row',res.data);
                });
                this.reset();
                alert("Sale Edited Successfully");
            },
            reset()
            {
                this.id=0;
                this.name='';
                this.medicine={};
                this.date=this.today;
                this.quantity='';
                this.price='';
                this.edit=false;
            }
        },
        computed: {
            isSaleValid() {
                if(!this.medicine.id||!Number.isInteger(parseInt(this.quantity))||this.quantity<=0)
                    return false;
                return true;
            }
        }
    }
</script>

<style>
</style>