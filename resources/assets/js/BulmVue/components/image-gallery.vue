<template>
    <div class="box" v-if="images.length">
        <div class="columns is-multiline">
            <div class="column is-2" v-for="(image,index) in images" :key="index">
                <figure class="tile image is-96x96" >
                    <img :src="image[srcKey]" style="object-fit: cover;">
                </figure>
            </div>
        </div>
    </div>
</template>
<script>
	export default{
		name: 'imagesGallery',
		props: {
			images: {
				type: [Array, Object],
				required: true
			},
			srcKey: {
				type: String,
				required: true
			}
		}
	}
</script>