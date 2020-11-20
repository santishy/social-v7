<template>
    <div :class="highlight" :id="`comment-${comment.id}`" class="d-flex">
        <img
            class="rounded shadow-sm mr-3"
            height="34px"
            width="34px"
            :src="comment.user.avatar"
            :alt="comment.user.name"
        />
        <div class="flex-grow-1">
            <div class="card border-0 shadow-sm ">
                <div class="card-body  p-2  text-secondary">
                    <a :href="comment.user.link"
                        ><strong>{{ comment.user.name }}</strong></a
                    >
                    {{ comment.body }}
                </div>
            </div>
            <small
                dusk="comment-likes-count"
                class="float-right badge badge-primary badge-pill mt-1"
            >
                <i class="fa fa-thumbs-up"></i>
                {{ comment.likes_count }}
            </small>
            <like-btn
                :url="`/comments/${comment.id}/likes`"
                :model="comment"
                selector="comment-like-btn"
                class="comments-like-btn"
            >
            </like-btn>
        </div>
    </div>
</template>
<script>
import LikeBtn from "./LikeBtn";
export default {
    props: {
        comment: {
            type: Object
        }
    },
    components: { LikeBtn },
    mounted() {
        Echo.channel(`comments.${this.comment.id}.likes`).listen(
            "ModelLiked",
            e => {
                this.comment.likes_count++;
            }
        );
         Echo.channel(`comments.${this.comment.id}.likes`).listen(
            "ModelUnliked",
            e => {
                this.comment.likes_count--;
            }
        );
    },
    computed:{
        highlight(){
            if(window.location.hash === `#comment-${this.comment.id}`){
                return 'highlight'
            }
        }
    }
};
</script>
<style scoped>
    .highlight{
        background:#ececec;
        padding:10px;
        border-left:4px solid #ff8d00
    }
</style>