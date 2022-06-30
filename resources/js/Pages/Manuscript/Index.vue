<template>
    <Layout :auth="auth.user.data">
        <template v-slot:header>
            <div class="lg:flex lg:items-center lg:justify-between">
                    <div class="flex-1 min-w-0">
                        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                            Manuscript Overview
                        </h2>
                    </div>
                    <div class="mt-5 flex lg:mt-0 lg:ml-4">

                    <span class="hidden sm:block ml-3">
                        <Link :href="`/admin/manuscript-create`" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" preserve-scroll>
                            <PlusIcon class="-ml-1 mr-2 h-5 w-5 text-white" aria-hidden="true" />
                            Submit Manuscript
                        </Link>
                    </span>

                    <!-- <span class="sm:ml-3">
                        <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <CheckIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                        Publish
                        </button>
                    </span> -->

                    <!-- Dropdown -->
                    <Menu as="span" class="ml-3 relative sm:hidden">
                        <MenuButton class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        More
                        <ChevronDownIcon class="-mr-1 ml-2 h-5 w-5 text-gray-500" aria-hidden="true" />
                        </MenuButton>

                        <transition enter-active-class="transition ease-out duration-200" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                        <MenuItems class="origin-top-right absolute right-0 mt-2 -mr-1 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                            <MenuItem v-slot="{ active }">
                            <a href="#" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">Edit</a>
                            </MenuItem>
                            <MenuItem v-slot="{ active }">
                            <a href="#" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">View</a>
                            </MenuItem>
                        </MenuItems>
                        </transition>
                    </Menu>
                </div>
            </div>
        </template>
        <template v-slot:default>
            <div class="w-full flex">
                <div class="w-64 my-3">
                    <input type="text" name="search" v-model="params.search" id="search" placeholder="Search" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                </div>
              </div>
            <Table>
                <template v-slot:header>
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase w-24">
                        #
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase w-64 cursor-pointer " @click="sort('title')">
                        <div class="columns-2">
                            <div>
                                Title 
                            </div>
                            <div>
                                <SortDescendingIcon v-if="(params.direction === 'desc' ? true : false) && (params.field === 'title')" class="-ml-1 mr-2 h-5 w-5 text-gray-500" aria-hidden="true" />
                                <SortAscendingIcon v-if="(params.direction === 'asc' ? true : false) && (params.field === 'title')" class="-ml-1 mr-2 h-5 w-5 text-gray-500" aria-hidden="true" />
                            </div>
                        </div>
                        </th>
                        <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Abstract
                        </th> -->
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" @click="sort('status')">
                            <div class="columns-2">
                                <div>
                                    Status
                                </div>
                                <div>
                                    <SortDescendingIcon v-if="(params.direction === 'desc' ? true : false) && (params.field === 'status')" class="-ml-1 mr-2 h-5 w-5 text-gray-500" aria-hidden="true" />
                                    <SortAscendingIcon v-if="(params.direction === 'asc' ? true : false) && (params.field === 'status')" class="-ml-1 mr-2 h-5 w-5 text-gray-500" aria-hidden="true" />
                                </div>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" @click="sort('updated_at')">
                            <div class="columns-2">
                                <div>
                                    Modified
                                </div>
                                <div>
                                    <SortDescendingIcon v-if="(params.direction === 'desc' ? true : false) && (params.field === 'updated_at')" class="-ml-1 mr-2 h-5 w-5 text-gray-500" aria-hidden="true" />
                                    <SortAscendingIcon v-if="(params.direction === 'asc' ? true : false) && (params.field === 'updated_at')" class="-ml-1 mr-2 h-5 w-5 text-gray-500" aria-hidden="true" />
                                </div>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" @click="sort('created_at')">
                            <div class="columns-2">
                                <div>
                                    Created
                                </div>
                                <div>
                                    <SortDescendingIcon v-if="(params.direction === 'desc' ? true : false) && (params.field === 'created_at')" class="-ml-1 mr-2 h-5 w-5 text-gray-500" aria-hidden="true" />
                                    <SortAscendingIcon v-if="(params.direction === 'asc' ? true : false) && (params.field === 'created_at')" class="-ml-1 mr-2 h-5 w-5 text-gray-500" aria-hidden="true" />
                                </div>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

                        </th>
                    </tr>
                </template>
                <template v-slot:body>
                    <tr v-for="(manuscript, index) in manuscripts.data" :key="manuscript.id">
                        <td class="px-6 py-4 word-break">
                            <div class="flex items-center">
                                <!-- <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full" :src="person.order" alt="" />
                                </div> -->
                                <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ manuscripts.meta.from + index }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    <!-- {{ person.email }} -->
                                </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 word-break text-sm">
                            <!-- <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            </span> -->
                            <div class="text-sm text-gray-500">{{ manuscript.manuscript_no }}</div>
                            <p class="text-gray-900">
                                {{ manuscript.title || 'N/a' }}
                            </p>
                            <div class="text-sm text-gray-500">{{ manuscript.type.name }}</div>
                        </td>
                        <td class="px-6 py-4 word-break text-sm text-gray-500">
                        {{ manuscript.status }}
                        </td>
                        <td class="px-6 py-4 word-break text-sm text-gray-500">
                        {{ manuscript.updated_at }}
                        </td>
                        <td class="px-6 py-4 word-break text-sm text-gray-500">
                        {{ manuscript.created_at_date }}
                        </td>
                        <td class="px-6 py-4 word-break text-right text-sm font-medium">
                            <Link v-if="auth.user.data.permissions_attribute.manuscripts.edit == true" :href="`/admin/manuscripts/${manuscript.id}/edit`" class="text-indigo-600 hover:text-indigo-900 px-2">View</Link>
                            <a v-if="auth.user.data.permissions_attribute.manuscripts.destroy == true" href="#" @click="deleteManuscript(manuscript)" class="text-indigo-600 hover:text-indigo-900 px-2">Delete</a>
                        </td>
                    </tr>
                </template>
            </Table>
            <div class="my-2 flex justify-end">
                <Pagination :links="manuscripts.meta.links" :meta="manuscripts.meta" />
            </div>

            
        </template>
    </Layout>
</template>
<script>
  import Layout from '../../Layout'
  import Table from '../../Components/Table'
  import { Link, useForm } from '@inertiajs/inertia-vue3'
  import {
  BriefcaseIcon,
  CalendarIcon,
  CheckIcon,
  ChevronDownIcon,
  CurrencyDollarIcon,
  LinkIcon,
  LocationMarkerIcon,
  PencilIcon,
  SortAscendingIcon,
  SortDescendingIcon,
  PlusIcon
} from '@heroicons/vue/solid'
  import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
  import Pagination from '../../Components/Pagination.vue'
  import { Inertia } from '@inertiajs/inertia'

  export default {
      components: {
            Pagination,
            Layout,
            Table,
            Menu,
            MenuButton,
            MenuItem,
            MenuItems,
            BriefcaseIcon,
            CalendarIcon,
            CheckIcon,
            ChevronDownIcon,
            CurrencyDollarIcon,
            LinkIcon,
            LocationMarkerIcon,
            PencilIcon,
            PlusIcon,
            Link,
            SortAscendingIcon,
            SortDescendingIcon,
      },
    props: {
        manuscripts: Object,
        filters: Object,
        auth: Object
    },
    data() {
        return {
            params: {
                search: this.filters.search,
                field: this.filters.field,
                direction: this.filters.direction,
            },
        }
    },
    watch: {
        params: {
            handler: _.debounce(async function() {
                let params = _.pickBy(this.params);
                Inertia.get(`/admin/manuscripts`, params, {
                    replace: true,
                    preserveState: true
                });
            }, 300),
            deep: true
        }
    },
    methods: {
        sort(field) {
            this.params.field = field;
            this.params.direction = this.params.direction === 'asc' ? 'desc' : 'asc';
        },
        async deleteManuscript(manuscript) {
            const deleteAttachForm = useForm({
                _method: 'post'
            });
            if (confirm('Are you sure to delete "' + manuscript.type.name + '"?')) {
                deleteAttachForm.post(`/admin/manuscripts/${manuscript.id}/destroy`, {
                    preserveScroll: true,
                });
            }
        }
    },
    async created() {
        console.log(this.manuscripts);
    }
  }
</script>