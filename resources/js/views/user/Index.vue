<template>
    <div v-if="loader">...загрузка</div>
    <div v-else>
        <div class="item">
            <div class="user-info">
                <h2>
                    {{ userData.result.name }}
                    {{ userData.result.last_name }}
                </h2>

                <span v-if="userData.result.id === user.id">
                    <span v-if="userData.result.birthday === null">
                        <router-link :to="{ name: 'Birthday' }">
                            <p class="user-birthday">указать дату рождения</p>
                        </router-link>
                    </span>
                    <span v-else>
                        <router-link :to="{ name: 'Birthday' }">
                            <p>дата рождения:</p>
                            <h3>
                                {{
                                    userData.result.birthday
                                        .split("-")
                                        .reverse()
                                        .join(".")
                                }}
                            </h3>
                        </router-link>
                    </span>
                </span>
                <span v-else>
                    <span v-if="userData.result.birthday !== null">
                        <p>дата рождения:</p>
                        <h3>
                            {{
                                userData.result.birthday
                                    .split("-")
                                    .reverse()
                                    .join(".")
                            }}
                        </h3>
                    </span>
                </span>

                <span>
                    <p>дата регистрации:</p>
                    <h3>{{ userData.result.created_at }}</h3>
                </span>

                <span v-if="userData.result.id === user.id">
                    <router-link :to="{ name: 'CreateEvent' }" class="btn">
                        Создать событие
                    </router-link>
                </span>
            </div>

            <div class="cards-events">
                <h2 v-if="!userData.result.events.length">Событий нет</h2>
                <h2 v-else>События:</h2>
                <ul>
                    <li v-for="event in userData.result.events" :key="event.id">
                        <router-link
                            :to="{ name: 'Event', params: { id: event.id } }"
                        >
                            {{ event.title }}
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "User",
    components: {},
    data: () => ({
        user: null,
        userData: {},
        loader: true,
    }),
    props: {
        id: String,
    },
    mounted() {
        if (localStorage.getItem("user")) {
            this.user = JSON.parse(localStorage.getItem("user"));
        }
        this.getUser(this.user.token);
    },
    methods: {
        async getUser(token) {
            await axios
                .get(`/api/user/${this.id}`, {
                    headers: { Authorization: `Bearer ${token}` },
                })
                .then((responce) => {
                    this.userData = JSON.parse(responce.request.response);

                    this.loader = false;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>

<style scoped>
.item {
    display: flex;
}
.user-info {
    width: 300px;
}
.user-info h2 {
    color: #8fbc8f;
}
.user-birthday {
    color: #8fbc8f;
    margin: 1rem 0;
}
.btn {
    display: block;

    border: 1px solid #8fbc8f;
    background-color: #8fbc8f;
    border-radius: 10px;

    color: #fff;
    text-align: center;

    padding: 10px;
    margin-top: 3rem;

    cursor: pointer;
}
.cards-events {
    padding-left: 2rem;
}
.cards-events h2 {
    color: #8fbc8f;
    margin-bottom: 10px;
}
.cards-events li {
    margin-bottom: 10px;
}
</style>
