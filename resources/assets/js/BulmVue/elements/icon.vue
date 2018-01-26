<template>
    <span class="icon" v-if="iconClass">
        <i class="fa" :class="iconClass"></i>
    </span>
</template>
<script>
    export default{
    	name: 'icon',
        props: {
    		iconClass: {
				type: String,
				required: true
			}
        }
    }
</script>  