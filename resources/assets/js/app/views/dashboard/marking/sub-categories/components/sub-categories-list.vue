<template>
    <v-list v-show="SubCategoriesObj.selectedCategoryID > 0">
        <template v-for="(SubCategory,index) in SubCategoriesObj.subCategories">
            <v-divider v-if="parseInt(index) > 0"/>
            <v-list-tile @click="" :key="SubCategory.id">

                <v-list-tile-content>
                    <!-- SubCategory name -->
                    <v-list-tile-title
                            v-text="SubCategory.name"
                    />
                </v-list-tile-content>

                <!-- Level up-->
                <v-list-tile-action>
                    <v-btn icon flat @click.native="SubCategoriesObj.levelUpSubCategory(SubCategory.id)" v-show="index !== 0">
                        <v-icon>keyboard_arrow_up</v-icon>
                    </v-btn>
                </v-list-tile-action>

                <!-- Level down -->
                <v-list-tile-action>
                    <v-btn icon flat @click.native="SubCategoriesObj.levelDownSubCategory(SubCategory.id)" v-show="SubCategoriesObj.subCategories.length !== index+1">
                        <v-icon>keyboard_arrow_down</v-icon>
                    </v-btn>
                </v-list-tile-action>

                <!-- Edit sub-category -->
                <v-list-tile-action>
                    <edit-sub-category-dialog-form :sub-categories-obj="SubCategoriesObj" :sub-category="SubCategory"/>
                </v-list-tile-action>

                <!-- Delete sub-category -->
                <v-list-tile-action>
                    <delete-sub-category-dialog-form :sub-categories-obj="SubCategoriesObj" :sub-category="SubCategory"/>
                </v-list-tile-action>
            </v-list-tile>
        </template>
    </v-list>
</template>

<script>
	import EditSubCategoryDialogForm from "./edit-sub-category-dialog-form";
	import DeleteSubCategoryDialogForm from "./delete-sub-category-dialog-form";

	export default {
		components: {
			DeleteSubCategoryDialogForm,
			EditSubCategoryDialogForm},
		name: "sub-categories-list",
        props: {
			SubCategoriesObj: {
				type: Object,
                required: true
            }
        }
	}
</script>