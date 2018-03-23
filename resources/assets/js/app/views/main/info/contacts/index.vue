<template>
    <v-container>
        <v-layout row wrap v-show="!isRequestInProgress">
            <v-flex xs12 sm10>
                <div v-html="contacts.content"></div>
            </v-flex>
        </v-layout>
        <progress-circular v-if="isRequestInProgress"/>
    </v-container>
</template>

<script>
	import ProgressCircular from "../../../components/progress-circular";

	export default {
		components: { ProgressCircular },
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