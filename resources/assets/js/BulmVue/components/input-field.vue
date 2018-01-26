<template>
    <div class="field is-horizontal" v-if="isHorizontal">
        <div v-if="label" class="field-label" :class="getSize()" :style="getTextAlign() + ' ' + getFlexGrow()">
            <label :for="type" class="label" v-text="label"></label>
        </div>
        <div class="field-body">
            <div class="field">
                <div class="control" :class="{'has-icons-left': hasIconLeft, 'has-icons-right': hasIconRight}">
                    <input ref="input" :type="type" :id="type" v-model="input" :class="getInputClasses()"
                           :placeholder="placeholder" :required="required">
                    <icon :iconClass="iconClass" :class="{'is-left': hasIconLeft, 'is-right': hasIconRight}"></icon>
                </div>
                <help-list type="danger" :messages="errorsArray"></help-list>
            </div>
        </div>
    </div>
    <div class="field" v-else>
        <label v-if="label" :for="type" class="label" :class="getSize()" v-text="label">Name</label>
        <div class="control" :class="{'has-icons-left': hasIconLeft, 'has-icons-right': hasIconRight}">
            <input ref="input" :type="type" :id="type" v-model="input" :class="getInputClasses()" :placeholder="placeholder" :required="required">
            <icon :iconClass="iconClass" :class="{'is-left': hasIconLeft, 'is-right': hasIconRight}"></icon>
        </div>
        <help-list type="danger" :messages="errorsArray"></help-list>
    </div>
</template>
<script>
	import HelpList from "../elements/help-list";
	import Icon from "../elements/icon";
	export default{
		name: 'inputField',
		components: {
			Icon,
			HelpList
		},
		props: {
			inputValue: { // need .sync
				type: [String, Boolean],
				required: false
			},
			isHorizontal: {
				type: Boolean,
				default: true
			},
			label: {
				type: String,
			},
			type: {
				type: String,
				required: false,
				default: 'text'
			},
			placeholder: {
				type: String,
			},
			hasIconLeft: {
				type: Boolean,
				default: false
			},
			hasIconRight: {
				type: Boolean,
				default: false
			},
			iconClass: {
				type: String,
				default: ''
			},
			errorsArray: { // need .sync
				type: Array,
				default: () => []
			},
			size: {
				type: String
			},
			textAlign: {
				type: String,
				default: 'right'
			},
			noFlexGrow: {
				type: Boolean,
				default: false
			},
            required: {
				type: Boolean,
                default: false
            },
			autoFocus: {
				type: Boolean,
                default: false
            }
		},
        created(){
			this.input = this.inputValue;
		},
		data(){
			return {
				input: ''
			}
		},
		watch: {
			autoFocus: function (newValue) {
                (newValue) ? this.$refs.input.focus() : false;

			},
			inputValue: function (newValue) {
				this.input = newValue;
			},
			input: function (newValue) {
				this.$emit('update:errorsArray', []);
				this.$emit('update:inputValue', newValue);
			}
		},
		methods: {
			isCheckbox: function () {
				return (this.type.toLowerCase() === 'checkbox') ? '' : 'input';
			},
			getSize: function () {
				return (this.size) ? 'is-' + this.size.toLowerCase() : '';
			},
			getTextAlign: function () {
				return (this.textAlign) ? 'text-align: ' + this.textAlign + ';' : '';
			},
			getFlexGrow: function () {
				return (this.noFlexGrow) ? 'flex-grow: 0' : '';
			},
			hasErrors: function () {
				return (this.errorsArray.length > 0) ? 'is-danger' : '';
			},
			getInputClasses: function () {
				return this.isCheckbox() + ' ' + this.getSize() + ' ' + this.hasErrors()
			},
		}
	}
</script>  