<template>
    <v-form @submit.prevent="pushToQuery()">
        <v-list>
            <v-list-tile>
                <!-- Search button -->
                <v-list-tile-action>
                    <v-btn icon large type="submit">
                        <v-icon>search</v-icon>
                    </v-btn>
                </v-list-tile-action>
                <v-layout row wrap>
                    <v-flex xs12>
                        <v-list-tile-content>
                            <v-text-field
                                    clearable
                                    label="Ieškoti"
                                    v-model="input"
                                    color="teal accent-2"
                                    :error-messages="errorMessages"
                            />
                        </v-list-tile-content>
                    </v-flex>
                </v-layout>
            </v-list-tile>
        </v-list>
    </v-form>
</template>

<script>
	export default {
		name   : "simple-search-form",
		props  : {
			showResultsFormFirstPage: {
				type    : Boolean,
				required: false,
				default : true,
			},
			errorMessages           : {
				type    : Array,
				required: false,
			},
			inputName               : {
				type    : String,
				required: true,
			},
		},
		data () {
			return {
				input: this.$route.query[ this.inputName ] || undefined,
			};
		},
		methods: {
			pushToQuery () {
				let $_query = Object.assign( {}, this.$route.query );

				// Show results from first page
				if (this.showResultsFormFirstPage) {
					$_query.page = 1;
				}

				if (this.input) {
					$_query[ this.inputName ] = this.input;
				} else {
					// Remove from query
					delete $_query[ this.inputName ];
				}

				this.$router.push( { query: $_query } );
			},
		},
	};
</script>