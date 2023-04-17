<template>
    <div>
        <PublicLayout :auth="auth">
            <template v-slot:default>
                <div class="bg-white">
                    <div class="">
                        <!-- Product info -->
                        <div class="max-w-2xl mx-auto pb-16 px-4 sm:px-6 lg:max-w-7xl lg:px-8 lg:grid lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8">
                        <div class="lg:col-span-3 lg:border-r-cancel lg:border-gray-200 lg:pr-8">
                            <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">
                                Collection of Journals
                            </h1>
                            
                        </div>

                        <div class="py-10 lg:pt-6 lg:pb-16 lg:col-start-1 lg:col-span-3 lg:border-gray-200 lg:pr-8">

                            <div class="mt-5" v-for="journal in journals.data" :key="journal.id">
                                <h2 class="text-xl font-medium text-gray-900"><a :href="`/journals/${journal.id}`" class="text-indigo-500 hover:text-indigo-800">{{ journal.name }}</a></h2>
                                <p class="mb-5">
                                    Published date: {{ moment(journal.date).format("DD/MM/YYYY") }}
                                </p>
                                <hr/>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
            </template>
        </PublicLayout>
    </div>
</template>
<script>
import PublicLayout from '../../../PublicLayout.vue'
import { DownloadIcon } from '@heroicons/vue/outline'
import moment from 'moment'
export default {
    components: {
        PublicLayout,
        DownloadIcon,
    },
    data() {
        return {
            moment
        }
    },
    setup() {
        
    },
    props: {
        journals: Array,
        auth: Object
    }
};
</script>

