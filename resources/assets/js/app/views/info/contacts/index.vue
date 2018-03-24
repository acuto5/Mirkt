<template>
    <v-container>
        <v-layout row wrap v-show="!isRequestInProgress">
            <!-- Content -->
            <v-flex xs12 sm10>
                <div v-html="contacts.content"></div>
            </v-flex>

            <!-- Edit button link -->
            <v-flex xs12 v-if="isSuperAdmin()">
                <v-btn flat icon color="warning" :to="linkToEditContacts">
                    <v-icon>edit</v-icon>
                </v-btn>
            </v-flex>
        </v-layout>

        <!-- Progress circular -->
        <progress-circular v-if="isRequestInProgress"/>
    </v-container>
</template>

<script>
	import ProgressCircular from "../../../components/progress-circular";

	export default {
		name: 'contacts',
		components: { ProgressCircular },
		data () {
			return {
				isRequestInProgress: true,
				User               : window.USER,
				contacts           : { content: '' },
				getContactsURL     : window.URLS.getContacts,
				linkToEditContacts : { name: 'dashboard.info.contacts' },
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
			isSuperAdmin () {
				return !!this.User.is_super_admin;
			},
		},
	};
</script>