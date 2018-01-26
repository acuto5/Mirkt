<template>
    <div class="file is-boxed is-small">
        <label class="file-label">
            <input class="file-input" type="file" @change="onFilesSelected" :multiple="multiple">
            <span class="file-cta">
                <span class="file-icon">
                    <i class="fa fa-upload"></i>
                </span>
                <span class="file-label">
                    Pasirinkite faila
                </span>
            </span>
        </label>
    </div>
</template>
<script>
    export default{
    	name: 'selectFile',
        props: {
    		onFilesSelected: {
    			type: Function,
                required: true
            },
			multiple: {
    			type: Boolean,
                default: false
            }
        }
    }
</script>  