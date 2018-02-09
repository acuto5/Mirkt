<template>
    <v-dialog v-model="isVisible" max-width="500px" persistent>
        <v-card dark>
            <v-form @submit.prevent="register()">
                <v-card-title>
                    <span class="headline">Registracija</span>
                </v-card-title>
                <v-card-text>
                    <v-text-field
                            required
                            type="text"
                            label="Vardas"
                            color="teal accent-2"
                            v-model="inputs.name"
                            :error-messages="Errors.name"/>
                    <v-text-field
                            required
                            type="email"
                            label="El. Paštas"
                            color="teal accent-2"
                            v-model="inputs.email"
                            :error-messages="Errors.email"/>
                    <v-text-field
                            required
                            type="password"
                            label="Slaptažodis"
                            color="teal accent-2"
                            v-model="inputs.password"
                            :error-messages="Errors.password"/>
                    <v-text-field
                            required
                            type="password"
                            color="teal accent-2"
                            label="Pakartokite Slaptažodis"
                            v-model="inputs.password_confirmation"
                            :error-messages="Errors.password_confirmation"/>
                </v-card-text>
                <v-card-actions>
                    <v-btn rised outline color="teal accent-2" type="submit">Registruotis</v-btn>
                    <v-btn rised outline @click.native="hideMe()">Atgal</v-btn>
                </v-card-actions>
            </v-form>
        </v-card>
    </v-dialog>
</template>

<script>
	export default {
		name: "register-form-dialog",
		props: {
			value: Boolean
		},
		data() {
			return {
				inputs: {},
				isVisible: false,
				registerURL: window.URLS.register,
				Errors: new window.Errors({name: [], message: '', password_confirmation: [], password: [], email: []})
			}
		},
		watch: {
			value(newValue){
				this.isVisible = newValue;
            }
        },
		methods: {
			register: function () {
				axios.post(this.registerURL, this.inputs)
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