require('./bootstrap');

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'
import Layout from './Layout'

InertiaProgress.init()

createInertiaApp({
    resolve: name => {
        const page = import(`./Pages/${name}`)
        page.layout = page.layout || Layout
        return page
    },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .mount(el)
  },
})