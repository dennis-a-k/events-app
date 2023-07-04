<template>
    <div class="main-app">
        <Header />

        <main>
            <div v-if="loader">...загрузка</div>

            <div v-else>
                <div v-if="authUser">
                    <EventsUser :user="userData" :events="eventsData" />
                </div>

                <div v-else>
                    <EventsView :events="eventsData" />
                </div>
            </div>
        </main>

        <footer></footer>
    </div>
</template>

<script>
import Header from "@/components/Header.vue";
import EventsUser from "@/components/events-user/Index.vue";
import EventsView from "@/components/events-view/Index.vue";

export default {
    name: "Home",
    components: {
        Header,
        EventsUser,
        EventsView,
    },
    data: () => ({
        loader: true,
        authUser: null,
        eventsData: {},
        userData: {},
    }),
    mounted() {
        if (localStorage.getItem("user")) {
            this.authUser = JSON.parse(localStorage.getItem("user"));

            return this.getUser(this.authUser.token, this.authUser.id);
        }

        this.getEvents();
        this.loader = false;
    },
    methods: {
        async getUser(token, id) {
            await axios
                .get(`/api/user/${id}`, {
                    headers: { Authorization: `Bearer ${token}` },
                })
                .then((responce) => {
                    this.userData = JSON.parse(responce.request.response);

                    this.getEvents();
                    this.loader = false;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getEvents() {
            await axios
                .get(`/api/events`)
                .then((responce) => {
                    this.eventsData = JSON.parse(responce.request.response);
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
.main-app {
    min-height: 100vh;
    display: grid;
    grid-template: minmax(auto, auto) 1fr minmax(auto, auto) / 1fr;
}
main {
    margin: 1rem 2rem;
}
</style>
