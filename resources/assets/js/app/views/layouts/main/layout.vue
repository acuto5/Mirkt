<template>
    <v-app dark>
        <toolbar/>
        <v-content>
            <flash-messages/>
            <router-view />
        </v-content>
        <main-footer/>
    </v-app>
</template>

<script>
	import Toolbar from "../../toolbar/index";
	import FlashMessages from "../components/flash-messages";
	import MainFooter from "./footer";

	export default {
		components: {
			FlashMessages,
			Toolbar,
			MainFooter,
		},
		name      : "layout",
	}
</script>