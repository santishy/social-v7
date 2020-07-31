<template>

  <div class="card border-0 mb-3 shadow-sm">
    <div class="card-body d-flex flex-column">
      <div class="d-flex align-items-center mb-3">
        <img class="rounded mr-3 shadow-sm"
             width="40px"
             src="https://aprendible.com/images/default-avatar.jpg" />
        <div class="">
          <h5 class="mb-1">{{ status.user_name }}</h5>
          <div class="small text-muted">
            {{ status.ago }}
          </div>
        </div>
      </div>
      <p class="card-text text-secondary" v-text="status.body"></p>
    </div>
    <div class="card-footer p-2 d-flex justify-content-between align-items-center">
      <like-btn :status="status" :key="status.id"> </like-btn>
      <div class="mr-2 text-secondary">
        <i class="far fa-thumbs-up"></i>
        <span dusk="likes-count">
                      {{ status.likes_count }}
                  </span>
      </div>
    </div>
    <div class="card-footer">
      <div v-for="comment in comments">
        <img class="rounded float-left shadow-sm mr-3" width="34px" :src="comment.user_avatar" :alt="comment.user_name">
        <div class="card mb-2 border-0 shadow-sm ">
          <div class="card-body  p-2  text-secondary">
            <a href="#"><strong>{{ comment.user_name }}</strong></a> {{ comment.body }}
            <span dusk="comment-likes-count"></span>
          </div>
        </div>
      </div>
      <form @submit.prevent="addComment" v-if="isAuthenticated">
        <div class="d-flex align-items-center">
          <img class="rounded float-left shadow-sm mr-3"
               width="34px"
               src="https://aprendible.com/images/default-avatar.jpg"
               :alt="currentUser.name"
          />
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
  },
};
</script>
