<template>
    <div class="field is-grouped is-grouped-multiline">
        <div class="control" v-if="tags" v-for="tag in tags">
            <div class="tags has-addons">
                <tag :text="tag[tagTextKey]" :hasCloseButton="hasCloseButton" :tagStyle="tagStyle"
                     :tagId="tag[tagIdKey]" :onClose="onClose"></tag>
            </div>
        </div>
    </div>
</template>
<script>
	export default{
		name: 'tagsField',
		props: {
			tags: {
				type: Array,
				required: true
			},
			tagTextKey: {
				type: String,
				required: true
			},
			hasCloseButton: {
				type: Boolean,
				default: false
			},
			tagStyle: {
				type: String,
				default: ''
			},
			onClose: {
				type: Function
			},
			tagIdKey: {
				type: String,
				default: 'id'
			}
		}
	}
</script>  