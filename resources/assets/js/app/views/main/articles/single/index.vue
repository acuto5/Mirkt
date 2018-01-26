<template>
    <v-container fluid grid-list-md >
        <v-layout row wrap>
            <v-flex d-flex xs12 mt-2>
                <v-layout row wrap >
                    <v-flex  xs12 sm12 md9 >
                        <v-layout row wrap>
                            <v-flex d-flex xs12 hidden-md-and-up>
                                <h4 class="display-1"  v-text="SingleArticleObj.Article.title"></h4>
                            </v-flex>
                            <v-flex d-flex xs12>
                                <v-card>
                                    <v-card-media>
                                        <v-carousel v-if="SingleArticleObj.Article.images.length" :hide-controls="SingleArticleObj.Article.images.length <= 1" hide-delimiters>
                                            <v-carousel-item v-for="(image,i) in SingleArticleObj.Article.images" :src="image.url" :key="i" >
                                            </v-carousel-item>
                                        </v-carousel>
                                        <span class="headline pa-2 white--text carousel-title hidden-sm-and-down" v-text="SingleArticleObj.Article.title"></span>
                                    </v-card-media>
                                </v-card>
                            </v-flex>
                        </v-layout>
                    </v-flex>
                    <v-flex d-flex xs12 sm12 md3>
                        <v-layout row wrap justify-space-around>
                            <v-flex d-flex xs12 sm4 md12 v-for="i in 2" :key="i">
                                <v-card >
                                    <v-card-text>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta dolore, exercitationem maiores
                                        maxime nemo placeat totam! Distinctio fugit libero mollitia nesciunt repellendus repudiandae
                                        saepe sequi! Consequuntur earum error harum maiores!
                                    </v-card-text>
                                </v-card>
                            </v-flex>
                        </v-layout>
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-flex d-flex xs12>
                <v-layout row wrap>
                    <v-flex sm12 md9 pt-3 pr-3>
                        <p v-text="SingleArticleObj.Article.content"></p>
                    </v-flex>
                    <v-flex sm12 md3 >
                        <v-layout row wrap justify-space-around>
                            <v-flex xs12 sm4 md12 v-for="i in 3" :key="i">
                                <v-card>
                                    <v-card-text>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta dolore, exercitationem maiores
                                        maxime nemo placeat totam! Distinctio fugit libero mollitia nesciunt repellendus repudiandae
                                        saepe sequi! Consequuntur earum error harum maiores!
                                    </v-card-text>
                                </v-card>
                            </v-flex>
                        </v-layout>
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
	import SingleArticleClass from './SingleArticle';

	export default{
		name: 'singleArticle',
		data() {
			return {
				SingleArticleObj: new SingleArticleClass(this.$route.params.id),
			}
		},
		created(){

			this.SingleArticleObj.getArticle();
		},
		computed: {
			getDefaultImg() {
				return this.SingleArticleObj.getDefaultImg();
			}
		}
	}
</script>

<style>
    .carousel-title{
        background: rgba(0, 0, 0, 0.5);
        position: absolute;
        bottom: 0;
        width: 100%;
    }
</style>