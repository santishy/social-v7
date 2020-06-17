<template>
  <div>
    <div v-for="status in statuses" class="card border-0 mb-3 shadow-sm">
      <div class="card-body d-flex flex-column">
        <div class="d-flex align-items-center mb-3">
          <img class="rounded mr-3 shadow-sm" width="40px" src="https://aprendible.com/images/default-avatar.jpg"/>
          <div class="">
            <h5 class="mb-1">{{status.user_name}}</h5>
            <div class="small text-muted">
              {{status.ago}}
            </div>
          </div>

        </div>
        <p class="card-text text-secondary" v-text="status.body"></p>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data(){
      return {
        statuses:[]
      }
    },
    created(){
      axios.get('/statuses')
           .then((res) => {
             this.statuses = res.data.data
           } )
           .catch( err =>{
             console.log(err.response.data);
           });
      EventBus.$on('status-created', status => {
        this.statuses.unshift(status);
      })
    }
  }
</script>
