<template>
    <v-btn-toggle mandatory v-model="order_by" dark class="brown darken-3">
        <v-btn class="brown darken-3" value="newest">Naujausi</v-btn>
        <v-btn class="brown darken-3" value="oldest">Seniausi</v-btn>
    </v-btn-toggle>
</template>
<script>
	export default {
		props: {
			onOrderChange: {
				type: Function,
				required: true
			}
		},
		data() {
			return {
				order_by: (this.$route.query.order_by === 'oldest') ? 'oldest' : 'newest'
			}
		},
		watch: {
			order_by: function (newValue) {
				this.onOrderChange(newValue);
			}
		}
	}
</script>  