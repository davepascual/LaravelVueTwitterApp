<template>
    <div class="col-md-8 posts">
        <p v-if="!posts.length">No posts</p>
        
        <div class="media" v-for="post in posts" :key="post.id">
            <div class="" style="background-color: #fff;padding: 20px;clear: both;width: 100%;margin-bottom: 10px;">
                <img class="mr-3" />
                <div class="media-body">
                    <div >
                        <a :href="post.user.profileLink">{{ post.user.name }}</a>
                        <span><small>@{{ post.user.username}}</small></span>
                        <span class="float-right">
                            <a :href="post.user.followLink" class="btn btn-sm btn-outline-primary" v-if=""><strong>+</strong>Follow</a>
                        </span> 
                    </div>
                    <p>{{ post.body }}</p><span><small>{{ post.createdDate }}</small></span>
                    
                    <like-post-component :postId="post.id" :post="post"></like-post-component>
                    
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
            likeCount : 0
        }
    },

    mounted() {
        console.log(window)
        let username = window.location.pathname.split('/').pop()

        axios.get('/posts/user/'+ username).then((resp => {
            this.posts = resp.data;
        }));

        Event.$on('added_tweet', (post) => {
            this.posts.unshift(post);
        });

         
       
    }
}
</script>

