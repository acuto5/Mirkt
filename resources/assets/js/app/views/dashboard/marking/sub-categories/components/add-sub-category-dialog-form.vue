<template>
    <v-dialog v-model="isDialogVisible" max-width="400px">
        <!-- Activator -->
        <v-btn outline color="success" block slot="activator">
            <v-icon class="subheading">add</v-icon>
            Pridėti
        </v-btn>
        <v-card>
            <v-form @submit.prevent="addSubCategory()">
                <!-- Dialog title -->
                <v-card-title class="success title" v-text="'Pridėti naują sub-kategoriją'"/>

                <!-- New sub-category name input -->
                <v-card-text>
                    <v-text-field
                            label="Pavadinimas"
                            v-model="input"
                            color="teal accent-2"
                            :error-messages="SubCategoriesObj.AddSubCategoryErrors.name"
                    />

                    <!-- Other errors -->
                    <error-caption-list :error-messages="SubCategoriesObj.AddSubCategoryErrors.category_id"/>
                </v-card-text>
                <v-card-actions>
                    <v-btn flat color="success" type="submit" :loading="isLoading">Pridėti</v-btn>
                    <v-btn flat @click="isDialogVisible = false" :loading="isLoading">Atgal</v-btn>
                </v-card-actions>
            </v-form>
        </v-card>
    </v-dialog>
</template>

<script>
	import ErrorCaptionList from "../../../../components/error-caption-list";

	export default {
		components: {ErrorCaptionList},
		name: "add-sub-category-dialog-form",
		props: {
			SubCategoriesObj: {
				type: Object,
				required: true
			}
		},
		data() {
			return {
				input: '',
				isLoading: false,
				isDialogVisible: false
			}
		},
        watch: {
			isDialogVisible(isVisible){
				// if dialog reopened, clean input
				if(isVisible){
					this.input = '';
                }
            }
        },
        methods: {
			async addSubCategory(){
				this.isLoading = true;

				this.isDialogVisible = ! await this.SubCategoriesObj.addSubCategory(this.input);

				this.isLoading = false;
			}
        }
	}
</script>