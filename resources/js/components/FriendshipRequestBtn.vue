<template>
    <div
        class="d-flex justify-content-between bg-light p-3 rounded mb-3 shadow-sm"
    >
        <div >
            <div v-if="localFriendshipStatus === 'pending'">
                <span v-text="sender.name"></span> te ha enviado una solicitud
                de amistad
            </div>
             <div v-if="localFriendshipStatus === 'accepted'">
                Tú y <span>{{ sender.name }}</span> son amigos
            </div>
            <div v-else-if="localFriendshipStatus === 'denied'">
                Solicitud denegada de <span>{{ sender.name }}</span>
            </div>
            <div v-if="localFriendshipStatus === 'deleted'">
                Solicitud eliminada de <span>{{ sender.name }}</span>
            </div>
        </div>
        <div>
           
            
            <button class="btn btn-small btn-primary" v-if="localFriendshipStatus === 'pending'" dusk="accept-friendship" @click="acceptFriendshipRequest">
                Aceptar solicitud
            </button>
            <button class="btn btn-small btn-warning" v-if="localFriendshipStatus === 'pending'" dusk="deny-friendship" @click="denyFriendshipRequest">
                Denegar solicitud
            </button>
            <button
                class="btn btn-small btn-danger"
                v-if="localFriendshipStatus !== 'deleted'"
                dusk="delete-friendship"
                @click="deleteFriendshipRequest"
            >
                Eliminar solicitud
            </button>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        sender: {
            type: Object
        },
        friendshipStatus: {
            type: String
        }
    },
    data() {
        return {
            localFriendshipStatus: this.friendshipStatus
        };
    },
    methods: {
        acceptFriendshipRequest() {
            axios
                .post(`/accept-friendships/${this.sender.name}`)
                .then(res => {
                    this.localFriendshipStatus = res.data.friendship_status;
                })
                .catch(err => {
                    console.log(err.response.data);
                });
        },
        denyFriendshipRequest() {
            axios
                .delete(`/accept-friendships/${this.sender.name}`)
                .then(res => {
                    this.localFriendshipStatus = res.data.friendship_status;
                })
                .catch(err => {
                    console.log(err.response.data);
                });
        },
        deleteFriendshipRequest() {
            axios
                .delete(`/friendships/${this.sender.name}`)
                .then(res => {
                    this.localFriendshipStatus = res.data.friendship_status;
                })
                .catch(err => {
                    console.log(err.response.data);
                });
        }
    }
};
</script>
