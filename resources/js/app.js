require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp , Head, Link} from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
import vSelect from 'vue-select'
import VCalendar from 'v-calendar';
import { Calendar, DatePicker } from 'v-calendar';
import axios from 'axios';

import 'vue-select/dist/vue-select.css';
import 'v-calendar/dist/style.css';
import { Dataset, DatasetItem, DatasetInfo, DatasetPager, DatasetSearch, DatasetShow } from 'vue-dataset'
//
import VueLoading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import Maska from 'maska'
import { maska } from 'maska'


createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        const myApp = createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(VCalendar, {})
            .use(Maska)
            .use(VueLoading,{
                // Pass props by their camelCased names
                color: '#984346',
                loader: 'bars',
                width: 80,
                height: 80,
                backgroundColor: '#ffffff',
                opacity: 0.3,
                zIndex: 999,
            })
            .component('InertiaHead', Head)
            .component('InertiaLink', Link)
            .component("v-select", vSelect)
            .component('Calendar', Calendar)
            .component('DatePicker', DatePicker)
            .component('Dataset', Dataset)
            .component('DatasetItem', DatasetItem)
            .component('DatasetInfo', DatasetInfo)
            .component('DatasetPager', DatasetPager)
            .component('DatasetSearch', DatasetSearch)
            .component('DatasetShow', DatasetShow)
            .mixin({
                directives: { maska },
                props:['auth'],
                methods: {
                            route,
                            toDecimal : str => Number(str).toFixed(2),
                            preserveUrl: url => {
                                                    return  {
                                                                preserveState: true,
                                                                replace:true,
                                                                only:['products'],
                                                                onSuccess: () => {
                                                                    window.history.pushState("Update History","", url.replace(window.location.origin,""))
                                                                }
                                                    };
                            },
                }
            })
            .mount(el);

        let  loader = null;

        // Add a request interceptor
        axios.interceptors.request.use(function (config) {
            loader = myApp.$loading.show();
            return config;
        }, function (error) {
            // Do something with request error
            return Promise.reject(error);
        });

        // Add a response interceptor
        axios.interceptors.response.use(function (response) {
            loader.hide();
            return response;
        }, function (error) {
            return Promise.reject(error);
        });
        //
        return myApp;
    },
});

InertiaProgress.init({ color: '#4B5563' });
