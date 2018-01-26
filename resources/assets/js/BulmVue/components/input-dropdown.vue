<template>
    <div class="dropdown" :class="{'is-active': isActive}">
        <div class="dropdown-trigger">
            <input type="text" v-model="input" class="input" @focus="isActive = true" @blur="atBlur()"
                   :placeholder="placeholder">
        </div>
        <div class="dropdown-menu" id="dropdown-menu" role="menu">
            <div class="dropdown-content" v-if="list.length">
                <a class="dropdown-item" v-for="item in list" @click="onItemClick(item[itemValueKey])"
                   v-text="item[itemTextKey]">
                </a>
            </div>
        </div>
    </div>
</template>
<script>
	export default{
		name: 'inputDropdown',
		props: {
			inputValue: {
				type: String,
				required: true
			},
			list: {
				type: Array,
				required: true
			},
			itemTextKey: {
				type: String,
				required: true
			},
			itemValueKey: {
				type: String,
				required: true
			},
			onItemClick: {
				type: Function,
				required: true
			},
			placeholder: {
				type: String
			}
		},
		data(){
			return {
				input: '',
				isActive: false
			}
		},
		watch: {
			input: function (newValue) {
				this.$emit('update:inputValue', newValue);
			}
		},
		methods: {
			atBlur: function () {
				window.setTimeout(() => this.isActive = false, 100);
			},
		}
	}
</script>  