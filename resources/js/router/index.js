import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/",
        name: "Home",
        component: () => import("@/views/main/Index.vue"),
        children: [
            {
                path: "user/:id",
                name: "User",
                component: () => import("@/views/user/Index.vue"),
                props: true,
                beforeEnter: (to, from, next) => {
                    if (!localStorage.getItem("user")) next({ name: "Home" });
                    else next();
                },
            },
            {
                path: "user/birthday",
                name: "Birthday",
                component: () => import("@/components/birthday/Index.vue"),
                beforeEnter: (to, from, next) => {
                    if (!localStorage.getItem("user")) next({ name: "Home" });
                    else next();
                },
            },
            {
                path: "create-event",
                name: "CreateEvent",
                component: () => import("@/components/create-event/Index.vue"),
                beforeEnter: (to, from, next) => {
                    if (!localStorage.getItem("user")) next({ name: "Home" });
                    else next();
                },
            },
            {
                path: "event/:id",
                name: "Event",
                component: () => import("@/components/event/Index.vue"),
                props: true,
            },
        ],
    },
    {
        path: "/login",
        name: "Login",
        component: () => import("@/views/login/Index.vue"),
        beforeEnter: (to, from, next) => {
            if (!localStorage.getItem("user")) {
                next();
            } else {
                next({ name: "Home" });
            }
        },
    },
    {
        path: "/register",
        name: "Register",
        component: () => import("@/views/register/Index.vue"),
        beforeEnter: (to, from, next) => {
            if (!localStorage.getItem("user")) {
                next();
            } else {
                next({ name: "Home" });
            }
        },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
