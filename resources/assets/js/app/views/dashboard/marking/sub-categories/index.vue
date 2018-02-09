<template>
    <v-container fluid grid-list-lg>
        <v-layout row wrap justify-space-around>

            <!-- Select category -->
            <v-flex xs10 sm8 md6 lg3 >
                <select-category :sub-categories-obj="SubCategoriesObj"/>
            </v-flex>

            <!-- Sub-categories list -->
            <v-flex d-flex xs12 sm10>
                <!-- List -->
                <sub-categories-list
                        :sub-categories-obj="SubCategoriesObj"
                        v-show="!SubCategoriesObj.isRequestInProgress"
                />
                <v-progress-circular
                        fill
                        indeterminate
                        color="teal accent-2"
                        :width="4"
                        :size="50"
                        v-if="SubCategoriesObj.isRequestInProgress && SubCategoriesObj.selectedCategoryID > 0"
                />
                <!-- Errors -->
                <error-caption-list :error-messages="SubCategoriesObj.UpdateSubCategoriesErrors.id"/>
            </v-flex>

            <!-- Add new sub-category -->
            <v-flex d-flex xs10 sm8 md6 lg4 v-if="SubCategoriesObj.selectedCategoryID > 0">
                <add-sub-category-dialog-form
                        :sub-categories-obj="SubCategoriesObj"
                        v-show="!SubCategoriesObj.isRequestInProgress && SubCategoriesObj.selectedCategoryID > 0"
                />
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
	import SubCategories from './SubCategories';
	import SelectCategory from "./components/select-category";
	import SubCategoriesList from "./components/sub-categories-list";
	import AddSubCategoryDialogForm from "./components/add-sub-category-dialog-form";
	import ErrorCaptionList from "../../../components/error-caption-list";

	export default {
		components: {
			ErrorCaptionList,
			AddSubCategoryDialogForm,
			SubCategoriesList,
			SelectCategory},
		data() {
			return {
				SubCategoriesObj: new SubCategories()
			}
		}
	}
</script>  