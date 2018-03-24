<template>
    <v-layout row wrap justify-space-around>
        <v-flex d-flex xs12 class="text-xs-center">
            <v-progress-circular fill indeterminate color="teal accent-2" :width="4" :size="50"/>
        </v-flex>
    </v-layout>
</template>

<script>
	export default {
		name: "progress-circular",
	};
</script>