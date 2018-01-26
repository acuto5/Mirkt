<template>
    <v-container>
        <v-layout row wrap justify-space-around>
            <v-flex d-flex xs12 sm8 md6 class="text-xs-center">
                <v-form @submit.prevent="updateProfile()">
                    <v-text-field
                            autofocus
                            type="email"
                            label="El. Paštas"
                            v-model="inputs.email"
                            :error-messages="Errors.email"

                    />
                    <v-text-field
                            type="password"
                            v-model="inputs.password"
                            label="Dabartinis slaptažodis"
                            :error-messages="Errors.password"
                    />
                    <v-text-field
                            type="password"
                            label="Naujas slaptažodis"
                            v-model="inputs.new_password"
                            :error-messages="Errors.new_password"
                    />
                    <v-text-field
                            type="password"
                            label="Pakartokite naują slaptažodį"
                            v-model="inputs.new_password_confirmation"
                            :error-messages="Errors.new_password_confirmation"
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
				FlashMessages: window.FlashMessages,
				inputs: {email: window.USER.email}, // From blade template
				Errors: new window.Errors({
					email: [],
					password: [],
					new_password: [],
					new_password_confirmation: [],
				}),
				updateUserProfileURL: window.URLS.updateUserProfile
			}
		},
		methods: {
			updateProfile: function () {
				this.Errors.clear();

				axios.patch(this.updateUserProfileURL, this.inputs)
					.then(response => this.successUpdateProfile())
					.catch(error => {
						this.FlashMessages.setError(error.response.data.message);
						this.Errors.setLarevelErrors(error);
					});
			},
			successUpdateProfile: function () {
				this.FlashMessages.setSuccess('Atnaujinta. Prisijunkite iš naujo.');

				// Go to home page
				this.$router.push({name: 'home'});

				// Reload page(user now is logout)
				window.location.reload();
			}
		}
	}
</script>  