<template>
    <v-app>
        <toolbar/>
        <v-content>
            <router-view/>
            <dashboard-menu/>
        </v-content>
    </v-app>
</template>

<script>
    import Toolbar from "../toolbar/index";
	import DashboardMenu from "../dashboard/menu/index";

	export default{
		components: {
			DashboardMenu,
			Toolbar}
	}
</script>