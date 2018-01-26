<template>
    <div>
        <tags-field
                tagIdKey="id"
                tagStyle="dark"
                tagTextKey="name"
                :hasCloseButton="true"
                :tags="tags"
                :onClose="removeSelectedTag">
        </tags-field>

        <input-dropdown
                itemValueKey="id"
                itemTextKey="name"
                placeholder="Žymės"
                :onItemClick="selectTag"
                :inputValue.sync="input"
                :list="TagsFound">
        </input-dropdown>

        <help-list type="danger" :messages="errors"></help-list>
        <help-list type="danger" :messages="Errors.take"></help-list>
        <help-list type="danger" :messages="Errors.tags_ids"></help-list>
        <help-list type="danger" :messages="Errors.searchTagInput"></help-list>
    </div>
</template>
<script>
	import {takeTags} from "../../marking/tags/Tags";

	export default{
		name: 'SelectTagsField',
		props: {
			SelectedTags: {
				type: Array,
				required: true
			},
            errors: {
				type: Array,
                required: false
            }
		},
        created(){
			this.getTags();
		},
        data(){
			return{
				tags: [],
				input: '',
                TagsFound: [],
                Errors: new window.Errors({take: [], tags_ids: [], searchTagInput: []})
            }
        },
        watch: {
			SelectedTags: function () {
				this.tags = this.SelectedTags;
				this.getTags();
			},
        	input: function(){
        		this.getTags();
            },
        	tags: function (newValue) {
				this.$emit('update:SelectedTags', newValue);
			}
        },
		methods: {
			selectTag: function(tagID) {
				// Take tag (returned as Array)
				let tag = _.filter(this.TagsFound, {id: tagID});

				// Remove from searched tags
				this.TagsFound = _.reject(this.TagsFound, {id: tagID});

				// Add to tags list
				this.tags.push(tag[0]);

				// update input-dropdown list
				this.getTags();
			},
			getTags: _.debounce(function() { // wait till user stop typing
				this.clearErrors();

				let alreadySelectedTagsIDs = this.getSelectedTagsIds();

				// Params for request
				let Params = {take: 5, tags_ids: alreadySelectedTagsIDs, searchTagInput: this.input};

				takeTags(Params)
					.then(response => this.TagsFound = response.data)
					.catch(error => this.setErrors(error));
			}, 200), // ms
            setErrors: function (error) {
				this.Errors.setLarevelErrors(error);
				window.FlashMessages.setError(error.response.data.message);
			},
            clearErrors: function () {
				this.Errors.clear();
				window.FlashMessages.clear();
			},
			getSelectedTagsIds: function () {
				let tags_ids = [];

				_.forEach(this.tags, function (value, key) {
					tags_ids.push(value.id);
				});
				return tags_ids;
			},
			removeSelectedTag: function(tagID) {
				this.tags  = _.reject(this.tags, {id: tagID});
				this.getTags();
			}
		}
	}
</script>  