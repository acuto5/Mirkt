<template>
    <v-list-tile-action>
        <v-dialog v-model="isDialogVisible" max-width="400px">
            <v-btn slot="activator" outline icon color="warning">
                <v-icon>edit</v-icon>
            </v-btn>
            <v-card>
                <!-- Title -->
                <v-card-title class="title warning" v-text="'Redaguoti kategoriją: ' + category.name"/>
                <v-form @submit.prevent="editCategory()">
                    <!-- id error -->
                    <template v-for="error in CategoriesObj.EditCategoryErrors.id">
                        <p class="body-2 error--text ml-1" v-text="error"></p>
                    </template>

                    <!-- Form -->
                    <v-card-text>
                        <v-text-field
                                label="Pavadinimas"
                                v-model="tempCategory.name"
                                :error-messages="CategoriesObj.EditCategoryErrors.name"
                        />
                    </v-card-text>

                    <!-- Submit action -->
                    <v-card-actions>
                        <v-btn type="submit" flat color="warning" :loading="isLoading">
                            Atnaujinti
                        </v-btn>
                    </v-card-actions>
                </v-form>
            </v-card>
        </v-dialog>
    </v-list-tile-action>
</template>

<script>
	export default {
		name: "categories-list-tile-action-edit-dialog",
		props: {
			category: {
				type: Object,
				required: true
			},
			CategoriesObj: {
				type: Object,
				required: true
			}
		},
		data() {
			return {
				isLoading: false,
				isDialogVisible: false,
				tempCategory: Object.assign({}, this.category)
			}
		},
		watch: {
			isDialogVisible(newValue) {
				// if dialog reopened, update category name
				if (!newValue) {
					this.tempCategory = Object.assign({}, this.category);
				}
			}
		},
		methods: {
			async editCategory() {
				this.isLoading = true;

				let isSuccess = await this.CategoriesObj.editCategory(this.tempCategory);

				this.isDialogVisible = !isSuccess;

				this.isLoading = false;
			}
		}
	}
</script>