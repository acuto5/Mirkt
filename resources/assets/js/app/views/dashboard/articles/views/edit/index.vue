<!--suppress ALL -->
<template>
    <v-container fluid>
        <v-layout row wrap justify-space-around v-show="!EditArticleObj.isRequestInProgress">
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
                        color="teal accent-2"
                />
            </v-flex>

            <!-- Title -->
            <v-flex xs12 sm10 md8 lg8>
                <v-text-field
                        required
                        label="Antraštė"
                        color="teal accent-2"
                        v-model="EditArticleObj.EditArticleInputs.title"
                        :error-messages="EditArticleObj.Errors.title"
                />
            </v-flex>

            <!-- Content -->
            <v-flex xs12 sm10 mb-2>
                <vue2-medium-editor
                        :class="isContentHasErrors"
                        class="text-editor pa-2"
                        :text="EditArticleObj.EditArticleInputs.content"
                        :options="editorOptions"
                        @edit="contentChange"
                />
                <error-caption-list :error-messages="EditArticleObj.Errors.content"/>
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
                        color="teal accent-2"
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
                        outline
                        color="warning"
                        :loading="EditArticleObj.isButtonsDisabled"
                        @click.native="EditArticleObj.updateArticle()">
                    Atnaujinti
                </v-btn>
            </v-flex>
        </v-layout>

        <progress-circular v-if="EditArticleObj.isRequestInProgress"/>
    </v-container>
</template>
<script>
	import vue2MediumEditor from 'vue2-medium-editor';

	import ErrorCaptionList from "../../../../components/error-caption-list";
	import ProgressCircular from "../../../../components/progress-circular";
	import ImagesInputPanel from "../../components/images-input-panel";
	import EditArticleClass from './EditArticle';

	export default {
		components: {
			vue2MediumEditor,
			ErrorCaptionList,
			ProgressCircular,
			ImagesInputPanel,
		},
		data() {
			return {
				EditArticleObj: new EditArticleClass(),
				editorOptions : {
					toolbar: {
						buttons: [
							'bold',
							'italic',
							'underline',
							'strikethrough',
							'subscript',
							'superscript',
							'image',
                            'outdent',
                            'indent',
                            'justifyLeft',
                            'justifyCenter',
                            'justifyRight',
                            'justifyFull',
                            'h1',
                            'h2',
                            'h3',
                            'h4',
                            'h5',
                            'h6',
                            'html',
                            'removeFormat'
						],
					},
				},
			}
		},
		computed: {
			isContentHasErrors(){
				return {'red-border': !!this.EditArticleObj.Errors.content.length};
			}
		},
		created() {
			this.EditArticleObj.setRouterObj(this.$router);
			this.EditArticleObj.getArticle(this.$route.params.id);
			this.EditArticleObj.getTags();
			this.EditArticleObj.getSubCategoriesForSelectInput();
		},
		methods   : {
			contentChange ( obj ) {
				this.EditArticleObj.EditArticleInputs.content = obj.api.elements[ 0 ].innerHTML;
			},
		},
	}
</script>

<style scoped>
    .red-border, .red-border:hover, .red-border:focus{
        border-color: #ff5252;
        outline-color: #ff5252 !important;
    }
</style>