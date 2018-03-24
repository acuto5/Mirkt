<template>
    <v-list>
        <template v-for="(Category, index) in CategoriesObj.Categories">
            <v-divider v-if="index >=1"/>
            <v-list-tile :key="Category.id">

                <!-- Category title -->
                <v-list-tile-content>
                    <v-list-tile-title
                            v-text="Category.name"
                    />
                </v-list-tile-content>

                <!-- Level up-->
                <v-list-tile-action>
                    <v-btn icon flat @click.native="CategoriesObj.levelUpCategory(Category.id)" v-show="index !== 0">
                        <v-icon>keyboard_arrow_up</v-icon>
                    </v-btn>
                </v-list-tile-action>

                <!-- Level down -->
                <v-list-tile-action>
                    <v-btn icon flat @click.native="CategoriesObj.levelDownCategory(Category.id)" v-show="CategoriesObj.Categories.length !== index+1">
                        <v-icon>keyboard_arrow_down</v-icon>
                    </v-btn>
                </v-list-tile-action>

                <!-- Edit category dialog -->
                <v-list-tile-action>
                    <categories-list-tile-action-edit-dialog
                            :category="Category"
                            :categories-obj="CategoriesObj"
                    />
                </v-list-tile-action>

                <!-- Delete category dialog -->
                <v-list-tile-action>
                    <categories-list-tile-action-deletion-dialog
                            :id="Category.id"
                            :category-name="Category.name"
                            :categories-obj="CategoriesObj"
                    />
                </v-list-tile-action>
            </v-list-tile>
        </template>
    </v-list>
</template>
<script>
	import CategoriesListTileActionDeletionDialog from "./sub-components/categories-list-tile-action-deletion-dialog";
	import CategoriesListTileActionEditDialog     from "./sub-components/categories-list-tile-action-edit-dialog";

	export default{
		components: {
			CategoriesListTileActionEditDialog,
			CategoriesListTileActionDeletionDialog},
		name: 'CategoriesTable',
		props: {
			CategoriesObj: {
				type: Object,
				required: true
			}
		},
		created(){
			this.CategoriesObj.updateCategoriesList();
		},
        data(){
			return{
				isDialogVisible: false
            }
        }
	}
</script>  