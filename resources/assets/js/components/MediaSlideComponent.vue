<template>
	<v-gallery :images="imageList">
	</v-gallery>
	
</template>

<script>

	export default {
		props: ['medias'],
		computed:{
			imageList: function(){
				return this.medias.map((media)=>{
					media.url = '/images/'+media.name
					return media
				})
			}
		}
	}
</script>