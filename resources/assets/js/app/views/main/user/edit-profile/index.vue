<template>
    <v-container>
        <v-layout row wrap justify-space-around>
            <v-flex d-flex xs12 sm8 md6 class="text-xs-center">
                <v-form @submit.prevent="updateProfile()">
                    <v-text-field
                            autofocus
                            type="email"
                            label="El. Paštas"
                            color="teal accent-2"
                            v-model="inputs.email"
                            :error-messages="Errors.email"

                    />
                    <v-text-field
                            type="password"
                            color="teal accent-2"
                            v-model="inputs.password"
                            label="Dabartinis slaptažodis"
                            :error-messages="Errors.password"
                    />
                    <v-text-field
                            type="password"
                            color="teal accent-2"
                            label="Naujas slaptažodis"
                            v-model="inputs.new_password"
                            :error-messages="Errors.new_password"
                    />
                    <v-text-field
                            type="password"
                            color="teal accent-2"
                            label="Pakartokite naują slaptažodį"
                            v-model="inputs.new_password_confirmation"
                            :error-messages="Errors.new_password_confirmation"
                    />
                    <v-checkbox
                            label="Adminas"
                            v-model="inputs.is_admin"
                            :error-messages="Errors.is_admin"
                    />
                    <v-checkbox
                            label="Moderatorius"
                            v-model="inputs.is_moderator"
                            :error-messages="Errors.is_moderator"
                    />
                    <v-btn
                            outline
                            type="submit"
                            color="warning"
                    >
                        Atnaujinti
                    </v-btn>
                </v-form>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
	export default{
		name: 'editProfile',
		data(){
			return {
				User: window.USER,
				inputs: { // From blade template
					email: window.USER.email,
					is_admin: !!window.USER.is_admin,
					is_moderator: !!window.USER.is_moderator
                },
				Errors: new window.Errors({
					email: [],
					password: [],
					is_admin: [],
					is_moderator: [],
					new_password: [],
					new_password_confirmation: [],
				}),
				updateUserProfileURL: window.URLS.updateUserProfile
			}
		},
        mounted(){
			this.redirectIfGuest();
        },
		methods: {
			updateProfile: function () {
				this.Errors.clear();

				axios.patch(this.updateUserProfileURL, this.inputs)
					.then(response => this.successUpdateProfile())
					.catch(error => {
						this.Errors.setLarevelErrors(error);
					});
			},
			successUpdateProfile: function () {
				window.FlashMessages.setSuccess('Atnaujinta. Prisijunkite iš naujo.');

				// Reload page(user now is logout)
				window.location.reload();
			},
			redirectIfGuest(){
				if(!this.User.id){
					this.$router.push({name: 'home'});
				}
            }
		}
	}
</script>  