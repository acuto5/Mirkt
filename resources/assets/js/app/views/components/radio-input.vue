<template>
    <div>
        <label @click="check()" :style="{'cursor: pointer': disabled}" :class="{'radio-input-disabled': disabled}">{{ label }}</label>
        <v-btn icon depressed flat :color="color" :disabled="disabled" @click.native="check()">
            <v-icon :size="size">{{ icon }}</v-icon>
        </v-btn>
    </div>
</template>

<script>
	export default {
		name: "radio-input",
        props:{
			color: {
				type: String,
                required: true
            },
            value: {
				type: [Number, String,  Boolean]
            },
            passValueOnCheck:{
				type: Number,
                required: true
            },
            label: {
				type: String,
                required: false,
                default: ''
            },
            size: {
				type: [Number,  String],
                required: false,
                default: '21px'
            },
            disabled: {
				type: Boolean,
                required: false,
                default: false
            }
        },
		data () {
			return {
				isChecked: false
            };
		},
        filters: {
			addSpaceToEnd(text){
				return text + ' ';
            }
        },
        watch: {
			isChecked(isChecked){
				if (isChecked){
					this.$emit('input', this.passValueOnCheck);
                }
            },
            value(newValue){
                this.isChecked = newValue === this.passValueOnCheck;
            }
        },
        computed: {
			icon(){
				return (this.isChecked) ? 'radio_button_checked' : 'radio_button_unchecked';
            }
        },
        methods: {
			check(){
				if (!this.disabled){
					this.isChecked = !this.isChecked;
				}
            }
        },
        mounted(){
			if (this.value === this.passValueOnCheck){
				this.isChecked = true;
            }
        }
	};
</script>
<style>
    .radio-input-disabled{
        opacity: 0.3
    }
</style>