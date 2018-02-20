<template>
    <v-alert outline :color="type" :dismissible="dismissible" v-model="isVisible" >
        <span v-for="(message, index) in messages" :key="index" v-text="message"></span>
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
            },
			dismissible: {
				type: Boolean,
                required: false,
                default: true
            }
        },
        data(){
			return{
				isVisible: !!this.messages.length
            }
        },
        watch: {
			'messages'(newValue){
				this.isVisible = !!newValue.length;
            }
        }
	}
</script>