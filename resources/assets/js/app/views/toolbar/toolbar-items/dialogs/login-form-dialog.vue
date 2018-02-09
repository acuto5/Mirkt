<template>
    <v-dialog v-model="isVisible" persistent max-width="600px">
        <!-- Dialog content-->
        <v-card dark>
            <v-form @submit.prevent="login()">
                <v-card-title>
                <span class="headline">
                    Prisijungti
                </span>
                </v-card-title>
                <v-card-text>
                    <v-text-field
                            required
                            type="email"
                            label="El. Paštas"
                            color="teal accent-2"
                            v-model="inputs.email"
                            :error-messages="Errors.email"
                    />
                    <v-text-field
                            required
                            type="password"
                            label="Slaptažodis"
                            color="teal accent-2"
                            v-model="inputs.password"
                            :error-messages="Errors.password"/>
                    <v-checkbox
                            label="Prisiminti"
                            input-value="true"
                            color="teal accent-2"
                            v-model="inputs.remember"/>
                </v-card-text>
                <v-card-actions>
                    <v-btn dark rised outline color="teal accent-2" type="submit">Prisijungti</v-btn>
                    <v-btn rised outline @click.native="hideMe()">Atgal</v-btn>
                </v-card-actions>
            </v-form>
        </v-card>
    </v-dialog>
</template>

<script>
	export default {
		name: "login-form-dialog",
        props: {
			value: Boolean
        },
		data() {
			return {
				inputs: {},
				isVisible: false,
				loginURL: window.URLS.login,
				Errors: new window.Errors({remember: [], password: [], email: [], message: ''})
			}
		},
        watch: {
			value(newValue){
				this.isVisible = newValue;
            }
        },
		methods: {
			login: function () {
				if (!this.loginURL) {
					console.error("<login-modal> method::login():: loginURL is not set.");
					return false;
				}
				axios.post(this.loginURL, this.inputs)
					.then(response => (response.data) ? window.location.reload() : false)
					.catch(error => this.Errors.setLarevelErrors(error));
			},
			hideMe: function () {
				this.inputs = {};
				this.Errors.clear();
				this.$emit('input', false);
			}
		}
	}
</script>