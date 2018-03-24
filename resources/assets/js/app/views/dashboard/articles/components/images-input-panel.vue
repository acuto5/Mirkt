<template>
    <v-layout row wrap>
        <!-- Old images -->
        <v-flex d-flex xs6 md3 lg2 ma-1 v-for="(image,index) in old_images" :key="'old-' + index">
            <v-card>
                <v-card-media :src="image.url" height="130px" :class="{'custom-img': image.is_removed}">
                    <v-btn icon dark @click.native="restoreOldImage(index)" v-if="image.is_removed" color="white--text">
                        <v-icon x-large>restore</v-icon>
                    </v-btn>
                    <v-btn icon dark @click.native="removeOldImage(index)" v-else>
                        <v-icon>close</v-icon>
                    </v-btn>
                </v-card-media>
                <v-card-actions>
                    <v-spacer/>
                    <radio-input
                            label="Pagrindinė"
                            :disabled="!!image.is_removed"
                            color="teal accent-1"
                            v-model="oldImageAsDefault"
                            :pass-value-on-check="image.id"
                    />
                    <v-spacer/>
                </v-card-actions>
            </v-card>
        </v-flex>

        <!-- New selected images -->
        <v-flex d-flex xs6 md3 lg2 ma-1 v-for="(image, index) in prevImages" :key="'new-' + index">
            <v-card>
                <v-card-media :src="image.src" height="130px">
                    <v-btn icon dark @click.native="removeImage(index)">
                        <v-icon>close</v-icon>
                    </v-btn>
                </v-card-media>

                <v-card-actions>
                    <v-spacer/>
                    <radio-input
                            label="Pagrindinė"
                            color="teal accent-1"
                            v-model="newImageAsDefault"
                            :pass-value-on-check="image.id"
                    />
                    <v-spacer/>
                </v-card-actions>
            </v-card>
        </v-flex>

        <!-- Select images button -->
        <v-flex d-flex xs-6 md3 lg2 ma-1>
            <select-file :onFilesSelected="imagesSelected" :multiple="true"/>
        </v-flex>

        <!-- Image errors -->
        <v-flex d-flex xs12 v-if="imagesErrorMessages.length">
            <p v-for="(error,index) in imagesErrorMessages" :key="index" class="error--text" v-text="error"></p>
        </v-flex>

        <!-- Default image errors-->
        <v-flex d-flex xs12 v-if="defaultImageErrorMessages.length" >
            <p v-for="(error,index) in defaultImageErrorMessages" :key="index" class="error--text" v-text="error"></p>
        </v-flex>
    </v-layout>
</template>
<script>
	import RadioInput from "../../../../components/radio-input";
	import SelectFile from "./sub-components/select-file";

	export default {
		components: {
			RadioInput,
			SelectFile,
		},
		name      : 'images-input-panel',
		props     : {
			newFilesArray: { // sync
				type: Array,
				required: false
			},
			oldImagesArray: { // sync
				type: Array,
				required: false,
				default: () => []
			},
			defaultImageId: { // Sync
				type: Number,
				required: false
			},
			isDefaultImgOld: { // Sync
				type: Number,
				required: false
			},
			imagesErrorMessages: {
				type: Array,
                required: false
            },
            defaultImageErrorMessages: {
				type: Array,
                required: false
            }
		},
		watch     : {
			oldImagesArray: function () {
				if (this.oldImagesArray.length
					&& !this.old_images.length
					&& this.oldImageAsDefault === null
					&& this.newImageAsDefault === null) {

					this.oldImagesArray.forEach(image => {
						this.old_images.push(Object.assign({}, image))
					});

					this.resetOldImageAsDefault();
				}
			},
			oldImageAsDefault: function (newValue) {
				if (newValue !== null) {
					this.newImageAsDefault = null;
					this.$emit('update:isDefaultImgOld', 1); // true
					this.$emit('update:defaultImageId', newValue);
				}
			},
			newImageAsDefault: function (newValue) {
				if (newValue !== null) {
					this.oldImageAsDefault = null;
					this.$emit('update:isDefaultImgOld', 0); // false
					this.$emit('update:defaultImageId', newValue);
				}
			},
			imagesIndexForPreview(array){
				if (array.length > 0) {
					this.addImagesInPreview();
				}
            }
		},
		data() {
			return {
				old_images: [],
				images: [],
				prevImages: [],
				oldImageAsDefault: null,
				newImageAsDefault: null,
				imagesIndexForPreview: [],
			}
		},
		methods   : {
			updateOldImagesArray() {
				let notRemovedOldImagesArray = [];

				this.old_images.forEach(image => {
					if (!image.is_removed) {
						notRemovedOldImagesArray.push(image);
					}
				});

				this.$emit('update:oldImagesArray', notRemovedOldImagesArray);
			},
			resetOldImageAsDefault() {
				this.oldImagesArray.forEach(image => {
					if (image.is_default) {
						this.setOldImageAsDefault(image.id);
					}
				});
			},
			setOldImageAsDefault(id) {
				this.oldImageAsDefault = id;
			},
			restoreOldImage(index) {
				this.old_images[index].is_removed = 0;
				this.updateOldImagesArray();
				this.checkDefaultImageSelection();
			},
			removeOldImage(index) {
				this.old_images[index].is_removed = 1;

				if (this.oldImageAsDefault === this.old_images[index].id) {
					this.old_images[index].is_default = 0;
					this.oldImageAsDefault = null;
					this.$emit('update:defaultImageId', null);
				}

				this.checkDefaultImageSelection();
				this.updateOldImagesArray();
			},
			imagesSelected: _.debounce(function (e) { // Wait 500ms
				if (e.target.files && e.target.files.length) {

					// add images in images array
					for (let index = 0; index < e.target.files.length; index++) {
                        this.images.push( e.target.files.item( index ) );
                        this.imagesIndexForPreview.push(this.images.length - 1);
					}

					// push images
					this.$emit('update:newFilesArray', this.images);
				}
			}, 500), // ms
			removeImage(index) {
				// Remove image
				this.images = this.images.filter((image, key) => key !== index);
				this.prevImages = this.prevImages.filter((image, key) => key !== index);

				// push images
				this.$emit('update:newFilesArray', this.images);
			},
			addImagesInPreview () {
                let reader = new FileReader();

                reader.onload = (event) => {
                    this.prevImages.push( { src: event.target.result, id: this.imagesIndexForPreview.shift() } );
					this.checkDefaultImageSelection();
				};

                reader.readAsDataURL( this.images[this.imagesIndexForPreview[0]] );

			},
			checkDefaultImageSelection () {
				if (this.oldImageAsDefault === null && this.newImageAsDefault === null) {
					if (this.old_images.length) {
						for (let image of this.old_images) {
							if (!image.is_removed) {
								// set image as default
								this.oldImageAsDefault = image.id;

								break;
							}
						}
					} else if (this.images.length) {
						// set first image as default
						this.newImageAsDefault = this.images.findIndex( ( image ) => {
							return true;
						} );
					}
				}
			}
		}
	}
</script>