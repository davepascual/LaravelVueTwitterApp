<template>
	<div>
		<div class="row">
			<div class="col-md-12">
				<a href="#" @click.prevent.stop="likePost(post)" :class="isLiked ? 'text-danger': 'text-primary'">
					<i class="fa fa-2x fa-heart"></i> <span class="badge">{{likeCount }}</span>
				</a href="#">
				<a href="#" ><i class="fa fa-2x fa-comments"></i> <span class="badge">{{ post.replies_count }}</span></a>
				<a href="#" ><i class="fa fa-2x fa-share-alt"></i></a>
			</div>
		</div>
		<notifications group="likePost"/>
		<reply-post-component :postID="post.id" ></reply-post-component>
		
	</div>
</template>


<script>
import Event from '../event.js';

	export default({

		props:{
			post: Object,
			isPostLiked : Boolean,
			likePostCount: Number

		},

		data: function(){
			return {
				currentUser: {},
				replyActive : true,
				isLiked: this.isPostLiked,
				likeCount: this.likePostCount
			}
		},
		mounted:function(){
			this.currentUser = {id:51}

			Event.$on('likePost',(post)=>{
				console.log(post)
				this.likePost(post)
				console.log("likes")
			})
		},

		methods:{
			likePost: function(post){
				var post_id = post
				console.log(post_id)
				

				axios.post('/posts/'+ post.id+ '/like',{
					postData : post
				})
	            .then((response => {
	                Event.$emit('postLiked');
	                this.isLiked = !this.isLiked
					this.isLiked ? this.likeCount++ : this.likeCount--
					this.likeCount<0 ? 0: this.likeCount
					this.notification()
					console.log(this.post.id + " "+this.isLiked)
					console.log("Data" + response.data)

	            }))
			},

	        openReplyForm: function(){
	        	Event.$emit('openReplyForm', {openForm:!this.replyActive})
	        	this.replyActive = !this.replyActive
	        },
	        notification(){
	        	this.$notify({
					group: "likePost",
					title: "Favorited!",
					text: "Tweed added to favorite"
				})
	        }
		}
	});
</script>