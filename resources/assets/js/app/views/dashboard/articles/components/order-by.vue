<template>
    <v-btn-toggle mandatory v-model="order_by" dark>
        <v-btn value="newest">Naujausi</v-btn>
        <v-btn value="oldest">Seniausi</v-btn>
    </v-btn-toggle>
</template>
<script>
	export default {
		data() {
			return {
				order_by: this.order_by = (this.$route.query.order_by === 'oldest') ? 'oldest' : 'newest'
			}
		},
		watch: {
			order_by: function (newValue) {
				let $_query = Object.assign({}, this.$route.query);

				$_query.order_by = newValue;

				this.$router.push({query: $_query});
			}
		}
	}
</script>  