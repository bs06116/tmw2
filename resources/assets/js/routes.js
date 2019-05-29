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
            }
        ]
    }
];

const router = new VueRouter({ mode: 'history', routes: routes})
export  default router;