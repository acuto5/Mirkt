<template>
    <v-form @submit.prevent="searchArticles()" v-if="$vuetify.breakpoint.mdAndUp">
        <v-toolbar-items>
            <v-text-field
                    clearable
                    type="text"
                    single-line
                    class="my-3"
                    hide-details
                    label="Ieškoti"
                    v-model="input"
                    prepend-icon="search"
                    :prepend-icon-cb="searchArticles"
                    color="teal accent-2"
            />
        </v-toolbar-items>
    </v-form>
    <v-btn icon :to="{name: 'articles.search'}" v-else>
        <v-icon>search</v-icon>
    </v-btn>
</template>

<script>
	export default {
		name: "search-articles-toolbar-items",
		data() {
			return {
				input: this.$route.query.title
			}
		},
        methods: {
			searchArticles(){
				let $_query = {};

				if(this.input){
					$_query['title'] = this.input;
                }

				this.$router.push( {
					name : 'articles.search',
					query: $_query,
				} );
            }
        }
	}
</script>