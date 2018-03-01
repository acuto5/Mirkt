<template>
    <v-container>
        <v-layout>
            <v-flex xs12 sm10>
                <div v-html="websiteInfo.content"></div>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
	export default {
		data () {
			return {
				isRequestInProgress: false,
				websiteInfo        : { content: '' },
				getWebsiteInfoURL  : window.URLS.getWebsiteInfo,
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
		},
	};
</script>