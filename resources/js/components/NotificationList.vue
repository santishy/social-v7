<template>
    <li class="nav-item dropdown">
        <a
            id="dropdownNotifications"
            dusk="notifications"
            class="nav-link dropdown-toggle"
            href="#"
            role="button"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
            :class="this.count ? 'text-primary font-weight-bold' : ''"
        >
            <slot></slot>
            {{ count }}
            <span class="caret"></span>
        </a>
        <div
            class="dropdown-menu dropdown-menu-right"
            aria-labelledby="dropdownNotifications"
        >
            <div class="dropdown-header text-center">
                Notifications
            </div>
            <notification-list-item
                v-for="notification in notifications"
                :key="notification.id"
                :notification="notification"
            ></notification-list-item>
        </div>
    </li>
</template>
<script>
import NotificationListItem from "./NotificationListItem.vue";
export default {
    data() {
        return {
            notifications: [],
            count: ""
        };
    },
    components: { NotificationListItem },
    created() {
        axios.get("/notifications").then(res => {
            this.notifications = res.data;
            this.unreadNotifications();
        });
        EventBus.$on("read-notification", () => {
            if (this.count === 1) {
                return (this.count = "");
            }
            return this.count--;
        });

        EventBus.$on("unread-notification", () => {
            this.count++;
        });
    },
    methods: {
        unreadNotifications() {
            this.count =
                this.notifications.filter(notification => {
                    return notification.read_at === null;
                }).length || "";
        }
    }
};
</script>
