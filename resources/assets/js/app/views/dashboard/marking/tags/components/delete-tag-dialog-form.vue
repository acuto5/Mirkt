<template>
    <v-dialog v-model="isDialogVisible" class="brown darken-3" max-width="400px">
        <!-- Activator -->
        <v-btn icon outline slot="activator" color="error">
            <v-icon>delete_forever</v-icon>
        </v-btn>

        <v-card>

            <!-- Title -->
            <v-card-title class="red accent-2" v-text="'Dėmesio!'"/>

            <!-- Content -->
            <v-card-text>
                Tikrai trinti: <b>{{tag.name}}</b>?<br/>
                Bus ištrinta negryštamai!
            </v-card-text>

            <!-- Buttons -->
            <v-card-actions>
                <v-btn flat class="red--text text--accent-2" @click="deleteTag()" :loading="isLoading">Trinti negryštamai</v-btn>
                <v-btn flat @click="isDialogVisible = false" :loading="isLoading">Atgal</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
	export default{
		name: 'delete-tag-dialog-form',
		props: {
			tag: {
				type: Object,
                required: true
            },
			TagsObj:{
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
			async deleteTag(){
				this.isLoading = true;

				this.isDialogVisible = ! await this.TagsObj.deleteTag(this.tag);

				if(!this.isDialogVisible){

                }

				this.isLoading = false;
            }
        }
	}
</script>  