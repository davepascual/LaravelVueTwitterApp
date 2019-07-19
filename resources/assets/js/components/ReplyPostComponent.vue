<template>
	<div class="mt-2">
		<div v-if="true">
			<form @submit.prevent="storeReply()" method="POST" :key="postID">
				<div class="form-group">
					<textarea class="form-control " v-model="newReply" rows=2 style="" placeholder="Reply.....">
						
					</textarea>
				</div>
				<div class="form-group float-md-right">
					<button class="btn btn-primary">Reply</button>
				</div>
			</form>
			<notifications group="replySubmit"/>
			
			 <div class="media" v-for="reply in replies" :key="reply.id">
            <div class="" style="background-color: #fcfcfc;padding:0px 20px;clear: both;width: 100%;margin-bottom: 10px;">
                <img class="mr-3" />
                <div class="media-body">
                    <div >
                        <a :href="reply.user.profileLink">{{ reply.user.name }}</a>
                        <span><small>@{{ reply.user.username}}</small></span>
                        
                    </div>
                    <p>{{ reply.content }}</p>
                    <span><small>{{ reply.createdDate }}</small></span>
                    
                </div>
            </div>
        </div>
			
		</div>
	</div>
</template>

<script>

import Event from '../event.js'

	export default {
		props:{
			postID: Number
		},

		data: function(){
			return{
				replies: [],
				replyForm: false,
				newReply: ''
			}
		},

		mounted:function(){
			Event.$on('openReplyForm',data=>{
				this.replies.replyForm = data.openForm
				
			})
			Event.$on('replySubmitted',data=>{
				
			})
				 this.fetchReplies()
			
		},
		methods:{

			fetchReplies:function(){
				axios.get("/posts/"+ this.postID +"/replies")
				.then(response=>{
					this.replies = response.data
				})
			},
			storeReply: function(){
				//return console.log($event)
				axios.post("/posts/reply/save",{
					postID: this.postID,
					replyMessage: this.newReply

				})
				.then(response=>{
					this.replies.unshift(response.data)
					this.newReply = ''
					this.notification()
					Event.$emit('replySubmitted',response.data)
				})
			},
			notification()
			{
				this.$notify({
					group: "replySubmit",
					title: "Reply to tweet",
					text: "Reply submitted!"
				})
			}
		}


	}
</script>