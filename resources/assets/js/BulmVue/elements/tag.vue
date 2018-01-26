<template>
    <div class="tags has-addons" v-if="hasCloseButton">
        <a class="tag is-link" :class="getTagStyles()" v-if="textLink" :href="textLink" v-text="text"></a>
        <span class="tag" :class="getTagStyles()" v-else v-text="text"></span>
        <a class="tag is-delete" @click="onClose(tagId)"></a>
    </div>
    <a class="tag is-link" :class="getTagStyles()" v-else-if="!hasCloseButton && textLink" :href="textLink"
       v-text="text"></a>
    <span class="tag" :class="getTagStyles()" v-else-if="!hasCloseButton && !textLink" v-text="text"></span>
</template>
<script>
	export default{
		name: 'tag',
		props: {
			text: {
				type: String,
				required: true
			},
			tagStyle: {
				type: String,
				default: ''
			},
			hasCloseButton: {
				type: Boolean,
				default: false
			},
			textLink: {
				type: String,
				default: ''
			},
			tagId: {
				type: [String, Number],
                default: ''
            },
            onClose: {
				type: Function
            }
		},
		methods: {
			getTagStyles: function (){
				return (this.tagStyle) ? 'is-' + this.tagStyle : '';
            }
		}
	}
</script>  