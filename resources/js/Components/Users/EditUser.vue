<template>

    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 col-md-6 offset-md-3">
                <div class="card shadow sm">
                    <div class="card-body">
                        <h1 class="text-center">Edit User </h1>
                        <hr/>
                        <form action="javascript:void(0)" @submit="saveEdit" class="row" method="post">
                            <div class="form-group col-12">
                                <label for="name" class="font-weight-bold">Name</label>
                                <input type="text" name="name" v-model="user.name" id="name" placeholder="Enter name" class="form-control">
                                <div class="errors" v-if="Object.keys(errors).length > 0 && errors.name !== undefined">
                                    <span>{{errors.name[0]}}</span>
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label for="email" class="font-weight-bold">Email</label>
                                <input type="text" name="email" v-model="user.email" id="email" placeholder="Enter Email" class="form-control">
                                <div class="errors" v-if="Object.keys(errors).length > 0 && errors.email !== undefined">
                                    <span>{{errors.email[0]}}</span>
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label for="password" class="font-weight-bold">Password</label>
                                <input type="password" name="password" v-model="user.password" id="password" placeholder="Enter Password" class="form-control">
                                <div class="errors" v-if="Object.keys(errors).length > 0 && errors.password !== undefined">
                                    <span>{{errors.password[0]}}</span>
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label for="password_confirmation" class="font-weight-bold">Confirm Password</label>
                                <input type="password" name="password_confirmation" v-model="user.password_confirmation" id="password_confirmation" placeholder="Enter Password" class="form-control">
                                <div class="errors text-red-500" v-if="Object.keys(errors).length > 0 && errors.password !== undefined">
                                    <span>{{errors.password[0]}}</span>
                                </div>
                            </div>
                            <div class="col-12 mb-2 mt-2">
                                <button type="submit" :disabled="processing" class="btn btn-warning m2-2">
                                    {{ processing ? "Please wait" : "Save" }}
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "EditUser",
    data(){
        return {
            errors:[],
            user:{
                id:"",
                name:"",
                email:"",
                password:"",
                password_confirmation:"",
            },
            processing:false
        }
    },
    mounted() {
     this.getUser();
        },
    methods:{
        async saveEdit(){
            this.processing = true
            await axios.patch(`users/${this.$route.params.id}`,this.user).then(response=>{
            if(response.status){
                this.$router.push('/users')
            }
            }).catch(({response:{data}})=>{
                this.errors=data.errors
            }).finally(()=>{
                this.processing = false
            })
        },
        async getUser(){
            this.processing = true
            await axios.get(`users/${this.$route.params.id}/edit`).then(response=>{
               this.user.name=response.data.user.name;
               this.user.email=response.data.user.email;
               this.user.id=response.data.user.id;

            }).catch(({response:{data}})=>{
            }).finally(()=>{
                this.processing = false
            })
        }
    }
}
</script>

<style scoped>
.errors{
    color: red;
}
</style>
