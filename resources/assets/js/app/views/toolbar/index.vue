<template>
    <v-toolbar dark color="brown darken-4" app dense fixed clipped-left>
        <v-toolbar-side-icon v-if="inMainLayout" @click.native="toggleDashboardMenu()"/>
        <v-toolbar-title>
            <router-link :to="{name: 'home'}" class="blue--text text--lighten-4">Mirkt</router-link>
        </v-toolbar-title>

        <v-spacer/>

        <!-- If user is logged in -->
        <user-toolbar-items v-if="User.id"/>

        <!-- If user not logged in -->
        <guest-toolbar-items v-else/>
    </v-toolbar>
</template>
<script>
	import UserToolbarItems from "./toolbar-items/user-toolbar-items";
	import GuestToolbarItems from "./toolbar-items/guest-toolbar-items";

	export default {
		name: 'toolbar',
		components: {
			GuestToolbarItems,
			UserToolbarItems
		},
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
			toggleDashboardMenu(){
				this.$emit('input', !this.value);
            }
        }

	}
</script>  