<template>
    <div>
        <Sidebar/>
        <div class = "container">
            <div>This is the welcome pages</div>
            <br>
            <div v-for="user in users"> {{ user.email }}</div>
        </div>
    </div>
    
</template>

<script>
import Sidebar from './Templates/Sidebar'

export default {
    props: ['posts', 'users'],
    components: {
        Sidebar
    }
}
</script>

<style>


</style>
