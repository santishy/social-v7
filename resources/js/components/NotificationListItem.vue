<template>
    <div class="d-flex align-items-center dropdown-item" :class="isRead ? '' : 'bg-light'">
        <a
            :dusk="notification.id"
            class="dropdown-item"
            :href="notification.data.link"
        >
            {{ notification.data.message }}
        </a>
        <button
            class="btn btn-link mr-2"
            v-if="isRead"
            :dusk="`mark-as-unread-${notification.id}`"
            @click.stop="markAsUnread"
        >
           <i class="fas fa-circle"></i>
           <span class="position-absolute ml-2 py-1 px-2 text-white bg-dark w-50">Marcar como no leída</span>
        </button>
        <button
            v-else
            class="btn btn-link mr-2"
            :dusk="`mark-as-read-${notification.id}`"
            @click.stop="markAsRead"
        >
            
            <i class="far fa-circle"></i>
             <span class="position-absolute ml-2 py-1 px-2 text-white bg-dark w-50">Marcar como  leída</span>
        </button>
    </div>
</template>
<script>
export default {
    data() {
        return {
            isRead: !!this.notification.read_at,
        };
    },
    props: {
        notification: {
            type: Object,
            required: true
        }
    },
    methods: {
        markAsRead() {
            axios
                .post(`/read-notifications/${this.notification.id}`)
                .then(res => {
                    this.isRead = true;
                    EventBus.$emit('read-notification')
                });
        },
        markAsUnread() {
            axios
                .delete(`/read-notifications/${this.notification.id}`)
                .then(res => {
                    this.isRead = false;
                    EventBus.$emit('unread-notification')
                });
        }
    }
};
</script>
<style lang="scss" scoped>
    button > span {
        display:none;
    }
    button i{
        &:hover{
            & + span {
                display: inline;
            }
        }
    }
</style>