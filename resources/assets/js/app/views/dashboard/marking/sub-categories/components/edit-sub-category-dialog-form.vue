<template>
    <v-dialog v-model="isDialogVisible" max-width="500px">
        <v-btn icon outline color="warning" slot="activator">
            <v-icon>edit</v-icon>
        </v-btn>
        <v-card>
            <v-form @submit.prevent="editSubCategory()">

                <!-- Title -->
                <v-card-title class="warning title">Redaguoti: {{ subCategory.name }}</v-card-title>

                <!-- Content -->
                <v-card-text>
                    <!-- Category -->
                    <!--<v-list>-->
                        <!--<v-list-tile>-->
                            <v-select
                                    single-line
                                    item-value="id"
                                    item-text="name"
                                    label="Kategorija"
                                    color="teal accent-2"
                                    :items="SubCategoriesObj.categories"
                                    v-model="tempSubCategory.category_id"
                                    :error-messages="SubCategoriesObj.EditSubCategoryErrors.category_id"
                            />
                        <!--</v-list-tile>-->
                    <!--</v-list>-->

                    <!-- Name -->
                    <v-text-field
                            label="Pavadinimas"
                            color="teal accent-2"
                            v-model="tempSubCategory.name"
                            :error-messages="SubCategoriesObj.EditSubCategoryErrors.name"
                    />

                    <!-- Other errors -->
                    <error-caption-list :error-messages="SubCategoriesObj.EditSubCategoryErrors.id"/>
                </v-card-text>
                <v-card-actions>
                    <v-btn flat type="submit" color="warning" :loading="isLoading">Atnaujinti</v-btn>
                    <v-btn flat @click="isDialogVisible = false" :loading="isLoading">Atgal</v-btn>
                </v-card-actions>
            </v-form>
        </v-card>
    </v-dialog>
</template>

<script>
	import ErrorCaptionList from "../../../../components/error-caption-list";

	export default {
		components: {ErrorCaptionList},
		name: "edit-sub-category-dialog-form",
		props: {
			subCategory: {
				type: Object,
				required: true
			},
			SubCategoriesObj: {
				type: Object,
				required: true
			}
		},
		data() {
			return {
				isLoading: false,
				tempSubCategory: {},
				isDialogVisible: false,
				editSubCategoryURL: window.URLS.editSubCategory,
                Errors: new window.Errors({id: [], sub_category_id: [], name: []})
			}
		},
        watch: {
			isDialogVisible(isVisible){
				if(isVisible){
					this.tempSubCategory = Object.assign({}, this.subCategory);
				}
            }
        },
        methods: {
			async editSubCategory(){
				this.isLoading = true;

				this.isDialogVisible = ! await this.SubCategoriesObj.editSubCategory(this.tempSubCategory);

				this.isLoading = false;
			}
        }
	}
</script>