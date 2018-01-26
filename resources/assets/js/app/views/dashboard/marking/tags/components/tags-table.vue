<template>
    <v-list dark class="brown darken-3">
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
    <!--<div>-->
    <!--<help-list type="danger" :messages="TagsObj.UpdateListErrors.page"></help-list>-->

        <!--<article class="message is-primary" v-for="tag in TagsObj.tags" :key="tag.id">-->
            <!--<div class="message-body">-->
                <!--<div class="is-pulled-right">-->
                    <!--<icon iconClass="fa-edit" class="button has-text-warning" title="Redaguoti"-->
                          <!--@click.native="TagsObj.showEditModal(tag)"></icon>-->
                    <!--<icon iconClass="fa-trash" class="button has-text-danger" title="Trinti"-->
                          <!--@click.native="TagsObj.showDeletionModal(tag)"></icon>-->
                <!--</div>-->
                <!--<p v-text="tag.name"></p>-->
            <!--</div>-->
        <!--</article>-->
    <!--</div>-->
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