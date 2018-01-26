<template>
    <article class="message" :class="getTypeClass()" v-if="isVisible || alwaysVisible">
        <div class="message-header" v-if="title">
            <p v-if="title" v-text="title"></p>
            <button class="delete" aria-label="delete" @click="hideMe()" v-if="hasCloseButton"></button>
        </div>
        <div class="message-body">
            <button v-if="!title && hasCloseButton" class="delete is-pulled-right" aria-label="delete" @click="hideMe()" ></button>
            <slot name="body"></slot>
            <help :type="type" :message="message"></help>
        </div>
    </article>
</template>
<script>
	import Help from "../elements/help";

    export default{
		components: {Help},
		name: 'message',
    	props: {
            type: {
    		    type: String,
                required: false,
				default: 'dark'
            },
			message: { // .sync
				type: String,
                default: ''
			},
			title: {
				type: String
			},
            hasCloseButton: {
    			type: Boolean,
				default: true
            },
			alwaysVisible: {
            	type: Boolean,
                default: false
            }
        },
        created(){
			this.isVisible = !!this.message;
        },
        data(){
    	    return{
				isVisible: false,
			}
        },
        watch: {
            message: function(newValue){
				this.isVisible = !!newValue;
            }
        },
        methods: {
    		hideMe: function(){
				this.isVisible = false;
				this.$emit('update:message', '');
			},
            getTypeClass: function(){
                return {
                	['is-' + this.type]: !!this.type
                }
            }
        }
    }
</script>  