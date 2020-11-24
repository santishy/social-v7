<template>
    <div>
        <button
            class="btn btn-primary btn-block"
            @click="toggleFriendshipStatus"
        >
            {{ getTextBtn }}
        </button>
    </div>
</template>

<script>
export default {
    props: {
        recipient: {
            type: Object,
            required: true
        },
    },
    data() {
        return {
            friendshipStatus: null
        };
    },
    created()
    {
        axios
            .get(`/friendships/${this.recipient.name}`)
            .then ( res => {
                this.friendshipStatus = res.data.friendship_status;
            })
    },
    methods: {
        
        toggleFriendshipStatus() {
            this.redirectIfGuest();
            let method = this.getMethod;
            axios[method](`/friendships/${this.recipient.name}`)
                .then(res => {
                    this.friendshipStatus = res.data.friendship_status;
                })
                .catch(err => {
                    console.log(err.response.data);
                });
        }
    },
    computed: {
        getMethod() {
            if (
                this.friendshipStatus === "pending" ||
                this.friendshipStatus === "accepted"
            )
                return "delete";
            return "post";
        },
        getTextBtn() {
            if (this.friendshipStatus === "pending")
                return "Cancelar solicitud";
            if (this.friendshipStatus === "accepted")
                return "Eliminar de mis amigos";
            if (this.friendshipStatus === "denied")
                return "Solicitud denegada";
            return "Solicitar amistad";
        },
       /* recipientIsCurrentUser(){
            return this.currentUser.id === this.recipient.id;
        }*/
    }
};
</script>
