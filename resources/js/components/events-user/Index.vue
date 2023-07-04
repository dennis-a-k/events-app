<template>
    <router-link :to="{ name: 'User', params: { id: user.result.id } }">
        <h1>{{ user.result.name }}&nbsp;{{ user.result.last_name }}</h1>
    </router-link>

    <div class="item">
        <div class="events-lists">
            <h2>Все события:</h2>

            <span v-if="Object.keys(events).length === 0">
                <p>список пуст</p>
                <hr />
            </span>
            <ul v-else>
                <li v-for="event in events.result" :key="event.id">
                    <router-link
                        :to="{
                            name: 'Event',
                            params: { id: event.id },
                        }"
                    >
                        {{ event.title }}
                    </router-link>
                </li>
            </ul>
            <hr />

            <h2>Мои события:</h2>

            <span v-if="!user.result.events.length">
                <p>список пуст</p>
            </span>
            <ul v-else>
                <li v-for="event in user.result.events" :key="event.id">
                    <router-link
                        :to="{
                            name: 'Event',
                            params: { id: event.id },
                        }"
                    >
                        {{ event.title }}
                    </router-link>
                </li>
            </ul>
        </div>

        <div class="event-info">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
export default {
    name: "EventsUser",
    props: {
        events: Object,
        user: Object,
    },
};
</script>

<style scoped>
a {
    display: inline-block;
}
h1 {
    width: auto;
    margin-bottom: 25px;
}
hr {
    margin: 10px;
    border: 1px solid #8fbc8f;
}
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
.event-info {
    padding-left: 20px;
}
</style>
