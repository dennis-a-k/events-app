<template>
    <div class="item">
        <router-link :to="{ name: 'Home' }" class="logo">События</router-link>

        <div class="card">
            <div v-if="Object.keys(errored).length">
                <ul>
                    <li
                        class="text-danger"
                        v-for="(error, index) in errored"
                        :key="index"
                    >
                        {{ error }}
                    </li>
                </ul>
            </div>

            <form @submit.prevent="registerUser">
                <div>
                    <label for="login">Логин (минимум 5 символов)</label>
                    <input type="text" v-model="login" id="login" />
                </div>

                <div>
                    <label for="name">Имя</label>
                    <input type="text" v-model="name" id="name" />
                </div>

                <div>
                    <label for="last_name">Фамилия</label>
                    <input type="text" v-model="last_name" id="last_name" />
                </div>

                <div>
                    <label for="password">Пароль (минимум 8 символов)</label>
                    <input type="password" v-model="password" id="password" />
                </div>

                <div>
                    <label for="password_confirmation">Повторите пароль</label>
                    <input
                        type="password"
                        v-model="password_confirmation"
                        id="password_confirmation"
                    />
                </div>

                <div class="card-footer">
                    <router-link :to="{ name: 'Login' }">
                        Авторизация
                    </router-link>
                    <button class="btn" type="submit">Регистрация</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "Register",
    data: () => ({
        login: null,
        name: null,
        last_name: null,
        password: null,
        password_confirmation: null,

        errored: [],
    }),
    methods: {
        async registerUser() {
            await axios
                .post("/api/register", {
                    login: this.login,
                    name: this.name,
                    last_name: this.last_name,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                })
                .then((response) => {
                    this.login = "";
                    this.name = "";
                    this.last_name = "";
                    this.password = "";
                    this.password_confirmation = "";

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
                    console.log(element);
                    switch (element) {
                        case "The login field must be at least 5 characters.":
                            this.errored.push("Логин менее 5 символов");
                            break;
                        case "The login field is required.":
                            this.errored.push("Введите логин");
                            break;
                        case "The password field is required.":
                            this.errored.push("Введите пароль");
                            break;
                        case "The password field must be at least 8 characters.":
                            this.errored.push("Пароль менее 8 символов");
                            break;
                        case "The login has already been taken.":
                            this.errored.push("Логин уже занят");
                            break;
                        case "The name field is required.":
                            this.errored.push("Введите имя");
                            break;
                        case "The password field confirmation does not match.":
                            this.errored.push("Подтвердите пароль");
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

    margin: 3rem auto;
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
