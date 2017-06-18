<template>
	<form class="card">
		<div>
			<label for="title">Title</label>
			<input class="card-input" id="title" type="text" v-model="collection.title">
			<span v-if="errors.has('title')">{{ errors.get('title') }}</span>
		</div>
		<div>
			<label for="description">Description</label>
			<input class="card-input" id="description" type="textarea" v-model="collection.description">
			<span v-if="errors.has('description')">{{ errors.get('description') }}</span>
		</div>
		<div class="card-input">
			<label for="public">Public</label>
			<input id="public" type="checkbox" v-model="collection.public">
		</div>
		<button @click.prevent="submit()">Submit</button>
	</form>
</template>
