<template>
    <div>
       <Sidebar/>
        <div v-bind:class="isCollapsed ? containerCollapsed : container " >
            <slot></slot>
        </div>
    </div>
    
</template>

<script>
import Sidebar from './Sidebar'



export default {
    props: ['posts', 'users'],
    components: {
        Sidebar,
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
            isCollapsed: false
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
}

</script>

<style>

.container{
    margin: 0 auto !important;
    margin-top: 40px !important;
}


</style>
