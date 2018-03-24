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
	import FlashMessages from "../flash-messages/flash-messages.vue";
	import MainFooter    from "../footer/main-footer";
	import Toolbar       from "../toolbar/index";

	export default {
		components: {
			FlashMessages,
			Toolbar,
			MainFooter,
		},
		name      : "layout",
	}
</script>