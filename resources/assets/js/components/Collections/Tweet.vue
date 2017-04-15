<template>
	<section class="card">
		<div>@{{ tweet.user_nickname }}</div>
		<div>{{ tweet.text }}</div>
	</section>
</template>

<script>
	export default {
		props: ['tweet']
	}
</script>
