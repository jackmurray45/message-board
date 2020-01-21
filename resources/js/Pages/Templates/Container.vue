<template>
    <div>
       <Sidebar/>
        <div class = "login-sign-up">
            <div class = "row">
                <div class = "col text-right" v-if="loggedIn">
                    <user-card/>
                </div>
                <div class = "col text-right" v-else>
                    <login-sign-up/>
                </div>
            </div>
        </div>





        <div v-bind:class="isCollapsed ? containerCollapsed : container " >
            
            <slot></slot>
        </div>
    </div>
    
</template>

<script>
import Sidebar from './Sidebar'
import UserCard from './UserCard'
import LoginSignUp from './LoginSignUp'



export default {
    props: ['posts', 'users'],
    components: {
        Sidebar,
        UserCard,
        LoginSignUp
    },
    methods: {
        checkCollapse(event){
            this.currentWidth = document.documentElement.clientWidth
            this.isCollapsed = this.currentWidth <=650
        },
    },
    data() {
        return {
            container: "container",
            containerCollapsed: "containerCollapsed",
            isCollapsed: false,
            loggedIn: this.$page.auth.user,
        }
    },

    mounted() {
        this.$nextTick(function() {
            window.addEventListener('resize', this.checkCollapse);
            //Init
            this.checkCollapse()
        })
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.checkCollapse);
    },

     
    //
}

</script>
<style scoped>

.container{
    width:100% !important;
    max-width:100% !important;
}

.login-sign-up{
}

.link-button{
    /* padding:15px; */

}


</style>
