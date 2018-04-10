<template>
    <div v-if="errorMessages.length">
        <template v-for="(error,index) in errorMessages">
            <v-divider v-if="index === 0"/>
            <p :key="index" v-text="error" class="caption error--text"></p>
        </template>
    </div>
</template>

<script>
	export default {
		name: "error-caption-list",
		props: {
			errorMessages: {
				type: Array,
				required: true
			}
		}
	}
</script>