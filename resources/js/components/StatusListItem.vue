<template>
    <div class="card border-0 mb-3 shadow-sm">
        <div class="card-body d-flex flex-column">
            <div class="d-flex align-items-center mb-3">
                <img
                    class="rounded mr-3 shadow-sm"
                    width="40px"
                    :alt="status.user.name"
                    :src="status.user.avatar"
                />
                <div class="">
                    <h5 class="mb-1">
                        <a
                            :href="status.user.link"
                            v-text="status.user.name"
                        ></a>
                    </h5>
                    <div class="small text-muted">
                        {{ status.ago }}
                    </div>
                </div>
            </div>
            <p class="card-text text-secondary" v-text="status.body"></p>
        </div>
        <div
            class="card-footer p-2 d-flex justify-content-between align-items-center"
        >
            <like-btn
                :model="status"
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
        <div
            class="card-footer pb-0"
            v-if="isAuthenticated || status.comments.length"
        >
            <comment-list :comments="status.comments" :status-id="status.id" />
            <comment-form :status-id="status.id" />
        </div>
        <div v-else class="mb-3 text-center ">
            Debes <a href="/login">autenticarte</a> para poder comentar
        </div>
    </div>
</template>

<script>
import CommentForm from "./CommentForm";
import LikeBtn from "./LikeBtn";
import CommentList from "./CommentList.vue";
export default {
    components: {
        LikeBtn,
        CommentList,
        CommentForm
    },
    props: {
        status: {
            type: Object
        }
    },
    mounted(){
      Echo.channel(`statuses.${this.status.id}.likes`).listen('ModelLiked',(e) => {
        this.status.likes_count++;
      });
       Echo.channel(`statuses.${this.status.id}.unlikes`).listen('ModelLiked',(e) => {
        this.status.likes_count++;
      });
    }
};
</script>
<style lang="scss">
.comments-like-btn {
    i {
        display: none;
        font-size: 0.6em;
    }
    padding-left: 0px;
}
</style>
