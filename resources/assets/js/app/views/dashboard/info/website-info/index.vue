<template>
    <v-container>
        <v-layout row wrap v-show="!isRequestInProgress">
            <!-- Title -->
            <v-flex xs12 sm10 offset-sm1 md8 offset-md2 lg6 offset-lg3 xl4 offset-sl4 class="text-xs-center">
                <p class="headline">Apie projektą</p>
            </v-flex>

            <!-- Content editor -->
            <v-flex xs12 sm10 offset-sm1>
                <vue2-medium-editor
                        :class="isContentHasErrors"
                        class="text-editor pa-2"
                        :text="WebsiteInfo.content"
                        :options="editorOptions"
                        @edit="contentChange"
                />
                <!-- Errors -->
                <error-caption-list :error-messages="Errors.content"/>
            </v-flex>

            <!-- Submit -->
            <v-flex xs12 sm10 offset-sm1 md8 offset-md2 lg6 offset-lg3 xl4 offset-sl4 mt-2 class="text-xs-center">
                <v-btn color="warning" @click.native="saveUpdatedContent()" :loading="isButtonLoading">Atnaujinti
                </v-btn>
            </v-flex>
        </v-layout>
        <progress-circular v-if="isRequestInProgress"/>
    </v-container>
</template>

<script>
	import vue2MediumEditor from 'vue2-medium-editor';
	import ErrorCaptionList from "../../../../components/errors/error-caption-list";
	import ProgressCircular from "../../../../components/progress-circular";

	export default {
		components: {
			ProgressCircular,
			ErrorCaptionList,
			vue2MediumEditor,
		},
		data () {
			return {
				WebsiteInfo         : { content: '' },
				editorOptions       : {
					toolbar: {
						buttons: [
							'bold',
							'italic',
							'underline',
							'strikethrough',
							'subscript',
							'superscript',
							'image',
							'outdent',
							'indent',
							'justifyLeft',
							'justifyCenter',
							'justifyRight',
							'justifyFull',
							'h1',
							'h2',
							'h3',
							'h4',
							'h5',
							'h6',
							'html',
							'removeFormat',
						],
					},
				},
				isButtonLoading     : false,
				isRequestInProgress : true,
				getWebsiteInfoURL   : window.URLS.getWebsiteInfo,
				Errors              : new window.Errors( { content: [] } ),
				updateWebsiteInfoURL: window.URLS.updateWebsiteInfo,
			};
		},
		computed  : {
			isContentHasErrors () {
				return { 'red-border': !!this.Errors.content.length };
			},
		},
		mounted () {
			this.checkIsUserSuperAdmin();
			this.getContent();
		},
		methods   : {
			getContent () {
				this.isRequestInProgress = true;

				axios.get( this.getWebsiteInfoURL )
					 .then( response => {
						 this.WebsiteInfo = response.data;
						 this.isRequestInProgress = false;
					 } )
					 .catch( error => {
						 this.Errors.setLarevelErrors( error );
						 this.isRequestInProgress = false;
					 } );
			},
			contentChange ( obj ) {
				this.WebsiteInfo.content = obj.api.elements[ 0 ].innerHTML;
			},
			saveUpdatedContent () {
				this.isButtonLoading = true;

				axios.patch( this.updateWebsiteInfoURL, { content: this.WebsiteInfo.content } )
					 .then( response => {
						 this.isButtonLoading = false;
						 window.FlashMessages.setSuccess( 'Atnaujinta.' );
						 this.previewWebsiteInfo();
					 } )
					 .catch( error => {
						 this.isButtonLoading = false;

						 this.Errors.setLarevelErrors( error );
					 } );
			},
			checkIsUserSuperAdmin () {
				if (!window.USER.is_super_admin) {
					this.$router.replace( { name: 'home' } );
				}
			},
			previewWebsiteInfo(){
				this.$router.push({name: 'website-info'});
            }
		},
	};
</script>
<style>
    .red-border, .red-border:hover, .red-border:focus {
        border-color: #ff5252;
        outline-color: #ff5252 !important;
    }
</style>