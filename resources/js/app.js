require('./bootstrap');

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'
import Layout from './Layout'
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

InertiaProgress.init()

createInertiaApp({
    resolve: name => {
        const page = import(`./Pages/${name}`)
        page.layout = page.layout || Layout
        return page
    },
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })
    app.use(VueToast)
    app.use(plugin)
    app.mount(el)
  },
})