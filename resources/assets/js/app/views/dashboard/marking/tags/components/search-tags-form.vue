<template>
    <v-form @submit.prevent="pushToQuery()">
        <v-list dark class="brown darken-3">
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
                                    label="Ieškoti"
                                    v-model="input"
                                    :error-messages="TagsObj.UpdateListErrors.tag"
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
		name: 'SearchTagsForm',
		props: {
			TagsObj: {
				type: Object,
				required: true
			}
		},
        data(){
			return {
				input: this.$route.query.tag || null
            }
        },
		methods: {
			pushToQuery(){
				let $_query = Object.assign({}, this.$route.query);
				$_query.tag = this.input;

				this.$router.push({query: $_query});
            }
		}
	}
</script>