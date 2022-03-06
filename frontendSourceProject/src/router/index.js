import { createWebHistory, createRouter } from 'vue-router';

import IndexComponent from "@/components/IndexComponent";
import HomeComponent from "@/components/HomeComponent";
import CreatePostComponent from "@/components/CreatePostComponent";
import ShowPostComponent from "@/components/ShowPostComponent";

const routes = [
    {
        path: '/',
        name: 'IndexComponent',
        component: IndexComponent
    },
    {
        path: '/home',
        name: 'HomeComponent',
        component: HomeComponent
    },
    {
        path: '/create',
        name: 'CreatePostComponent',
        component: CreatePostComponent
    },
    {
        path: '/show/:id',
        name: 'ShowPostComponent',
        component: ShowPostComponent
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;