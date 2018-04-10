<template>
    <v-list-tile-action>
        <v-dialog max-width="400px" v-model="isDialogVisible">
            <v-btn
                    icon
                    ripple
                    outline
                    slot="activator"
                    color="grey lighten-1"
                    title="Ištrinti galutinai"
                    :loading="DraftArticlesObj.isButtonsLoadingStyle"
            >
                <v-icon color="error">delete_forever</v-icon>
            </v-btn>
            <v-card>
                <v-card-title  class="red accent-3 title" v-text="'Demesio!'"/>

                <v-card-text >
                    Ar tikrai trinti straipsnį: <b>{{title}}</b>? <br/>
                    Straipsnis bus ištrintas visam laikui!
                </v-card-text>

                <v-card-actions>
                    <v-btn flat color="error" @click.native="deleteArticle()" :loading="isLoading">Trinti visam laikui</v-btn>
                    <v-btn flat @click.native="isDialogVisible = false" :loading="isLoading">Atgal</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </v-list-tile-action>
</template>

<script>
	export default {
		name: "tile-action-delete-article-confirm-dialog",
        props: {
			id: {
				type: Number,
                required: true
            },
			title: {
				type: String,
                required: true
            },
			DraftArticlesObj: {
				type: Object,
                required: true
            }
        },
        data() {
			return{
				isLoading: false,
				isDialogVisible: false
            }
        },
        methods: {
			async deleteArticle(){
				this.isLoading = true;

				this.isDialogVisible = !await this.DraftArticlesObj.deleteArticle(this.id);

				if(!this.isDialogVisible){
					let $_query = Object.assign({}, this.$route.query);

					window.FlashMessages.setWarning('Straipsnis ištrintas.');
					this.DraftArticlesObj.searchArticles($_query);
                }

				this.isLoading = false;
			}
        }
	}
</script>