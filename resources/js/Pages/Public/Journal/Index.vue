<template>
    <div>
        <PublicLayout :auth="auth">
            <template v-slot:default>
                <div class="bg-white">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="lg:text-center">
                            <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Journal Published</h2>
                            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">Lorem ipsum, dolor sit amet.</p>
                        </div>
                    <div class="mt-10">
                        <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                        <div v-for="journal in journals.data" :key="journal.name" class="relative">
                            <dt>
                            <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                
                            </div>
                            <Link :href="`/journals/${journal.id}`" class="ml-16 text-lg leading-6 font-medium text-gray-900">{{ journal.name }}</Link>
                            <small class="px-2">
                                {{ moment(journal.date).format('DD/MM/YYYY') }}
                            </small>
                            </dt>
                            <dd class="mt-2 ml-16 text-base text-gray-500">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </dd>
                        </div>
                        </dl>
                    </div>
                    </div>
                </div>
            </template>
        </PublicLayout>
    </div>
</template>
<script>
import PublicLayout from '../../../PublicLayout.vue'
import { AnnotationIcon, GlobeAltIcon, LightningBoltIcon, ScaleIcon } from '@heroicons/vue/outline'
import { Link } from '@inertiajs/inertia-vue3'
import moment from 'moment'

export default {
    components: {
        PublicLayout,
        AnnotationIcon,
        GlobeAltIcon,
        LightningBoltIcon,
        ScaleIcon,
        Link
    },
    props: {
        auth: Object,
        journals: Object
    },
    setup() {
        return {
            moment
        }
    },
}
</script>
