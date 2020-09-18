<template>
    <button @click="toggleFriendshipStatus" v-text="getTextBtn"></button>
</template>

<script>
export default {
    props: {
        recipient: {
            type: Object,
            required: true
        },
        friendshipStatus: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            localFriendshipStatus: this.friendshipStatus
        };
    },
    methods: {
        toggleFriendshipStatus() {
            let method = this.getMethod;
            axios[method](`/friendships/${this.recipient.name}`)
                .then(res => {
                    this.localFriendshipStatus = res.data.friendship_status;
                })
                .catch(err => {
                    console.log(err.response.data);
                });
        }
    },
    computed: {
        getMethod() {
            if (this.localFriendshipStatus === "pending") return "delete";
            return "post";
        },
        getTextBtn() {
            if (this.localFriendshipStatus === "pending")
                return "Cancelar solicitud";
            if (this.localFriendshipStatus === "accepted")
                return "Eliminar de mis amigos";
            return "Solicitar amistad";
        }
    }
};
</script>
