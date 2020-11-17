<template>
    <li class="nav-item dropdown">
        <a
            id="navbarDropdownNotifications"
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
            aria-labelledby="navbarDropdownNotifications"
        >
            <a
                v-for="notification in notifications"
                :dusk="notification.id" 
                :key="notification.id"
                class="dropdown-item"
                :href="notification.data.link"
            >
                {{ notification.data.message }} 
                <button :dusk="`mark-as-read-${notification.id}`" >Leido</button>
            </a>
        </div>
    </li>
</template>
<script>
export default {
    data() {
        return {
            notifications: []
        };
    },
    created() {
        axios.get("/notifications").then(res => {
            this.notifications = res.data;
        });
    }
};
</script>
