import VueRouter from 'vue-router'
// Pages
import Home from './components/Home'
import Upload from './components/Upload'
// Routes
const routes = [
    {
        path: '/',
        name: 'home',
        component: Home,
    },
    {
        path: '/upload',
        name: 'upload',
        component: Upload,
    },
];
const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
});
export default router