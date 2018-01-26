<template>
    <div>
        <v-btn flat large for="images" @click.native="openFileExplorer()">
            <v-icon large>file_upload</v-icon>
        </v-btn>
        <input type="file" ref="fileInput" multiple v-show="false" @change="onFilesSelected" />
    </div>
</template>

<script>
	export default {
		name: "select-file",
        props: {
			multiple: {
				type: Boolean,
                required: false,
                default: false
            },
			onFilesSelected: {
				type: Function,
                required: true
            }
        },
        methods: {
			openFileExplorer(){
				this.$refs.fileInput.click();
            }
        }
	}
</script>