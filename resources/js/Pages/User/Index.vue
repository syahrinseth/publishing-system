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
                        <Link :href="`/admin/roles`" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <UserIcon class="-ml-1 mr-2 h-5 w-5 text-gray-500" aria-hidden="true" />
                            Roles & Permissions
                        </Link>
                    </span>
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
                                Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Roles
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Last Modified
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

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
                                            {{ index + 1 }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <!-- {{ person.email }} -->
                                        </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ user.name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <!-- <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                </span> -->
                                {{ user.email || 'N/a' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ user.roles.length == 0 ? 'N/a' : user.roles.map((e) => e.name).join(', ') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ user.updated_at }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form @submit.prevent="deleteUser(user)">
                                        <Link v-if="auth.user.data.permissions_attribute.users.edit == true" :href="`/admin/users/${user.id}/edit`" class="text-indigo-600 hover:text-indigo-900 px-2">Edit</Link>
                                        <button v-if="auth.user.data.permissions_attribute.users.destroy == true" class="text-indigo-600 hover:text-indigo-900 px-2">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        </template>
                    </Table>
                </div>
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
        UserIcon
    } from '@heroicons/vue/solid'
    import { useForm, Link } from '@inertiajs/inertia-vue3'
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
            useForm,
            Link,
            UserIcon
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
        },
        setup(props) {
            const deleteForm = useForm();
            return {
                deleteForm
            };
        },
        props: {
            users: Array,
            auth: Object
        },
    }
</script>