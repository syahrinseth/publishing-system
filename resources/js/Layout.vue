<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <!--
    This example requires updating your template:

    ```
    <html class="h-full bg-gray-100">
    <body class="h-full">
    ```
  -->
  <div class="min-h-full">
    <Disclosure as="nav" class="bg-white border border-b-gray-200 z-50 min-w-full" v-slot="{ open }">
      

      <Banner v-for="banner in banners"
        :key="banner.id"
        :show="banner.isOpen"
        :text="banner.text"
        :color="banner.color"
        :accept-link="banner.accept_link"
        :decline-link="banner.decline_link"
        @close="banner.isOpen = false"></Banner>

      <div class="h-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <a href="/">
              <img class="mx-auto h-12 w-auto" src="/img/logo.png" alt="Workflow" />
            </a>
            </div>
            <div class="hidden md:block">
              <div class="ml-10 flex items-baseline space-x-4">
                <template v-for="item in navigation">
                  <div v-if="item.disabled == false">
                    <Link v-if="item.isParent == false" :key="item.name" :href="item.href" :class="[item.href == $page.url ? 'bg-gray-900 text-white' : 'text-gray-900 hover:bg-gray-700 hover:text-white', 'px-3 py-2 rounded-md text-sm font-medium']" :aria-current="item.current ? 'page' : undefined" preserve-state preserve-scroll>{{ item.name }}</Link>
                    
                    <Popover v-else class="relative" v-slot="{ open }">
                      <PopoverButton :class="[item.href == $page.url ? 'bg-gray-900 text-white' : 'text-gray-900 hover:bg-gray-700 hover:text-white', 'px-3 py-2 rounded-md text-sm font-medium']">
                        More
                        <!-- <svg class="text-gray-400 ml-2 h-5 w-5 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                          <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg> -->
                      </PopoverButton>

                      <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 translate-y-1" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition ease-in duration-150" leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-1">
                        <PopoverPanel class="absolute z-10 left-1/2 transform -translate-x-1/2 mt-3 px-2 w-screen max-w-md sm:px-0">
                          <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                            <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8">
                              <template  v-for="child in item.children" :key="child.name">
                                <a v-if="child.disabled == false" :href="child.href" :class="[child.href == $page.url ? 'bg-gray-900 text-white' : 'text-gray-900 hover:bg-gray-700 hover:text-white', 'px-3 py-2 rounded-md text-sm font-medium']">
                                  <component :is="item.icon" class="flex-shrink-0 h-6 w-6 text-indigo-600" aria-hidden="true" />
                                  <div class="ml-4">
                                    <p class="text-base font-medium">
                                      {{ child.name }}
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500">
                                    </p>
                                  </div>
                                </a>
                              </template>
                            </div>
                            <!-- <div class="px-5 py-5 bg-gray-50 sm:px-8 sm:py-8">
                              <div>
                                <h3 class="text-sm tracking-wide font-medium text-gray-500 uppercase">Recent Posts</h3>
                                <ul role="list" class="mt-4 space-y-4">
                                  <li v-for="post in recentPosts" :key="post.id" class="text-base truncate">
                                    <a :href="post.href" class="font-medium text-gray-900 hover:text-gray-700">
                                      {{ post.name }}
                                    </a>
                                  </li>
                                </ul>
                              </div>
                              <div class="mt-5 text-sm">
                                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500"> View all posts <span aria-hidden="true">&rarr;</span></a>
                              </div>
                            </div> -->
                          </div>
                        </PopoverPanel>
                      </transition>
                    </Popover>
                  </div>
                </template>
                
                <!-- <a :href="'/manuscripts/1/attach-files/1'" :class="['text-gray-300 hover:bg-gray-700 hover:text-white', 'px-3 py-2 rounded-md text-sm font-medium']" target="_blank">Download</a> -->
              </div>
            </div>
          </div>
          <div class="hidden md:block">
            <div class="ml-4 flex items-center md:ml-6">
              <!-- <button type="button" class="bg-gray-800 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                <span class="sr-only">View notifications</span>
                <BellIcon class="h-6 w-6" aria-hidden="true" />
              </button> -->

              <!-- Profile dropdown -->
              <Menu as="div" class="ml-3 relative">
                <div>
                  <MenuButton class="max-w-xs bg-gray-800 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                    <span class="sr-only">Open user menu</span>
                    <img v-if="$props.auth.photo != null" class="h-8 w-8 rounded-full" :src="`/storage/${$props.auth.photo}`" alt="" />
                    <svg v-else class="h-8 w-8 rounded-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                  </MenuButton>
                </div>
                <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                  <MenuItems class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                      <a v-if="item.method == 'get' && item.disabled == false" :href="item.href" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">{{ item.name }}</a>
                      <a v-else href="#" @click="signOut(item)" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">
                        {{ item.name }}
                      </a>
                    </MenuItem>
                  </MenuItems>
                </transition>
              </Menu>
              <Link href="/admin/faqs" class="text-gray-900 hover:bg-gray-700 hover:text-white px-1 py-1 mx-1 rounded-md text-sm font-medium" preserve-state preserve-scroll>
                <SupportIcon class="block h-6 w-6 mx-1" aria-hidden="true" />
              </Link>
            </div>
          </div>
          <div class="-mr-2 flex md:hidden">
            <!-- Mobile menu button -->
            <DisclosureButton class="bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
              <span class="sr-only">Open main menu</span>
              <MenuIcon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
              <XIcon v-else class="block h-6 w-6" aria-hidden="true" />
            </DisclosureButton>
          </div>
        </div>
      </div>

      <DisclosurePanel class="md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
          <DisclosureButton v-for="item in navigation" :key="item.name" as="a" :href="item.href" :class="[item.href == $page.url ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-700 hover:text-white', 'block px-3 py-2 rounded-md text-base font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</DisclosureButton>
        </div>
        <div class="pt-4 pb-3 border-t border-gray-700">
          <div class="flex items-center px-5">
            <div class="flex-shrink-0">
              <!-- <img class="h-10 w-10 rounded-full" :src="user.imageUrl" alt="" /> -->
              <svg class="h-8 w-8 rounded-full text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
              </svg>
            </div>
            <!-- <div class="ml-3">
              <div class="text-base font-medium leading-none text-white">{{ user.name }}</div>
              <div class="text-sm font-medium leading-none text-gray-400">{{ user.email }}</div>
            </div> -->
            <!-- <button type="button" class="ml-auto bg-gray-800 flex-shrink-0 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
              <span class="sr-only">View notifications</span>
              <BellIcon class="h-6 w-6" aria-hidden="true" />
            </button> -->
          </div>
          <div class="mt-3 px-2 space-y-1">
            <DisclosureButton v-for="item in userNavigation" :key="item.name" as="a" :href="item.href" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-white hover:bg-gray-700">{{ item.name }}</DisclosureButton>
          </div>
        </div>
      </DisclosurePanel>
    </Disclosure>

    <header class="bg-white border border-b-gray-200 shadow-md">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- <h1 class="text-3xl font-bold text-gray-900">
        
        </h1> -->
        <slot name="header"></slot>

        <!-- <div class="hidden sm:block" aria-hidden="true">
            <div class="pt-5">
            <div class="border-t border-gray-200" />
            </div>
        </div> -->
      </div>
    </header>
    <main class="bg-gray-100 px-2 md:px-0">
      <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 min-h-screen">
        <!-- Replace with your content -->
        <!-- <div class="px-4 py-6 sm:px-0">
          <div class="border-4 border-dashed border-gray-200 rounded-lg h-96" />
        </div> -->
        
        <slot></slot>
        <!-- /End replace -->
      </div>
    </main>
    
    <footer class="p-4 bg-white sm:p-6 dark:bg-gray-800">
      <div class="md:flex md:justify-between">
      <div class="mb-6 md:mb-0">
      <a href="/" class="flex items-center">
      <img src="/img/logo.jpeg" class="mr-3 h-12 rounded shadow" alt="FlowBite Logo">
      <!-- <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">
        JSSM
      </span> -->
      </a>
      </div>
      <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
      <div>
        <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Resources</h2>
        <ul class="text-gray-600 dark:text-gray-400">
          <li class="mb-4">
            <a href="https://sensormalaysia.com.my" target="_blind" class="hover:underline">Sensor Malaysia</a>
          </li>
        </ul>
      </div>
      <div>
      <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Follow us</h2>
      <ul class="text-gray-600 dark:text-gray-400">
      <li class="mb-4">
      <a href="https://facebook.com/SENSORMalaysia" target="_blind" class="hover:underline ">Facebook</a>
      </li>
      </ul>
      </div>
      <div>
      <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Legal</h2>
      <ul class="text-gray-600 dark:text-gray-400">
      <li class="mb-4">
      <a href="#" class="hover:underline">Privacy Policy</a>
      </li>
      <li>
      <a href="#" class="hover:underline">Terms &amp; Conditions</a>
      </li>
      </ul>
      </div>
      </div>
      </div>
      <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8">
      <div class="sm:flex sm:items-center sm:justify-between">
      <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2022 <a href="https://sensormalaysia.com.my" class="hover:underline">Sensor Malaysia</a>. All Rights Reserved.
      </span>
      <div class="flex mt-4 space-x-6 sm:justify-center sm:mt-0">
      <a href="https://facebook.com/SENSORMalaysia" target="_blank" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path></svg>
      </a>
      <!-- <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"></path></svg>
      </a>
      <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path></svg>
      </a>
      <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path></svg>
      </a>
      <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c5.51 0 10-4.48 10-10S17.51 2 12 2zm6.605 4.61a8.502 8.502 0 011.93 5.314c-.281-.054-3.101-.629-5.943-.271-.065-.141-.12-.293-.184-.445a25.416 25.416 0 00-.564-1.236c3.145-1.28 4.577-3.124 4.761-3.362zM12 3.475c2.17 0 4.154.813 5.662 2.148-.152.216-1.443 1.941-4.48 3.08-1.399-2.57-2.95-4.675-3.189-5A8.687 8.687 0 0112 3.475zm-3.633.803a53.896 53.896 0 013.167 4.935c-3.992 1.063-7.517 1.04-7.896 1.04a8.581 8.581 0 014.729-5.975zM3.453 12.01v-.26c.37.01 4.512.065 8.775-1.215.25.477.477.965.694 1.453-.109.033-.228.065-.336.098-4.404 1.42-6.747 5.303-6.942 5.629a8.522 8.522 0 01-2.19-5.705zM12 20.547a8.482 8.482 0 01-5.239-1.8c.152-.315 1.888-3.656 6.703-5.337.022-.01.033-.01.054-.022a35.318 35.318 0 011.823 6.475 8.4 8.4 0 01-3.341.684zm4.761-1.465c-.086-.52-.542-3.015-1.659-6.084 2.679-.423 5.022.271 5.314.369a8.468 8.468 0 01-3.655 5.715z" clip-rule="evenodd"></path></svg>
      </a> -->
      </div>
      </div>
    </footer>
  </div>
</template>

<script>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Link, useForm } from '@inertiajs/inertia-vue3'
import Toast from './Components/Toast'
import { Popover, PopoverButton, PopoverGroup, PopoverPanel } from '@headlessui/vue'
import {
  BellIcon,
  BookmarkAltIcon,
  CalendarIcon,
  ChartBarIcon,
  CursorClickIcon,
  MenuIcon,
  PhoneIcon,
  PlayIcon,
  RefreshIcon,
  ShieldCheckIcon,
  SupportIcon,
  ViewGridIcon,
  XIcon,
} from '@heroicons/vue/outline'
import Banner from './Components/Banner.vue'

// let user = {
//   name: 'Tom Cook',
//   email: 'tom@example.com',
//   imageUrl:
//     'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
// }
let navigation = [
  { name: 'Dashboard', href: '/admin/', disabled: false, isParent: false },
  { name: 'Submit Manuscript', href: '/admin/manuscript-create', disabled: false, isParent: false },
  { name: 'Manuscripts', href: '/admin/manuscripts', disabled: false, isParent: false },
  { name: 'Journals', href: '/admin/journals', disabled: false, isParent: false },
  { name: 'FAQs', href: '/admin/faqs', disabled: false, isParent: false },
  { 
    name: 'More', 
    href: '#', 
    disabled: false, 
    isParent: true, 
    children: [
      { name: 'Users', href: '/admin/users', disabled: false },
      { name: 'Settings', href: '/admin/settings', disabled: false },
    ] 
  },
]
let userNavigation = [
  { name: 'Your Profile', href: '/admin/profile', method: 'get', disabled: false },
  // { name: 'Settings', href: '#', method: 'get', disabled: false },
  { name: 'Sign out', href: '/logout', method: 'post', disabled: false },
]

export default {
  components: {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    BellIcon,
    MenuIcon,
    XIcon,
    Link,
    BookmarkAltIcon,
    CalendarIcon,
    ChartBarIcon,
    CursorClickIcon,
    PhoneIcon,
    PlayIcon,
    RefreshIcon,
    ShieldCheckIcon,
    SupportIcon,
    ViewGridIcon,
    Popover,
    PopoverButton,
    PopoverGroup,
    PopoverPanel,
    Banner
  },
  watch: {
    auth(newVal, oldVal) {
      this.refreshNavBar();
    }
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
    signOut(item) {
      const form = useForm();
      form.post(item.href, {
        onError: (errors) => {
            Object.keys(errors).forEach((value, index) => {
                this.notification(errors[value], 'error');
            });
        },
        onSuccess: (res) => {
          this.notification('Signed Out.');
        }
      });
    },
    refreshNavBar() {
      const user = this.$props.auth;
      this.navigation = this.navigation.map((val) => {
        
        if (user.permissions_attribute.dashboard.show == false && val.name == 'Dashboard') {
          val.disabled = true;
        }
        
        if(user.permissions_attribute.users.show == false && val.name == 'Users') {
          val.disabled = true;
        }

        if(user.permissions_attribute.journals.show == false && val.name == 'Journals') {
          val.disabled = true;
        }

        if(user.permissions_attribute.manuscripts.show == false && (val.name == 'Manuscripts' || val.name == 'Submit manuscript')) {
          val.disabled = true;
        }

        if(user.permissions_attribute.settings.edit == false && (val.name == 'Settings')) {
          val.disabled = true;
        }

        if(val.name == 'More') {
          for(let i = 0; i < val.children?.length; i++) {
              
            if (user.permissions_attribute.users.show == false && val.children?.[i].name == 'Users') {
              val.children[i].disabled = true;
            }

            if (user.permissions_attribute.settings.show == false && val.children?.[i].name == 'Settings') {
              val.children[i].disabled = true;
            }

          }
        }

        return val;

      });

      this.userNavigation = this.userNavigation.map((val) => {

        if (user.permissions_attribute.settings.show == false && val.name == 'Settings') {
          val.disabled = true;
        }

        return val;
      });

    }
  },
  props: {
    auth: Object
  },
  data() {
    return {
      banners: []
    }
  },
  setup(props) {
    return {
      navigation,
      userNavigation,
    }
  },
  created() {
    this.banners = this.$props.auth?.manuscript_pending_members?.map((v) => {
      return {
        isOpen: true,
        text: `You have a pending invitation to review a manuscript entitled "${v?.manuscript?.manuscript_no}".`,
        color: 'red',
        accept_link: `/admin/manuscripts/${v?.manuscript?.id}/members/${v?.id}/accept-invitation`,
        decline_link: `/admin/manuscripts/${v?.manuscript?.id}/members/${v?.id}/decline-invitation`
      };
    });
    this.refreshNavBar();
  }
}
</script>