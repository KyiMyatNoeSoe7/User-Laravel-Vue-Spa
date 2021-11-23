import Register from './components/Register.vue';
import Profile from './components/Profile.vue';
import Login from './components/Login.vue';
import Home from './components/Home.vue';
import About from './components/About.vue';
import App from './components/App.vue';
import Post from './components/Post.vue';
import PostDetail from './components/PostDetail.vue';
import ContactUs from './components/ContactUs.vue';
import Admin from './components/Admin.vue';
import ContactList from './components/ContactList.vue';
 
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
        name: 'post',
        path: '/post',
        component: Post,
    },
    {
        name: 'contactus',
        path: '/contactus',
        component: ContactUs,
    },
    {
        name: 'postdetail',
        path: '/postdetail',
        component: PostDetail,
    },
    {
        name: 'profile',
        path: '/profile',
        component: Profile,
    },
    {
        name: 'admin',
        path: '/admin',
        component: Admin
    },
    {
        name: 'contactList',
        path: '/contactList',
        component: ContactList
    },
    {
        name: 'about',
        path: '/about',
        component: About
    }
];