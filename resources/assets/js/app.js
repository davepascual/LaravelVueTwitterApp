require('./bootstrap');

window.Vue = require('vue');
import Notifications from 'vue-notification'
import vGallery from 'v-gallery'

Vue.component('form-component', require('./components/FormComponent.vue'));
Vue.component('timeline-component', require('./components/TimelineComponent.vue'));
Vue.component('media-slide-component', require('./components/MediaSlideComponent.vue'));
Vue.component('user-post-component', require('./components/UserPostComponent.vue'));
Vue.component('like-post-component', require('./components/LikePostComponent.vue'));
Vue.component('reply-post-component', require('./components/ReplyPostComponent.vue'));


Vue.use(Notifications)
Vue.use(vGallery)
const app = new Vue({
    el: '#app',

    data:{
    	userData: {}
    },
    
    created: function(){
    	this.userData = this.getUserData()
	},

	methods:{
    	getUserData: function(){
    		
    		axios.get('/api/user').then(response=>{
    			this.userData = response.data
    			
    			
    		})
    		
    	}
    }
    
    
});
