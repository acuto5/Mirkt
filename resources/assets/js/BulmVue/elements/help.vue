<template>
    <p class="help" :class="getType()" v-if="message" v-text="message"></p>
</template>
<script>
    export default{
    	name: 'help',
    	props: {
    		type: {
    			type: String,
                default: 'dark'
            },
            message: {
    			type: String,
                required: true
            }
        },
    	methods: {
    		getType: function () {
    			return 'is-' + this.type;
			}
        }
    }
</script>  