<template>
    <Layout>
        <template v-slot:header>
            <div class="lg:flex lg:items-center lg:justify-between">
                    <div class="flex-1 min-w-0">
                        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                            Manuscript
                        </h2>
                        <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                            <div class="mt-2 flex items-center text-sm text-gray-500">
                            <BriefcaseIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                            Info
                            </div>
                            <div class="mt-2 flex items-center text-sm text-gray-500">
                            <LocationMarkerIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                            Info
                            </div>
                            <div class="mt-2 flex items-center text-sm text-gray-500">
                            <CurrencyDollarIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                            $120k &ndash; $140k
                            </div>
                            <div class="mt-2 flex items-center text-sm text-gray-500">
                            <CalendarIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                            Info on January 9, 2020
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 flex lg:mt-0 lg:ml-4">
                    <span class="hidden sm:block">
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
                    </span>

                    <span class="sm:ml-3">
                        <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <CheckIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                        Publish
                        </button>
                    </span>

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
                <div class="flex justify-between px-4 py-5 sm:px-6">
                    <div class="">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Attach Files
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Personal details and application.
                        </p>
                    </div>
                    <div>
                        <span class="sm:ml-3">
                            <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <CheckIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                                Upload File 
                            </button>
                        </span>
                    </div>
                </div>
                
                <div class="border-t border-gray-200">
                    <Table></Table>
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
                        <h3 class="text-lg font-medium leading-6 text-gray-900">General Information</h3>
                        <p class="mt-1 text-sm text-gray-600">
                        Decide which communications you'd like to receive and how.
                        </p>
                    </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="#" method="POST">
                        <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <fieldset>
                            <legend class="text-base font-medium text-gray-900">By Email</legend>
                            <div class="mt-4 space-y-4">
                                <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="comments" name="comments" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" />
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="comments" class="font-medium text-gray-700">Comments</label>
                                    <p class="text-gray-500">Get notified when someones posts a comment on a posting.</p>
                                </div>
                                </div>
                                <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="candidates" name="candidates" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" />
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="candidates" class="font-medium text-gray-700">Candidates</label>
                                    <p class="text-gray-500">Get notified when a candidate applies for a job.</p>
                                </div>
                                </div>
                                <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="offers" name="offers" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" />
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="offers" class="font-medium text-gray-700">Offers</label>
                                    <p class="text-gray-500">Get notified when a candidate accepts or rejects an offer.</p>
                                </div>
                                </div>
                            </div>
                            </fieldset>
                            <fieldset>
                            <div>
                                <legend class="text-base font-medium text-gray-900">Push Notifications</legend>
                                <p class="text-sm text-gray-500">These are delivered via SMS to your mobile phone.</p>
                            </div>
                            <div class="mt-4 space-y-4">
                                <div class="flex items-center">
                                <input id="push-everything" name="push-notifications" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" />
                                <label for="push-everything" class="ml-3 block text-sm font-medium text-gray-700">
                                    Everything
                                </label>
                                </div>
                                <div class="flex items-center">
                                <input id="push-email" name="push-notifications" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" />
                                <label for="push-email" class="ml-3 block text-sm font-medium text-gray-700">
                                    Same as email
                                </label>
                                </div>
                                <div class="flex items-center">
                                <input id="push-nothing" name="push-notifications" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" />
                                <label for="push-nothing" class="ml-3 block text-sm font-medium text-gray-700">
                                    No push notifications
                                </label>
                                </div>
                            </div>
                            </fieldset>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save
                            </button>
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
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Additional Information</h3>
                            <p class="mt-1 text-sm text-gray-600">
                            Use a permanent address where you can receive mail.
                            </p>
                        </div>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                        <form action="#" method="POST">
                            <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Files
                                    </label>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                        <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Upload a file</span>
                                            <input id="file-upload" name="file-upload" type="file" class="sr-only" />
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            PDF, DOCS, PNG up to 50MB
                                        </p>
                                        </div>
                                    </div>
                                    </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save
                                </button>
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
                            <form action="#" method="POST">
                                <div class="shadow sm:rounded-md sm:overflow-hidden">
                                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                    <div class="grid grid-cols-3 gap-6">
                                        <div class="col-span-3 sm:col-span-2">
                                            <label for="company-website" class="block text-sm font-medium text-gray-700">
                                            Article Type
                                            </label>
                                            <select type="text" name="company-website" id="company-website" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="www.example.com" >
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-3 gap-6">
                                        <div class="col-span-3 sm:col-span-2">
                                            <label for="company-website" class="block text-sm font-medium text-gray-700">
                                            Website
                                            </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                                http://
                                            </span>
                                            <input type="text" name="company-website" id="company-website" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="www.example.com" />
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                    <label for="about" class="block text-sm font-medium text-gray-700">
                                        About
                                    </label>
                                    <div class="mt-1">
                                        <textarea id="about" name="about" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="you@example.com" />
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Brief description for your profile. URLs are hyperlinked.
                                    </p>
                                    </div>

                                    
                                </div>
                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <Link href="/manuscripts/1/edit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Save
                                    </Link>
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

                    
                <div>
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Manuscript Data</h3>
                            <p class="mt-1 text-sm text-gray-600">
                            This information will be displayed publicly so be careful what you share.
                            </p>
                        </div>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                        <form action="#" method="POST">
                            <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                <div>
                                <label for="about" class="block text-sm font-medium text-gray-700">
                                    Title
                                </label>
                                <div class="mt-1">
                                    <textarea id="about" name="about" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="you@example.com" />
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    Brief description for your profile. URLs are hyperlinked.
                                </p>
                                </div>

                                <div>
                                <label for="about" class="block text-sm font-medium text-gray-700">
                                    Abstract
                                </label>
                                <div class="mt-1">
                                    <textarea id="about" name="about" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="you@example.com" />
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    Brief description for your profile. URLs are hyperlinked.
                                </p>
                                </div>

                                <div>
                                <label for="about" class="block text-sm font-medium text-gray-700">
                                    Keywords
                                </label>
                                <div class="mt-1">
                                    <textarea id="about" name="about" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="you@example.com" />
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    Brief description for your profile. URLs are hyperlinked.
                                </p>
                                </div>

                                <div>
                                <label for="about" class="block text-sm font-medium text-gray-700">
                                    Authors
                                </label>
                                <div class="mt-1">
                                    <textarea id="about" name="about" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="you@example.com" />
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    Brief description for your profile. URLs are hyperlinked.
                                </p>
                                </div>

                                <div>
                                <label for="about" class="block text-sm font-medium text-gray-700">
                                    Funding Information
                                </label>
                                <div class="mt-1">
                                    <textarea id="about" name="about" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="you@example.com" />
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    Brief description for your profile. URLs are hyperlinked.
                                </p>
                                </div>

                                
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <Link href="/manuscripts/1/edit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save
                                </Link>
                            </div>
                            </div>
                        </form>
                        </div>
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
      },
    props: {
    //   user: Object,
    },
  }
</script>