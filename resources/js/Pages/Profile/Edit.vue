<template>
    <div>
        <Layout :auth="auth.user.data">
            <template v-slot:header>
                <div class="lg:flex lg:items-center lg:justify-between">
                        <div class="flex-1 min-w-0">
                            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                                User Profile 
                            </h2>
                        </div>
                </div>
            </template>
            <template v-slot:default>
                <div>
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Profile</h3>
                        <p class="mt-1 text-sm text-gray-600">This information will be displayed publicly so be careful what you share.</p>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form @submit.prevent="onSubmit()"  method="POST">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                <div class="col-span-6 sm:col-span-6">
                                    <label for="first-name" class="block text-sm font-medium text-gray-700">First Name</label>
                                    <input v-model="userForm.first_name" type="text" name="first-name" id="first-name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                </div>
                                <div class="col-span-6 sm:col-span-6">
                                    <label for="last-name" class="block text-sm font-medium text-gray-700">Last Name</label>
                                    <input v-model="userForm.last_name" type="text" name="last-name" id="last-name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                </div>
                                <div class="col-span-8 sm:col-span-8">
                                    <label for="field" class="block text-sm font-medium text-gray-700">Field</label>
                                    <input v-model="userForm.field" type="text" name="field" id="field" autocomplete="given-name" placeholder="eg: Optical Sensors" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                </div>
                                <div class="col-span-8 sm:col-span-8">
                                    <label for="affiliation" class="block text-sm font-medium text-gray-700">Affiliation</label>
                                    <input v-model="userForm.affiliation" type="text" name="affiliation" id="affiliation" autocomplete="given-name" placeholder="eg: University of Malaya" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                </div>
                                <div class="grid grid-cols-3 gap-6">
                                    <div class="col-span-3 sm:col-span-2">
                                    <label for="company-website" class="block text-sm font-medium text-gray-700"> Website </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm"> http:// </span>
                                        <input v-model="userForm.website_url" type="text" name="company-website" id="company-website" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="www.example.com" />
                                    </div>
                                    </div>
                                </div>

                                <div>
                                    <label for="about" class="block text-sm font-medium text-gray-700"> About </label>
                                    <div class="mt-1">
                                    <textarea v-model="userForm.about" id="about" name="about" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="you@example.com" />
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">Brief description for your profile. URLs are hyperlinked.</p>
                                </div>

                                <div>
                                    <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <div class="mt-1 flex items-center">
                                        <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                            <svg v-if="userPhoto == null && userForm.photo == null" class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg> 
                                            <img v-else-if="userPhoto != null" :src="userPhoto" alt="">
                                            <img v-else :src="`/storage/${userForm.photo}`" alt="">
                                        </span>
                                        <span class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Change
                                        </span>
                                    </div>
                                    <input @change="onChangeProfileImage" id="file-upload" ref="file" type="file" class="sr-only" />
                                    </label>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</button>
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

                <div class="mt-10 sm:mt-0">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Personal Information</h3>
                        <p class="mt-1 text-sm text-gray-600">Use a permanent address where you can receive mail.</p>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form @submit.prevent="onSubmit()"  method="POST">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-12 gap-6">

                                <div class="col-span-4 sm:col-span-4">
                                    <label for="email-address" class="block text-sm font-medium text-gray-700">Email address</label>
                                    <input v-model="userForm.email" type="text" name="email-address" id="email-address" autocomplete="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                </div>

                                <div class="col-span-4 sm:col-span-4">
                                <label for="fax-number" class="block text-sm font-medium text-gray-700">Fax Number</label>
                                <input v-model="userForm.fax_no" type="text" name="fax-number" id="fax-number" autocomplete="fax-number" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                </div>

                                <div class="col-span-4 sm:col-span-4">
                                <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                                <select v-model="userForm.country" id="country" name="country" autocomplete="country-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option>Malaysia</option>
                                </select>
                                </div>

                                <div class="col-span-12">
                                    <label for="street-address" class="block text-sm font-medium text-gray-700">Street address</label>
                                    <input v-model="userForm.address_1" type="text" name="street-address" id="street-address" autocomplete="street-address" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                    <input v-model="userForm.address_2" type="text" name="street-address-2" id="street-address-2" autocomplete="street-address-2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                </div>

                                <div class="col-span-4">
                                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                <input v-model="userForm.city" type="text" name="city" id="city" autocomplete="address-level1" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                </div>

                                <div class="col-span-4">
                                <label for="region" class="block text-sm font-medium text-gray-700">State / Province</label>
                                <input v-model="userForm.state" type="text" name="region" id="region" autocomplete="address-level1" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                </div>

                                <div class="col-span-4">
                                <label for="postal-code" class="block text-sm font-medium text-gray-700">ZIP / Postal code</label>
                                <input v-model="userForm.postcode" type="text" name="postal-code" id="postal-code" autocomplete="postal-code" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                </div>
                            </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</button>
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

                <div class="mt-10 sm:mt-0">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Roles</h3>
                        <p class="mt-1 text-sm text-gray-600">Assign role to the user..</p>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form @submit.prevent="onSubmit()"  method="POST">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <fieldset>
                                <legend class="text-base font-medium text-gray-900">Roles</legend>
                                <div class="mt-4 space-y-4">
                                    <div v-for="role in roles" v-bind:key="`role-${role.id}`" class="flex items-start">
                                        <div class="flex items-center h-5">
                                        <input :id="`role-input-${role.id}`" v-model="userForm.roles" :value="role.id" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" :disabled="!canEditRoleAndPermission()" :class="{'cursor-not-allowed bg-slate-500': !canEditRoleAndPermission()}" />
                                        </div>
                                        <div class="ml-3 text-sm">
                                        <label :for="`role-input-${role.id}`" class="font-medium text-gray-700">
                                            {{ role.name }}
                                        </label>
                                        <!-- <p class="text-gray-500">Get notified when someones posts a comment on a posting.</p> -->
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" :disabled="!canEditRoleAndPermission()" :class="{'cursor-not-allowed bg-slate-500': !canEditRoleAndPermission()}">Save</button>
                            </div>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
            </template>
        </Layout>
    </div>
</template>
<script>
import Layout from '../../Layout'
import { useForm, Link } from '@inertiajs/inertia-vue3'
import Toast from '../../Components/Toast'
import { Inertia } from '@inertiajs/inertia'

export default {
    components: {
        Layout,
        useForm,
        Link,
        Toast,
        Inertia
    },
    props: {
        user: Object,
        roles: Array,
        auth: Object
    },
    data() {
        return {
            userPhoto: null
        }
    },
    methods: {
        notification(message, type = 'success') {
            this.$toast.open({
                message: message,
                type: type,
                duration: 5000,
                dismissible: true
            });
        },
        onSubmit() {
            this.userForm.post(`/admin/profile`, {
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
        },
        onChangeProfileImage(e) {
            this.userPhoto = URL.createObjectURL(e.target.files[0]);
            this.userForm.photo = e.target.files[0];
        },
        canEditRoleAndPermission() {
            return this.auth.user.data?.permissions_attribute?.roles_and_permissions?.edit;
        }
    },
    setup(props) {
        let user = props.user.data;
        const userForm = useForm({
            _method: 'PUT',
            first_name: user.first_name,
            last_name: user.last_name,
            email: user.email,
            address_1: user.address_1,
            address_2: user.address_2,
            postcode: user.postcode,
            field: user.field,
            city: user.city,
            state: user.state,
            fax_no: user.fax_no,
            country: user.country,
            website_url: user.website_url,
            about: user.about,
            photo: user.photo,
            affiliation: user.affiliation,
            roles: user.roles.length > 0 ? user.roles.map((e) => e.id) : []
        });

        return {
            userForm
        };
    },
}
</script>
