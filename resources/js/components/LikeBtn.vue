<template>
    <button
        v-if="status.is_liked"
        @click="unlike(status)"
        dusk="unlike-btn"
        class="btn btn-link btn-sm"
    >
        <i class="fa fa-thumbs-up"></i>
        <strong>Te gusta</strong>
    </button>
    <button
        v-else
        @click="like(status)"
        dusk="like-btn"
        class="btn btn-link btn-sm"
    >
        <i class="far fa-thumbs-up"></i>
        Me gusta
    </button>
</template>

<script>
export default {
    props: {
        status: {
            type: Object
        }
    },
    methods: {
        like(status) {
            axios
                .post("/statuses/" + status.id + "/likes")
                .then(res => {
                    status.is_liked = true;
                    status.likes_count++;
                })
                .catch(err => {
                    if (err.response.status == 401)
                        window.location.href = "/login";
                });
        },
        unlike(status) {
            axios
                .delete("/statuses/" + status.id + "/likes")
                .then(res => {
                    status.is_liked = false;
                    status.likes_count--;
                })
                .catch(err => {
                    console.log(err);
                });
        }
    }
};
</script>
