<template>
    <div class="field">
        <label v-if="hasLabel" :for="id" class="label" v-text="label"></label>
        <div class="control">
            <textarea :id="id" v-model="input" class="textarea" :class="getTextAreaClass()" :placeholder="placeholder"></textarea>
        </div>
        <help-list type="danger" :messages="errorsArray"></help-list>
    </div>
</template>
<script>
	import HelpList from "../elements/help-list";
    export default{
		components: {HelpList},
		name: 'textAreaField',
        props: {
			inputValue: { // .sync
				type: String,
				required: false
			},
    		hasLabel: {
    			type: Boolean,
                default: false
            },
            label: {
    			type: String
            },
    		id: {
    			type: String
            },
			placeholder: {
    			type: String
            },
			errorsArray: {
    			type: Array,
                default: () => []
            }
        },
        watch: {
    		inputValue: function (newValue) {
                this.input = newValue;
			},
            input: function (newValue) {
    			this.$emit('update:errorsArray', []);
                this.$emit('update:inputValue', newValue);
			}
        },
        data(){
			return{
				input: ''
            }
        },
        methods: {
			isErrorsExists: function () {
                return (this.errorsArray.length > 0) ? 'is-danger' : '';
			},
			getTextAreaClass: function () {
                return this.isErrorsExists();
			}
        }
    }
</script>  