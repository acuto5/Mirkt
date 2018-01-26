<template>
    <div class="field has-addons" :class="getPosition()">
        <div class="control" v-if="hasLeftAddon">
            <slot name="left-addon"></slot>
        </div>
        <div class="control">
            <input class="input" v-model="value" :type="type" :placeholder="placeholder" :class="getInputClass()">
            <help-list type="danger" :messages="errorsArray"></help-list>
        </div>
        <div class="control" v-if="hasRightAddon">
            <slot name="right-addon"></slot>
        </div>
    </div>
</template>
<script>
	import HelpList from "../elements/help-list";
    export default{
		components: {HelpList},
		name: 'inputFieldWitchAddon',
        props: {
    		inputValue: { // .sync
    			type: String,
                required: true
            },
    		type: {
				type: String,
				required: true,
                default: 'text'
            },
            hasLeftAddon: {
    			type: Boolean,
                default: false
            },
			hasRightAddon: {
				type: Boolean,
				default: false
			},
    		placeholder: {
				type: String,
            },
			isInputExpanded: {
    			type: Boolean,
                default: false
            },
            position: {
    			type: String,
                default: 'left'
            },
            size: {
    			type: String,
                default: 'normal'
            },
            errorsArray: {
    			type: Array,
                default: () => []
            }
        },
        watch: {
    		inputValue: function (newValue) {
                this.value = newValue;
			},
    		value: function (newValue) {
    			this.$emit('update:errorsArray', []);
                this.$emit('update:inputValue', newValue);
			}
        },
        data(){
    		return{
    			value: ''
            }
        },
        methods: {
			getExpanded: function () {
                return (this.isInputExpanded) ? 'is-expanded' : '';
			},
            getPosition: function () {
                return 'has-addons-' + this.position;
			},
            getSize: function () {
                return 'is-' + this.size;
			},
			isErrorsExists: function () {
                return (this.errorsArray.length > 0) ? 'is-danger': '';
			},
            getInputClass: function () {
                return this.getSize() + ' ' + this.getExpanded() + ' ' + this.isErrorsExists();
			}
        }

    }
</script>  