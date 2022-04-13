<template>
    <Layout :auth="auth.user.data">
        <template v-slot:header>
            <div class="lg:flex lg:items-center lg:justify-between">
                    <div class="flex-1 min-w-0">
                        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                            Roles & Permissions
                        </h2>
                    </div>
                    <div class="mt-5 flex lg:mt-0 lg:ml-4">

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
            <div v-for="role in roles.data" v-bind:key="role.id" class="bg-white shadow overflow-hidden sm:rounded-lg mb-5">
                <div class="px-4 py-5 sm:px-6">
                    <div class="flex">
                        <div class="flex-none">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ role.name }}</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">Permissions</p>
                        </div>
                        <div class="flex-grow">

                        </div>
                        <div class="flex-none">
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div v-for="(permission, index) in permissions.map((val) => val.name.split('.')[0]).filter((value, index, self) => {return self.indexOf(value) === index;})" v-bind:key="`permission-${permission.id}`" :class="index % 2 == 0 ? `` : `bg-gray-50`" class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ permission }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <div class="" v-for="detail_permission in permissions" v-bind:key="`detail-${detail_permission.id}`">
                                    <div v-if="detail_permission.name.split('.')[0] == permission" class="flex items-center">
                                        <input :id="`${role.id}-${permission}-${detail_permission.name}`" v-model="roleForm[role.id].permissions" :value="detail_permission.id" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" />
                                        <label :for="`${role.id}-${permission}-${detail_permission.name}`" class="ml-2 block text-sm text-gray-900"> {{ detail_permission.name.split('.')[1] }} </label>
                                    </div>
                                </div>
                            </dd>
                        </div>
                    </dl>
                </div>
                <div class="border-t border-gray-200">
                    <div class="flex">
                        <div class="flex-grow">

                        </div>
                        <div class="flex-none">
                            <form @submit.prevent="onSubmit(role.id)">
                                <button class="m-5 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Save
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </Layout>
</template>
<script>
import { PaperClipIcon } from '@heroicons/vue/solid'
import { useForm, Link } from '@inertiajs/inertia-vue3'
import Layout from '../../Layout'
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import Toast from '../../Components/Toast'

export default {
    components: {
        PaperClipIcon,
        useForm,
        Link,
        Layout,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        Toast
    },
    props: {
        roles: Array,
        permissions: Array,
        auth: Object
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
        onSubmit(roleId) {
            this.roleForm[roleId].post(`/admin/roles/${roleId}/update`, {
                preserveScroll: true,
                onError: (errors) => {
                    Object.keys(errors).forEach((value, index) => {
                        this.notification(errors[value], 'error');
                    });
                },
                onSuccess: () => {
                    this.notification('Saved', 'success');
                }
            });
        }
    },
    setup(props) {
        console.log(props.roles);
        let roles = props.roles.data;
        let roleForm = [];
        for (let i = 0; i < roles.length; i++) {
            roleForm[roles[i].id] = useForm({
                name: roles[i].name,
                permissions: roles[i].permissions.map((val) => val.id)
            });
        }
        return {
            roleForm
        };
    }
}
</script>