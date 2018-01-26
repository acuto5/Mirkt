<template>
    <v-alert :value="messages.length" :color="type" >
        <span v-for="(message, index) in messages" :key="alert" v-text="message"></span>
    </v-alert>
</template>

<script>
	export default {
		name: "alert-component",
        props: {
			messages: {
				type: Array,
                required: true
            },
            type: {
				type: String,
                required: true
            }
        }
	}
</script>