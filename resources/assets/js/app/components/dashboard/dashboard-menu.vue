<template>
    <v-navigation-drawer fixed temporary clipped app width="250" dark v-model="tempValue">
        <v-list subheader>
            <!-- Groups tiles -->
            <v-list-group v-for="(group, index) in groups" :value="isGroupActive(index)" :key="group.title">
                <v-list-tile slot="activator" :disabled="!isUserHasRole(group.role)">
                    <!-- Icon -->
                    <v-list-tile-action>
                        <v-icon v-text="group.icon"/>
                    </v-list-tile-action>

                    <!-- Group title and link-->
                    <v-list-tile-content>
                        <v-list-tile-title v-text="group.title"/>
                    </v-list-tile-content>
                </v-list-tile>

                <!-- Sub-group tile-->
                <v-list-tile v-for="subGroup in group.subGroups" :to="subGroup.to"
                             :active-class="activeSubGroupClass"
                             :key="subGroup.title"
                             ripple
                             :disabled="!isUserHasRole(subGroup.role)"
                >

                    <!-- Space -->
                    <v-list-tile-action/>

                    <!-- Sub-group title and link -->
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
				User               : window.USER,
				tempValue          : false,
				activeSubGroupClass: 'grey darken-2 teal--text text--accent-2',
				groups             : [
					{
						title    : 'Straipsniai',
						icon     : 'library_books',
						routeName: 'dashboard.articles',
						role     : 'moderator',
						subGroups: [
							{
								title: 'Visi',
								role : 'moderator',
								to   : {
									name: 'dashboard.articles.all',
									query: {
										page: 1
									}
								}
							},
							{
								title: 'Pridėti',
								role : 'moderator',
								to: {
									name: 'dashboard.articles.add'
								}
							},
							{
								title: 'Juodraščiai',
								role : 'moderator',
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
						title    : 'Žymėjimas',
						icon     : 'collections_bookmark',
						routeName: 'dashboard.marking',
						role     : 'moderator',
						subGroups: [
							{
								title: 'Kategorijos',
								to   : { name: 'categories' },
								role : 'admin',
							},
							{
								title: 'Sub-kategorijos',
								to   : { name: 'sub-categories' },
								role : 'moderator',
							},
							{
								title: 'Žymės',
								to: {
									name: 'tags',
									query: {
										page: 1
									}
								},
								role : 'moderator',
							}
						]
					},
					{
						title    : 'Info',
						icon     : 'info',
						routeName: 'dashboard.info',
						role     : 'super',
						subGroups: [
							{
								title: 'Kontaktai',
								to   : { name: 'dashboard.info.contacts' },
								role : 'super',
							},
							{
								title: 'Puslapio info',
								to   : { name: 'dashboard.info.website-info' },
								role : 'super',
							},
						],
					},
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
			},
			isUserHasRole ( $role ) {
				switch ($role) {
					case 'moderator':
						return !!this.User.is_moderator || !!this.User.is_admin || !!this.User.is_super_admin;
					case 'admin':
						return !!this.User.is_admin || !!this.User.is_super_admin;
					case 'super':
						return !!this.User.is_super_admin;
					default:
						return false;
				}
			},
		}
	}
</script>  