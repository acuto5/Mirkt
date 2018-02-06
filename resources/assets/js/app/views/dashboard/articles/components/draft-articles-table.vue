<template>
    <v-list dark class="brown darken-3">
        <template v-for="(article, index) in DraftArticlesObj.Articles">
            <v-divider v-if="index > 0"/>
            <v-list-tile avatar @click="" :key="article.id">
                <!-- Article header image -->
                <tile-avatar-default-article-image
                        :image="article.header_image"
                />

                <!-- Article title and creation date -->
                <tile-content-title-and-creation-date
                        :id="article.id"
                        :title="article.title"
                        :created-at="article.created_at"
                />

                <!-- Edit article -->
                <tile-action-edit-article-link-button
                        :id="article.id"
                />

                <!-- Mark article as published-->
                <tile-action-mark-article-as-published-button-link
                        :id="article.id"
                        :draft-articles-obj="DraftArticlesObj"
                />

                <!-- Delete article confirm dialog -->
                <tile-action-delete-article-confirm-dialog
                        :id="article.id"
                        :title="article.title"
                        :draft-articles-obj="DraftArticlesObj"
                />

            </v-list-tile>
        </template>
    </v-list>
</template>
<script>
	import TileAvatarDefaultArticleImage from "./sub-components/tile-avatar-default-article-image";
	import TileContentTitleAndCreationDate from "./sub-components/tile-content-title-and-creatiion-date";
	import TileActionEditArticleLinkButton from "./sub-components/tile-action-edit-article-link-button";
	import TileActionMarkArticleAsPublishedButtonLink from "./sub-components/tile-action-mark-article-as-published-button-link";
	import TileActionDeleteArticleConfirmDialog from "./sub-components/tile-action-delete-article-confirm-dialog";

	export default {
		components: {
			TileActionDeleteArticleConfirmDialog,
			TileActionMarkArticleAsPublishedButtonLink,
			TileActionEditArticleLinkButton,
			TileContentTitleAndCreationDate,
			TileAvatarDefaultArticleImage
		},
		name: 'draft-articles-table',
		props: {
			DraftArticlesObj: {
				type: Object,
				required: true
			}
		}
	}
</script>