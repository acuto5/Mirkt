<template>
    <v-app>
        <toolbar/>
        <v-content>
            <router-view />
        </v-content>
        <main-footer/>
    </v-app>
</template>

<script>
	import MainFooter from "./footer";
	import Toolbar from "../../toolbar/index";

	export default {
		components: {Toolbar, MainFooter},
		name: "layout"
	}
</script>