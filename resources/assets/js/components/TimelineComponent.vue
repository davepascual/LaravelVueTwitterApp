<template>
    <div class="col-md-8 posts">
        <p v-if="!posts.length">No posts</p>

        <div class="media" v-for="post in posts" :key="post.id">
            <div class="" style="background-color: #fff;padding:0px 20px;clear: both;width: 100%;margin-bottom: 10px;">
                 <img class="mr-3" />
                <div class="media-body">
                    <div>
                        <a :href="post.user.profileLink">{{ post.user.name }}</a>
                        <span><small>@{{ post.user.username}}</small></span>
                        <span class="float-right" v-if="currentUser.id != post.user.id">
                            <a :href="post.user.followLink" class="btn btn-sm btn-outline-primary" v-if=""><strong>+</strong>Follow</a>
                        </span> 
                    </div>
                    <p>{{ post.body }}</p><span><small>{{ post.createdDate }}</small></span>
                    <div v-if="post.medias != null" class="p-4" @click="viewImage">
                        <media-slide-component :medias="post.medias"></media-slide-component>
                    </div>
                    <like-post-component :post="post" :isPostLiked="isLiked(post.likes)" :likePostCount="!post.likes ? 0: post.likes.length"></like-post-component>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Event from '../event.js';

export default {
    data() {
        return {
            posts: [],
            post: {},
            postLiked: {},
            currentUser: {}
        }
    },

    created() {
        axios.get('/posts').then((resp => {
            this.posts = resp.data;
        }));

        Event.$on('added_tweet', (post) => {
            this.posts.unshift(post);
        });

        axios.get('/api/user/').then((resp => {
            this.currentUser = resp.data;
            this.$nextTick(()=>{this.currentUser = resp.data})
        }));
          
    },
    methods:{
        isLiked: function(post){
            var user_id = this.currentUser.id
            if(!post)
                return false

            var i = false
             post.find(function(a){
                if(a.user_id == user_id)
                    i = true
            })

             return i
        },

        countCurrentLikes: function(){
            return !this.post.likes ? 0: this.post.likes.length
        },
        viewImage: function(){
            
        },
        likePost: function(post){
            Event.$emit('likePost',post)
        }

    }
}
</script>

