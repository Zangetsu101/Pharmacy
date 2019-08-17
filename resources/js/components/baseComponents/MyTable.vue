<template>
    <div>
        <div class="d-flex pt-2">
            <div class="form-row mr-auto">
                <div class="col-auto pt-2">
                    <label for="pageSize">Per Page:</label>
                </div>
                <div class="col-auto">
                    <select name="pageSize" v-model="pageSize" class="form-control">
                        <option v-for="(item,index) in perPage"
                                v-bind:key="index">{{item}}</option>
                    </select>
                </div>
            </div>
            <i class="fas fa-search fa-2x text-primary pt-1 pr-2"></i>
            <input type="text" class="form-control mb-2" style="width:30vw" v-model="search" placeholder="Search">
        </div>
        <div class="table-resoponsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th v-for="column in tableColumns" 
                            v-bind:key="column.key"
                            v-on:click="sortColumn(column.key)"
                            >
                                {{column.name}}
                                <i v-bind:class="{'fas fa-sort-up':selectedColumn===column.key&&sortDir==='asc'}"></i>
                                <i v-bind:class="{'fas fa-sort-down':selectedColumn===column.key&&sortDir==='desc'}"></i>
                        </th>
                        <th v-if="isEditable" style="width:2vw"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in rows" 
                        v-bind:key="row.id"
                        >
                        <td v-for="column in tableColumns" 
                            v-bind:key="column.key">{{row[column.key]}}</td>
                        <td v-if="isEditable">
                            <button v-on:click.prevent="$emit('edit',row) " class="btn btn-primary btn-sm">Edit</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="d-flex mb-2">
            <button v-on:click.prevent="toPage(1)" 
                    v-bind:class="{'btn btn-outline-primary mr-2 ml-auto':true,'active':isCurrentPage(1)}">First</button>
            <button v-on:click.prevent="prevPage" class="btn btn-outline-primary mr-2"
                    v-bind:disabled="isPrevDisabled">Previous</button> 
            <div class="btn-group">
                <button v-for="page in pages" 
                        v-bind:class="{'btn btn-outline-primary':true,'active':isCurrentPage(page)}"
                        v-bind:key="page"
                        v-on:click.prevent="toPage(page)">{{page}}</button>
            </div>
            <button v-on:click.prevent="nextPage" class="btn btn-outline-primary ml-2 mr-2"
                    v-bind:disabled="isNextDisabled">Next</button>
            <button v-on:click.prevent="toPage(totalPages)" 
                    v-bind:class="{'btn btn-outline-primary':true,'active':isCurrentPage(totalPages)}">Last</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            url:String,
            columns:Array,
            isEditable:Boolean
        },
        data() {
            return {
                tableRows:[],
                tableColumns:[],
                search:null,
                selectedColumn:null,
                sortDir:null,
                currentSize:0,
                currentPage:1,
                pageSize:10,
                perPage:[5,10,15,20]
            }
        },
        created() {
            this.fetchData();
            this.tableColumns=this.columns;
        },
        mounted() {
            this.$parent.$on('add-row',(row)=>this.addRow(row));
            this.$parent.$on('edit-row',(row)=>this.editRow(row));
        },
        methods: {
            fetchData() {
                fetch(this.url)
                    .then(res=>res.json())
                    .then(res=> {
                        this.tableRows=res.data;
                    });
            },
            addRow(row) {
                this.tableRows.push(row);
            },
            editRow(row) {
                let index=this.tableRows.findIndex(x=>x.id===row.id);
                this.tableRows.splice(index,1);
                this.tableRows.splice(index,0,row);
            },
            sortColumn(columnName) {
                if(this.selectedColumn===columnName) {
                    if(this.sortDir==='desc')
                        this.selectedColumn=null;
                    else
                        this.sortDir='desc';
                }
                else {
                    this.selectedColumn=columnName;
                    this.sortDir='asc';
                }
            },
            prevPage() {
                if(this.currentPage>1)
                    this.currentPage--;
            },
            nextPage() {
                if(this.currentPage*this.pageSize<this.currentSize)
                    this.currentPage++;
            },
            toPage(page) {
                this.currentPage=page;
            },
            isCurrentPage(page) {
                return page===this.currentPage;
            }
        },
        computed: {
            rows() {
                let rows=this.tableRows.filter(row=> {
                    let values=Object.values(row);
                    return values.some(str => 
                        !this.search||((typeof str==='string')?
                        str.toString().toLowerCase().includes(this.search.toLowerCase()):false));
                });
                this.currentSize=rows.length;
                if(this.currentSize<(this.currentPage-1)*this.pageSize)
                    this.currentPage=1;
                return rows.sort((a,b)=> {
                    let mul=this.sortDir==='asc'?1:-1;
                    if(a[this.selectedColumn]>b[this.selectedColumn])
                        return 1*mul;
                    else if(a[this.selectedColumn]<b[this.selectedColumn])
                        return -1*mul;
                    return 0;
                }).filter((row, index) => {
                    let start = (this.currentPage-1)*this.pageSize;
                    let end = this.currentPage*this.pageSize;
                    if(index >= start && index < end) return true;
                });
            },
            totalPages() {
                return Math.ceil(this.currentSize/this.pageSize);
            },
            isPrevDisabled() {
                return this.currentPage===1;
            },
            isNextDisabled() {
                return this.currentPage===this.totalPages;
            },
            pages() {
                let p=[];
                let start=Math.floor((this.currentPage-1)/5)*5+1;
                let end=Math.min(this.totalPages,start+4);
                for(let i=start;i<=end;i++)
                    p.push(i);
                return p;
            }
        }
    }
</script>

<style>
    th {
        cursor: pointer;
    }
</style>