<template>
    <div>
        <div class="side-bar">
            <side-bar v-model="selectedPage"></side-bar>
        </div>
        <div class="page-container">
            <div v-show="selectedPage==='medicines'">
                <medicines-table></medicines-table>
            </div>
            <div v-show="selectedPage==='companies'">
                <companies-table></companies-table>
            </div>
            <div v-show="selectedPage==='sales'">
                <!-- <auto-complete v-model="medicine" v-bind:data="medicines" field="name"></auto-complete> -->
                <sales-table></sales-table>
            </div>
            <!-- <div v-show="selectedPage==='orders'">

            </div> -->
        </div>
    </div>
</template>

<script>
    import SideBar from './SideBar.vue';
    import MedicinesTable from './MedicinesTable.vue';
    import CompaniesTable from './CompaniesTable.vue';
    // import AutoComplete from './baseComponents/AutoComplete.vue';
    import SalesTable from'./SalesTable.vue';
    export default {
        components: {
            'side-bar':SideBar,
            'medicines-table':MedicinesTable,
            'companies-table':CompaniesTable,
            'sales-table':SalesTable
        },
        data() {
            return {
                selectedPage:'sales',
                medicine:{},
                medicines:[]
            }
        },
        watch: {
            medicine(newVal) {
                console.log(this.medicine);
            }
        }
    }
</script>