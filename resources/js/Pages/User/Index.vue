<template>
    <Layout :auth="auth.user.data">
        <template v-slot:header>
            <div class="lg:flex lg:items-center lg:justify-between">
                    <div class="flex-1 min-w-0">
                        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                            Users
                        </h2>
                    </div>
                    <div class="mt-5 flex lg:mt-0 lg:ml-4">
                    <span class="hidden sm:block">
                        <Link v-if="auth.user.data.permissions_attribute.users.create" :href="`/admin/user-create`" class="mx-1 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <UserAddIcon class="-ml-1 mr-2 h-5 w-5 text-gray-500" aria-hidden="true" />
                            Add User
                        </Link>
                        <Link :href="`/admin/roles`" class="mx-1 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <UserIcon class="-ml-1 mr-2 h-5 w-5 text-gray-500" aria-hidden="true" />
                            Roles & Permissions
                        </Link>
                    </span>
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" @click="sort('first_name')">
                            <div class="columns-2">
                                <div>
                                    Name
                                </div>
                                <div>
                                    <SortDescendingIcon v-if="(params.direction === 'desc' ? true : false) && (params.field === 'first_name')" class="-ml-1 mr-2 h-5 w-5 text-gray-500" aria-hidden="true" />
                                    <SortAscendingIcon v-if="(params.direction === 'asc' ? true : false) && (params.field === 'first_name')" class="-ml-1 mr-2 h-5 w-5 text-gray-500" aria-hidden="true" />
                                </div>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" @click="sort('email')">
                            <div class="columns-2">
                                <div>
                                    email
                                </div>
                                <div>
                                    <SortDescendingIcon v-if="(params.direction === 'desc' ? true : false) && (params.field === 'email')" class="-ml-1 mr-2 h-5 w-5 text-gray-500" aria-hidden="true" />
                                    <SortAscendingIcon v-if="(params.direction === 'asc' ? true : false) && (params.field === 'email')" class="-ml-1 mr-2 h-5 w-5 text-gray-500" aria-hidden="true" />
                                </div>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="columns-2">
                                <div>
                                    Roles
                                </div>
                                <div>
                                    <SortDescendingIcon v-if="(params.direction === 'desc' ? true : false) && (params.field === 'roles')" class="-ml-1 mr-2 h-5 w-5 text-gray-500" aria-hidden="true" />
                                    <SortAscendingIcon v-if="(params.direction === 'asc' ? true : false) && (params.field === 'roles')" class="-ml-1 mr-2 h-5 w-5 text-gray-500" aria-hidden="true" />
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase ">

                        </th>
                    </tr>
                </template>
                <template v-slot:body>
                    <tr v-for="(user, index) in users.data" :key="user.id">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <!-- <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full" :src="person.order" alt="" />
                                </div> -->
                                <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ users.meta.from + index }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    <!-- {{ person.email }} -->
                                </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 word-break">
                            <div class="text-sm text-gray-900 flex gap-3">
                                <div>
                                    <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                        <svg v-if="user.photo == null" class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg> 
                                        <img v-else :src="`/storage/${user.photo}`" alt="">
                                    </span>
                                </div>
                                <div class="flex-1">
                                    <p>{{ user.first_name }} {{ user.last_name }}</p>
                                    <p>
                                        <small class="text-gray-600">
                                            {{ user.field }}
                                        </small>
                                    </p>
                                    <p>
                                        <small class="text-gray-600">
                                        {{ user.affiliation }}
                                        </small>
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 word-break text-sm text-gray-500">
                        <!-- <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        </span> -->
                        {{ user.email || 'N/a' }}
                        </td>
                        <td class="px-6 py-4 word-break text-sm text-gray-500">
                            {{ user.roles.length == 0 ? 'N/a' : user.roles.map((e) => e.name).join(', ') }}
                        </td>
                        <td class="px-6 py-4 word-break text-sm text-gray-500">
                        {{ user.updated_at }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <form @submit.prevent="deleteUser(user)">
                                <Link v-if="auth.user.data.permissions_attribute.users.edit == true" :href="`/admin/users/${user.id}/edit`" class="text-indigo-600 hover:text-indigo-900 px-2">View</Link>
                                <button v-if="auth.user.data.permissions_attribute.users.destroy == true" class="text-indigo-600 hover:text-indigo-900 px-2">Delete</button>
                            </form>
                        </td>
                    </tr>
                </template>
            </Table>
            <div class="my-2 flex justify-end">
                <Pagination :links="users.meta.links" :meta="users.meta" />
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
        CheckIcon,
        ChevronDownIcon,
        CurrencyDollarIcon,
        LinkIcon,
        LocationMarkerIcon,
        PencilIcon,
        UserIcon,
        SortAscendingIcon,
        SortDescendingIcon,
        UserAddIcon
    } from '@heroicons/vue/solid'
    import { useForm, Link } from '@inertiajs/inertia-vue3'
    import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
    import Pagination from '../../Components/Pagination.vue'
    import { Inertia } from '@inertiajs/inertia'

    export default {
        components: {
            Layout,
            Table,
            Menu,
            Pagination,
            MenuButton,
            MenuItem,
            MenuItems,
            SortAscendingIcon,
            SortDescendingIcon,
            BriefcaseIcon,
            CalendarIcon,
            CheckIcon,
            ChevronDownIcon,
            CurrencyDollarIcon,
            LinkIcon,
            LocationMarkerIcon,
            PencilIcon,
            useForm,
            Link,
            UserIcon,
            UserAddIcon
        },
        methods: {
            deleteUser(user) {
                if (confirm('Are you sure to delete "' + user.name + '"?')) {
                    this.deleteForm.post(`/admin/users/${user.id}/destroy`, {
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
            sort(field) {
                this.params.field = field;
                this.params.direction = this.params.direction === 'asc' ? 'desc' : 'asc';
            }
        },
        setup(props) {
            const deleteForm = useForm();
            return {
                deleteForm
            };
        },
        data() {
            return {
                params: {
                    search: this.filters.search,
                    field: this.filters.field,
                    direction: this.filters.direction
                }
            };
        },
        watch: {
            params: {
                handler: _.debounce(function() {
                    let params = _.pickBy(this.params);
                    Inertia.get(`/admin/users`, params, {
                        replace: true,
                        preserveState: true
                    });
                }, 300),
                deep: true
            }
        },
        props: {
            users: Object,
            auth: Object,
            filters: Object
        },
    }
</script>