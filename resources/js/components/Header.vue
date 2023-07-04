<template>
    <div class="card">
        <router-link :to="{ name: 'Home' }" class="logo">События</router-link>

        <ul v-if="!user">
            <li>
                <router-link :to="{ name: 'Login' }"> Авторизация </router-link>
            </li>
            <li>
                <router-link :to="{ name: 'Register' }">
                    Регистрация
                </router-link>
            </li>
        </ul>

        <ul v-else>
            <li>
                <a href="#" @click="logout">Выход</a>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "Header",
    data: () => ({
        user: null,
    }),
    mounted() {
        if (localStorage.getItem("user")) {
            this.user = JSON.parse(localStorage.getItem("user"));
        }
    },
    methods: {
        async logout() {
            await axios
                .post(
                    "/api/logout",
                    {},
                    {
                        headers: { Authorization: `Bearer ${this.user.token}` },
                    }
                )
                .then((responce) => {
                    this.user = null;

                    localStorage.removeItem("user");

                    this.$router.push({ name: "Login" });
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>

<style scoped>
.card {
    background: white;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
    border-radius: 10px;

    margin: 0 2rem;
    padding: 20px;

    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card ul {
    display: flex;
    align-items: center;
}

.card li {
    margin: 0 10px;
}

.logo {
    color: #8fbc8f;
    font-size: 24px;
    text-transform: uppercase;
}
</style>
