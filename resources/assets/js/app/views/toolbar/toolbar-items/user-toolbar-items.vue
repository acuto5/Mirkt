<template>
    <v-menu>
        <!-- Icon and user nickname -->
        <v-btn slot="activator" flat>
            <v-icon left>account_circle</v-icon>
            <span class="blue--text text--lighten-4">{{User.name}}</span>
            <v-icon dark color="blue lighten-4">arrow_drop_down</v-icon>
        </v-btn>

        <!-- Drop down menu-->
        <v-list class="brown darken-3" dark>

            <!-- Edit profile tile  -->
            <v-list-tile :to="{name: 'user.edit-profile'}">
                <v-list-tile-action>
                    <v-icon>edit</v-icon>
                </v-list-tile-action>
                <v-list-tile-title class="blue--text text--lighten-4" v-text="'Redaguoti profili'"/>
            </v-list-tile>

            <!-- Dashboard tile -->
            <v-list-tile v-if="imGod" :to="{name:'dashboard.articles.all'}">
                <v-list-tile-action>
                    <v-icon>dashboard</v-icon>
                </v-list-tile-action>
                <v-list-tile-title class="blue--text text--lighten-4" v-text="'Valdymo skydelis'"/>
            </v-list-tile>

            <!-- Logout tile -->
            <v-list-tile @click="logout()">
                <v-list-tile-action>
                    <v-icon>exit_to_app</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title class="red--text text--lighten-2" v-text="'Atsijungti'"/>
                </v-list-tile-content>
            </v-list-tile>
        </v-list>
    </v-menu>
</template>

<script>
	export default {
		name: "user-toolbar-items",
		data() {
			return {
				User: window.USER,
				logoutURL: window.URLS.logout,
				FlashMessages: window.FlashMessages
			}
		},
        computed: {
			imGod(){
				return (!!this.User.is_admin || !!this.User.is_moderator);
            }
        },
		methods: {
			logout() {
				FlashMessages.clear();

				axios.post(this.logoutURL)
					.then(response => {
						(response.data) ? window.location.reload() : false;
					})
					.catch(error => {
						console.error(error);
						this.FlashMessages.setError(error.response.data.message);
					});
			},
		}
	}
</script>