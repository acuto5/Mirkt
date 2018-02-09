<template>
    <v-app dark>
        <toolbar v-model="isDashboardMenuVisible" in-main-layout/>
        <v-content>
            <router-view/>
            <dashboard-menu v-model="isDashboardMenuVisible"/>
        </v-content>
    </v-app>
</template>

<script>
    import Toolbar from "../../toolbar/index";
	import DashboardMenu from "../../dashboard/menu/index";

	export default{
		components: { DashboardMenu, Toolbar},
        data(){
			return{
				isDashboardMenuVisible: false
            }
        }
	}
</script>