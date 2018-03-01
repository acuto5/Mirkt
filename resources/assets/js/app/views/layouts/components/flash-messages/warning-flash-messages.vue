<template>
    <v-snackbar bottom color="warning" :timeout="6000" v-model="showMessage">
        {{ message }}
        <v-btn flat @click.native="removeWarning()">
            <v-icon class="title">close</v-icon>
        </v-btn>
    </v-snackbar>
</template>

<script>
	export default {
		name   : "warning-flash-messages",
		data () {
			return {
				message      : '',
				showMessage  : false,
				FlashMessages: window.FlashMessages,

			};
		},
		mounted () {
			this.message = this.FlashMessages.warning || '';
			this.showMessage = !!this.message.length;
		},
		watch  : {
			'FlashMessages.warning' ( newMessage ) {
				if(newMessage){
					this.message = newMessage;
				}

				this.showMessage = !!newMessage;
			},
			showMessage(boolean){
				if(!boolean){
					this.FlashMessages.removeWarning();
				}
			}
		},
		methods: {
			removeWarning () {
				this.FlashMessages.removeWarning();
			},
		},
	};
</script>