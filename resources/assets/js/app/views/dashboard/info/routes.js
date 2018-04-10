import WebsiteInfo from './website-info/index';
import Contacts from './contacts/index';

export default [
	{
		name: 'dashboard.info',
		path: 'info',
		redirect: {name: 'dashboard.info.contacts'},
		component: {template: '<router-view />'},
		children: [
			{
				name: 'dashboard.info.contacts',
				path: 'contacts',
				component: Contacts,
				meta: {
					parentName: 'dashboard.info'
				}
			},
			{
				name: 'dashboard.info.website-info',
				path: 'website-info',
				component: WebsiteInfo,
				meta: {
					parentName: 'dashboard.info'
				}
			}
		]
	}
]