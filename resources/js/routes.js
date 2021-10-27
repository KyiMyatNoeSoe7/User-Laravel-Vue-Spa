import AllUser from './components/AllUser.vue';
import Register from './components/Register.vue';
import Profile from './components/Profile.vue';
import Login from './components/Login.vue';
import Home from './components/Home.vue';
import About from './components/About.vue';
import ProfileEdit from './components/ProfileEdit.vue';
import App from './components/App.vue';
 
export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'edit',
        path: '/edit/:id',
        component: ProfileEdit
    },
    {
        name: 'app',
        path: '/app',
        component: App
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'alluser',
        path: '/alluser',
        component: AllUser,
    },
    {
        name: 'profile',
        path: '/profile',
        component: Profile,
    },
    {
        name: 'about',
        path: '/about',
        component: About
    }
];