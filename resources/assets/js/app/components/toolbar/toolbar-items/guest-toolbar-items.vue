<template>
    <v-toolbar-items class="ml-2">
        <!-- Login dialog-->
        <v-btn flat @click.native="isLoginDialogVisible = true">Prisijungti</v-btn>
        <login-form-dialog v-model="isLoginDialogVisible"/>

        <!-- Register dialog -->
        <v-btn flat @click.native="isRegistrationDialogVisible = true">Registracija</v-btn>
        <register-form-dialog v-model="isRegistrationDialogVisible"/>
    </v-toolbar-items>
</template>

<script>
	import LoginFormDialog    from "./dialogs/login-form-dialog";
	import RegisterFormDialog from "./dialogs/register-form-dialog";

	export default {
		name: "guest-toolbar-items",
		components: { RegisterFormDialog, LoginFormDialog },
		data(){
			return{
				isLoginDialogVisible: false,
				isRegistrationDialogVisible: false
            }
        }
	}
</script>