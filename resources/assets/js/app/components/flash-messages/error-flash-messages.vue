<template>
    <v-snackbar bottom color="error" :timeout="6000" v-model="showMessage">
        {{ message }}
        <v-btn flat @click.native="removeError()">
            <v-icon class="title">close</v-icon>
        </v-btn>
    </v-snackbar>
</template>

<script>
	export default {
		name   : "error-flash-messages",
		data () {
			return {
				message      : '',
				showMessage  : false,
				FlashMessages: window.FlashMessages,

			};
		},
		mounted () {
			this.message = this.FlashMessages.error || '';
			this.showMessage = !!this.message.length;
		},
		watch  : {
			'FlashMessages.error' ( newMessage ) {
				if(newMessage){
					this.message = newMessage;
                }

				this.showMessage = !!newMessage;
			},
            showMessage(boolean){
				if(!boolean){
					this.FlashMessages.removeError();
				}
            }
		},
		methods: {
			removeError () {
				this.FlashMessages.removeError();
			},
		},
	};
</script>