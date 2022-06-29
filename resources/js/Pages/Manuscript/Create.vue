<template>
    <div>
        <Layout :auth="auth.user.data">
            <template v-slot:header>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Submit Manuscript
                </h2>
            </template>
            <template v-slot:default>
                <form @submit.prevent="submit">
                    <div>
                        <div class="mt-10 sm:mt-0">
                            <div class="md:grid md:grid-cols-3 md:gap-6">
                                <div class="md:col-span-1">
                                <div class="px-4 sm:px-0">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">General Information</h3>
                                    <p class="mt-1 text-sm text-gray-600">
                                        <span>
                                            Please select type of manuscript in the dropdown menu.
                                        </span>
                                    </p>
                                    <p class="mt-1 text-sm text-gray-600">
                                        <span>
                                            Please identify your submission's areas of interest and specialization by selecting one or more classifications.
                                        </span>
                                    </p>
                                    <p class="mt-1 text-sm text-gray-600">
                                        <span>
                                            Please name specific Authors, Editors to be assigned to your submission. The request will be taken under advisement by the Editor.
                                        </span>
                                    </p>
                                </div>
                                </div>
                                <div class="mt-5 md:mt-0 md:col-span-2">
                                <form @submit.prevent="saveManuscript()">
                                    <div class="shadow overflow-hidden sm:rounded-md">
                                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                        <div class="grid grid-cols-3 gap-6">
                                            <div class="col-span-3 sm:col-span-2">
                                                <label for="company-website" class="block text-sm font-medium text-gray-700">
                                                Article Type <span class="text-red-600">*</span>
                                                </label>
                                                <select name="company-website" id="company-website" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="www.example.com" v-model="manuscriptForm.type">
                                                    <option value="" selected>Select</option>
                                                    <option v-for="type in articleTypes" :key="type.id" :value="type.id">
                                                        {{ type.name }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-span-3 sm:col-span-2">
                                                <label for="company-website" class="block text-sm font-medium text-gray-700">
                                                Author(s) <span class="text-red-600">*</span>
                                                </label>
                                                <VueMultiselect 
                                                v-model="manuscriptForm.authors_obj" id="ajax" label="first_name" :custom-label="(value) => `${value.first_name} ${value.last_name || ``}`" track-by="id" placeholder="Type to search" open-direction="bottom" :options="authorSelect.options" :multiple="true" :searchable="true" :loading="authorSelect.isLoading" :internal-search="false" :clear-on-select="false" :close-on-select="false" :options-limit="300" :max-height="600" :show-no-results="false" :hide-selected="true" @search-change="asyncFindAuthors">
                                                    </VueMultiselect>
                                            </div>
                                            <div class="col-span-3 sm:col-span-2">
                                                <div class="col-span-3 sm:col-span-2">
                                                    <label for="company-website" class="block text-sm font-medium text-gray-700">
                                                    Request Editor(s) <span class="text-red-600">*</span>
                                                    </label>
                                                    <VueMultiselect 
                                                    v-model="manuscriptForm.editors_obj" id="ajax" label="first_name" :custom-label="(value) => `${value.first_name} ${value.last_name || ``}`" track-by="id" placeholder="Type to search" open-direction="bottom" :options="editorSelect.options" :multiple="false" :searchable="true" :loading="editorSelect.isLoading" :internal-search="false" :clear-on-select="false" :close-on-select="false" :options-limit="300" :max-height="600" :show-no-results="false" :hide-selected="true" @search-change="asyncFindEditors">
                                                        </VueMultiselect>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 h-12">
                                        </div>
                                    </div>
                                </form>
                                </div>
                            </div>
                            <div class="hidden sm:block" aria-hidden="true">
                                <div class="py-5">
                                    <div class="border-t border-gray-200" />
                                </div>
                            </div>  
                            <div>
                                <div class="md:grid md:grid-cols-3 md:gap-6">
                                    <div class="md:col-span-1">
                                        <div class="px-4 sm:px-0">
                                            <h3 class="text-lg font-medium leading-6 text-gray-900">Review Preferences</h3>
                                            <p class="mt-1 text-sm text-gray-600">
                                            Please name specific reviewers to be assigned to your submission. The request will be taken under advisement by the Editor. If you do not request any reviewers, your submission will be assigned to the appropriate reviewer(s) as determined by the Editorial staff.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-5 md:mt-0 md:col-span-2">
                                        <form @submit.prevent="saveManuscript()" >
                                            <div class="shadow sm:rounded-md sm:overflow-hidden">
                                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                                <div class="grid grid-cols-3 gap-6">
                                                    <div class="col-span-3 sm:col-span-2">
                                                        <label for="company-website" class="block text-sm font-medium text-gray-700">
                                                        Suggest Reviewer(s) <span class="text-red-600">*</span>
                                                        </label>
                                                        <div class="mt-1 flex rounded-md shadow-sm">
                                                        <VueMultiselect 
                                                        v-model="manuscriptForm.reviewers_obj" id="ajax" label="first_name" :custom-label="(value) => `${value.first_name} ${value.last_name || ``}`" track-by="id" placeholder="Type to search" open-direction="bottom" :options="reviewerSelect.options" :multiple="true" :searchable="true" :loading="reviewerSelect.isLoading" :internal-search="false" :clear-on-select="false" :close-on-select="false" :options-limit="300" :max-height="600" :show-no-results="false" :hide-selected="true" @search-change="asyncFindReviewers">
                                                            </VueMultiselect>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 h-12">
                                            </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="hidden sm:block" aria-hidden="true">
                                <div class="py-5">
                                    <div class="border-t border-gray-200" />
                                </div>
                            </div>
                            <div>
                                <div class="md:grid md:grid-cols-3 md:gap-6">
                                    <div class="md:col-span-1">
                                    <div class="px-4 sm:px-0">
                                        <h3 class="text-lg font-medium leading-6 text-gray-900">Manuscript Data</h3>
                                        <p class="mt-1 text-sm text-gray-600">
                                            When possible these fields will be populated with information collected from your uploaded submission file. Steps requiring review will be marked with a warning icon. Please review these fields to be sure we found the correct information and fill in any missing details.
                                        </p>
                                    </div>
                                    </div>
                                    <div class="mt-5 md:mt-0 md:col-span-2">
                                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                            <div>
                                            <label for="title" class="block text-sm font-medium text-gray-700">
                                                Full Title <span class="text-red-600">*</span>
                                            </label>
                                            <div class="mt-1">
                                                <textarea v-model="manuscriptForm.title" id="title" name="title" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="" />
                                            </div>
                                            <p class="mt-2 text-sm text-gray-500">
                                            </p>
                                            </div>
                                            <!--<div>
                                            <label for="short_title" class="block text-sm font-medium text-gray-700">
                                                Short Title
                                            </label>
                                            <div class="mt-1">
                                                <textarea v-model="manuscriptForm.short_title" id="short_title" name="short_title" rows="1" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="" />
                                            </div>
                                            </div>-->
                                            <div>
                                            <label for="abstract" class="block text-sm font-medium text-gray-700">
                                                Abstract
                                            </label>
                                            <div class="mt-1">
                                                <textarea v-model="manuscriptForm.abstract" id="abstract" name="abstract" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="" />
                                            </div>
                                            <p class="mt-2 text-sm text-gray-500">
                                                Limit 300 words
                                            </p>
                                            </div>

                                            <div>
                                            <label for="keywords" class="block text-sm font-medium text-gray-700">
                                                Keywords
                                            </label>
                                            <div class="mt-1">
                                                <textarea v-model="manuscriptForm.keywords" id="keywords" name="keywords" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="" />
                                            </div>
                                            <p class="mt-2 text-sm text-gray-500">
                                                Please enter keywords separated by semicolons. Each individual keyword may be up to 256 characters in length.
                                            </p>
                                            </div>

                                            <div>
                                            <!-- <label for="authors" class="block text-sm font-medium text-gray-700">
                                                Authors
                                            </label>
                                            <div class="mt-1">
                                                <textarea v-model="manuscriptForm.authors" id="authors" name="authors" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="" />
                                            </div> -->
                                            <p class="mt-2 text-sm text-gray-500">
                                            </p>
                                            </div>

                                            <div>
                                            <label for="funding_information" class="block text-sm font-medium text-gray-700">
                                                Funding Information
                                            </label>
                                            <div class="mt-1">
                                                <textarea v-model="manuscriptForm.funding_information" id="funding_information" name="funding_information" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="" />
                                            </div>
                                            <p class="mt-2 text-sm text-gray-500">

                                            </p>
                                            </div>

                                            
                                        </div>

                                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 h-12">
                                    </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="hidden sm:block" aria-hidden="true">
                                <div class="py-5">
                                    <div class="border-t border-gray-200" />
                                </div>
                            </div> -->
                            <!-- <div class="mt-10 sm:mt-0">
                                <div class="md:grid md:grid-cols-3 md:gap-6">
                                    <div class="md:col-span-1">
                                    <div class="px-4 sm:px-0">
                                        <h3 class="text-lg font-medium leading-6 text-gray-900">Additional Information</h3>
                                        <p class="mt-1 text-sm text-gray-600">
                                            Please respond to the presented questions/statements.
                                        </p>
                                    </div>
                                    </div>
                                    <div class="mt-5 md:mt-0 md:col-span-2">
                                        <div class="shadow overflow-hidden sm:rounded-md">
                                        <div class="px-4 py-5 bg-white sm:p-6">
                                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                                <fieldset>
                                                <legend class="text-base font-medium text-gray-900">Please confirm that you have mentioned all organizations that funded your research in the Acknowledgements section of your submission, including grant numbers where appropriate.</legend>
                                                <div class="mt-4 space-y-4">
                                                    <div class="flex items-start">
                                                    <div class="flex items-center h-5">
                                                        <input v-model="manuscriptForm.is_confirm_grant_numbers" id="is_confirm_grant_numbers" name="is_confirm_grant_numbers" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                                    </div>
                                                    <div class="ml-3 text-sm">
                                                        <label for="is_confirm_grant_numbers" class="font-medium text-gray-700">I Confirm</label>
                                                        <p class="text-gray-500">I confirm that I have mentioned all organizations that funded my research in the Acknowledgements section of my submission, including grant numbers where appropriate.</p>
                                                    </div>
                                                    </div>
                                                </div>
                                                </fieldset>
                                                <div class="hidden sm:block" aria-hidden="true">
                                                    <div class="py-5">
                                                        <div class="border-t border-gray-200" />
                                                    </div>
                                                </div>
                                                <fieldset>
                                                <legend class="text-base font-medium text-gray-900">Sensors Malaysia is an open access journal which charges an Article Publishing Charge (APC) to cover the cost associated with the publication process. All articles published Open Access will be immediately and permanently free on ScienceDirect for users to read, download, and use in accordance with the author’s selected Creative Commons user license. </legend>
                                                <div class="mt-4 space-y-4">
                                                    <div class="flex items-start">
                                                    <div class="flex items-center h-5">
                                                        <input v-model="manuscriptForm.is_acknowledge" id="is_acknowledge" name="is_acknowledge" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                                    </div>
                                                    <div class="ml-3 text-sm">
                                                        <label for="is_acknowledge" class="font-medium text-gray-700">I Acknowledge</label>
                                                        <p class="text-gray-500">As an Author, I acknowledge I need to pay the Article Publishing Charge if my manuscript is accepted for publication</p>
                                                    </div>
                                                    </div>
                                                </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="py-3 text-right">
                                <button class="mx-1 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Proceed
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </template>
        </Layout>
  </div>
</template>
<script>
import Layout from '../../Layout'
import { Link, useForm } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import Toast from '../../Components/Toast'
import VueMultiselect from 'vue-multiselect'

export default {
    components: {
        Layout,
        Link,
        Toast,
        VueMultiselect,
    },
    data() {
        return {
            input: {
                type: "",
            },
            authorSelect: {
                isLoading: false,
                options: []
            },
            correspondingAuthorSelect: {
                isLoading: false,
                options: []
            },
            editorSelect: {
                isLoading: false,
                options: []
            },
            reviewerSelect: {
                isLoading: false,
                options: []
            },
        };
    },
    methods: {
        notification(message, type = 'success') {
            this.$toast.open({
                message: message,
                type: type,
                duration: 5000,
                dismissible: true
            })
        },
        async submit() {
            this.manuscriptForm.authors = this.manuscriptForm.authors_obj.map((user) => user.id);
            this.manuscriptForm.corresponding_authors = this.manuscriptForm.corresponding_authors_obj.map((user) => user.id);
            if (Array.isArray(this.manuscriptForm.editors_obj)) {
                this.manuscriptForm.editors = this.manuscriptForm.editors_obj.map((member) => member.id);
            } else {
                this.manuscriptForm.editors = ([this.manuscriptForm.editors_obj]).map((member) => member.id);
            }
            this.manuscriptForm.reviewers = this.manuscriptForm.reviewers_obj.map((user) => user.id);
            this.manuscriptForm.post(`/admin/manuscript-store`, {
                preserveScroll: true,
                onError: (errors) => {
                    Object.keys(errors).forEach((value, index) => {
                        this.notification(errors[value], 'error');
                    });
                },
                onSuccess: (res) => {
                    
                }
            });
        },
        notification(message, type = 'success') {
            this.$toast.open({
                message: message,
                type: type,
                duration: 5000,
                dismissible: true
            })
        },
        asyncFindEditors: _.debounce(async function(query) {
            this.editorSelect.isLoading = true;
            let resp = await window.axios.get('/api/users', {
                params: {
                    search: query,
                    role: 'Editor',
                }
            });
            this.editorSelect.isLoading = false;
            if (resp.status == 200) {
                this.editorSelect.options = resp.data;
                return 0;
            }
            this.editorSelect.options = [];
            return 0;
        }, 300),
        asyncFindReviewers: _.debounce(async function(query) {
            this.reviewerSelect.isLoading = true;
            let resp = await window.axios.get('/api/users', {
                params: {
                    search: query,
                    role: 'Reviewer',
                }
            });
            this.reviewerSelect.isLoading = false;
            if (resp.status == 200) {
                this.reviewerSelect.options = resp.data;
                return 0;
            }
            this.reviewerSelect.options = [];
            return 0;
        }, 300),
        asyncFindAuthors: _.debounce(async function(query) {
            this.authorSelect.isLoading = true;
            let resp = await window.axios.get('/api/users', {
                params: {
                    search: query || null,
                    role: 'Author',
                }
            });
            this.authorSelect.isLoading = false;
            if (resp.status == 200) {
                this.authorSelect.options = resp.data;
                return 0;
            }
            this.authorSelect.options = [];
            return 0;
        }, 300),
    },
    setup(props) {

        const manuscriptForm = useForm({
            type: "",
            title: null,
            authors: [],
            authors_obj: [],
            corresponding_authors: [],
            corresponding_authors_obj: [],
            editors: [],
            editors_obj: [],
            reviewers: [],
            reviewers_obj: [],
        });

        return {
            manuscriptForm
        };
    },
    async created() {
        this.asyncFindAuthors();
        this.asyncFindEditors();
        this.asyncFindReviewers();
    },
    props: {
        types: Array,
        auth: Object,
        articleTypes: Array,
    },
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<style>
.multiselect--active {
  z-index: 9999;
}
</style>