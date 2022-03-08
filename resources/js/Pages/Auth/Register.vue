<template>
    <div>
        <Head>
            <title>Register</title>
        </Head>
        <div class="h-full">
            <div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
                <div class="max-w-md w-full space-y-8">
                    <div>
                        <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="Workflow" />
                        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Sign Up</h2>
                    </div>
                    <form class="mt-8 space-y-6" @submit.prevent="onSubmit()">
                        <input type="hidden" name="remember" value="true" />
                        <div class="rounded-md shadow-sm -space-y-px">
                        <div>
                            <label for="name-address" class="sr-only">Name</label>
                            <input v-model="registerForm.name" id="name-address" name="name" type="name" autocomplete="name" required="" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Name" />
                        </div>
                        <div>
                            <label for="email-address" class="sr-only">Email address</label>
                            <input v-model="registerForm.email" id="email-address" name="email" type="email" autocomplete="email" required="" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Email address" />
                        </div>
                        <div>
                            <label for="password" class="sr-only">Password</label>
                            <input v-model="registerForm.password" id="password" name="password" type="password" autocomplete="current-password" required="" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Password" />
                        </div>
                        <div>
                            <label for="confirm-password" class="sr-only">Confirm Password</label>
                            <input v-model="registerForm.password_confirmation" id="confirm-password" name="password_confirmation" type="password" autocomplete="current-confirm-password" required="" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Confirm Password" />
                        </div>
                        </div>


                        <div>
                        <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            </span>
                            Sign Up
                        </button>
                        <div class="flex justify-center items-center">
                            <div class="border-t flex-1"></div>
                            <div class="p-2 text-gray-400">or</div>
                            <div class="border-t flex-1"></div>
                        </div>
                        <Link :href="`/login`" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <LockClosedIcon class="h-5 w-5 text-gray-500 group-hover:text-gray-400" aria-hidden="true" />
                            </span>
                            Login
                        </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Layout from '../../Layout'
import { Head } from '@inertiajs/inertia-vue3'
import { LockClosedIcon } from '@heroicons/vue/solid'
import { useForm, Link } from '@inertiajs/inertia-vue3'
import Toast from '../../Components/Toast'

export default {
    components: {
        LockClosedIcon,
        Head,
        Layout,
        useForm,
        Link,
        Toast
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
        onSubmit() {
            this.registerForm.post(`register`, {
                preserveScroll: true,
                onError: (errors) => {
                    Object.keys(errors).forEach((value, index) => {
                        this.notification(errors[value], 'error');
                    });
                },
                onSuccess: (res) => {
                    this.notification('Registered.')
                }
            })
        }
    },
    setup(props) {
        const registerForm = useForm({
            name: null,
            email: null,
            password: null,
            password_confirmation: null
        });

        return {
            registerForm
        };
    },
    props: {
        auth: Object
    }
}
</script>