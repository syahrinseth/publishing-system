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
                                {{ moment(journal.data.date).format("DD/MM/YYYY") }}
                            </p>
                        </div>

                        <!-- Options -->
                        <div class="mt-4 lg:mt-0 lg:row-span-3">
                            <h2 class="">Publisher:</h2>
                            <div class="text-2xl text-gray-900  ">Prof Syamsir
                            </div>
                            <div class="text-sm text-gray-600 mb-2">University Sains Islam  Malaysia</div>

                            <h2 class="">Authors:</h2>
                            <div class="text-2xl text-gray-900  ">Syahrin
                            </div>
                            <div class="text-sm text-gray-600">University Sains Islam  Malaysia</div>
                            <div class="text-2xl">Ahmad</div>
                            <div class="text-sm text-gray-600 mb-2">University Malaya</div>

                            <h2 class="">Co-author:</h2>
                            <div class="text-2xl">Saiful</div>
                            <div class="text-sm text-gray-600 mb-2">University Malaya</div>

                            <form class="mt-10">

                            <!-- Document -->
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
                        </div>

                        <div class="py-10 lg:pt-6 lg:pb-16 lg:col-start-1 lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
                            <!-- Description and details -->
                            <div>
                            <h3 class="sr-only">Description</h3>

                            <div class="space-y-6">
                                <p class="text-base text-gray-900"></p>
                            </div>
                            </div>


                            <div class="mt-10">
                            <h2 class="text-sm font-medium text-gray-900">Details</h2>

                            <div class="mt-4 space-y-6">
                                <p class="text-sm text-gray-600"></p>
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
        auth: Object
    }
};
</script>

