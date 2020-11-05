<template>
    <form @submit.prevent="addComment" v-if="isAuthenticated" class="mb-3">
        <div class="d-flex align-items-center">
            <img
                class="rounded float-left shadow-sm mr-3"
                width="34px"
                :src="currentUser.avatar"
                :alt="currentUser.name"
            />

            <div class="input-group">
                <textarea
                    v-model="newComment"
                    class="form-control border-0 shadow-sm"
                    placeholder="Escribe un comentario..."
                    rows="1"
                    name="comment"
                    required
                >
                </textarea>
                <div class="input-group-append">
                    <button dusk="comment-btn" class="btn btn-primary">
                        Enviar
                    </button>
                </div>
            </div>
        </div>
    </form>
</template>
<script>
export default {
    data() {
        return {
            newComment: ""
        };
    },
    props:{
        statusId:{
            type:Number,
            required:true
        }
    },
   
    methods: {
        addComment() {
            axios
                .post(`/statuses/${this.statusId}/comments`, {
                    body: this.newComment
                })
                .then(res => {
                    EventBus.$emit(
                        `statuses.${this.statusId}.comments`,
                        res.data.data
                    );
                    this.newComment='';
                })
                .catch(error => {
                    console.log(error.response.data);
                });
        }
    }
};
</script>
