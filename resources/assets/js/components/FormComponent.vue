<template>
    <div class="col-md-4">
      
        <form @submit.prevent="saveTweet" enctype="multipart/form-data">
            <div class="form-group">
                <textarea 
                    class="form-control" 
                    rows="8" cols="8" 
                    maxlength="130"
                    placeholder="Tweet something...." 
                    v-model="body"
                    required>
                </textarea>
            </div>
            <div class="form-group">
                <input class="form-control" type="file" name="images[]" multiple accept="image/*" @change="handleImage"></input>
            </div>
            <div class="form-group" >
                <img id="imagePreview" class="img-fluid" :src="imagePreview" />
            </div>
            <div class="form-group">
                <button class="btn btn-primary">
                    <i class="fa fa-bullhorn "></i>Tweet
                </button>
            </div>
        </form>    
    <notifications group="postSubmit" position="top right" width="500px"/>
    <notifications group="errorOnPost" position="top right" width="500px"/>
    </div>
  
</template>
<script>
import Event from '../event.js';
export default {
    data() {
        return {
            body: '',
            images: [],
            postData: {},
            imagePreview: '',
        }
    },
    mounted(){
       
    },
    methods: {
        saveTweet() {
            let formData = new FormData();

            for(let i=0 ;i < this.images.length; i++){
                formData.append('images[]', this.images[i])
            }
            
            formData.append('body', this.body)


            axios.post('/tweet/save',formData,{headers: {'Content-Type': 'multipart/form-data'}}).then(res => {
                this.postData = res.data;
                this.notification()
                Event.$emit('added_tweet', this.postData)
            }).catch(e => {
                this.$notify({
                  group: 'errorOnPost',
                  title: 'Something is wrong with your tweet',
                  text: e.response.data.message
                });
            });
            this.body = '';
            
        },
        handleImage(e){
            var selectedFiles = e.target.files
            for(let i=0 ;i < selectedFiles.length; i++){
                
                this.images.push(selectedFiles[i])
            }

            /*if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#imagePreview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
*/
            
        },
        notification(){
             this.$notify({
                  group: 'postSubmit',
                  title: 'Tweeted!',
                  text: 'Your tweet is added!'
                });
        }
    }
}
</script>

