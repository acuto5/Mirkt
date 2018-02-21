<template>
    <v-container>
        <v-layout row wrap v-show="!CategoriesObj.isRequestInProgress">
            <!-- Title -->
            <v-flex xs12 mb-2 class="text-xs-center">
                <h2 class="headline">Kategorijos</h2>
            </v-flex>

            <!-- Categories table -->
            <v-flex xs12 sm10 offset-sm1 md8 offset-md2 lg6 offset-lg3 v-show="CategoriesObj.Categories.length">
                <categories-table :categories-obj="CategoriesObj"/>
            </v-flex>

            <!-- Add category dialog form -->
            <v-flex d-flex xs12 sm8 offset-sm2 md6 offset-md3 lg4 offset-lg4>
                <add-category-form-dialog :categories-obj="CategoriesObj"/>
            </v-flex>
        </v-layout>

        <!-- Errors -->
        <v-layout row wrap justify-space-around v-if="errorExists">
            <v-flex xs12 sm10 md8 lg6 xl4>
                <alert-component :messages="CategoriesObj.LevelUpErrors.id" type="error"/>
                <alert-component :messages="CategoriesObj.LevelDownErrors.id" type="error"/>
            </v-flex>
        </v-layout>

        <!-- Progress circular -->
        <progress-circular v-if="CategoriesObj.isRequestInProgress"/>
    </v-container>
</template>
<script>
	import AlertComponent        from "../../../components/alert-component";
	import ProgressCircular      from "../../../components/progress-circular";
	import Categories            from './Categories';
	import AddCategoryFormDialog from "./components/add-category-form-dialog";
	import CategoriesTable       from "./components/categories-table";

	export default{
		components: {
			ProgressCircular,
			AlertComponent,
			AddCategoryFormDialog,
			CategoriesTable},
		data(){
			return {
				CategoriesObj: new Categories()
			}
		},
	}
</script>  