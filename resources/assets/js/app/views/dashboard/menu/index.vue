<template>
    <v-navigation-drawer fixed temporary clipped app width="250" dark v-model="tempValue">
        <v-list subheader>
            <v-list-group v-for="(group, index) in groups" :value="isGroupActive(index)" :key="group.title">
                <v-list-tile slot="item" @click="" ripple="">
                    <v-list-tile-action>
                        <v-icon v-text="group.icon"/>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title v-text="group.title"/>
                    </v-list-tile-content>
                    <v-list-tile-action>
                        <v-icon>keyboard_arrow_down</v-icon>
                    </v-list-tile-action>
                </v-list-tile>
                <v-list-tile dark v-for="subGroup in group.subGroups" :to="subGroup.to"
                             :active-class="activeSubGroupClass" :key="subGroup.title" @click="" ripple>
                    <v-list-tile-action>
                        <v-icon v-text="subGroup.icon"/>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title v-text="subGroup.title"/>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list-group>
        </v-list>
    </v-navigation-drawer>
</template>
<script>
	export default {
		name: 'dashboard-menu',
		props: {
			value: Boolean
		},
		data() {
			return {
				tempValue: false,
				activeSubGroupClass: 'grey darken-2 teal--text text--accent-2',
				groups: [
					{
						title: 'Straipsniai',
						icon: 'library_books',
						routeName: 'dashboard.articles',
						subGroups: [
							{
								title: 'Visi',
								icon: 'assignment_turned_in',
								active: true,
								to: {
									name: 'dashboard.articles.all',
									query: {
										page: 1
									}
								}
							},
							{
								title: 'Pridėti',
								icon: 'note_add',
								to: {
									name: 'dashboard.articles.add'
								}
							},
							{
								title: 'Juodraščiai',
								icon: 'assignment',
								to: {
									name: 'dashboard.articles.draft',
									query: {
										page: 1
									}
								}
							}
						]
					},
					{
						title: 'Žymėjimas',
						icon: 'collections_bookmark',
						routeName: 'dashboard.marking',
						subGroups: [
							{
								title: 'Kategorijos',
								icon: 'bookmark_border',
								to: {name: 'categories'}
							},
							{
								title: 'Sub-kategorijos',
								icon: 'bookmark',
								to: {name: 'sub-categories'}
							},
							{
								title: 'Žymės',
								icon: 'label',
								to: {
									name: 'tags',
									query: {
										page: 1
									}
								}
							}
						]
					}
				]
			}
		},
		watch: {
			value(newValue){
				this.tempValue = newValue;
            },
			tempValue(newValue) {
                this.$emit('input', newValue);
			}
		},
		methods: {
			isGroupActive(index) {
				return this.groups[index].routeName === this.$route.meta.parentName;
			}
		}
	}
</script>  