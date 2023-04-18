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
                                {{ journal.name }}
                            </h1>
                            <p>
                                Published date: {{ moment(journal.date).format("DD/MM/YYYY") }}
                            </p>
                        </div>

                        <!-- Options -->
                        <!-- <div class="mt-4 lg:mt-0 lg:row-span-3">
                            <h2 class="">Description:</h2>
                            <div class="text-sm text-gray-600 mb-2 h-96 overflow-auto">
                                
                            </div>

                            <h2 class="">Editorial board:</h2>
                            <div v-show="editorial_board.publisher.length > 0" class="text-2xl text-gray-900">
                                Publisher
                            </div>
                            <div v-for="editor in editorial_board.publisher" :key="editor.id">
                                <div class="text-sm text-gray-600 mb-2">
                                    {{ editor.first_name }} {{ editor.last_name }} <span v-show="editor.affiliation">-</span> {{ editor.affiliation }}
                                </div>
                            </div>
                            <div v-show="editorial_board.chief_editor.length > 0" class="text-2xl text-gray-900">
                                Editor in Chief
                            </div>
                            <div v-for="editor in editorial_board.chief_editor" :key="editor.id">
                                <div class="text-sm text-gray-600 mb-2">
                                    {{ editor.first_name }} {{ editor.last_name }} <span v-show="editor.affiliation">-</span> {{ editor.affiliation }}
                                </div>
                            </div>
                            <div v-show="editorial_board.editor.length > 0" class="text-2xl text-gray-900">
                                Editor
                            </div>
                            <div v-for="editor in editorial_board.editor" :key="editor.id">
                                <div class="text-sm text-gray-600 mb-2">
                                    {{ editor.first_name }} {{ editor.last_name }} <span v-show="editor.affiliation">-</span> {{ editor.affiliation }}
                                </div>
                            </div>
                            

                            <form class="mt-10">

                             <div class="mt-10">
                                <div class="flex items-center justify-between">
                                <h3 class="text-sm text-gray-900 font-medium">Document</h3>
                                <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Document guide</a>
                                </div>

                            </div>

                            <button type="submit" class="mt-10 w-full bg-indigo-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <DownloadIcon class="h-6 w-6 px-1" aria-hidden="true" />
                                Download Full-Text PDF
                            </button>
                            </form>
                        </div> -->

                        <div class="py-10 lg:pt-6 lg:pb-16 lg:col-start-1 lg:col-span-3 lg:border-gray-200 lg:pr-8">
                            <!-- Description and details -->
                            <p class="mb-5">{{ journal.description }}</p>
                            <h3 class="text-2xl bold mb-5">Table of Content</h3>
                            <!-- <small>Articles most recently published online for this journal.</small> -->


                            <hr>

                            <div class="mt-10" v-for="manuscript in journal.get_manuscripts" :key="manuscript.id">
                                <h2 class="text-xl font-medium text-gray-900"><a :href="`/journals/${journal.id}/manuscripts/${manuscript.id}`" class="text-indigo-500 hover:text-indigo-800">{{ manuscript.title }}</a></h2>
                                <div class="mt-2 mb-5">
                                    <p class="text-sm text-gray-600">
                                        {{ manuscript.get_authors?.map(v => v?.first_name + ' ' + v?.last_name)?.join(', ') }}
                                    </p>
                                    <a :href="`/journals/${journal.id}/manuscripts/${manuscript.id}/download`" target="_blank" class="mt-2 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm">
                                        PDF <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75v6.75m0 0l-3-3m3 3l3-3m-8.25 6a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                                        </svg>
                                    </a>
                                </div>
                                
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
        journal: Object,
        auth: Object,
        manuscripts: Object,
        editorial_board: Array
    }
};
</script>

