<template>
    <div>
        <success-flash-messages/>
        <error-flash-messages/>
        <warning-flash-messages/>
    </div>
</template>

<script>
	import ErrorFlashMessages   from "./flash-messages/error-flash-messages";
	import SuccessFlashMessages from "./flash-messages/success-flash-messages";
	import WarningFlashMessages from "./flash-messages/warning-flash-messages";

	export default {
		components: {
			WarningFlashMessages,
			ErrorFlashMessages,
			SuccessFlashMessages,
		},
		name      : "flash-messages",
	};
</script>