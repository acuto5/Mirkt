<template>
    <v-toolbar-items>
        <v-menu offset-y class="ml-2">
            <!-- Icon and user nickname -->
            <v-btn icon v-if="$vuetify.breakpoint.mdAndDown" slot="activator">
                <v-icon>menu</v-icon>
            </v-btn>

            <v-btn flat slot="activator" v-else>
                <v-icon  left color="teal accent-2">account_circle</v-icon>
                <span >{{User.name}}</span>
                <v-icon >arrow_drop_down</v-icon>
            </v-btn>

            <!-- Drop down menu-->
            <v-list>
                <!-- Edit profile tile  -->
                <v-list-tile :to="{name: 'user.edit-profile'}" :active-class="activeSubGroupClass">
                    <v-list-tile-action>
                        <v-icon>edit</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-title  v-text="'Redaguoti profili'"/>
                </v-list-tile>

                <!-- Dashboard tile -->
                <v-list-tile v-if="isIAmGod" :to="{name:'dashboard.articles.all'}" :active-class="activeSubGroupClass">
                    <v-list-tile-action>
                        <v-icon>dashboard</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-title v-text="'Valdymo skydelis'"/>
                </v-list-tile>

                <!-- Logout tile -->
                <v-list-tile @click="logout()">
                    <v-list-tile-action>
                        <v-icon>exit_to_app</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title class="red--text text--lighten-1" v-text="'Atsijungti'"/>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-menu>
    </v-toolbar-items>
</template>

<script>
	export default {
		name: "user-toolbar-items",
		data() {
			return {
				User: window.USER,
				logoutURL: window.URLS.logout,
				FlashMessages: window.FlashMessages,
				activeSubGroupClass: 'grey darken-2 teal--text text--accent-2'
			}
		},
        computed: {
			isIAmGod(){
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