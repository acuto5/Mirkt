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
    <!--<div>-->
        <!--<message type="primary" :alwaysVisible="true" v-for="category in CategoriesObj.categories" :key="category.id"-->
                 <!--:hasCloseButton="false">-->
            <!--<template slot="body">-->
                <!--<span class="title is-6" v-text="category.name"></span>-->
                <!--<div class="is-pulled-right">-->
                <!--<span class="button icon" title="Pakelti" @click="CategoriesObj.levelUpCategory(category.id)">-->
                    <!--<i class="fa fa-arrow-up"></i>-->
                <!--</span>-->
                    <!--<span class="is-static icon" title="Pozicija" v-text="category.level"></span>-->
                    <!--<span class="button icon" title="Nuleisti" @click="CategoriesObj.levelDownCategory(category.id)">-->
                    <!--<i class="fa fa-arrow-down"></i>-->
                <!--</span>-->
                    <!--<span class="button icon has-text-warning" title="Redaguoti"-->
                          <!--@click="CategoriesObj.showEditCategoryModal(category)">-->
                    <!--<i class="fa fa-edit is-warning"></i>-->
                <!--</span>-->
                    <!--<span class="button icon has-text-danger" title="Trinti"-->
                          <!--@click="CategoriesObj.showDeleteCategoryModal(category)">-->
                    <!--<i class="fa fa-trash"></i>-->
                <!--</span>-->
                <!--</div>-->
            <!--</template>-->
        <!--</message>-->
    <!--</div>-->
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