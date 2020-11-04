<template>
    <div @click="redirectIfGuest">
        <transition-group name="status-list-transition">
            <status-list-item
                v-for="status in statuses"
                :status="status"
                :key="status.id"
            >
            </status-list-item>
        </transition-group>
    </div>
</template>

<script>
import StatusListItem from "./StatusListItem.vue";
export default {
    data() {
        return {
            statuses: []
        };
    },
    props: {
        url: String
    },
    components: {
        "status-list-item": StatusListItem
    },
    mounted() {
        axios
            .get(this.getUrl)
            .then(res => {
                this.statuses = res.data.data;
            })
            .catch(err => {
                console.log(err.response);
            });
        EventBus.$on("status-created", status => {
            this.statuses.unshift(status);
        });
        Echo.channel("statuses").listen("StatusCreated", e => {
            // podria ser ({status}) => {...} en lugar de (e) => {...}
            this.statuses.unshift(e.status);
        });
    },
    computed: {
        getUrl() {
            return this.url ? this.url : "/statuses";
        }
    }
};
</script>
<style>
.status-list-transition-move{
  transition: all .8s;
}
</style>
