<template>
    <div class="item">
        <router-link :to="{ name: 'Home' }" class="logo">События</router-link>

        <div class="card">
            <div v-if="Object.keys(errored).length">
                <ul>
                    <li v-for="(error, index) in errored" :key="index">
                        <div class="text-danger">
                            {{ error }}
                        </div>
                    </li>
                </ul>
            </div>

            <form @submit.prevent="loginUser">
                <div>
                    <label for="login">Логин</label>
                    <input type="text" v-model="login" id="login" />
                </div>

                <div>
                    <label for="password">Пароль</label>
                    <input type="password" v-model="password" id="password" />
                </div>

                <div class="card-footer">
                    <router-link :to="{ name: 'Register' }">
                        Регистрация
                    </router-link>
                    <button class="btn" type="submit">Войти</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "Login",
    data: () => ({
        login: null,
        password: null,

        errored: [],
    }),
    methods: {
        async loginUser() {
            await axios
                .post("/api/login", {
                    login: this.login,
                    password: this.password,
                })
                .then((response) => {
                    this.login = "";
                    this.password = "";

                    localStorage.setItem(
                        "user",
                        JSON.stringify({
                            token: response.data.token,
                            id: response.data.result.id,
                        })
                    );

                    this.$router.push({ name: "Home" });
                })
                .catch((error) => {
                    this.errorMessage(error.response.data.errors);
                    setTimeout(() => {
                        this.errored = [];
                    }, 2500);
                })
                .finally(() => {});
        },

        errorMessage(errors) {
            for (let index in errors) {
                let error = errors[index];
                error.forEach((element) => {
                    switch (element) {
                        case "The login field is required.":
                            this.errored.push("Введите логин");
                            break;
                        case "The password field is required.":
                            this.errored.push("Введите пароль");
                            break;
                        case "Wrong login or password":
                            this.errored.push("Неверный логин или пароль");
                            break;
                    }
                });
            }
        },
    },
};
</script>

<style scoped>
.item {
    margin: 2rem;
}
.logo {
    color: #8fbc8f;
    font-size: 24px;
    text-transform: uppercase;
}
.card {
    width: 500px;

    margin: 10rem auto;
    padding: 20px;

    background: white;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
    border-radius: 10px;
}
.card div {
    margin: 10px 0;
}
.card input {
    width: 100%;

    border: 1px solid #8fbc8f;
    border-radius: 10px;

    padding: 10px;
}
.btn {
    display: block;

    border: 1px solid #8fbc8f;
    background-color: #8fbc8f;
    border-radius: 10px;

    color: #fff;

    padding: 10px;

    cursor: pointer;
}
.card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.text-danger {
    color: #8b0000;
}
</style>
