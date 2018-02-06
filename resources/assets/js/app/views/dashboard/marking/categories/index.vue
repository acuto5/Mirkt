<template>
    <v-container fluid>
        <v-layout row wrap justify-space-around>
            <v-flex d-flex xs12 sm10>
                <categories-table
                        :categories-obj="CategoriesObj"
                        v-show="!CategoriesObj.isRequestInProgress"
                />
                <v-progress-circular
                        fill
                        indeterminate
                        color="brown darken-3"
                        :width="4"
                        :size="50"
                        v-if="CategoriesObj.isRequestInProgress"
                />
            </v-flex>
            <v-flex d-flex xs10 sm8 md6 lg4>
                <add-category-form-dialog :categories-obj="CategoriesObj" v-show="!CategoriesObj.isRequestInProgress"/>
            </v-flex>
        </v-layout>
    </v-container>
    <!--<div>-->
        <!--<help-list type="danger" :messages="CategoriesObj.LevelUpErrors.id"></help-list>-->
        <!--<help-list type="danger" :messages="CategoriesObj.LevelDownErrors.id"></help-list>-->

        <!--<categories-table :CategoriesObj="CategoriesObj"></categories-table>-->

        <!--<hr/>-->

        <!--<add-category-form :CategoriesObj="CategoriesObj"></add-category-form>-->

        <!--<edit-category-modal-form :CategoriesObj="CategoriesObj"></edit-category-modal-form>-->

        <!--<delete-category-modal-form :CategoriesObj="CategoriesObj"></delete-category-modal-form>-->
    <!--</div>-->
</template>
<script>
	import Categories from './Categories';
	import CategoriesTable from "./components/categories-table";
	import AddCategoryFormDialog from "./components/add-category-form-dialog";

	export default{
		components: {
			AddCategoryFormDialog,
			CategoriesTable},
		data(){
			return {
				CategoriesObj: new Categories()
			}
		}
	}
</script>  