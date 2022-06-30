<template>
  <div>
    <div v-if="links.length > 3" class="flex flex-wrap -mb-1">
      <template v-for="(link, key) in links">
        <div v-if="link.url === null" :key="key" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded" v-html="link.label" preserve-scroll />
        <inertia-link v-else :key="link" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500" :class="{ 'bg-white': link.active }" :href="link.url" v-html="link.label" preserve-scroll />
      </template>
    </div>
    <div class="my-2 flex justify-end">
        <small class="text-gray-600">Showing {{ meta.from }} to {{ meta.to }} of {{ meta.total }} results.</small>
    </div>
  </div>
</template>

<script>
import {InertiaLink} from "@inertiajs/inertia-vue3";

export default {
  props: {
    links: Array,
    meta: Object
  },
  components : {
    InertiaLink
  }
}
</script>