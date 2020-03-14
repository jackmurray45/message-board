<template>
    <div>
        <div v-for="profile in profiles" :key="profile.id"> 
            <profile :profileData="profile" class = 'profiles' />
        </div>
        
    </div>
</template>

<script>
import Profile from './Profile'


export default {
    props: {
        profiles: Array,
    },
    components: {
        Profile,
    },
}

</script>