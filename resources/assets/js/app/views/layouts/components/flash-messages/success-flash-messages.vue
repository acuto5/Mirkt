<template>
    <v-snackbar bottom color="success" :timeout="6000" v-model="showMessage">
        {{ message }}
        <v-btn flat icon small @click.native="removeSuccess()">
            <v-icon class="title">close</v-icon>
        </v-btn>
    </v-snackbar>
</template>

<script>
	export default {
		name   : "success-flash-messages",
		data () {
			return {
				message      : '',
				showMessage  : false,
				FlashMessages: window.FlashMessages,

			};
		},
		mounted () {
			this.message = this.FlashMessages.success || '';
			this.showMessage = !!this.message.length;
		},
		watch  : {
			'FlashMessages.success' ( newMessage ) {
				if(newMessage){
					this.message = newMessage;
				}

				this.showMessage = !!newMessage;
			},
			showMessage(boolean){
				if(!boolean){
					this.FlashMessages.removeSuccess();
				}
			}
		},
		methods: {
			removeSuccess () {
				this.FlashMessages.removeSuccess();
			},
		},
	};
</script>