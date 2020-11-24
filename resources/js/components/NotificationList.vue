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

            <span dusk="notifications-count"> {{ count }}</span>
        </a>
        <div
            class="dropdown-menu dropdown-menu-right"
            aria-labelledby="dropdownNotifications"
        >
            <div class="dropdown-header text-center">
                <!-- <slot></slot>
                <span dusk="notifications-count">{{ count }}</span> -->
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
        if (this.isAuthenticated) {
            Echo.private(`App.User.${this.currentUser.id}`).notification(
                notification => {
                    this.count++;
                    this.notifications.push({
                        id: notification.id,
                        data: {
                            link: notification.link,
                            message: notification.message
                        }
                    });
                }
            );
        }

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
