<template>
    <v-container fluid>
        <v-layout row wrap justify-space-around v-if="SingleArticleObj.Article.title">
            <v-flex d-flex xs12>
                <v-layout row justify-space-between>

                    <!-- Categories and sub-categories breadcrumbs-->
                    <v-flex d-flex xs6>
                        <v-breadcrumbs divider="/">
                            <v-breadcrumbs-item v-text="SingleArticleObj.Article.sub_category.category.name"/>
                            <v-breadcrumbs-item v-text="SingleArticleObj.Article.sub_category.name"/>
                        </v-breadcrumbs>
                    </v-flex>

                    <!-- Author name -->
                    <v-flex d-flex xs6 class="text-xs-right">
                        <v-breadcrumbs justify-end>
                            <v-breadcrumbs-item v-text="'Autorius: ' + SingleArticleObj.Article.author.name"/>
                        </v-breadcrumbs>
                    </v-flex>
                </v-layout>
            </v-flex>

            <!-- Divider -->
            <v-flex xs12 mb-3>
                <v-divider/>
            </v-flex>

            <!-- Title -->
            <v-flex d-flex xs10>
                <p class="title" v-text="SingleArticleObj.Article.title"></p>
            </v-flex>

            <!-- Content -->
            <v-flex d-flex xs10>
                <p v-text="SingleArticleObj.Article.content"></p>
            </v-flex>

            <!-- Tags -->
            <v-flex xs10 v-if="SingleArticleObj.Article.tags.length">
                <v-divider/>
                <v-chip label v-for="(tag,index) in SingleArticleObj.Article.tags" :key="index">{{tag.name}}</v-chip>

            </v-flex>

            <!-- Images -->
            <v-flex xs10>
                <v-divider/>

                <images-gallery-panel
                        src-key="url"
                        :images="SingleArticleObj.Article.images"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap justify-space-around v-else>
            <v-flex d-flex xs12 class="text-xs-center">
                <v-progress-circular fill indeterminate  color="teal accent-2" :width="4" :size="50"/>
            </v-flex>
        </v-layout>
    </v-container>
    <!--<section class="section">-->
    <!--<div class="container">-->
    <!--<div class="content">-->
    <!--<h1 v-text="SingleArticleObj.article.title"></h1>-->
    <!--<p v-text="SingleArticleObj.article.content"></p>-->
    <!--</div>-->
    <!--</div>-->
    <!--&lt;!&ndash; Images &ndash;&gt;-->
    <!--<images-gallery :images="SingleArticleObj.article.images" srcKey="url"></images-gallery>-->
    <!--&lt;!&ndash; Tags &ndash;&gt;-->
    <!--<tags-field :tags="SingleArticleObj.article.tags" tagTextKey="name"></tags-field>-->
    <!--&lt;!&ndash;Buttons&ndash;&gt;-->
    <!--<div class="buttons is-centered">-->
    <!--<router-link :to="SingleArticleObj.linkToEditThisArticle" class="button is-outlined is-warning"-->
    <!--v-text="'Redaguoti'"></router-link>-->

    <!--<button v-show="SingleArticleObj.article.is_draft" :disabled="SingleArticleObj.isMarkButtonDisabled"-->
    <!--@click="SingleArticleObj.markArticleAsPublished()" class="button is-outlined is-info"-->
    <!--v-text="'Skelbti'"></button>-->

    <!--<button v-show="!SingleArticleObj.article.is_draft" :disabled="SingleArticleObj.isMarkButtonDisabled"-->
    <!--@click="SingleArticleObj.markArticleAsDraft()" class="button is-outlined is-info"-->
    <!--v-text="'Perkelti į juodraštį'">-->
    <!--</button>-->
    <!--</div>-->

    <!--<help-list type="danger" :messages="SingleArticleObj.ArticleErrors.id"></help-list>-->
    <!--</section>-->
</template>
<script>
	import SingleArticle from './SingleArticle';
	import ImagesGalleryPanel from "../../components/images-gallery-panel";

	export default {
		components: {ImagesGalleryPanel},
		data() {
			return {
				SingleArticleObj: new SingleArticle(this.$route.params.id),
			}
		},
		created() {
			this.SingleArticleObj.getArticle();
		}
	}
</script>