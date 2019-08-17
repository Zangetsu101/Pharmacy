<template>
    <div class="position-relative">
        <input type="text" v-model="input" class="form-control" 
                           v-bind:placeholder="placeholder"
                           v-on:focus="focused=true"
                           v-on:blur="focused=false"
                           v-on:keydown.down="nextPos"
                           v-on:keydown.up="prevPos"
                           v-on:keydown.enter.prevent="complete(listPos)">
        <div v-if=focused class="list-group position-absolute">
            <button v-for="(row,index) in rows" class="list-group-item list-group-item-action"
                    v-bind:key="index"
                    v-on:mousedown="complete(index)"
                    v-bind:class="{'active':listPos===index}">{{row[field]}}</button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        value:[Object,String],
        data:Array,
        field:String,
        placeholder:String,
        weak:Boolean
    },
    data() {
        return {
            input:'',
            listItems:[],
            shownItems:[],
            listPos:-1,
            focused:false
        }
    },
    watch: {
        data(newVal) {
            this.listItems=newVal;
        },
        input(newVal) {
            this.listPos=-1;
            if(this.weak)
                this.$emit('input',this.input);
            else
            {
                this.shownItems.some((item,index)=> {
                    if(item[this.field].toLowerCase()==newVal.toLowerCase())
                    {
                        this.$emit('input',this.shownItems[index]);
                        return true;
                    }
                });
            }
        },
        value(newVal) {
            if(this.weak)
                this.input=newVal;
            else
                this.input=newVal[this.field];
        }
    },
    methods: {
        complete(index) {
            if(index>=0)
                this.input=this.shownItems[index][this.field];
        },
        nextPos() {
            if(this.listPos<this.shownItems.length-1)
                this.listPos++;
        },
        prevPos() {
            if(this.listPos>0)
                this.listPos--;
        }
    },
    computed: {
        rows() {
            let rows=this.listItems.filter(row=> {
                if(!this.input)
                    return false;
                return row[this.field].toLowerCase().startsWith(this.input.toLowerCase());
            }).filter((row,index)=> {
                if(index>=10)
                    return false;
                return true;
            });
            this.shownItems=rows;
            return rows;
        }
    }
}
</script>