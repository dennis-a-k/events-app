<template>
    <div class="item">
        <div class="events-lists">
            <h2>Все события:</h2>

            <span v-if="Object.keys(events).length === 0">
                <p>список пуст</p>
            </span>
            <ul v-else>
                <li v-for="event in events.result" :key="event.id">
                    <router-link
                        :to="{ name: 'Event', params: { id: event.id } }"
                    >
                        {{ event.title }}
                    </router-link>
                </li>
            </ul>
        </div>

        <div>
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
export default {
    name: "Events",
    props: {
        events: Object,
    },
};
</script>

<style scoped>
.item {
    display: flex;
}
.events-lists {
    width: 300px;
}
.events-lists h2 {
    color: #8fbc8f;
    margin-bottom: 10px;
}
.events-lists li {
    margin-bottom: 10px;
}
</style>
