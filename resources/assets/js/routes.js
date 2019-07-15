import  VueRouter from  "vue-router";
import store from "./store"
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
                component: require('./views/all_member'),
                meta: {
                    requiresAuth: true
                }
            },
            {
                name: 'add_member',
                path: '/add-member',
                component: require('./views/add_member'),
                meta: {
                    requiresAuth: true
                }
            },
            {
                name: 'edit_member',
                path: '/edit-member/:memberId',
                component: require('./views/edit_member'),
                props: true,
                meta: {
                    requiresAuth: true
                }
            },
            {
                name: 'member',
                path: '/member/:memberId',
                component: require('./views/details_member'),
                props: true,
                meta: {
                    requiresAuth: true
                }
            }
        ]
    }
];

const router = new VueRouter({ mode: 'history', routes: routes})
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (!store.getters.getLogged) {
            next({ name: 'login' })
        } else {
            next() // go to wherever I'm going
        }
    } else {
        if (store.getters.getLogged) {
            next({name: 'all_member'})

        }else{
            next() // does not require auth, make sure to always call next()!
        }

    }
})
export  default router;