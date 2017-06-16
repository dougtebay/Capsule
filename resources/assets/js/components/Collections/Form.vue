<template>
	<form>
		<label for="title">Title</label>
		<input id="title" type="text" v-model="collection.title">
		<span v-if="errors.has('title')">{{ errors.get('title') }}</span>
		<label for="description">Description</label>
		<input id="description" type="textarea" v-model="collection.description">
		<label for="public">Public</label>
		<input id="public" type="checkbox" v-model="collection.public">
		<button @click.prevent="submit()">Submit</button>
	</form>
</template>
