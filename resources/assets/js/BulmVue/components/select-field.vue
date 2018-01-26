<template>
    <div class="field is-horizontal" v-if="isHorizontal">
        <div class="field-label" :class="fieldSize()" :style="getStyle()">
            <label :for="selectID" class="label" v-text="label"></label>
        </div>
        <div class="field-body">
            <div class="field is-narrow">
                <div class="control">
                    <div class="select" :class="fieldSize() + ' ' + isErrorsExists()">
                        <select v-model="value" :id="selectID" :class="{'has-text-grey': value == -1}">
                            <option v-show="false" :value="-1" v-text="placeholder"></option>
                            <option v-if="optionsArray && !hasOptgroup" v-for="option in optionsArray" :value="option[optionValueKey]"
                                    v-text="option[optionTextKey]" :class="{'has-text-black': true}"></option>
                            <template v-if="hasOptgroup" v-for="option in optionsArray" >
                                <optgroup :label="option[optionTextKey]"></optgroup>
                                <option v-if="hasOptgroup" v-for="sub_option in option[optgroupArrayKey]" :value="sub_option[optgroupOptionValueKey]"
                                        v-text="sub_option[optgroupOptionTextKey]" :class="{'has-text-black': true}"></option>
                            </template>
                        </select>
                    </div>
                    <help-list type="danger" :messages="errorsArray"></help-list>
                </div>
            </div>
        </div>
    </div>
    <div class="field" v-else>
        <label :for="selectID" class="label" :class="fieldSize()" v-text="label"></label>
        <div class="control">
            <div class="select"  :class="fieldSize() + ' ' + isErrorsExists()">
                <select v-model="value" :id="selectID" :class="{'has-text-grey': value == -1}">
                    <option v-show="false" :value="-1" v-text="placeholder"></option>
                    <option v-if="optionsArray && !hasOptgroup" v-for="option in optionsArray" :value="option[optionValueKey]"
                            v-text="option[optionTextKey]" :class="{'has-text-black': true}"></option>
                    <template v-if="hasOptgroup" v-for="option in optionsArray" >
                        <optgroup :label="option[optionTextKey]"></optgroup>
                        <option v-if="hasOptgroup" v-for="sub_option in option[optgroupArrayKey]" :value="sub_option[optgroupOptionValueKey]"
                                v-text="sub_option[optgroupOptionTextKey]" :class="{'has-text-black': true}"></option>
                    </template>
                </select>
            </div>
            <help-list type="danger" :messages="errorsArray"></help-list>
        </div>
    </div>
</template>
<script>
	export default {
		name: 'selectField',
		props: {
			optionsArray: {
				type: [Array, Object],
				required: true
			},
			inputValue: { // need .sync
				type: [String, Number],
				required: true
			},
			label: {
				type: String,
				required: false
			},
			size: {
				type: String,
				required: false
			},
			selectID: {
				type: String,
				required: true
			},
			optionTextKey: {
				type: String,
				required: true
			},
			optionValueKey: {
				type: [String, Number],
				required: true
			},
			placeholder: {
				type: String,
				required: false
			},
			errorsArray: {
				type: Array,
                default: () => []
			},
			isHorizontal: {
				type: Boolean,
				required: false
			},
			textAlign:{
				type: String,
                default: 'right'
            },
			noFlexGrow: {
				type: Boolean,
				default: false
			},
			hasOptgroup: {
				type: Boolean,
                default: false
            },
			optgroupArrayKey: {
				type: String
            },
			optgroupOptionValueKey: {
				type: String
            },
			optgroupOptionTextKey: {
				type: String
            }
		},
		data(){
			return {
				value: -1
			}
		},
		watch: {
			inputValue: function(newValue){
				this.value = newValue;
            },
			value: function (newValue) {
				this.$emit('update:errorsArray', []);
				this.$emit('update:inputValue', newValue);
			}
		},
		methods: {
			fieldSize: function () {
				return (this.size) ? 'is-' + this.size : false;
			},
			getTextAlign: function () {
				return (this.textAlign) ? 'text-align: ' + this.textAlign + ';': '';
			},
			getFlexGrow: function () {
				return (this.noFlexGrow) ? 'flex-grow: 0;' : '';
			},
			isErrorsExists: function () {
				return (this.errorsArray.length > 0) ? 'is-danger' : '';
			},
            getStyle: function () {
                return (this.getTextAlign() + ' ' + this.getFlexGrow());
			}
		}
	}
</script>  