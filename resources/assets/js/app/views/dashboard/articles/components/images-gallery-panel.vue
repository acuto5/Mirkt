<template>
    <v-layout row wrap>
        <v-flex d-flex xs2 ma-1 v-for="(image, index) in images" :key="index">
            <v-card>
                <v-card-media :src="image[srcKey]" height="100px" @click.native="imageClicked(index)" style="cursor: pointer;"/>
            </v-card>
        </v-flex>
        <v-dialog v-model="isModalVisible" :cycle="false" full-width>
            <v-carousel>
                <v-carousel-item v-for="(image,index) in images" :key="index" :src="image[srcKey]"/>
            </v-carousel>
        </v-dialog>
    </v-layout>
</template>

<script>
	export default {
		name: "images-gallery-panel",
        props: {
			images: {
				type: Array,
                required: true
            },
            srcKey: {
				type: String,
                required: false,
                default: 'src'
            }
        },
        data(){
			return{
				isModalVisible: false
            }
        },
        methods: {
			imageClicked(index){
				this.isModalVisible = true;
            }
        }
	}
</script>