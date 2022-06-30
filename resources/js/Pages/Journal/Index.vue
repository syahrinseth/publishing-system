<template>
    <Layout :auth="auth.user.data">
        <template v-slot:header>
            <div class="lg:flex lg:items-center lg:justify-between">
                    <div class="flex-1 min-w-0">
                        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                            Journal Overview
                        </h2>
                    </div>
                    <div class="mt-5 flex lg:mt-0 lg:ml-4">
                    <!-- <span class="hidden sm:block">
                        <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <PencilIcon class="-ml-1 mr-2 h-5 w-5 text-gray-500" aria-hidden="true" />
                        Some Link
                        </button>
                    </span>

                    <span class="hidden sm:block ml-3">
                        <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <LinkIcon class="-ml-1 mr-2 h-5 w-5 text-gray-500" aria-hidden="true" />
                        View
                        </button>
                    </span> -->

                
                    <span class="sm:ml-3">
                        <Link v-for="item in headermenu.filter((v) => {return v.disabled == true ? false : true;})" :key="item.name" :href="item.href" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" :aria-current="item.current ? 'page' : undefined" preserve-state preserve-scroll>
                            <PlusIcon v-if="item.icon == 'plus'" class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                            {{ item.name }}
                        </Link>
                    </span>

                    <!-- Dropdown -->
                    <!-- <Menu as="span" class="ml-3 relative sm:hidden">
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
                    </Menu> -->
                </div>
            </div>
        </template>
        <template v-slot:default>
            <Table>
                <template v-slot:header>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            #
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

                        </th>
                    </tr>
                </template>
                <template v-slot:body>
                    <tr v-for="(journal, index) in journals.data" :key="journal.id">
                        <td class="px-6 py-4 word-break">
                            {{ journals.meta.from + index }}
                        </td>
                        <td class="px-6 py-4 word-break">
                            {{ journal.name }}
                        </td>
                        <td class="px-6 py-4 word-break">
                            {{ moment(journal.date).format('DD/MM/YYYY') }}
                        </td>
                        <td class="px-6 py-4 word-break">
                            {{ journal.status }}
                        </td>
                        <td class="px-6 py-4 word-break">
                            <form @submit.prevent="deleteJournal(journal)">
                                <!-- <Link v-if="journal.status == 'published'" :href="`/journals/${journal.id}`" class="text-indigo-600 hover:text-indigo-900 px-2">View</Link> -->
                                <Link v-if="auth.user.data.permissions_attribute.journals.edit == true" :href="`/admin/journals/${journal.id}/edit`" class="text-indigo-600 hover:text-indigo-900 px-2">View</Link>
                                <button v-if="auth.user.data.permissions_attribute.journals.destroy == true" class="text-indigo-600 hover:text-indigo-900 px-2">Delete</button>
                            </form>
                        </td>
                    </tr>
                </template>
            </Table>
            <div class="my-2 flex justify-end">
                <Pagination :links="journals.meta.links" :meta="journals.meta" />
            </div>
            
        </template>
    </Layout>
</template>
<script>
import Layout from '../../Layout'
import Table from '../../Components/Table'
import {
BriefcaseIcon,
CalendarIcon,
PlusIcon,
ChevronDownIcon,
CurrencyDollarIcon,
LinkIcon,
LocationMarkerIcon,
PencilIcon,
} from '@heroicons/vue/solid'
import { useForm, Link } from '@inertiajs/inertia-vue3'
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import moment from 'moment'
import Pagination from '../../Components/Pagination.vue'

let headermenu = [
    { 
        name: 'Create Journal', 
        icon: 'plus', 
        href: '/admin/journal-create',
        disabled: false 
    },
];

export default {
    components: {
        Layout,
        Table,
        Menu,
        Pagination,
        MenuButton,
        MenuItem,
        MenuItems,
        BriefcaseIcon,
        CalendarIcon,
        PlusIcon,
        ChevronDownIcon,
        CurrencyDollarIcon,
        LinkIcon,
        LocationMarkerIcon,
        PencilIcon,
        Link,
    },
    methods: {
        deleteJournal(journal) {
            if (confirm('Are you sure to delete "' + journal.name + '"?')) {
                this.deleteForm.post(`/admin/journals/${journal.id}/destroy`, {
                    preserveScroll: true,
                    onError: (errors) => {
                        Object.keys(errors).forEach((value, index) => {
                            this.notification(errors[value], 'error');
                        });
                    },
                    onSuccess: () => {
                        this.notification('Deleted.', 'success');
                    }
                });
            }
        },
        notification(message, type = 'success') {
            this.$toast.open({
                message: message,
                type: type,
                duration: 5000,
                dismissible: true
            })
        },
    },
    setup(props) {
        const deleteForm = useForm();
        return {
            deleteForm,
            headermenu,
            moment
        };
    },
    props: {
        journals: Object,
        auth: Object
    },
    created() {
        let user = this.$props.auth.user;
        this.headermenu = this.headermenu.map((val) => {
            if (user.data.permissions_attribute.journals.create == false && val.name == 'Create Journal') {
                val.disabled = true;
            }
            return val;
        });
    }
}
</script>