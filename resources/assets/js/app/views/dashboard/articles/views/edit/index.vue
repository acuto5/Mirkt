<template>
    <v-container fluid>
        <v-layout row wrap justify-space-around v-show="EditArticleObj.EditArticleInputs.title">
            <v-flex xs12 sm10 lg8 class="text-xs-center">
                <p class="title">Redaguoti straipsnį</p>
            </v-flex>

            <!-- Title -->
            <v-flex xs12 sm10 md8 lg6>
                <v-select
                        required
                        label="Sub-kategorija"
                        item-text="name"
                        item-value="id"
                        clearable
                        v-model="EditArticleObj.EditArticleInputs.sub_category_id"
                        :items="EditArticleObj.subCategoriesForSelectInput"
                        :error-messages="EditArticleObj.Errors.sub_category_id"
                />
            </v-flex>

            <!-- Title -->
            <v-flex xs12 sm10 md8 lg8>
                <v-text-field
                        required
                        label="Antraštė"
                        v-model="EditArticleObj.EditArticleInputs.title"
                        :error-messages="EditArticleObj.Errors.title"
                />
            </v-flex>

            <!-- Content -->
            <v-flex xs12 sm10>
                <v-text-field
                        :rows="15"
                        textarea
                        label="Straipsnis"
                        v-model="EditArticleObj.EditArticleInputs.content"
                        :error-messages="EditArticleObj.Errors.content"
                />
            </v-flex>

            <!-- Tags -->
            <v-flex xs12 sm10>
                <v-select
                        chips
                        multiple
                        label="Žymės"
                        persistent-hint
                        deletable-chips
                        item-value="id"
                        item-text="name"
                        :items="EditArticleObj.Tags"
                        :error-messages="EditArticleObj.Errors.tags_ids"
                        v-model="EditArticleObj.EditArticleInputs.tags_ids"
                />
            </v-flex>

            <!-- Images -->
            <v-flex xs12 sm10>
                <images-input-panel
                        :is-default-img-old.sync="EditArticleObj.EditArticleInputs.is_default_img_old"
                        :default-image-id.sync="EditArticleObj.EditArticleInputs.default_image_id"
                        :old-images-array.sync="EditArticleObj.EditArticleInputs.old_images"
                        :new-files-array.sync="EditArticleObj.EditArticleInputs.images"
                        :images-error-messages="EditArticleObj.Errors.images"
                        :default-image-error-messages="EditArticleObj.Errors.default_image_id"
                />
            </v-flex>

            <!-- Actions -->
            <v-flex xs12 class="text-xs-center">
                <v-btn
                        color="warning"
                        :loading="EditArticleObj.isButtonsDisabled"
                        @click.native="EditArticleObj.updateArticle()">
                    Atnaujinti
                </v-btn>
            </v-flex>
        </v-layout>
        <v-layout row wrap justify-space-around v-if="!EditArticleObj.EditArticleInputs.title">
            <v-flex d-flex xs12 class="text-xs-center">
                <v-progress-circular fill indeterminate color="brown darken-3" :width="4" :size="50"/>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
	import EditArticleClass from './EditArticle';
	import SelectTagsField from "../../components/select-tags-field";
	import ImagesInputPanel from "../../components/images-input-panel";

	export default {
		components: {
			ImagesInputPanel,
			SelectTagsField
		},
		data() {
			return {
				EditArticleObj: new EditArticleClass()
			}
		},
		created() {
			this.router = this.$router;
			this.EditArticleObj.setRouterObj(this.$router);
			this.EditArticleObj.getArticle(this.$route.params.id);
			this.EditArticleObj.getTags();
			this.EditArticleObj.getSubCategoriesForSelectInput();
		}
	}
</script>  