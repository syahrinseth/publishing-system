<template>
    <div>
        <Head>
            <title>Login</title>
        </Head>
        <div class="h-full">
            <div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
                <div class="max-w-md w-full space-y-8">
                    <div>
                        <a href="/">
                            <img class="mx-auto h-16 w-auto" src="/img/logo.png" alt="Workflow" />
                        </a>
                        <h2 class="text-center text-3xl font-extrabold text-gray-900">
                            Journal of Smart Sensor and Materials (JSSM)
                        </h2>
                        <div class="hidden sm:block" aria-hidden="true">
                            <div class="py-5">
                            <div class="border-t border-gray-200" />
                            </div>
                        </div>
                        <h2 class="text-center text-2xl font-extrabold text-gray-900">Sign in to your account</h2>
                        <p class="mt-2 text-center text-sm text-gray-600">
                        Or
                        {{ ' ' }}
                        <Link :href="`/register`" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Sign Up
                        </Link>
                        </p>
                    </div>
                    <form class="mt-8 space-y-6" action="#" @submit.prevent="onSubmit()">
                        <!-- <input type="hidden" name="remember" v-model="userForm.remember_me"/> -->
                        <div class="rounded-md shadow-sm -space-y-px">
                        <div>
                            <label for="email-address" class="sr-only">Email address</label>
                            <input id="email-address" name="email" type="email" autocomplete="email" 
                            v-model="userForm.email" required="" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Email address" />
                        </div>
                        <div>
                            <label for="password" class="sr-only">Password</label>
                            <input id="password" name="password" type="password" autocomplete="current-password" required="" v-model="userForm.password" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Password" />
                        </div>
                        </div>

                        <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" v-model="userForm.remember_me" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" />
                            <label for="remember-me" class="ml-2 block text-sm text-gray-900"> Remember me </label>
                        </div>

                        <div class="text-sm">
                            <Link :href="`/forgot-password`" class="font-medium text-indigo-600 hover:text-indigo-500">
                                Forgot your password?
                            </Link>
                        </div>
                        </div>

                        <div>
                        <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <LockClosedIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" aria-hidden="true" />
                            </span>
                            Login
                        </button>
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

export default {
    components: {
        LockClosedIcon,
        Head,
        Layout,
        useForm,
        Link
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
            this.userForm.post('/login', {
                onError: (errors) => {
                    Object.keys(errors).forEach((value, index) => {
                        this.notification(errors[value], 'error');
                    });
                }
            });
        }
    },
    setup(props) {
        const userForm = useForm({
            email: null,
            password: null,
            remember_me: false
        });

        return {
            userForm
        };
    }
}
</script>