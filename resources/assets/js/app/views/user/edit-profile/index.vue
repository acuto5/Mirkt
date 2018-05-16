<template>
    <v-container>
        <v-layout row wrap>
            <v-flex d-flex xs12 sm8 offset-sm2 md6 offset-md3 class="text-xs-center">
                <v-alert :value="isUserCanBeUpdated" type="error">
                    admin@mirkt.lt ir moderator@mirkt.lt vartotojai negali redaguoti savo profilio
                </v-alert>
            </v-flex>
            <v-flex d-flex xs12 sm8 offset-sm2 md6 offset-md3 class="text-xs-center">
                <v-form @submit.prevent="updateProfile()">
                    <v-text-field
                            autofocus
                            type="email"
                            label="El. Paštas"
                            color="teal accent-2"
                            v-model="inputs.email"
                            :disabled="isUserCanBeUpdated"
                            :error-messages="Errors.email"
                    />
                    <v-text-field
                            type="password"
                            color="teal accent-2"
                            v-model="inputs.password"
                            :disabled="isUserCanBeUpdated"
                            label="Dabartinis slaptažodis"
                            :error-messages="Errors.password"
                    />
                    <v-text-field
                            type="password"
                            color="teal accent-2"
                            label="Naujas slaptažodis"
                            v-model="inputs.new_password"
                            :disabled="isUserCanBeUpdated"
                            :error-messages="Errors.new_password"
                    />
                    <v-text-field
                            type="password"
                            color="teal accent-2"
                            :disabled="isUserCanBeUpdated"
                            label="Pakartokite naują slaptažodį"
                            v-model="inputs.new_password_confirmation"
                            :error-messages="Errors.new_password_confirmation"
                    />
                    <v-checkbox
                            label="Adminas"
                            v-model="inputs.is_admin"
                            :disabled="isUserCanBeUpdated"
                            :error-messages="Errors.is_admin"
                    />
                    <v-checkbox
                            label="Moderatorius"
                            v-model="inputs.is_moderator"
                            :disabled="isUserCanBeUpdated"
                            :error-messages="Errors.is_moderator"
                    />
                    <v-btn
                            outline
                            type="submit"
                            color="warning"
                            :disabled="isUserCanBeUpdated"
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
		name: 'edit-profile',
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
				updateUserProfileURL: window.URLS.updateUserProfile,
			}
		},
        mounted(){
			this.redirectIfGuest();
        },
        computed: {
            isUserCanBeUpdated(){
                let name = this.User.name.toLowerCase();

                return (name === 'admin' || name === 'moderator');
            }
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