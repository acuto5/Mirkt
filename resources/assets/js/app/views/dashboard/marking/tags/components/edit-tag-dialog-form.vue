<template>
    <v-dialog v-model="isDialogVisible" max-width="400px">
        <!-- Activator button -->
        <v-btn slot="activator" icon outline color="warning">
            <v-icon>edit</v-icon>
        </v-btn>
        <v-card>
            <v-form  @submit.prevent="editTag()">

                <!-- Title -->
                <v-card-title class="title warning" v-text="'Redaguoti: ' + tag.name"/>

                <!-- Content -->
                <v-card-text>
                    <v-text-field
                            label="Pavadinimas"
                            v-model="tempTag.name"
                            color="teal accent-2"
                            :error-messages="TagsObj.EditErrors.name"
                    />
                    <error-caption-list :error-messages="TagsObj.EditErrors.id"/>
                </v-card-text>

                <!-- Buttons -->
                <v-card-actions>
                    <v-btn flat color="warning" type="submit" :loading="isLoading">Atnaujinti</v-btn>
                    <v-btn flat  @click="isDialogVisible = false" :loading="isLoading">Atgal</v-btn>
                </v-card-actions>
            </v-form>
        </v-card>
    </v-dialog>
</template>
<script>
	import ErrorCaptionList from "../../../../../components/errors/error-caption-list";

	export default {
		components: {ErrorCaptionList},
		name: 'edit-tag-dialog-form',
		props: {
			tag: {
				type: Object,
				required: true
			},
			TagsObj: {
				type: Object,
				required: true
			}
		},
		data() {
			return {
				tempTag: {},
				isLoading: false,
				isDialogVisible: false
			}
		},
        watch: {
			isDialogVisible(isVisible){
				if(isVisible){
					this.tempTag = Object.assign({}, this.tag);
                }
            }
        },
        methods: {
			async editTag(){
				this.isLoading = true;

                this.isDialogVisible = ! await this.TagsObj.editTag(this.tempTag);

                this.isLoading = false;
            }
        }
	}
</script>  