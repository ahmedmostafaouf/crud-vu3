<template>
   <navbar></navbar>
    <router-view></router-view>
</template>

<script>
import Navbar from "../Components/Layouts/Navbar.vue";
export default {
    name: "app",
    components:{
        Navbar
    }
}
</script>

<style scoped>

</style>
