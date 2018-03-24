<template>
    <v-container>
        <v-layout wrap row v-show="!isRequestInProgress">
            <!-- Content-->
            <v-flex xs12 sm10>
                <div v-html="websiteInfo.content"></div>
            </v-flex>

            <!-- Edit button link -->
            <v-flex xs12 v-if="isSuperAdmin()">
                <v-btn flat icon color="warning" :to="linkToEditWebsiteInfo">
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
		name: 'website-info',
		components: { ProgressCircular },
		data () {
			return {
				isRequestInProgress  : false,
				User                 : window.USER,
				websiteInfo          : { content: '' },
				getWebsiteInfoURL    : window.URLS.getWebsiteInfo,
				linkToEditWebsiteInfo: { name: 'dashboard.info.website-info' },
			};
		},
		mounted () {
			this.getWebsiteInfo();
		},
		methods: {
			getWebsiteInfo () {
				this.isRequestInProgress = true;

				axios.get( this.getWebsiteInfoURL )
					 .then( response => {
						 this.websiteInfo = response.data;
						 this.isRequestInProgress = false;
					 } )
					 .catch(error => {
					 	window.FlashMessages.setError(error.response.data.message);
					 	this.isRequestInProgress = false;
                     });
			},
			isSuperAdmin () {
				return !!this.User.is_super_admin;
			},
		},
	};
</script>