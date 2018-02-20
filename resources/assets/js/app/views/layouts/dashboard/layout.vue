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
	import DashboardMenu from "../../dashboard/menu/index";
	import Toolbar       from "../../toolbar/index";
	import FlashMessages from "../components/flash-messages";

	export default{
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