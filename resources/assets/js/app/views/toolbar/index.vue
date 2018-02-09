<template>
    <v-toolbar dark color="" app dense fixed clipped-left>
        <v-toolbar-side-icon v-if="inMainLayout" @click.native="toggleDashboardMenu()"/>
        <v-toolbar-title>
            <router-link
                    :to="{name: 'home'}"
                    class="hidden-sm-and-down teal--text text--accent-2"
                    style="text-decoration: none;"
            >Mirkt
            </router-link>
            <router-link
                    :to="{name: 'home'}"
                    class="hidden-md-and-up"
                    style="text-decoration: none;"
            >
                <v-icon color="teal accent-2">home</v-icon>
            </router-link>
            <!--<v-btn :to="{name: 'home'}" class="hidden-md-and-up">-->
                <!---->
            <!--</v-btn>-->
        </v-toolbar-title>

        <!-- Links -->
        <links-toolbar-items/>

        <v-spacer/>

        <!-- Search articles -->
        <search-articles-toolbar-items class="hidden-sm-and-down"/>

        <!-- If user is logged in -->
        <user-toolbar-items v-if="User.id"/>

        <!-- If user not logged in -->
        <guest-toolbar-items v-else/>
    </v-toolbar>
</template>
<script>
	import GuestToolbarItems from "./toolbar-items/guest-toolbar-items";
	import LinksToolbarItems from "./toolbar-items/links-toolbar-items";
	import SearchArticlesToolbarItems from "./toolbar-items/search-articles-toolbar-items";
	import UserToolbarItems from "./toolbar-items/user-toolbar-items";

	export default {
		name: 'toolbar',
		components: {SearchArticlesToolbarItems, LinksToolbarItems, GuestToolbarItems, UserToolbarItems},
		props: {
			value: Boolean,
			inMainLayout: Boolean
		},
		data() {
			return {
				User: window.USER,
				isLoginDialogVisible: false,
				isRegisterDialogVisible: false,
			}
		},
		methods: {
			toggleDashboardMenu() {
				this.$emit('input', !this.value);
			}
		}

	}
</script>  