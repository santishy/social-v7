<template>
    <div class="d-flex">
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
    props:{
        comment:{
            type:Object
        }
    },
    components:{LikeBtn},
    mounted(){
          Echo.channel(`coments.${this.comment.id}.likes`).listen(
            'ModelLiked',
            (e) => {
                this.comment.likes_count++;
            }
        );
    }
}
</script>