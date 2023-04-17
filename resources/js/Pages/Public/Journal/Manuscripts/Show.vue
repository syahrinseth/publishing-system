<template>
    <div>
        <PublicLayout :auth="auth">
            <template v-slot:default>
                <div class="bg-white">
                    <div class="">
                        <!-- Product info -->
                        <div class="max-w-2xl mx-auto pb-16 px-4 sm:px-6 lg:max-w-7xl lg:px-8 lg:grid lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8">
                        <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
                            <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">
                                {{ manuscript.title }}
                            </h1>
                            
                        </div>

                        <!-- Options -->
                        <div class="mt-4 lg:mt-0 lg:row-span-3">
                            <div class="text-sm text-gray-600 mb-2 h-96 overflow-auto">
                                <div class="mb-3">
                                    <a :href="`/journals/${journal.id}/manuscripts/${manuscript.id}/download`" target="_blank" class="mt-2 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm">
                                        PDF <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75v6.75m0 0l-3-3m3 3l3-3m-8.25 6a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                                        </svg>
                                    </a>
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <div>
                                        <div class="my-5 text-lg">
                                            <b>Published</b> 
                                            <p>{{ moment(journal.date).format('DD MMMM YYYY') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <div>
                                        <div class="my-5 text-lg">
                                            <b>Issue</b> 
                                            <p>{{ journal.name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="py-10 lg:pt-6 lg:pb-16 lg:col-start-1 lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
                            <div class="grid grid-cols-1">
                                <div v-for="author in manuscript.get_authors" :key="author.id">
                                    <h3 class="text-xl font-bold">{{ author.first_name }} {{ author.last_name }}</h3>
                                    <h6 class="text-md font-light">{{ author.affiliation }}</h6>
                                </div>
                                <div v-for="coAuthor in manuscript.get_co_authors" :key="coAuthor.id">
                                    <h3 class="text-xl font-bold">{{ coAuthor.first_name }} {{ coAuthor.last_name }}</h3>
                                    <h6 class="text-md font-light">{{ coAuthor.affiliation }}</h6>
                                </div>
                            </div>
                            <div class="mt-5 grid grid-cols-1">
                                <div>
                                    <p class="my-5 text-lg"><b>Keywords:</b> {{ manuscript.keywords }}</p>
                                </div>
                                <div>
                                    <div class="my-5 text-lg">
                                        <b>Abstract</b> 
                                        <p>{{ manuscript.abstract }}</p>
                                    </div>
                                </div>
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
import PublicLayout from '../../../../PublicLayout.vue'
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
        journal: Object,
        auth: Object,
        manuscript: Object
    }
};
</script>

