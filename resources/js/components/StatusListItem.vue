<template>

  <div class="card border-0 mb-3 shadow-sm">
    <div class="card-body d-flex flex-column">
      <div class="d-flex align-items-center mb-3">
        <img class="rounded mr-3 shadow-sm"
             width="40px"
             :alt="status.user.name"
             :src="status.user.avatar" />
        <div class="">
          <h5 class="mb-1"><a :href="status.user.link" v-text="status.user.name"></a></h5>
          <div class="small text-muted">
            {{ status.ago }}
          </div>
        </div>
      </div>
      <p class="card-text text-secondary" v-text="status.body"></p>
    </div>
    <div class="card-footer p-2 d-flex justify-content-between align-items-center">
      <like-btn :model="status"
                :key="status.id"
                :url="`/statuses/${status.id}/likes`"
                selector="like-btn"
      >
      </like-btn>
      <div class="mr-2 text-secondary">
        <i class="far fa-thumbs-up"></i>
        <span dusk="likes-count">
                      {{ status.likes_count }}
                  </span>
      </div>
    </div>
    <div class="card-footer">
      <div v-for="comment in comments">
        <div class="d-flex">
          <img class="rounded shadow-sm mr-3" height="34px" width="34px" :src="comment.user.avatar" :alt="comment.user.name">
          <div class="flex-grow-1">
            <div class="card border-0 shadow-sm ">
              <div class="card-body  p-2  text-secondary">
                <a :href="comment.user.link"><strong>{{ comment.user.name }}</strong></a> {{ comment.body }}
              </div>
            </div>
            <small dusk="comment-likes-count"
                   class="float-right badge badge-primary badge-pill mt-1"
            >
              <i class="fa fa-thumbs-up"></i>
              {{comment.likes_count}}
            </small>
            <like-btn :url='`/comments/${comment.id}/likes`'
                      :model="comment"
                      selector="comment-like-btn"
                      class="comments-like-btn"
            >
            </like-btn>
          </div>
        </div>
      </div>
      <form @submit.prevent="addComment" v-if="isAuthenticated">
        <div class="d-flex align-items-center">
          <img class="rounded float-left shadow-sm mr-3"
               width="34px"
               :src="currentUser.avatar"
               :alt="currentUser.name"
          />
          <h1> hola mundo {{currentUser.avatar}} </h1>
          <div class="input-group">
            <textarea v-model="newComment"
                      class="form-control border-0 shadow-sm"
                      placeholder="Escribe un comentario..."
                      rows="1"
                      name="comment"
                      required
            >
            </textarea>
            <div class="input-group-append">
                <button dusk="comment-btn" class="btn btn-primary">Enviar</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  </div>

</template>

<script>
import LikeBtn from './LikeBtn';
export default {
  data() {
    return {
      newComment: '',
      comments: this.status.comments,
    };
  },
  components: {
    LikeBtn,
  },
  props: {
    status: {
      type: Object,
    },
  },
  methods: {
    addComment() {
      axios
        .post(`/statuses/${this.status.id}/comments`, {
          body: this.newComment,
        })
        .then(res => {
          this.newComment = '';
          this.comments.push(res.data.data);
        })
        .catch(error => {
          console.log(error.response.data);
        });
    },
  }
}
</script>
<style lang="scss" >
  .comments-like-btn{
    i {
        display: none;
        font-size: 0.6em;

      }
    padding-left: 0px;
  }
</style>
