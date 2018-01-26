<template>
    <v-list-tile-avatar tile>
        <template v-if="image">
            <img :src="getUrl" alt="avatar">
        </template>
    </v-list-tile-avatar>
</template>

<script>
	export default {
		name: "tile-avatar-default-article-image",
		props: {
			image: {
				type: Object
            }
        },
        computed: {
			getUrl(){
				return this.image.url || '';
            }
        }
	}
</script>

<style scoped>

</style>