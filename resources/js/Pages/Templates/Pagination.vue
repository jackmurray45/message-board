<template>
    <div>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class = "page-item" v-bind:class = "{disabled : disableBackPages}">
                    <inertia-link :href="`${urlString}1`" class="page-link" :preserve-scroll="isPreserveScroll"> 
                        «
                    </inertia-link>
                </li>
                <li class="page-item" v-bind:class = "{disabled : disableBackPages}">
                    <inertia-link :href="`${urlString}${metaData.current_page-1}`" class="page-link" :preserve-scroll="isPreserveScroll">
                        Previous
                    </inertia-link>
                </li>

                <template  v-for="n in (end-start)+1">
                    <li class = "page-item" v-bind:class = "{disabled : n+start-1 == metaData.current_page}" :key="n">
                        <inertia-link :href="`${urlString}${n+start-1}`" class="page-link" :preserve-scroll="isPreserveScroll">
                            {{n+start-1}}
                        </inertia-link>
                    </li>
                </template>

                <li class="page-item" v-bind:class = "{disabled : disableForwardPages}">
                    <inertia-link :href="`${urlString}${metaData.current_page+1}`" class="page-link" :preserve-scroll="isPreserveScroll">
                        Next
                    </inertia-link>
                </li>
                <li class="page-item" v-bind:class = "{disabled : disableForwardPages}">
                    <inertia-link :href="`${urlString}${this.$props.metaData.last_page}`" class="page-link" :preserve-scroll="isPreserveScroll">
                        »
                    </inertia-link>
                </li>
                
            </ul>
        </nav>
    </div>
</template>

<script>


export default {
    props: {
        metaData: Object,
        pagesDisplayed: Number,
        urlParams: {
           type: String | Object,
           default: window.location.search
        },
        urlPath:{
            type: String,
            default: ''
        },
        preserveScroll:{
            type: Boolean,
            default: false
        }
    },

    components: {
        
    },
    methods: {

        createUrl(){

            let urlParams = this.$props.urlParams
            let urlPath = this.$props.urlPath

            if( typeof(urlParams)  == "Object"){
                urlParams = Object.keys(urlParams).map(key => key + '=' + urlParams[key]).join('&')
            }

            if(urlPath == ''){
                urlPath = window.location.pathname
            }


            this.urlString = urlParams.replace(/\&?\??A?page=[^&]+&*/, '')
            this.urlString = `${urlPath}?${this.urlString}page=`
        },

        createNums(){
            
            let bottomHalfCount = Math.floor((this.$props.pagesDisplayed - 1)/2)
            let upperHalfCount = Math.ceil((this.$props.pagesDisplayed - 1)/2)

            const currentPage = this.$props.metaData.current_page
            const lastPage = this.$props.metaData.last_page

            let start = currentPage-bottomHalfCount;
            let end = currentPage+upperHalfCount;

            if(start <= 0)
            {
                //When bottom half count is less than 0 means too close to beginning pages
                end += (1 - start)
                start = 1
            }

            if(end > lastPage)
            {
                if(start > 1)
                {
                    start -= (end-lastPage)
                    if(start <= 0)
                    {
                        
                        start = 1
                    }
                }

                end = lastPage
            }

            this.start = start
            this.end = end

        }

    },
    data() {
        return {
            disableBackPages: this.$props.metaData.current_page == 1,
            disableForwardPages: this.$props.metaData.last_page == this.$props.metaData.current_page,
            pagesListed: null,
            urlString: null,
            start: 0,
            end: 0,
            isPreserveScroll: this.$props.preserveScroll,
        }

            
    },

    created()
    {
        this.createNums()
        this.createUrl()
    }

}
</script>

<style scoped>

</style>


