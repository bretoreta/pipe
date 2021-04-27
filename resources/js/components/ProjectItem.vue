<template>
	<button
		@click="$emit('getTasks', project.id )"
		class="h-full w-full flex items-center justify-center focus:border-none focus:outline-none"
	>
		<div class="text-center text-xs">{{ project.title }}</div>
	</button>
</template>

<script>
	export default {
		emits: ["getTasks"],
		props: ["project"],
	};
</script>

<style>
</style>