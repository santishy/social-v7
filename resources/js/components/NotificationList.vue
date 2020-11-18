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
            v-pre

        >
            Notifications <span class="caret"></span>
        </a>

        <div
            class="dropdown-menu dropdown-menu-right"
            aria-labelledby="dropdownNotifications"
        >
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
            notifications: []
        };
    },
    components: { NotificationListItem },
    created() {
        axios.get("/notifications").then(res => {
            this.notifications = res.data;
            console.log(this.notifications)
        });
    }
};
</script>
