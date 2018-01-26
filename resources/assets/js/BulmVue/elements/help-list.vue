<template>
    <div v-if="messages">
        <help v-for="message in messages" :type="type" :message="message" :key="message"></help>
    </div>
</template>
<script>
	import Help from './help.vue';

	export default{
		name: 'helpList',
		components: {
			Help
		},
		props: {
			type: {
				type: String,
				required: true
			},
			messages: {
				type: Array,
				required: false
			}
		}
	}
</script>  