<template>
    <v-app>
        <toolbar/>
        <div class="container">
            <section class="section">
                <three-quarters>
                    <template slot="left-side">
                        <router-view></router-view>
                    </template>
                    <template slot="right-side">
                        Kada nors čia bus reklama. LOL
                    </template>
                </three-quarters>
            </section>
        </div>
    </v-app>
</template>
<script>
	import Toolbar from "../../toolbar/index";

	export default {
		components: {
			Toolbar
		},
		data() {
			return {
				messages: window.FlashMessages
			}
		}
	}
</script>  