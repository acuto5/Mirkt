<template>
    <v-list dark>
        <template v-for="(article, index) in PublishedArticlesObj.Articles">
            <v-divider v-if="index >= 1"/>
            <v-list-tile avatar @click="" :key="article.id">
                <!-- Article default image -->
                <tile-avatar-default-article-image
                        :image="article.header_image"
                />

                <!-- Title and creation date -->
                <tile-content-title-and-creation-date
                        :id="article.id"
                        :title="article.title"
                        :created-at="article.created_at"
                />

                <!-- Edit article -->
                <tile-action-edit-article-link-button :id="article.id" :articles-obj="PublishedArticlesObj" />

                <!-- Mark article as draft -->
                <tile-action-mark-article-as-draft-button
                        :id="article.id"
                        :published-articles-obj="PublishedArticlesObj"
                />
            </v-list-tile>
        </template>
    </v-list>
</template>
<script>

	import TileActionEditArticleLinkButton from "./sub-components/tile-action-edit-article-link-button";
	import TileActionMarkArticleAsDraftButton from "./sub-components/tile-action-mark-article-as-draft-button";
	import TileAvatarDefaultArticleImage from "./sub-components/tile-avatar-default-article-image";
	import TileContentTitleAndCreationDate from "./sub-components/tile-content-title-and-creatiion-date";

	export default {
		components: {
			TileAvatarDefaultArticleImage,
			TileContentTitleAndCreationDate,
			TileActionMarkArticleAsDraftButton,
			TileActionEditArticleLinkButton,
		},
		name: 'publishedArticlesTable',
		props: {
			PublishedArticlesObj: {
				type: Object,
				required: true
			}
		}
	}
</script>