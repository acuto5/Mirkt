<template>
    <v-card :to="getRouteParams()">
        <v-card-media :src="bgImageUrl" :height="height" @mouseenter="hideTitle()" @mouseleave="showTitle"/>
        <span v-if="isTitleVisible" class="headline card-title white--text pa-1">{{ title }}</span>
    </v-card>
</template>

<script>
	export default {
		name   : "article-card",
		props  : {
			title     : {
				type    : String,
				required: true,
			},
			bgImageUrl: {
				type    : String,
				required: false,
			},
			articleId : {
				type    : Number,
				required: true,
			},
			height    : {
				type    : String,
				required: false,
				default : '200px',
			},
		},
		data () {
			return {
				isTitleVisible: true,
			};
		},
		methods: {
			getRouteParams () {
				return {
					name  : 'articles.single',
					params: { id: this.articleId },
				};
			},
			showTitle () {
				this.isTitleVisible = true;
			},
			hideTitle () {
				this.isTitleVisible = false;
			},
		},
	};
</script>
<style scoped>
    .card-title {
        background: rgba(0, 0, 0, 0.5);
        position: absolute;
        bottom: 0;
        width: 100%;
    }
</style>