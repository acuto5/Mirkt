<template>
    <v-list v-show="TagsObj.Tags.length > 0">
        <template v-for="(Tag,index) in TagsObj.Tags">
            <v-divider v-if="index > 0"/>
            <v-list-tile :key="Tag.id">
                <!-- Name -->
                <v-list-tile-title v-text="Tag.name"/>

                <!-- Edit -->
                <edit-tag-dialog-form
                        :tag="Tag"
                        :tags-obj="TagsObj"
                />

                <!-- Delete -->
                <delete-tag-dialog-form
                        :tag="Tag"
                        :tags-obj="TagsObj"
                />

            </v-list-tile>
        </template>
    </v-list>
</template>
<script>
	import EditTagDialogForm from "./edit-tag-dialog-form";
	import DeleteTagDialogForm from "./delete-tag-dialog-form";

	export default{
		components: {
			DeleteTagDialogForm,
			EditTagDialogForm},
		name: 'TagsTable',
		props: {
			TagsObj: {
				type: Object,
				required: true
			}
		}
	}
</script>  