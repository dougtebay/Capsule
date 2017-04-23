<template>
	<form>
		<label for="title">Title</label>
		<input id="title" type="text" v-model="collection.title"></input>
		<label for="description">Description</label>
		<input id="description" type="textarea" v-model="collection.description"></input>
		<label for="public">Public</label>
		<input id="public" type="checkbox" v-model="collection.public"></input>
		<button @click.prevent="submit(collection)">Submit</button>
	</form>
</template>
