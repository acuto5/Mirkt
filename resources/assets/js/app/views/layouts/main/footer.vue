<template>
    <v-footer class="pa-1">
        <v-spacer/>
        <p class="body-1" v-text="'\u00A9' + thisYear + ' ' + author"></p>
        <v-spacer/>
    </v-footer>
</template>

<script>
	export default {
		name: "main-footer",
		data() {
			return {
				author: 'Tomas Smulkys',
				thisYear: new Date().getFullYear()
			}
		}
	}
</script>