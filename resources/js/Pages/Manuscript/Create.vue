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
                                    <div class="shadow sm:rounded-md">
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
                                                <JetInputError :message="manuscriptForm.errors.type" class="mt-2" />
                                            </div>
                                            <div class="col-span-3 sm:col-span-2">
                                                <label for="company-website" class="block text-sm font-medium text-gray-700">
                                                Author(s) <span class="text-red-600">*</span>
                                                </label>
                                                <VueMultiselect 
                                                v-model="manuscriptForm.authors" track-by="id" label="first_name" :custom-label="(value) => `${value.first_name} ${value.last_name || ``} ${value.field == null ? `` : `- ${value.field}`} ${value.affiliation == null ? `` : `- ${value.affiliation}`}`" placeholder="Type to search" open-direction="bottom" :options="authorSelect.options" :multiple="true" :searchable="true" :loading="authorSelect.isLoading" :internal-search="false" :clear-on-select="false" :close-on-select="false" :options-limit="300" :max-height="600" :show-no-results="false" :hide-selected="true" @search-change="asyncFindAuthors" :taggable="true" @tag="createNewAuthorModal" tag-placeholder="Press enter to add new user">
                                                </VueMultiselect>
                                                <JetInputError :message="manuscriptForm.errors.authors" class="mt-2" />
                                            </div>
                                            <div class="col-span-3 sm:col-span-2">
                                                <label for="company-website" class="block text-sm font-medium text-gray-700">
                                                Co-Author(s) <span class="text-red-600">*</span>
                                                </label>
                                                <VueMultiselect 
                                                v-model="manuscriptForm.corresponding_authors" track-by="id" label="first_name" :custom-label="(value) => `${value.first_name} ${value.last_name || ``} ${value.field == null ? `` : `- ${value.field}`} ${value.affiliation == null ? `` : `- ${value.affiliation}`}`" placeholder="Type to search" open-direction="bottom" :options="authorSelect.options" :multiple="true" :searchable="true" :loading="authorSelect.isLoading" :internal-search="false" :clear-on-select="false" :close-on-select="false" :options-limit="300" :max-height="600" :show-no-results="false" :hide-selected="true" @search-change="asyncFindAuthors" :taggable="true" @tag="createNewCoAuthorModal" tag-placeholder="Press enter to add new user">
                                                    </VueMultiselect>
                                                <JetInputError :message="manuscriptForm.errors.corresponding_authors" class="mt-2" />
                                            </div>
                                            <div class="col-span-3 sm:col-span-2">
                                                <div class="col-span-3 sm:col-span-2">
                                                    <label for="company-website" class="block text-sm font-medium text-gray-700">
                                                    Request Editor(s) <span class="text-red-600">*</span>
                                                    </label>
                                                    <VueMultiselect 
                                                    v-model="manuscriptForm.editor" track-by="id" label="first_name" :custom-label="(value) => `${value.first_name} ${value.last_name || ``} ${value.field == null ? `` : `- ${value.field}`} ${value.affiliation == null ? `` : `- ${value.affiliation}`}`" placeholder="Type to search" open-direction="bottom" :options="editorSelect.options" :multiple="false" :searchable="true" :loading="editorSelect.isLoading" :internal-search="false" :clear-on-select="false" :close-on-select="false" :options-limit="300" :max-height="600" :show-no-results="false" :hide-selected="true" @search-change="asyncFindEditors" :taggable="true" @tag="createNewEditorModal" tag-placeholder="Press enter to add new user">
                                                        </VueMultiselect>
                                                    <JetInputError :message="manuscriptForm.errors.editors" class="mt-2" />
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
                                        <h3 class="text-lg font-medium leading-6 text-gray-900">Manuscript Data</h3>
                                        <p class="mt-1 text-sm text-gray-600">
                                            When possible these fields will be populated with information collected from your uploaded submission file. Steps requiring review will be marked with a warning icon. Please review these fields to be sure we found the correct information and fill in any missing details.
                                        </p>
                                    </div>
                                    </div>
                                    <div class="mt-5 md:mt-0 md:col-span-2">
                                        <div class="shadow sm:rounded-md">
                                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                            <div>
                                            <label for="title" class="block text-sm font-medium text-gray-700">
                                                Full Title <span class="text-red-600">*</span>
                                            </label>
                                            <div class="mt-1">
                                                <textarea v-model="manuscriptForm.title" id="title" name="title" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="" />
                                                <JetInputError :message="manuscriptForm.errors.title" class="mt-2" />
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
                            <div class="py-3 text-right">
                                <button class="mx-1 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Proceed
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <Modal :show="showAddUserModal" @close="showAddUserModal = false;">
                    <template v-slot:default>
                        <div class="mt-2">
                            <div>
                                <div class="md:grid md:grid-cols-3 md:gap-6">
                                <div class="md:col-span-1">
                                    <div class="px-4 sm:px-0">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Add New User</h3>
                                    </div>
                                </div>
                                <div class="mt-5 md:mt-0 md:col-span-2">
                                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                            <div class="col-span-12 sm:col-span-12">
                                                <label for="first-name" class="block text-sm font-medium text-gray-700">First Name</label>
                                                <input v-model="userForm.first_name" type="text" name="first-name" id="first-name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                            </div>
                                            <div class="col-span-12 sm:col-span-12">
                                                <label for="last-name" class="block text-sm font-medium text-gray-700">Last Name</label>
                                                <input v-model="userForm.last_name" type="text" name="last-name" id="last-name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                            </div>
                                            <div class="col-span-12 sm:col-span-12">
                                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                                <input v-model="userForm.email" type="text" name="email" id="email" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-slot:footer>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <span @click="submitUserForm()" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer">Add</span>
                        </div>
                    </template>
                </Modal>
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
import JetInputError from '../../Components/InputError.vue';
import Modal from '../../Components/Modal';
import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions, Menu, MenuButton, MenuItem, MenuItems, DialogTitle } from '@headlessui/vue'

export default {
    components: {
        Layout,
        DialogTitle,
        Modal,
        Link,
        Toast,
        VueMultiselect,
        JetInputError
    },
    props: {
        types: Array,
        auth: Object,
        articleTypes: Array,
        authors: Array,
        correspondingAuthors: Array,
        editors: Array
    },
    data() {
        return {
            showAddUserModal: false,
            showAddUserModalDataIncludeIntoInput: 'authors',
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
        createNewAuthorModal(newUser) {
            this.assignNewUserIntoUserFormInputs(newUser);
            this.showAddUserModal = true;
            this.showAddUserModalDataIncludeIntoInput = 'authors';
        },
        createNewCoAuthorModal(newUser) {
            this.assignNewUserIntoUserFormInputs(newUser);
            this.showAddUserModal = true;
            this.showAddUserModalDataIncludeIntoInput = 'corresponding_authors';
        },
        createNewEditorModal(newUser) {
            this.assignNewUserIntoUserFormInputs(newUser);
            this.showAddUserModal = true;
            this.showAddUserModalDataIncludeIntoInput = 'editors';
        },
        createNewReviewerModal(newUser) {
            this.assignNewUserIntoUserFormInputs(newUser);
            this.showAddUserModal = true;
            this.showAddUserModalDataIncludeIntoInput = 'reviewers';
        },
        assignNewUserIntoUserFormInputs(newUser) {
            const parts = newUser.split(' ');

            const tag = {
                id: 0,
                last_name: parts.pop(),
                first_name: parts.pop()
            };

            this.userForm.first_name = tag['first_name'];
            this.userForm.last_name = tag['last_name'];
        },
        notification(message, type = 'success') {
            this.$toast.open({
                message: message,
                type: type,
                duration: 5000,
                dismissible: true
            })
        },      
        async submit() {
            this.manuscriptForm.editors = [this.manuscriptForm.editor];
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
        async submitUserForm() {
            await window.axios.post('/api/users', {
                first_name: this.userForm.first_name,
                last_name: this.userForm.last_name,
                email: this.userForm.email,
                password: this.userForm.password,
                password_confirmation: this.userForm.password
            })
                .then((res) => {
                    if (res.status >= 200 && res.status < 300) {
                        let user = res.data;
                        this.notification('User added', 'success');
                        if (this.showAddUserModalDataIncludeIntoInput == 'authors') {
                            this.manuscriptForm.authors.push(user);
                        } else if(this.showAddUserModalDataIncludeIntoInput == 'corresponding_authors') {
                            this.manuscriptForm.corresponding_authors.push(user);
                        } else if (this.showAddUserModalDataIncludeIntoInput == 'editors') {
                            this.manuscriptForm.editor = user;
                        } else {
                            this.manuscriptForm.reviewers.push(user);
                        }
                        this.showAddUserModal = false;
                        this.userForm.email = null;
                    }
                })
                .catch((err) => {
                    if (err.response) {
                        let errors = err.response.data.errors;
                        Object.keys(errors).forEach((value, index) => {
                            this.notification(errors[value][0], 'error');
                        });
                    } else {
                        this.notification(err.message, 'error');
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
                this.editorSelect.options = resp.data?.map(v => {
                    return {
                        id: v.id,
                        first_name: v.first_name,
                        last_name: v.last_name,
                        field: v.field,
                        affiliation: v.affiliation,
                    }
                });
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
                this.reviewerSelect.options = resp.data?.map(v => {
                    return {
                        id: v.id,
                        first_name: v.first_name,
                        last_name: v.last_name,
                        field: v.field,
                        affiliation: v.affiliation,
                    }
                });
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
                this.authorSelect.options = resp.data?.map(v => {
                    return {
                        id: v.id,
                        first_name: v.first_name,
                        last_name: v.last_name,
                        field: v.field,
                        affiliation: v.affiliation,
                    }
                });
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
            authors: [{
                id: props.auth.user.data?.id,
                first_name: props.auth.user.data?.first_name,
                last_name: props.auth.user.data?.last_name,
                field: props.auth.user.data?.field,
                affiliation: props.auth.user.data?.affiliation,
            }],
            corresponding_authors: [],
            editors: [],
            editor: null,
            reviewers: [],
        });

        const generateString = (length) => {
            let result = ' ';
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            const charactersLength = characters.length;
            for ( let i = 0; i < length; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }

            return result;
        }

        const userForm = useForm({
            first_name: null,
            last_name: null,
            email: null,
            password: generateString(8),
            password_confirmation: null
        });

        return {
            manuscriptForm,
            userForm,
            generateString
        };
    },
    async created() {
        this.asyncFindAuthors();
        this.asyncFindEditors();
        this.asyncFindReviewers();
    },
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<style>
.multiselect--active {
  z-index: 9999;
}
</style>