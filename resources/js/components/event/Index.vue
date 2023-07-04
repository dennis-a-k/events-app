<template>
    <div v-if="loader">...загрузка</div>

    <div v-else>
        <h2>{{ eventData.title }}</h2>
        <p>{{ eventData.text }}</p>
        <p class="event-date">дата создания: {{ eventData.created_at }}</p>
        <p>
            создатель:
            <router-link :to="'/user/' + eventData.user.id">
                {{ eventData.user.name }}&nbsp;{{ eventData.user.last_name }}
            </router-link>
        </p>

        <span v-if="!eventData.users.length"></span>
        <p v-else>
            участники:
            <span v-for="item in eventData.users" :key="item.id">
                <router-link class="user" :to="'/user/' + item.id">
                    {{ item.name }}&nbsp;{{ item.last_name }}
                </router-link>
            </span>
        </p>

        <span v-if="user">
            <span v-if="users">
                <button class="btn" @click="deleteUser(eventData.id)">
                    Отписаться
                </button>
            </span>
            <span v-else-if="user.id !== eventData.user.id">
                <button class="btn" @click="updateEvent(eventData.id)">
                    Участвовать
                </button>
            </span>

            <span v-else>
                <button class="btn" @click="deleteEvent(eventData.id)">
                    Удалить
                </button>
            </span>
        </span>
    </div>
</template>

<script>
export default {
    name: "Event",
    components: {},
    data: () => ({
        eventData: null,
        loader: true,
        user: null,
        users: false,
    }),
    props: {
        id: String,
    },
    mounted() {
        if (localStorage.getItem("user")) {
            this.user = JSON.parse(localStorage.getItem("user"));
        }

        this.getEvent(this.id);
    },
    methods: {
        async getEvent(id) {
            await axios
                .get(`/api/event/${id}`)
                .then((responce) => {
                    this.eventData = responce.data.result;

                    this.eventData.users.forEach((element) => {
                        if (element.id === this.user.id) {
                            this.users = true;
                        }
                    });
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => {
                    this.loader = false;
                });
        },

        deleteEvent(id) {
            axios
                .post(
                    `/api/event/${id}`,
                    {
                        _method: "DELETE",
                    },
                    {
                        headers: { Authorization: `Bearer ${this.user.token}` },
                    }
                )
                .then((responce) => {
                    this.$router.push({
                        name: "User",
                        params: { id: this.user.id },
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        updateEvent(id) {
            axios
                .post(
                    `/api/event/${id}`,
                    {
                        user_id: this.user.id,
                    },
                    {
                        headers: { Authorization: `Bearer ${this.user.token}` },
                    }
                )
                .then((responce) => {
                    this.$router.push({
                        name: "User",
                        params: { id: this.user.id },
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        deleteUser(id) {
            axios
                .post(
                    `/api/event/${id}`,
                    {
                        _method: "PATCH",
                        user_id: this.user.id,
                    },
                    {
                        headers: { Authorization: `Bearer ${this.user.token}` },
                    }
                )
                .then((responce) => {
                    this.$router.push({
                        name: "User",
                        params: { id: this.user.id },
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>

<style scoped>
h2 {
    color: #8fbc8f;
    margin-bottom: 10px;
}
.event-date {
    color: #8fbc8f;
    font-style: italic;

    margin: 10px 0;
}
.btn {
    border: 1px solid #8fbc8f;
    background-color: #8fbc8f;
    border-radius: 10px;

    color: #fff;

    padding: 10px;
    margin-top: 10px;

    cursor: pointer;
}
.user {
    font-size: 12px;
    color: #fff;

    background-color: #8fbc8f;

    border: 1px solid #8fbc8f;
    border-radius: 10px;

    padding: 0 3px;
    margin-right: 3px;
}
</style>
