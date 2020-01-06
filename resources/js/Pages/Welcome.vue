<template>
    <div>
        <div>This is the welcome pages</div>
        <br>
        <div v-for="user in users"> {{ user.email }}</div>
    </div>
    
</template>

<script>
export default {
    props: ['posts', 'users']
}


</script>
