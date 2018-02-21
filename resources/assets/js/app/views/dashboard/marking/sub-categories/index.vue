<template>
    <v-container>
        <v-layout row wrap v-show="!SubCategoriesObj.isRequestInProgress">
            <!-- Title -->
            <v-flex xs12 mb-2 class="text-xs-center">
                <h2 class="headline">Sub kategorijos</h2>
            </v-flex>

            <!-- Category select -->
            <v-flex xs12 sm8 offset-sm2 md6 offset-md3 lg4 offset-lg4 mb-2>
                <select-category :sub-categories-obj="SubCategoriesObj"/>
            </v-flex>

            <!-- Sub-categories list -->
            <v-flex xs12 sm8 offset-sm2 md6 offset-md3 v-show="SubCategoriesObj.subCategories.length">
                <sub-categories-list :sub-categories-obj="SubCategoriesObj"/>
            </v-flex>

            <!-- Add new sub-category -->
            <v-flex d-flex xs12 sm8 offset-sm2 md6 offset-md3 lg4 offset-lg4 v-if="SubCategoriesObj.selectedCategoryID > 0">
                <add-sub-category-dialog-form :sub-categories-obj="SubCategoriesObj"/>
            </v-flex>
        </v-layout>

        <!-- Errors -->
        <v-layout row wrap justify-space-around v-if="errorExists()">
            <v-flex xs12 sm10 md8 lg6 xl4>
                <alert-component :messages="SubCategoriesObj.LevelUpErrors.id" type="error"/>
                <alert-component :messages="SubCategoriesObj.LevelDownErrors.id" type="error"/>
                <alert-component :messages="SubCategoriesObj.UpdateSubCategoriesErrors.id" type="error"/>
            </v-flex>
        </v-layout>

        <!-- Progress circular -->
        <progress-circular v-if="SubCategoriesObj.isRequestInProgress"/>
    </v-container>
</template>
<script>
	import AlertComponent           from "../../../components/alert-component";
	import ErrorCaptionList         from "../../../components/error-caption-list";
	import ProgressCircular         from "../../../components/progress-circular";
	import AddSubCategoryDialogForm from "./components/add-sub-category-dialog-form";
	import SelectCategory           from "./components/select-category";
	import SubCategoriesList        from "./components/sub-categories-list";
	import SubCategories            from './SubCategories';

	export default {
		components: {
			AlertComponent,
			ProgressCircular,
			ErrorCaptionList,
			AddSubCategoryDialogForm,
			SubCategoriesList,
			SelectCategory},
		data() {
			return {
				SubCategoriesObj: new SubCategories()
			}
		},
		methods   : {
			errorExists () {
				return !!this.SubCategoriesObj.UpdateSubCategoriesErrors.id.length
					|| !!this.SubCategoriesObj.LevelUpErrors.id.length
					|| !!this.SubCategoriesObj.LevelDownErrors.id.length;
			},
		},
	}
</script>  