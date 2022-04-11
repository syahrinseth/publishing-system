<template>
    <div>
        <Layout :auth="auth.user.data">
            <template v-slot:header>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Create Journal
                </h2>
            </template>
            <template v-slot:default>
                <form @submit.prevent="submit">
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
                                            Create
                                        </button>
                                    </div>
                                </div>
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
        auth: Object
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
        async submit() {
            this.journalForm.post(`/admin/journal-store`, {
                preserveScroll: true,
                onError: (errors) => {
                    Object.keys(errors).forEach((value, index) => {
                        this.notification(errors[value], 'error');
                    });
                },
                onSuccess: (res) => {

                }
            });
        }
    },
    setup() {
        const journalForm = useForm({
            name: "",
            date: ""
        });

        return {
            journalForm
        };
    },
}
</script>
