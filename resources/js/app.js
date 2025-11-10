import '../css/app.css';
import './bootstrap';

import { createInertiaApp, Head, Link } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

// ✅ import Flowbite
// import 'flowbite';
// import 'flowbite/dist/flowbite.css';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        // return createApp({ render: () => h(App, props) })
        //     .use(plugin)
        //     .use(ZiggyVue)
        //     .use(VueSweetalert2)
        //     .mount(el);

        const app =  createApp({ render: () => h(App, props) })
            app.use(plugin)
            app.use(ZiggyVue, Ziggy)
            app.use(VueSweetalert2),
            window.Swal =  app.config.globalProperties.$swal

            app.mount(el)
    },
    progress: {
        color: '#4B5563',
    },
});
