<template>
    <v-toolbar-items class="hidden-sm-and-down">
        <!-- Login dialog-->
        <login-form-dialog/>

        <!-- Register dialog -->
        <register-form-dialog/>
    </v-toolbar-items>
</template>

<script>
	import LoginFormDialog from "./dialogs/login-form-dialog";
	import RegisterFormDialog from "./dialogs/register-form-dialog";

	export default {
		components: {
			RegisterFormDialog,
			LoginFormDialog
		},
		name: "guest-toolbar-items"
	}
</script>