<template>
  <div @click="redirectIfGuest">
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
      <div class="card-footer p-2 d-flex justify-content-between align-items-center">
        <button v-if="status.is_liked"
                @click="unlike(status)"
                dusk="unlike-btn"
                class="btn btn-link btn-sm">
                <i class="fa fa-thumbs-up"></i>
                <strong>Te gusta</strong>

              </button>
        <button v-else
                @click="like(status)"
                dusk="like-btn"
                class="btn btn-link btn-sm">
                <i class="far fa-thumbs-up"></i>
                Me gusta

              </button>
              <div class="mr-2 text-secondary">
                <i class="far fa-thumbs-up"></i>
                <span dusk="likes-count">
                  {{status.likes_count}}
                </span>
              </div>

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
             console.log(err.response);
           });
      EventBus.$on('status-created', status => {
        this.statuses.unshift(status);
      })
    },
    methods:{

      like(status){

        axios.post('/statuses/'+status.id+'/likes')
              .then((res) => {
                status.is_liked=true;
                status.likes_count++;
              })
              .catch((err) => {
                if(err.response.status == 401)
                window.location.href='/login'
              });
      },
      unlike(status){
        axios.delete('/statuses/'+status.id+'/likes')
              .then((res) => {
                status.is_liked=false;
                status.likes_count--;
              })
              .catch((err) => {
                console.log(err)
              });
      }
    }
  }
</script>
