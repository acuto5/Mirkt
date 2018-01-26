<template>
    <v-list-tile-action>
        <v-dialog v-model="isDialogVisible" max-width="300px">

            <!-- Activator -->
            <v-btn slot="activator" outline icon color="error">
                <v-icon>delete_forever</v-icon>
            </v-btn>

            <!-- Dialog content -->
            <v-card light >

                <!-- Title -->
                <v-card-title class="red accent-3 title" v-text="'Dėmesio!'"/>

                <!-- Content -->
                <v-card-text>
                    Tikrai trinti kategoriją: <b>{{categoryName}}</b>
                    <template v-for="error in CategoriesObj.DeleteCategoryErrors.id">
                        <p class="body-2 error--text ml-2" v-text="error"></p>
                    </template>
                </v-card-text>

                <!-- Actions -->
                <v-card-actions>
                    <v-btn flat @click.native="deleteCategory()" color="error" :loading="isLoading">
                        Trinti visam laikui
                    </v-btn>
                    <v-btn flat @click.native="isDialogVisible = false" :loading="isLoading">
                        Atgal
                    </v-btn>
                </v-card-actions>

            </v-card>
        </v-dialog>
    </v-list-tile-action>
</template>

<script>
	export default {
		name: "categories-list-tile-action-deletion-dialog",
        props: {
			id: {
				type: Number,
                required: true
            },
            categoryName: {
				type: String,
                required: true
            },
			CategoriesObj: {
				type: Object,
                required: true
            }
        },
        data(){
			return{
				isLoading: false,
				isDialogVisible: false
            }
        },
        methods: {
			async deleteCategory(){
				this.isLoading = true;

				this.isDialogVisible = ! await this.CategoriesObj.deleteCategory(this.id);

				this.isLoading = false;
			}
        }
	}
</script>