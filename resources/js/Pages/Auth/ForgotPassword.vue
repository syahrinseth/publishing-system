<template>
    <div>
        <Head>
            <title>Reset Password</title>
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
                        <h2 class="text-center text-2xl font-extrabold text-gray-900">Reset Password</h2>
                    </div>
                    <form class="mt-8 space-y-6" action="#" method="POST">
                        <input type="hidden" name="remember" value="true" />
                        <div class="rounded-md shadow-sm -space-y-px">
                        <div class="pb-3">
                            <label for="email-address" class="sr-only">Email address</label>
                            <input id="email-address" name="email" type="email" autocomplete="email" required="" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Email address" />
                        </div>
                        
                        <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Reset Password
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
}
</script>