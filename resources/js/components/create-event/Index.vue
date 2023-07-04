<template>
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

    <form class="form-birthday" @submit.prevent="createEvent">
        <label for="title">Название</label>
        <div>
            <input type="text" id="title" v-model="title" />
        </div>

        <label for="text">Текст</label>
        <div>
            <textarea id="text" v-model="text" />
        </div>
        <button class="btn" type="submit">Создать</button>
    </form>
</template>

<script>
export default {
    name: "CreateEvent",
    data: () => ({
        title: null,
        text: null,
        user: null,

        errored: [],
    }),
    mounted() {
        if (localStorage.getItem("user")) {
            this.user = JSON.parse(localStorage.getItem("user"));
        }
    },
    methods: {
        async createEvent() {
            await axios
                .post(
                    `/api/create-event`,
                    {
                        user_id: this.user.id,
                        title: this.title,
                        text: this.text,
                    },
                    {
                        headers: { Authorization: `Bearer ${this.user.token}` },
                    }
                )
                .then((response) => {
                    this.title = null;
                    this.text = null;

                    this.$router.push({
                        name: "User",
                        params: { id: this.user.id },
                    });
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
                        case "The title field is required.":
                            this.errored.push("Введите заголовок");
                            break;
                        case "The text field is required.":
                            this.errored.push("Введите текст");
                            break;
                        case "The title field must not be greater than 255 characters.":
                            this.errored.push(
                                "Заголовок не должен превышать 255 символов"
                            );
                            break;
                    }
                });
            }
        },
    },
};
</script>

<style scoped>
.form-birthday input {
    width: 800px;

    border: 1px solid #8fbc8f;
    border-radius: 10px;

    padding: 10px;
    margin: 10px 0;
}
.form-birthday textarea {
    width: 800px;
    resize: vertical;
    height: 300px;

    border: 1px solid #8fbc8f;
    border-radius: 10px;

    padding: 10px;
    margin: 10px 0;
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
.text-danger {
    color: #8b0000;
}
</style>
