<template>
    <div>
        <PublicLayout :auth="auth">
            <template v-slot:default>
                <div class="bg-white">
                    <div class="">
                        <!-- Product info -->
                        <div class="max-w-2xl mx-auto pt-10 pb-16 px-4 sm:px-6 lg:max-w-7xl lg:pt-16 lg:pb-24 lg:px-8 lg:grid lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8">
                        <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
                            <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">
                                {{ journal.data.name }}
                            </h1>
                            <p>
                                Published date: {{ moment(journal.data.date).format("DD/MM/YYYY") }}
                            </p>
                        </div>

                        <!-- Options -->
                        <div class="mt-4 lg:mt-0 lg:row-span-3">
                            <h2 class="">Description:</h2>
                            <div class="text-sm text-gray-600 mb-2 h-96 overflow-auto">
                                {{ journal.data.description }}
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

                            <!-- Document -->
                            <!-- <div class="mt-10">
                                <div class="flex items-center justify-between">
                                <h3 class="text-sm text-gray-900 font-medium">Document</h3>
                                <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Document guide</a>
                                </div>

                            </div> -->

                            <button type="submit" class="mt-10 w-full bg-indigo-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <DownloadIcon class="h-6 w-6 px-1" aria-hidden="true" />
                                Download Full-Text PDF
                            </button>
                            </form>
                        </div>

                        <div class="py-10 lg:pt-6 lg:pb-16 lg:col-start-1 lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
                            <!-- Description and details -->
                            <div>
                            <h3 class="text-lg bold">Recent Articles</h3>
                            <small>Articles most recently published online for this journal.</small>

                            <div class="space-y-6">
                                <p class="text-base text-gray-900"></p>
                            </div>
                            </div>


                            <div class="mt-10" v-for="manuscript in manuscripts.data" :key="manuscript.id">
                                <h2 class="text-sm font-medium text-gray-900">{{ manuscript.title }}</h2>

                                <div class="mt-4 space-y-6 mb-5">
                                    <p class="text-sm text-gray-600">
                                        {{ manuscript.abstract }}
                                    </p>
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

