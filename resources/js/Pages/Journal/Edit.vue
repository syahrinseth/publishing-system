<template>
    <div>
        <Layout :auth="auth.user.data">
            <template v-slot:header>
                <div class="lg:flex lg:items-center lg:justify-between">
                    <div class="flex-1 min-w-0">
                        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                            Edit Journal
                        </h2>
                    </div>
                    <div class="mt-5 flex lg:mt-0 lg:ml-4">
                        <span class="sm:ml-3">
                            <button v-if="journalForm.status == 'draft'" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" @click="publishJournal">
                                <NewspaperIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                                Publish Journal
                            </button>
                            <button v-else class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500" @click="draftJournal">
                                <DocumentTextIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                                Revert to Draft
                            </button>
                        </span>
                    </div>
                </div>
            </template>
            <template v-slot:default>
                <form @submit.prevent="update">
                    <div>
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">General Information</h3>
                                <p class="mt-1 text-sm text-gray-600">
                                This information will be displayed publicly so be careful what you share.
                                </p>
                            </div>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <div class="shadow sm:rounded-md sm:overflow-hidden">
                                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                        <div class="grid grid-cols-3 gap-6">
                                            <div class="col-span-3 sm:col-span-2">
                                                <label for="company-website" class="block text-sm font-medium text-gray-700">
                                                Journal Title
                                                </label>
                                                <input v-model="journalForm.name" type="text" name="name" id="name" autocomplete="name" placeholder="Title Here" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3 gap-6">
                                            <div class="col-span-3 sm:col-span-2">
                                                <label for="company-website" class="block text-sm font-medium text-gray-700">
                                                Journal Date
                                                </label>
                                                <input v-model="journalForm.date" type="date" name="date" id="date" autocomplete="date" placeholder="Date Here" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                        <button class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" type="submit">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hidden sm:block" aria-hidden="true">
                        <div class="py-5">
                            <div class="border-t border-gray-200" />
                        </div>
                    </div>
                    
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="flex justify-between px-4 py-5 sm:px-6">
                            <div class="">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Manuscripts
                                </h3>
                            </div>
                            <div>
                                <span class="sm:ml-3">
                                    <div class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer" @click="showManuscriptAddModel = !showManuscriptAddModel;">
                                        <PlusIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                                        Add Manuscript 
                                    </div>
                                </span>
                            </div>
                        </div>

                        
                        
                        <div class="border-t border-gray-200 text-sm">
                            <table class="min-w-full divide-y divide-gray-200 table-fixed">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            #
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Title
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Type
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Authors
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Last Modified
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <draggable
                                        tag="transition-group"
                                        v-model="list"
                                        v-bind="dragOptions"
                                        @start="drag = true"
                                        @end="drag = false"
                                        item-key="order"
                                    >
                                        <template #item="{ element }">
                                            <tr :key="element.id + '-attach'" class="list-group-item">
                                                <td class="px-6 py-4 whitespace-nowrap cursor-move" :class="
                                                    element.fixed ? 'fa fa-anchor' : 'glyphicon glyphicon-pushpin'
                                                "
                                                @click="element.fixed = !element.fixed"
                                                aria-hidden="true">
                                                    <MenuIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true"/>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ element.order }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ element.title }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ element.type.name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ element.authors.map(x => x.name).join(', ') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ element.status}}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ element.updated_at}}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                </td>
                                            </tr>
                                        </template>
                                    </draggable>
                                    <rawDisplayer class="col-3" :value="list" title="List" />
                                </tbody>
                            </table>
                        </div>

                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <button class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" type="submit">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>

                    <Modal :show="showManuscriptAddModel" @close="showManuscriptAddModel = false;">
                        <template v-slot:default>
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                    <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">
                                        Add Manuscripts
                                    </DialogTitle>
                                    <div class="mt-2">
                                        <form @submit.prevent="updateAttach">
                                            <div class="grid grid-cols-3 gap-6 mb-2">
                                                <div class="col-span-3 sm:col-span-3">
                                                    <label for="company-website" class="block text-sm font-medium text-gray-700">
                                                    Manuscripts
                                                    </label>
                                                    <VueMultiselect v-model="manuscripSelect.selected" id="ajax" label="title" :custom-label="(v) => `${v.manuscript_no} - ${v.title || 'Untitled'}`" track-by="id" placeholder="Type to search" open-direction="bottom" :options="manuscripSelect.options" :multiple="true" :searchable="true" :loading="manuscripSelect.isLoading" :internal-search="false" :clear-on-select="false" :close-on-select="false" :options-limit="300" :max-height="600" :show-no-results="false" :hide-selected="true" @search-change="asyncFindManuscripts">
                                                    </VueMultiselect>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template v-slot:footer>
                            <div class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer" @click="importManuscript()">
                                Import
                            </div>
                            <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="showManuscriptAddModel = false" ref="cancelButtonRef">
                                Cancel
                            </button>
                        </template>
                    </Modal>
                </form>
            </template>
        </Layout>
    </div>
</template>
<script>
import Layout from '../../Layout'
import { useForm, Link } from '@inertiajs/inertia-vue3'
import Toast from '../../Components/Toast'
import { Inertia } from '@inertiajs/inertia'
import { NewspaperIcon, DocumentTextIcon, PlusIcon, MenuIcon } from '@heroicons/vue/solid'
import { DialogTitle } from '@headlessui/vue'
import Modal from '../../Components/Modal'
import Table from '../../Components/Table'
import VueMultiselect from 'vue-multiselect'
import moment from 'moment'
import draggable from 'vuedraggable'

const message = [
  "vue.draggable",
  "draggable",
  "component",
  "for",
  "vue.js 2.0",
  "based",
  "on",
  "Sortablejs"
];

export default {
    components: {
        Layout,
        useForm,
        Link,
        Toast,
        Inertia,
        NewspaperIcon,
        DocumentTextIcon,
        PlusIcon,
        Modal,
        Table,
        DialogTitle,
        VueMultiselect,
        draggable,
        MenuIcon
    },
    props: {
        auth: Object,
        journal: Object
    },
    computed: {
        dragOptions() {
            return {
                animation: 200,
                group: "description",
                disabled: false,
                ghostClass: "ghost"
            };
        }
    },
    data() {
        return {
            list: [],
            moment,
            drag: false,
            showManuscriptAddModel: false,
            manuscripSelect: {
                selected: [],
                options: [],
                isLoading: false
            }
        }
    },
    methods: {
        sort() {
            this.list = this.list.sort((a, b) => a.order - b.order);
        },
        importManuscript() {
            if (this.manuscripSelect.selected.length == 0) {
                return 0;
            }
            this.journalForm.manuscripts = this.list.map(x => x.id).concat(this.manuscripSelect.selected.map(x => x.id));
            console.log(this.journalForm.manuscripts);
            this.journalForm.post(`/admin/journals/${this.$props.journal.data.id}/update`, {
                preserveScroll: true,
                onError: (errors) => {
                    Object.keys(errors).forEach((value, index) => {
                        this.notification(errors[value], 'error');
                    });
                },
                onSuccess: (res) => {
                    this.manuscripSelect.selected = [];
                    window.location.reload();
                    this.notification('Manuscript Imported.', 'success');
                }
            });
            this.journalForm.manuscripts = [];
        },
        asyncFindManuscripts: _.debounce(async function(query) {
            this.manuscripSelect.isLoading = true;
            let resp = await window.axios.get('/api/manuscripts', {
                params: {
                    search: query,
                    isPublished: true,
                    excepts: this.journalForm.manuscripts,
                    isInOtherJournals: false
                }
            });
            this.manuscripSelect.isLoading = false;
            if (resp.status == 200) {
                this.manuscripSelect.options = resp.data;
                return 0;
            }
            this.manuscripSelect.options = [];
            return 0;
        }, 300),
        notification(message, type = 'success') {
            this.$toast.open({
                message: message,
                type: type,
                duration: 5000,
                dismissible: true
            });
        },
        async update() {
            this.journalForm.manuscripts = this.list.map((manuscript, index) => {
                return manuscript.id;
            });
            this.journalForm.post(`/admin/journals/${this.$props.journal.data.id}/update`, {
                preserveScroll: true,
                onError: (errors) => {
                    Object.keys(errors).forEach((value, index) => {
                        this.notification(errors[value], 'error');
                    });
                },
                onSuccess: (res) => {
                    this.notification('Saved.', 'success');
                }
            });
        },
        publishJournal() {
            if (confirm("Are you sure to publish this journal?")) {
                this.journalForm.status = 'published';
                this.journalForm.post(`/admin/journals/${this.$props.journal.data.id}/update`, {
                    preserveScroll: true,
                    onError: (errors) => {
                        Object.keys(errors).forEach((value, index) => {
                            this.notification(errors[value], 'error');
                        });
                    },
                    onSuccess: () => {
                        this.notification("Journal Published.", 'success');
                    }
                });
            }
        },
        draftJournal() {
            if (confirm("Are you sure to revert this journal to draft?")) {
                this.journalForm.status = 'draft';
                this.journalForm.post(`/admin/journals/${this.$props.journal.data.id}/update`, {
                    preserveScroll: true,
                    onError: (errors) => {
                        Object.keys(errors).forEach((value, index) => {
                            this.notification(errors[value], 'error');
                        });
                    },
                    onSuccess: () => {
                        this.notification("Reverted to Draft.", 'success');
                    }
                });
            }
        }
    },
    created() {
        this.list = this.journal.data.manuscripts.map((manuscript, index) => {
            manuscript.order = index + 1;
            return manuscript;
        });
        this.asyncFindManuscripts();
    },
    setup(props) {
        const journalForm = useForm({
            name: props.journal.data.name,
            date: moment(props.journal.data.date).format('YYYY-MM-DD'),
            status: props.journal.data.status,
            manuscripts: props.journal.data.manuscripts.map(x => x.id),
            user_id: props.journal.data.user_id
        });

        return {
            journalForm
        };
    },
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<style>
.button {
  margin-top: 35px;
}
.flip-list-move {
  transition: transform 0.5s;
}
.no-move {
  transition: transform 0s;
}
.ghost {
  opacity: 0.5;
  background: #c8ebfb;
}
.list-group {
  min-height: 20px;
}
</style>