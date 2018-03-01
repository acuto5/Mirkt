<template>
    <v-container>
        <v-layout row wrap>
            <v-flex xs12 sm10>
                <div v-html="contacts.content"></div>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
	export default {
		data () {
			return {
				contacts           : { content: '' },
				isRequestInProgress: true,
				getContactsURL     : window.URLS.getContacts,
			};
		},
		mounted () {
			this.getContacts();
		},
		methods: {
			getContacts () {
				this.isRequestInProgress = true;

				axios.get( this.getContactsURL )
					 .then( response => {
						 this.contacts = response.data;
						 this.isRequestInProgress = false;
					 } )
					 .catch( error => {
						 window.FlashMessages.setError( error.response.data.message );
						 this.isRequestInProgress = false;
					 } );
			},
		},
	};
</script>