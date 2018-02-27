<template>
    <v-container fluid>
        <v-layout row wrap justify-space-around v-if="!SingleArticleObj.isRequestInProgress && !errorsExists">
            <!-- Breadcrumbs & author name -->
            <v-flex d-flex xs12 md10>
                <v-layout row justify-space-between>

                    <!-- Breadcrumbs -->
                    <v-flex xs6 class="text-xs-left">
                        <!-- Category -->
                        <router-link
                                :to="getCategoryRouteParams(SingleArticleObj.Article.sub_category.category)"
                                class="router-link teal--text text--accent-2"
                        >
                            {{ SingleArticleObj.Article.sub_category.category.name }}
                        </router-link>

                        <!-- Right chevron -->
                        <v-icon class="subheading">chevron_right</v-icon>

                        <!-- Sub-category -->
                        <router-link
                                :to="getSubCategoryRouteParams(SingleArticleObj.Article.sub_category.category, SingleArticleObj.Article.sub_category)"
                                class="router-link white--text "
                        >
                            {{ SingleArticleObj.Article.sub_category.name }}
                        </router-link>
                    </v-flex>

                    <!-- Author name -->
                    <v-flex xs6 class="text-xs-right">
                        Autorius:
                        <b class="teal--text text--accent-2">{{ SingleArticleObj.Article.author.name }}</b>
                    </v-flex>
                </v-layout>
            </v-flex>

            <!-- Divider -->
            <v-flex xs12 md10 mt-1 mb-2>
                <v-divider/>
            </v-flex>

            <!-- Images -->
            <v-flex xs12 md10 class="text-xs-center">
                <v-carousel
                        :cycle="false"
                        hide-delimiters
                        v-model="defaultImageIndex"
                        :hide-controls="isCarouselControlsHidden"
                >
                    <v-carousel-item
                            :src="image.url"
                            :key="getIndexAndSetDefaultImageIndex(index, image.id)"
                            v-for="(image,index) in SingleArticleObj.Article.images"
                    />
                </v-carousel>
            </v-flex>


            <!-- Title and buttons-->
            <v-flex d-flex xs12 md10 my-2>
                <div class="headline" style="margin: auto;">

                    <!-- Title -->
                    {{ getTitle(this.SingleArticleObj.Article.title) }}

                    <!-- Buttons -->
                    <div style="display: inline-flex;" v-if="IAmGod">
                        <v-btn
                                style="float: right"
                                icon
                                flat
                                class=""
                                title="Redaguoti"
                                color="warning"
                                :to="SingleArticleObj.linkToEditThisArticle"
                                :loading="SingleArticleObj.isMarkButtonDisabled"
                        >
                            <v-icon>edit</v-icon>
                        </v-btn>
                        <v-btn
                                icon
                                flat
                                style="float: right"

                                color="error"
                                title="Perkelti į juodraštį"
                                v-if="!SingleArticleObj.Article.is_draft"
                                @click="SingleArticleObj.markArticleAsDraft()"
                                :loading="SingleArticleObj.isMarkButtonDisabled"
                        >
                            <v-icon>directions</v-icon>
                        </v-btn>
                        <v-btn
                                icon
                                flat
                                style="float: right"
                                color="teal accent-2"
                                title="Paskelbti"
                                v-if="SingleArticleObj.Article.is_draft"
                                @click="SingleArticleObj.markArticleAsPublished()"
                                :loading="SingleArticleObj.isMarkButtonDisabled"
                        >
                            <v-icon>check</v-icon>
                        </v-btn>
                    </div>
                </div>
            </v-flex>

            <!-- Divider -->
            <v-flex xs12 md10 mb-1>
                <v-divider/>
            </v-flex>

            <!-- Content -->
            <v-flex xs12 md10 my-2 >
                <div v-html="SingleArticleObj.Article.content"></div>
                <div v-if="SingleArticleObj.Article.deletion_at" class="mt-2 warning--text">Bus ištrinta: {{ SingleArticleObj.Article.deletion_at }}</div>
            </v-flex>

            <!-- Divider -->
            <v-flex xs12 md10 mb-1>
                <v-divider/>
            </v-flex>

            <!-- Tags -->
            <v-flex xs12 md10 v-if="SingleArticleObj.Article.tags.length">
                <v-chip
                        label
                        v-for="(tag,index) in SingleArticleObj.Article.tags"
                        :key="index"
                        outline
                        text-color="grey lighten-3"
                        color="grey darken-2"
                >
                    <v-avatar>
                        <v-icon>label</v-icon>
                    </v-avatar>
                    <router-link class="router-link white--text" :to="{name: 'articles.tagArticles', params: {tagName: tag.name}}">
                        {{ tag.name }}
                    </router-link>
                </v-chip>
            </v-flex>
        </v-layout>

        <!-- Errors -->
        <v-layout row wrap justify-space-around v-if="errorsExists">
            <v-flex xs12 sm10 md8 lg6 xl4>
                <alert-component :messages="SingleArticleObj.ArticleErrors.id" type="error"/>
            </v-flex>
        </v-layout>

        <!-- Loading circle -->
        <progress-circular v-if="SingleArticleObj.isRequestInProgress"/>
    </v-container>
</template>
<script>
	import AlertComponent   from "../../../components/alert-component";
	import ProgressCircular from "../../../components/progress-circular";
	import SingleArticle    from './SingleArticle';

	export default {
		components: {
			AlertComponent,
			ProgressCircular,
		},
		data () {
			return {
				User             : window.USER,
				defaultImageIndex: 0,
				SingleArticleObj : new SingleArticle( this.$route.params.id ),
			};
		},
		mounted () {
			this.SingleArticleObj.getArticle();
		},
		computed  : {
			isCarouselControlsHidden () {
				return this.SingleArticleObj.Article.images.length <= 1;
			},
			IAmGod () {
				return this.User.is_admin || this.User.is_moderator;
			},
			errorsExists () {
				return this.SingleArticleObj.ArticleErrors.id.length;
			},
		},
		watch     : {
			'SingleArticleObj.getArticleResponseStatus'(statusCode){
				if(statusCode === 204){
					window.FlashMessages.setError('Article not found.');
					this.$router.push({name: 'home'});
                }
            },
			'SingleArticleObj.ArticleErrors.id' ( errorArray ) {
				if (errorArray.length) {
					setTimeout( () => this.$router.go( -1 ), 3000 );
				}
			},
		},
		methods   : {
			getIndexAndSetDefaultImageIndex ( index, imageID ) {
				if (imageID === this.SingleArticleObj.Article.header_image.id) {
					this.defaultImageIndex = index;
				}

				return index;
			},
			getSubCategoryRouteParams ( category, subCategory ) {
				let $_route = { name: 'home' };

				if (category.name && subCategory.name) {
					$_route = {
						name  : 'articles.subCategoryArticles',
						params: {
							categoryName   : category.name,
							subCategoryName: subCategory.name,
						},
					};
				}

				return $_route;
			},
			getCategoryRouteParams ( category ) {
				let $_route = { name: 'home' };

				// If category or sub-category not found
				if (category.name) {
					$_route = {
						name  : 'articles.categoryArticles',
						params: {
							categoryName: category.name,
						},
					};
				}

				return $_route;
			},
			getTitle ( title ) {
				return title[ 0 ].toUpperCase() + title.slice( 1 );
			},
		},
	};
</script>