<template>
    <v-app dark>
        <toolbar v-model="isDashboardMenuVisible" in-dashboard-layout/>
        <v-content>
            <flash-messages/>
            <router-view/>
            <dashboard-menu v-model="isDashboardMenuVisible"/>
        </v-content>
    </v-app>
</template>

<script>
	import DashboardMenu from "../dashboard/dashboard-menu";
	import FlashMessages from "../flash-messages/flash-messages.vue";
	import Toolbar       from "../toolbar/index";

	export default{
		name      : 'dashboard-layout',
		components: {
			FlashMessages,
			DashboardMenu,
			Toolbar,
		},
        data(){
			return{
				isDashboardMenuVisible: false
            }
        }
	}
</script>