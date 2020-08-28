<template>
  <button  @click="acceptFriendshipRequest" v-text="getTextBtn"></button>
</template>
<script>
export default{
  props:{
    sender:{
      type:Object
    },
    friendshipStatus:{
      type:String
    }
  },
  data(){
    return {
      localFriendshipStatus:this.friendshipStatus
    }

  },
  methods:{
    acceptFriendshipRequest(){
      axios.post(`/accept-friendships/${this.sender.name}`)
           .then(res => {
             this.localFriendshipStatus = 'accept';
           })
           .catch(err => {
             console.log(err.response.data)
           })
    }
  },
  computed:{
    getTextBtn(){
      if(this.localFriendshipStatus === 'pending')
        {
          return 'Solicitud enviada';
        }
      return 'son amigos'
    }
  }
}
</script>
