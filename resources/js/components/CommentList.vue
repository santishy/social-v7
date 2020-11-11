<template>
    <div>
        <div  >
            <comment-list-item :key="comment.id" v-for="comment in comments" :comment="comment"></comment-list-item>
        </div>
    </div>
</template>

<script>

import ComentListItem from "./CommentListItem";
export default {
    props: {
        comments: {
            type: Array,
            required: true
        },
        statusId:{
            type:Number,
            required:true
        }
    },
    components: {'comment-list-item' :  ComentListItem },
    mounted() {
        Echo.channel(`statuses.${this.statusId}.comments`).listen(
            'CommentCreated',
            (e) => {
                this.comments.push(e.comment);
            }
        );
      
        EventBus.$on(`statuses.${this.statusId}.comments`,(comment) => {
            this.comments.push(comment);
        })
    }
};
</script>
