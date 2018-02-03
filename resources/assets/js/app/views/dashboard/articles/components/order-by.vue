<template>
    <v-btn-toggle mandatory v-model="order_by" dark class="brown darken-3">
        <v-btn class="brown darken-3" value="newest">Naujausi</v-btn>
        <v-btn class="brown darken-3" value="oldest">Seniausi</v-btn>
    </v-btn-toggle>
</template>
<script>
	export default {
		data() {
			return {
				order_by: (this.$route.query.order_by === 'oldest') ? 'oldest' : 'newest'
			}
		},
		watch: {
			order_by: function (newValue) {
				let $_query = Object.assign({}, this.$route.query);

				$_query['order_by'] = newValue;

				this.$router.push({query: $_query});
			}
		}
	}
</script>  