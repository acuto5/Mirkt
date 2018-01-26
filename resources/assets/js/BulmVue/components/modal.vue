<template>
    <div class="modal" :class="{'is-active': isActive}" @keyup.esc="hideModal()" tabindex="0">
        <div class="modal-background has-text-black" @click="hideModal()"></div>
        <div class="modal-content">
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title" v-text="title"></p>
                    <button class="delete" aria-label="delete" v-show="hasCloseButton" @click="hideModal()"></button>
                </header>
                <div class="modal-card-body">
                    <div class="content">
                        <slot name="content"></slot>
                    </div>
                </div>
                <div class="modal-card-foot">
                    <slot name="footer"></slot>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
	export default {
		name: 'modal',
		props: {
			title: {
				type: String,
				required: false,
			},
			isActive: {
				type: Boolean,
				required: true
			},
			hasCloseButton: {
				type: Boolean,
				default: true
			}
		},
		methods: {
			hideModal: function () {
				this.$emit('update:isActive', false);
			}
		}
	}
</script>  