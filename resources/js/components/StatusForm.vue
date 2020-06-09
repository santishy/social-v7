<template>
  <form   @submit="submit">
    <div class="card-body bg-light">
        <textarea class="form-control border-0  bg-light" placeholder="¿Que estas pensando?"name="body"></textarea>
    </div>
    <div class="card-footer">
      <button id="create-status" class="btn btn-primary" name="button">Publicar</button>
    </div>
  </form>
</template>
<script>
  export default{
    data(){
      return{
        body:''
      }
    },
    methods:{
      submit(e){
        e.preventDefault();
        axios.post('/statuses',{body:this.body}).then((res) => {
          console.log(res.data)
        }).catch( err => {
          console.log(err.response.data)
        });
      }
    }
  }
</script>
