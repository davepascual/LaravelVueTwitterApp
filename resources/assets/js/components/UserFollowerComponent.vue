<template>
	<div class="col-md-4" followers>
		<ul v-for="follower on followers">
			<li>{{ follower.name}}</li>
		</ul>
	</div>
</template>


<script>
	import Event from '../event.js';

export default {
    data() {
        return {
            followers: [],
            follower: {}
        }
    },
    mounted() {
        axios.get('/posts').then((resp => {
            this.posts = resp.data;
        }));
    }
}
</script>