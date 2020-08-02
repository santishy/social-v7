<template>
    <button
        @click="toggle()"
        :dusk="selector"
        :class="getBtnClass"
    >
        <i :class="getIconClass"></i>
        {{getText}}
    </button>
</template>

<script>
export default {
    props: {
        model: {
            type: Object
        },
        url:{
          type: String,
          required: true
        },
        selector:{
          type:String
        }
    },
    methods: {
        toggle(){
          let $method = this.model.is_liked ? 'delete' : 'post';
          axios[$method](this.url)
              .then(res => {
                  this.model.is_liked = !this.model.is_liked;
                  if(this.model.is_liked)
                    this.model.likes_count++;
                  else
                    this.model.likes_count--;
              })
              .catch(err => {
                  if (err.response.status == 401)
                      window.location.href = "/login";
              });
        }
    },
    computed:{
      getText(){
        return this.model.is_liked ? 'Te gusta' : 'Me gusta';
      },
      getBtnClass(){
        return  [
          this.model.is_liked ? 'font-weight-bold' : '',
          'btn',
          'btn-link',
          'btn-sm'
        ];
      },
      getIconClass(){
        return [this.model.is_liked ? 'fa' : 'far',
                'fa-thumbs-up',
                'text-primary',
                'mr-1'
               ]
      }
    }
};
</script>
