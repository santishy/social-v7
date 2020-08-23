<template>
  <button dusk="request-friendship" @click="sendFriendshipRequest" v-text="getTextBtn"></button>
</template>

<script>
  export default{
    props:{
      recipient:{
        type:Object,
        required:true
      },
      friendshipStatus:{
        type:String,
        required:true
      }
    },
    methods:{
      sendFriendshipRequest(){
        axios.post(`/friendships/${this.recipient.name}`)
             .then( res => {
               console.log(res.data)
               this.friendshipStatus = 'Solicitud enviada'
             })
             .catch( err => {
               console.log(err.response.data)
             });
      }
    },
    computed:{
      getTextBtn(){
        if(this.friendshipStatus == 'pending')
          return 'Solicitud enviada';
        return 'Solicitar amistad'
      }
    }
  }
</script>
