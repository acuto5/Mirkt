<template>
    <v-container>
        <v-layout row wrap justify-space-around>
            <v-flex xs12 sm10 lg8 class="text-xs-center">
                <p class="title">Pridėti naują straipsnį</p>
            </v-flex>

            <!-- Sub- category id-->
            <v-flex xs12 sm10 md8 lg6>
                <v-select
                        required
                        label="Sub-kategorija"
                        item-text="name"
                        item-value="id"
                        clearable
                        color="teal accent-2"
                        v-model="NewArticleObj.NewArticleInputs.sub_category_id"
                        :items="NewArticleObj.subCategoriesForSelectInput"
                        :error-messages="NewArticleObj.Errors.sub_category_id"
                />
            </v-flex>

            <!-- Title -->
            <v-flex xs12 sm10 md8 lg8>
                <v-text-field
                        required
                        label="Antraštė"
                        color="teal accent-2"
                        v-model="NewArticleObj.NewArticleInputs.title"
                        :error-messages="NewArticleObj.Errors.title"
                />
            </v-flex>

            <!-- Content -->
            <v-flex xs12 sm10 mb-2>
                <vue2-medium-editor
                        :class="isContentHasErrors"
                        class="text-editor pa-2"
                        :text="NewArticleObj.NewArticleInputs.content"
                        :options="editorOptions"
                        @edit="contentChange"
                />
                <error-caption-list :error-messages="NewArticleObj.Errors.content"/>
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
                        :items="NewArticleObj.Tags"
                        :error-messages="NewArticleObj.Errors.tags_ids"
                        v-model="NewArticleObj.NewArticleInputs.tags_ids"
                />
            </v-flex>

            <!-- Images -->
            <v-flex xs12 sm10>
                <images-input-panel
                        :new-files-array.sync="NewArticleObj.NewArticleInputs.images"
                        :default-image-id.sync="NewArticleObj.NewArticleInputs.default_image_id"
                        :is-default-img-old.sync="NewArticleObj.NewArticleInputs.is_default_img_old"
                        :images-error-messages="NewArticleObj.Errors.images"
                        :default-image-error-messages="NewArticleObj.Errors.default_image_id"
                />
            </v-flex>

            <!-- Actions -->
            <v-flex xs12 class="text-xs-center">
                <v-btn
                        outline
                        color="primary"
                        :loading="NewArticleObj.isButtonsDisabled"
                        @click.native="NewArticleObj.publishNewArticle()">
                    Publikuoti
                </v-btn>
                <v-btn
                        outline
                        color="warning"
                        :loading="NewArticleObj.isButtonsDisabled"
                        @click="NewArticleObj.saveArticleToDraft()">
                    Į juodaraštį/Peržiūrėti
                </v-btn>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
	import vue2MediumEditor from 'vue2-medium-editor';
	import ErrorCaptionList from "../../../../../components/errors/error-caption-list";
	import ImagesInputPanel from "../../components/images-input-panel";
	import NewArticleClass  from './NewArticle';

	export default {
		components: {
			ErrorCaptionList,
			vue2MediumEditor,
			ImagesInputPanel },
		data() {
			return {
				searchTagInput: '',
				NewArticleObj: new NewArticleClass(),
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
				return {'red-border': !!this.NewArticleObj.Errors.content.length};
            }
        },
		created() {
			this.NewArticleObj.getTags();
			this.NewArticleObj.setRouterObj(this.$router);
			this.NewArticleObj.getSubCategoriesForSelectInput();
		},
        methods: {
			contentChange(obj){
				this.NewArticleObj.NewArticleInputs.content = obj.api.elements[0].innerHTML;
            }
        }
	}
</script>

<style scoped>
    .red-border, .red-border:hover, .red-border:focus{
        border-color: #ff5252;
        outline-color: #ff5252 !important;
    }
</style>