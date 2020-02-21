<template>
    <div>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class = "page-item" v-bind:class = "{disabled : disableBackPages}">
                    <a class="page-link" :href="`${urlString}1`" tabindex="-1">«</a>
                </li>
                <li class="page-item" v-bind:class = "{disabled : disableBackPages}">
                    <a class="page-link" :href="`${urlString}${metaData.current_page-1}`" tabindex="-1">Previous</a>
                </li>

                <template  v-for="n in (end-start)+1">
                    <li class = "page-item" v-bind:class = "{disabled : n+start-1 == metaData.current_page}" :key="n">
                        <a class="page-link" :href="`${urlString}${n+start-1}`">{{n+start-1}}</a>
                    </li>
                </template>

                <li class="page-item" v-bind:class = "{disabled : disableForwardPages}">
                    <a class="page-link" :href="`${urlString}${metaData.current_page+1}`">Next</a>
                </li>
                <li class="page-item" v-bind:class = "{disabled : disableForwardPages}">
                    <a class="page-link" :href="`${urlString}${this.$props.metaData.last_page}`">»</a>
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
            default: window.location.pathname
        }
    },

    components: {
        
    },
    methods: {

        createUrl(){
            if( typeof(this.$props.urlParams)  == "Object"){
                this.$props.urlParams = Object.keys(this.$props.url).map(key => key + '=' + this.$props.urlParams[key]).join('&')
            }


            this.urlString = this.$props.urlParams.replace(/\&?\??A?page=[^&]+&*/, '')
            this.urlString = `${this.$props.urlPath}?${this.urlString}page=`
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


