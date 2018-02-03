<template>
    <v-form @submit.prevent="searchArticles()">
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
        />
    </v-form>
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
                this.$router.push({name: 'articles.search', query: $_query});
            }
        }
	}
</script>