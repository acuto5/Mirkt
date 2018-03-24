<template>
    <div>
        <success-flash-messages/>
        <error-flash-messages/>
        <warning-flash-messages/>
    </div>
</template>

<script>
	import ErrorFlashMessages   from "./error-flash-messages";
	import SuccessFlashMessages from "./success-flash-messages";
	import WarningFlashMessages from "./warning-flash-messages";

	export default {
		components: {
			WarningFlashMessages,
			ErrorFlashMessages,
			SuccessFlashMessages,
		},
		name      : "flash-messages",
	};
</script>