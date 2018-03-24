<template>
    <div class="text-xs-center">
        <v-pagination v-show="length > 1" :length="length" v-model="currentPage"/>
    </div>
</template>

<script>
	export default {
		name: "pagination-with-page-query",
		props: {
			lastPage: {
				type: Number,
				required: true
			},
			onQueryChange: {
				type: Function,
				required: true
			}
		},
		data() {
			return {
				length: this.lastPage,
				isCurrentPageWatchDisabled: false,
				currentPage: parseInt(this.$route.query.page) || 1,
			}
		},
		mounted() {
			let $_query = Object.assign({}, this.$route.query);

            // Check if page is set
			if (!$_query.page) {
				$_query.page = 1;

				this.$router.replace({query: $_query});
			} else {
				this.onQueryChange($_query, $_query.page);
			}
		},
		watch: {
			'$route.query': function (newQuery) {
				let $_query = Object.assign({}, newQuery);

				// Check if page is set
				if (!$_query.page) {
					$_query.page = 1;

					this.$router.replace({query: $_query});
				} else {
					// Prevent double axios request, then user use history.back()
					if ($_query.page !== this.currentPage) {

						// Disable currentPage watch to prevent push same query
						this.isCurrentPageWatchDisabled = true;

						this.currentPage = parseInt($_query.page);
					}
					this.onQueryChange($_query, $_query.page);
				}
			},
			currentPage: function (newValue) {
				if (!this.isCurrentPageWatchDisabled) {
					let $_query = Object.assign({}, this.$route.query);
					$_query.page = newValue;

					this.$router.push({query: $_query});
				}

				this.isCurrentPageWatchDisabled = false;
			},
			lastPage(newValue) {
				this.length = newValue;

                //  Reload page
                if (newValue < this.currentPage) {
                	let $_query = Object.assign({}, this.$route.query);
					$_query.page = newValue;

					this.$router.replace({query: $_query});
                }
			}
		}
	}
</script>