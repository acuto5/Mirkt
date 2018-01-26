<template>
    <v-list dark class="brown darken-3">
        <v-list-tile>
            <v-list-tile-content>
                <v-select
                        dark
                        single-line
                        label="Kategorija"
                        item-value="id"
                        item-text="name"
                        v-model="SubCategoriesObj.selectedCategoryID"
                        :items="SubCategoriesObj.categories"
                />
            </v-list-tile-content>
        </v-list-tile>
    </v-list>

</template>

<script>
	export default {
		name: "select-category",
        props: {
			SubCategoriesObj :{
				type: Object,
                required: true
            }
        },
        watch: {
			'SubCategoriesObj.selectedCategoryID': function () {
				this.SubCategoriesObj.updateSubCategoriesList();
			}
        },
		created() {
			this.SubCategoriesObj.getCategories();
		}
	}
</script>

<style scoped>

</style>