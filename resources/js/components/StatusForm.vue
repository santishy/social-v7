<template>
  <div>
    <form   @submit="submit">
      <div class="card-body bg-light">
          <textarea class="form-control border-0  bg-light" v-model="body" :placeholder="`¿Que estas pensando ${user.name}?`"name="body"></textarea>
      </div>
      <div class="card-footer">
        <button id="create-status" class="btn btn-primary" name="button">Publicar</button>
      </div>
    </form>
    <!-- <div v-for="status in statuses" v-text="status.body">
    </div> -->
  </div>

</template>
<script>
  import auth from '../mixins/auth';
  export default{
    data(){
      return{
        body:'',

      }
    },
    mixins:[auth],
    created(){
      console.log(auth)
    },
    methods:{
      submit(e){
        e.preventDefault();
        axios.post('/statuses',{body:this.body}).then((res) => {
          EventBus.$emit('status-created',res.data.data);
          this.body='';
        }).catch( err => {
          console.log(err.response.data)
        });
      }
    }
  }
</script>
