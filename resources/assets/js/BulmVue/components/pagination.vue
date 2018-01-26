<template>
    <nav class="pagination is-centered" v-show="currentPage">
        <a v-if="currentPage > 1" class="pagination-previous" @click="pushToPage(currentPage-1)">Atgal</a>
        <a v-if="currentPage < lastPage" class="pagination-next" @click="pushToPage(currentPage+1)">Toliau</a>
        <ul class="pagination-list">
            <li v-if="currentPage>3"><a class="pagination-link" :class="{'is-current': currentPage===1}" v-text="1"
                                        @click="pushToPage(1)"></a></li>
            <li v-if="currentPage>4"><span class="pagination-ellipsis">&hellip;</span></li>
            <li v-if="currentPage-2 > 0"><a class="pagination-link" v-text="currentPage-2"
                                            @click="pushToPage(currentPage-2)"></a></li>
            <li v-if="currentPage-1 > 0"><a class="pagination-link" v-text="currentPage-1"
                                            @click="pushToPage(currentPage-1)"></a></li>

            <li v-if="currentPage != lastPage"><a class="pagination-link is-current" v-text="currentPage"></a></li>

            <li v-if="currentPage+1 < lastPage"><a class="pagination-link" v-text="currentPage+1"
                                                   @click="pushToPage(currentPage+1)"></a></li>
            <li v-if="currentPage+2 < lastPage"><a class="pagination-link" v-text="currentPage+2"
                                                   @click="pushToPage(currentPage+2)"></a></li>

            <li v-if="currentPage+3<lastPage"><span class="pagination-ellipsis">&hellip;</span></li>
            <li><a class="pagination-link" :class="{'is-current': currentPage===lastPage}" v-text="lastPage"
                   @click="pushToPage(lastPage)"></a></li>
        </ul>
    </nav>
</template>
<script>
	export default{
		name: 'pagination',
		props: {
			currentPage: {
				type: Number,
				required: true
			},
			lastPage: {
				type: Number,
				required: true
			},
			pushToPage: {
				type: Function,
				required: true
			}
		}
	}
</script>  