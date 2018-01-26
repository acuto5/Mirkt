<template>
    <v-dialog v-model="isDialogVisible" max-width="400px">
        <!-- Activator button -->
        <v-btn slot="activator" block color="success">
            <v-icon class="subheading">add</v-icon>
            Pridėti
        </v-btn>

        <v-card>
            <v-form @submit.prevent="addTag()">
                <!-- Title -->
                <v-card-title class="success" v-text="'Pridėti naują žymę'"/>

                <!-- Name -->
                <v-card-text>
                    <v-text-field
                            label="Pavadinimas"
                            v-model="input"
                            :error-messages="TagsObj.AddTagErrors.name"
                    />
                </v-card-text>

                <!-- Submit action -->
                <v-card-actions>
                    <v-btn type="submit" flat :loading="isLoading" color="success">Pridėti</v-btn>
                    <v-btn flat :loading="isLoading" @click="isDialogVisible = false">Atgal</v-btn>
                </v-card-actions>

            </v-form>
        </v-card>
    </v-dialog>
</template>
<script>
	export default{
		name: 'add-tag-dialog-form',
		props: {
			TagsObj: {
				type: Object,
				required: true
			}
		},
        data(){
			return {
				input: '',
				isLoading: false,
                isDialogVisible: false
            }
        },
        watch: {
			isDialogVisible(isVisible){
				// Clean input if dialog reopened
				if(isVisible){
					this.input = '';
                }
            }
        },
        methods: {
			async addTag(){
				this.isLoading = true;

				this.isDialogVisible = ! await this.TagsObj.addTag(this.input);

				this.isLoading = false;
            }
        }
	}
</script>  