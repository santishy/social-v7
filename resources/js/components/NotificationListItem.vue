<template>
    <div>
        <a
            :dusk="notification.id"
            class="dropdown-item"
            :href="notification.data.link"
        >
            {{ notification.data.message }}
        </a>
        <button
            v-if="isRead"
            :dusk="`mark-as-unread-${notification.id}`"
            @click.stop="markAsUnread"
        >
            Marcar como no leído
        </button>
        <button
            v-else
            :dusk="`mark-as-read-${notification.id}`"
            @click.stop="markAsRead"
        >
            Marcar como leído
        </button>
    </div>
</template>
<script>
export default {
    data() {
        return {
            isRead: !!this.notification.data.read_at
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
                });
        },
        markAsUnread() {
            axios
                .delete(`/read-notifications/${this.notification.id}`)
                .then(res => {
                    this.isRead = false;
                });
        }
    }
};
</script>
