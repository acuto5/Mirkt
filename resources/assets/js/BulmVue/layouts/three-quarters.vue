<template>
    <div class="columns">
        <div class="column is-three-quarters"><slot name="left-side"></slot></div>
        <div class="column"><slot name="right-side"></slot></div>
    </div>
</template>
<script>
 export default{
 	name: 'three-quarters'
 }
</script>  