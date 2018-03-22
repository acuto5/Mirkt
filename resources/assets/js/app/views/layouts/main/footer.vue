<template>
    <v-footer>
        <v-spacer/>
        <span class="body-1">
            {{ '\u00A9' + thisYear }}
            <router-link :to="{name: 'contacts'}" class="router-link white--text">{{ author }}</router-link>
        </span>
        <v-spacer/>
    </v-footer>
</template>

<script>
	export default {
		name: "main-footer",
		data() {
			return {
				author: ' Tomas Smulkys',
				thisYear: new Date().getFullYear()
			}
		}
	}
</script>