import  VueRouter from  "vue-router";
const routes = [
    {
        path: '/',
       redirect: { name: 'login' }
    },
    {
        name: 'login',
        path: '/',
        component: require('./views/login.vue')
    },
    {
        name: 'layout',
        path: 'layout',
        component: require('./views/common/layout.vue'),
        children:[
            {
                name: 'all_member',
                path: '/all-member',
                component: require('./views/all_member')
            },
            {
                name: 'add_member',
                path: '/add-member',
                component: require('./views/add_member.vue')
            },
            {
                name: 'edit_member',
                path: '/edit-member/:memberId',
                component: require('./views/edit_member.vue'),
                props: true,
            },
            {
                name: 'member',
                path: '/member/:memberId',
                component: require('./views/details_member.vue'),
                props: true,
            }
        ]
    }
];

const router = new VueRouter({ mode: 'history', routes: routes})
export  default router;