<template>
    <v-form @submit.prevent="searchMethod(searchInputs)">
        <v-list dark class="brown darken-3">
            <v-list-tile>
                <v-list-tile-action>
                    <v-btn icon large type="submit">
                        <v-icon>search</v-icon>
                    </v-btn>
                </v-list-tile-action>
                <v-layout row wrap>
                    <v-flex xs6 sm9>
                        <v-list-tile-content>
                            <v-text-field
                                    v-model="searchInputs.title"
                                    label="Paieška"
                                    :error-messages="titleErrors"
                            />
                        </v-list-tile-content>
                    </v-flex>
                    <v-flex xs6 sm3>
                        <v-list-tile-content>
                            <v-select
                                    clearable
                                    v-model="searchInputs.sub_category_id"
                                    single-line
                                    item-text="name"
                                    item-value="id"
                                    label="Sub-kategorija"
                                    :items="selectItems"
                                    :error-messages="subCategoryErrors"
                            />
                        </v-list-tile-content>
                    </v-flex>
                </v-layout>
            </v-list-tile>
        </v-list>
    </v-form>
</template>
<script>
	import {getSubCategoriesWithCategoryAsHeader} from "../../marking/categories/Categories";

	export default {
		name: 'SearchArticlesForm',
		props: {
			searchMethod: {
				type: Function,
				required: true
			},
			titleErrors: {
				type: Array,
				required: true
			},
			subCategoryErrors: {
				type: Array,
				required: true
			}
		},
		data() {
			return {
				selectItems: [],
				searchInputs: {
					sub_category_id: parseInt(this.$route.query.sub_category_id),
					title: this.$route.query.title,
					order_by: this.$route.query.order_by
				}
			}
		},
		created() {
			this.getSelectItems();
		},
		methods: {
			async getSelectItems() {
				this.selectItems = await getSubCategoriesWithCategoryAsHeader();
			}
		}
	}
</script>  