<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/">Home</router-link>
                    </li>
                    <li class="nav-item" v-if="!auth">
                        <router-link class="nav-link" to="/login">Login</router-link>
                    </li>
                    <li class="nav-item" v-if="!auth">
                        <router-link class="nav-link" to="/register">Regster</router-link>
                    </li>
                    <li class="nav-item" v-if="auth">
                        <router-link class="nav-link" to="/users">Users</router-link>
                    </li>
                    <li class="nav-item" v-if="auth">
                        <a class="nav-link btn " @click="logout">Logout</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name: "Navbar",
    computed:{
        logout(){
            localStorage.removeItem('authenticated',false)
            localStorage.removeItem('auth','')
            localStorage.removeItem('TOKEN','')
            this.auth=false
            this.$router.push('/login')
        }
    },
    data() {
        return {
            auth:localStorage.getItem('authenticated')
        }
    },
    methods:{

    }
}
</script>

<style scoped>

</style>
