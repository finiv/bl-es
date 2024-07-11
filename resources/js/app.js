// import { createApp, h } from 'vue';
// import { createInertiaApp } from '@inertiajs/inertia-vue3';
// import { InertiaProgress } from '@inertiajs/progress';
// import { ZiggyVue } from 'ziggy';
// import { Ziggy } from './ziggy';
//
// createInertiaApp({
//     resolve: name => {
//         const pages = import.meta.glob('./Pages/**/*.vue');
//         return pages[`./Pages/${name}.vue`]();
//     },
//     setup({ el, App, props, plugin }) {
//         createApp({ render: () => h(App, props) })
//             .use(plugin)
//             .use(ZiggyVue, Ziggy)
//             .mount(el)
//     },
// });
//
// InertiaProgress.init();

// main.js або app.js
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
// import { ZiggyVue } from 'ziggy';
// import { Ziggy } from './ziggy'; // Переконайтеся, що ви правильно імпортуєте Ziggy конфігурацію


createInertiaApp({
    resolve: name => import(`./Pages/${name}.vue`).then(module => module.default),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
});

