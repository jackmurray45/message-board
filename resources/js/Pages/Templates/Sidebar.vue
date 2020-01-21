<template>
  <sidebar-menu
        :menu="menu"
        :disableHover="disableHover"
        :hideToggle="hideToggle"
        :collapsed="isCollapsed"
        @item-click="onItemClick"
      />
</template>

<script>
import { SidebarMenu } from 'vue-sidebar-menu'
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css'


const separator = {
  template: `<hr style="border-color: rgba(220, 220, 220, 1); margin: 20px;">`
};

export default {

    components: {
        SidebarMenu
    },
    methods:{
        checkCollapse(event){
                this.currentWidth = document.documentElement.clientWidth;
                if(this.currentWidth <= 650 && !this.userUncollapsed){
                    this.collapsedLayout()
                }else if(this.currentWidth > 650){
                    this.unCollapsedLayout()
                }
        },

        onItemClick(event, item) {
            if(item.icon === 'fa fa-bars' && this.isCollapsed){
                this.userUncollapsedLayout()
            }else if(item.icon === 'fa fa-bars'){
                this.collapsedLayout()
            }
        },

        collapsedLayout(){
            this.isCollapsed = true
            this.userUncollapsed = false
            this.menu.map(a=>a.icon === 'fa fa-bars' ? a.hidden = false : a.hidden = true)

        },
        
        unCollapsedLayout(){
            this.isCollapsed = false
            this.userUncollapsed = false
            this.menu.map(a=>a.icon !== 'fa fa-bars' ? a.hidden = false : a.hidden = true)

        },

        userUncollapsedLayout(){
            this.isCollapsed = false
            this.userUncollapsed = true
            this.menu.map(a=> a.hidden = false)
        },


    },
    data() {
        return {
            menu: [
                {
                    icon: 'fa fa-bars',
                    hidden: true,
                },
                {
                    header: true,
                    title: 'Lara Post',
                    hiddenOnCollapse: true
                },
                {
                    href: '/',
                    title: 'Home',
                    icon: 'fa fa-home'
                },
                {
                    header: true,
                    component: separator,
                },
                {

                    title: 'Posts',
                    icon: 'fa fa-sticky-note',
                    hiddenOnCollapse: true,
                    disabled:true,
                },

                {
                    href: '/posts',
                    title: 'All',
                },

                {
                    href: '/posts?following=1',
                    title: 'Following',
                },
                {
                    header: true,
                    component:separator,
                },
                {
                    title: 'Profiles',
                    icon: 'fa fa-user',
                    hiddenOnCollapse: true,
                    disabled: true,
                },

                {
                    href: '/profiles',
                    title: 'All',
                },

                {
                    href: '/profiles?following=1',
                    title: 'Following',
                },
                
            ],

            userUncollapsed: false,
            hideToggle: true,
            isCollapsed: false,
            disableHover: true,
            currentWidth: 0,

        
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
.v-sidebar-menu .vsm--link.vsm--link_disabled {
    opacity: 1.0 !important;
}

</style>


