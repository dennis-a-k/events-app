<template>
    <form class="form-birthday" @submit.prevent="updateBirthday">
        <label for="date">Дата рождения</label>
        <div>
            <input
                type="date"
                id="date"
                v-model="birthday"
                min="1901-01-01"
                max="2199-12-31"
            />
        </div>
        <button class="btn" type="submit">Сохранить</button>
    </form>
</template>

<script>
export default {
    name: "Birthday",
    data: () => ({
        birthday: null,
        user: null,

        errored: [],
    }),
    mounted() {
        if (localStorage.getItem("user")) {
            this.user = JSON.parse(localStorage.getItem("user"));
        }
    },
    methods: {
        async updateBirthday() {
            await axios
                .post(
                    `/api/user/${this.user.id}`,
                    {
                        _method: "PATCH",
                        birthday: this.birthday,
                    },
                    {
                        headers: { Authorization: `Bearer ${this.user.token}` },
                    }
                )
                .then((response) => {
                    this.birthday = null;

                    this.$router.push({
                        name: "User",
                        params: { id: this.user.id },
                    });
                })
                .catch((error) => {
                    console.log(error);

                    setTimeout(() => {
                        this.errored = [];
                    }, 2500);
                })
                .finally(() => {});
        },
    },
};
</script>

<style scoped>
.form-birthday input {
    width: 220px;

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
</style>
