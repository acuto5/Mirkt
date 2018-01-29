<template>
    <v-toolbar-items class="ml-3">
        <!-- Articles menu -->
        <v-menu offset-y>
            <v-btn flat slot="activator">Straipsniai</v-btn>
            <v-list>
                <v-list-tile v-for="(page,index) in items" :key="index">
                    <v-list-tile-title>{{page}}</v-list-tile-title>
                </v-list-tile>
            </v-list>
        </v-menu>

        <!-- About me -->
        <v-menu offset-y>
            <v-btn flat slot="activator">Apie mane</v-btn>
            <v-list>
                <!-- Link to GitHub-->
                <v-list-tile :href="linkToMyGitHub">
                    <v-list-tile-title>GitHub</v-list-tile-title>
                </v-list-tile>
                <!-- Contacts -->
                <v-list-tile :to="routerLinkToContactsPage">
                    <v-list-tile-title>Kontaktai</v-list-tile-title>
                </v-list-tile>
            </v-list>
        </v-menu>
    </v-toolbar-items>
</template>

<script>
	export default {
		name: "links-toolbar-items",
		data() {
			return {
				articlesCategories: window.Categories,
				linkToMyGitHub: 'https://github.com/TSmulkys',
				routerLinkToContactsPage: {name: 'contacts'}
            }
		}
	}
</script>