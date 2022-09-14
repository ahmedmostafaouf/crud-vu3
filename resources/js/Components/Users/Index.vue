<template>
<div class="container">
    <div class="search">
    <router-link class="btn btn-primary mb-2" :to="{name:'create_user'}">Add</router-link>
        <input type="text" class="form-control" placeholder="Search Here......" v-model="search" @input="searchTerm">
    </div>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">name</th>
            <th scope="col">email</th>
            <th scope="col">action</th>
        </tr>
        </thead>
        <tbody>
        <tr v-if="users.length>0" v-for="user in users">
            <td>{{ user.name }}</td>
            <td>{{user.email}}</td>
            <td>
                <div class="btn_table">
                    <router-link class="btn btn-warning" :to="{name:'edit_user',params:{id:user.id}}">Edit</router-link>
                    <button class="btn btn-danger" @click="deleteRow(user.id)">Delete</button>
                </div>
            </td>
        </tr>
        <tr v-else  class="text-center" >
            <td colspan="3"> <p class="text-center">User Not Found</p></td>

        </tr>

        </tbody>
    </table>
    <div class="pagnate_style">
        <pagination v-model="page" :records="total" :per-page="perPage" @paginate="myCallback"/>
        <select class="" v-model="per_page"  @change="updatePage">
             <option v-for="page in pages">
                 {{page}}
             </option>
        </select>
    </div>

</div>
</template>

<script>
import Pagination from 'v-pagination-3';
export default {
    name: "Index",
    components:{
        Pagination
    },
    data(){
        return {
            users:[],
            search:'',
            page:1,
            meta: {},
            per_page:10,
            pages:[1,5,10,20,50,100]

        }
    },
    mounted() {
           this.getUsers();
    },
    computed:{
       total(){
           return parseInt(this.meta.total);
       },
        perPage(){
            return parseInt(this.meta.per_page);

        }
    },
    methods:{
        updatePage(){
            this.getUsers();
        },
        searchTerm(){
            this.getUsers();
        },
        async getUsers(){
            await axios.get(`users?page=${this.page}&per_page=${this.per_page}&searchTerm=${this.search}`).then(({data})=>{
                 this.users=data.data;
                 this.meta=data.meta;
                 console.log(this.meta.total);
            }).catch(({response:{data}})=>{
                alert(data.message)
            }).finally(()=>{
                this.processing = false
            })
        },
        myCallback(page){
          this.page=page;
          this.getUsers();
        },
        async  deleteRow(id){
            if(confirm( 'are You Sure ?')){
                await axios.delete(`users/${id}`).then(({data})=>{
                    this.getUsers();
                }).catch(({response:{data}})=>{
                    alert(data.message)
                }).finally(()=>{
                    this.processing = false
                })
            }

        }
    }
}
</script>

<style scoped>
.pagnate_style{
    display: flex;
    justify-content: space-between;
}
.search{
    display: flex;
    justify-content: space-between;
    margin-top:10px;
}
.search input{
    width: 211px;
    height: 39px;
}
.btn_table{
    display: flex;
    justify-content: flex-start;
    margin-top:10px;
    gap: 5px;
}
</style>
