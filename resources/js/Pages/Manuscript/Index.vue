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

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                
                <div class="border-t border-gray-200">
                    <Table>
                        <template v-slot:header>
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                #
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Title
                                </th>
                                <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Abstract
                                </th> -->
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Last Modified
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Created
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

                                </th>
                            </tr>
                        </template>
                        <template v-slot:body>
                            <tr v-for="(manuscript, index) in manuscripts.data" :key="manuscript.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <!-- <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" :src="person.order" alt="" />
                                        </div> -->
                                        <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ index + 1 }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <!-- {{ person.email }} -->
                                        </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm w-6">
                                    <!-- <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    </span> -->
                                    <div class="text-sm text-gray-500">{{ manuscript.manuscript_no }}</div>
                                    <div class="text-gray-900">
                                        <p class="break-words">
                                            {{ manuscript.title || 'N/a' }}
                                        </p>
                                    </div>
                                    <div class="text-sm text-gray-500">{{ manuscript.type.name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ manuscript.status }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ manuscript.updated_at }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ manuscript.created_at_date }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <Link v-if="auth.user.data.permissions_attribute.manuscripts.edit == true" :href="`/admin/manuscripts/${manuscript.id}/edit`" class="text-indigo-600 hover:text-indigo-900 px-2">Edit</Link>
                                    <a :href="`/admin/manuscripts/${manuscript.id}/download`" class="text-indigo-600 hover:text-indigo-900 px-2" target="_blank">Download</a>
                                    <a v-if="auth.user.data.permissions_attribute.manuscripts.destroy == true" href="#" @click="deleteManuscript(manuscript)" class="text-indigo-600 hover:text-indigo-900 px-2">Delete</a>
                                </td>
                            </tr>
                        </template>
                    </Table>
                </div>
            </div>

            <!-- <div class="hidden sm:block" aria-hidden="true">
                <div class="py-5">
                    <div class="border-t border-gray-200" />
                </div>
            </div> -->

            
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
  PlusIcon
} from '@heroicons/vue/solid'
  import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'

  export default {
      components: {
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
            Link
      },
    props: {
        manuscripts: Object,
        auth: Object
    },
    data() {
        return {

        }
    },
    methods: {
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
        
    }
  }
</script>