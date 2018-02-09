<template>
    <v-dialog v-model="isDialogVisible" max-width="400px">
        <v-btn slot="activator" outline icon color="error">
            <v-icon>delete_forever</v-icon>
        </v-btn>
        <v-card>
            <v-form @submit.prevent="deleteSubCategory()">
                <!-- Title -->
                <v-card-title class="red accent-3 title" v-text="'Dėmesio!'"/>

                <!-- Content -->
                <v-card-text>
                    Tikrai trinti: <b>{{SubCategory.name}}</b><br/>
                    Bus ištrinta negryštamai!
                    <error-caption-list :error-messages="SubCategoriesObj.DeleteSubCategoryErrors.id"/>
                </v-card-text>

                <!-- Action buttons -->
                <v-card-actions>
                    <!-- Submit -->
                    <v-btn flat color="error" type="submit" :loading="isLoading">
                        Trinti visam laikui
                    </v-btn>
                    <!-- Close dialog -->
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
		name: "delete-sub-category-dialog-form",
		props: {
			SubCategory: {
				type: Object,
				required: true
			},
			SubCategoriesObj: {
				type: Object,
				required: true
			}
		},
		data() {
			return {
				isLoading: false,
				isDialogVisible: false
			}
		},
		methods: {
			async deleteSubCategory() {
				this.isLoading = true;

				this.isDialogVisible = !await this.SubCategoriesObj.deleteSubCategory(this.SubCategory.id);

				this.isLoading = false;
			}
		}
	}
</script>