<template>
	<section class="search-result">
		<div>@{{ result.user_nickname }}</div>
		<div>{{ result.text }}</div>
	</section>
</template>

<script>
	export default {
		props: ['result']
	}
</script>
