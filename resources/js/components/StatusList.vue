<template>
  <div @click="redirectIfGuest">
    <status-list-item
        v-for="status in statuses"
        :status="status"
        :key="status.id"
     >
    </status-list-item>
  </div>
</template>

<script>
  import StatusListItem from './StatusListItem.vue';
  export default {
    data(){
      return {
        statuses:[]
      }
    },
    components:{
      'status-list-item':StatusListItem
    },
    created(){
      axios.get('/statuses')
           .then((res) => {
             this.statuses = res.data.data
           } )
           .catch( err =>{
             console.log(err.response);
           });
      EventBus.$on('status-created', status => {
        this.statuses.unshift(status);
      })
    },

  }
</script>
