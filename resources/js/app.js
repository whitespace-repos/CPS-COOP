require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp , Head, Link} from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
import vSelect from 'vue-select'
import VCalendar from 'v-calendar';
import { Calendar, DatePicker } from 'v-calendar';

import 'vue-select/dist/vue-select.css';
import 'v-calendar/dist/style.css';


createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(VCalendar, {})
            .component('InertiaHead', Head)
            .component('InertiaLink', Link)
            .component("v-select", vSelect)
            .component('Calendar', Calendar)
            .component('DatePicker', DatePicker)
            .mixin({
                methods: {
                            route,
                            toDecimal : str => Number(str).toFixed(2)
                }
            })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
