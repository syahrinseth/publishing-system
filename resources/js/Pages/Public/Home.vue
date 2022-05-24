<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <div>
        <div class="relative bg-white overflow-hidden">
            <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white transform translate-x-1/2" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                <polygon points="50,0 100,0 50,100 0,100" />
                </svg>

                <Popover>
                <div class="relative pt-6 px-4 sm:px-6 lg:px-8">
                    <nav class="relative flex items-center justify-between sm:h-10 lg:justify-start" aria-label="Global">
                    <div class="flex items-center flex-grow flex-shrink-0 lg:flex-grow-0">
                        <div class="flex items-center justify-between w-full md:w-auto">
                        <a href="/">
                            <img class="mx-auto h-12 w-auto" src="/img/logo.png" alt="Workflow" />
                        </a>
                        <div class="-mr-2 flex items-center md:hidden">
                            <PopoverButton class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                            <span class="sr-only">Open main menu</span>
                            <MenuIcon class="h-6 w-6" aria-hidden="true" />
                            </PopoverButton>
                        </div>
                        </div>
                    </div>
                    <div class="hidden md:block md:ml-10 md:pr-4 md:space-x-8">
                        
                        <PopoverGroup as="nav" class="hidden md:flex space-x-10">
                            <a v-for="item in navigation" :key="item.name" :href="item.href" class="font-medium text-gray-500 hover:text-gray-900">{{ item.name }}</a>
                            <Popover class="relative" v-slot="{ open }">
                                <PopoverButton :class="[open ? 'text-gray-900' : 'text-gray-500', 'group bg-white rounded-md inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']">
                                <span>Features</span>
                                <ChevronDownIcon :class="[open ? 'text-gray-600' : 'text-gray-400', 'ml-2 h-5 w-5 group-hover:text-gray-500']" aria-hidden="true" />
                                </PopoverButton>

                                <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 translate-y-1" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition ease-in duration-150" leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-1">
                                <PopoverPanel class="absolute z-10 -ml-4 mt-3 transform px-2 w-screen max-w-md sm:px-0 lg:ml-0 lg:left-1/2 lg:-translate-x-1/2">
                                    <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                                    <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8">
                                        <a v-for="item in menuFeatures" :key="item.name" :href="item.href" class="-m-3 p-3 flex items-start rounded-lg hover:bg-gray-50">
                                        <component :is="item.icon" class="flex-shrink-0 h-6 w-6 text-indigo-600" aria-hidden="true" />
                                        <div class="ml-4">
                                            <p class="text-base font-medium text-gray-900">
                                            {{ item.name }}
                                            </p>
                                            <p class="mt-1 text-sm text-gray-500">
                                            {{ item.description }}
                                            </p>
                                        </div>
                                        </a>
                                    </div>
                                    <div class="px-5 py-5 bg-gray-50 space-y-6 sm:flex sm:space-y-0 sm:space-x-10 sm:px-8">
                                        <div v-for="item in callsToAction" :key="item.name" class="flow-root">
                                        <a :href="item.href" class="-m-3 p-3 flex items-center rounded-md text-base font-medium text-gray-900 hover:bg-gray-100">
                                            <component :is="item.icon" class="flex-shrink-0 h-6 w-6 text-gray-400" aria-hidden="true" />
                                            <span class="ml-3">{{ item.name }}</span>
                                        </a>
                                        </div>
                                    </div>
                                    </div>
                                </PopoverPanel>
                                </transition>
                            </Popover>
                            <a v-if="auth.user == null" href="/login" class="font-medium text-indigo-600 hover:text-indigo-500">Log in</a>
                            <Link v-else :href="`/admin`" class="font-medium text-indigo-600 hover:text-indigo-500">Dashboard</Link>
                        </PopoverGroup>

                    </div>
                    </nav>
                </div>

                <transition enter-active-class="duration-150 ease-out" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="duration-100 ease-in" leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
                    <PopoverPanel focus class="absolute z-10 top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden">
                    <div class="rounded-lg shadow-md bg-white ring-1 ring-black ring-opacity-5 overflow-hidden">
                        <div class="px-5 pt-4 flex items-center justify-between">
                        <div>
                            <img class="h-8 w-auto" src="/img/logo.png" alt="" />
                        </div>
                        <div class="-mr-2">
                            <PopoverButton class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                            <span class="sr-only">Close main menu</span>
                            <XIcon class="h-6 w-6" aria-hidden="true" />
                            </PopoverButton>
                        </div>
                        </div>
                        <div class="px-2 pt-2 pb-3 space-y-1">
                        <a v-for="item in navigation" :key="item.name" :href="item.href" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">{{ item.name }}</a>
                        </div>
                        <a href="/login" class="block w-full px-5 py-3 text-center font-medium text-indigo-600 bg-gray-50 hover:bg-gray-100"> Log in </a>
                    </div>
                    </PopoverPanel>
                </transition>
                </Popover>

                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                    <span class="block xl:inline">Journal of Smart</span>
                    {{ ' ' }}
                    <span class="block text-indigo-600 xl:inline">Sensors and Materials</span>
                    </h1>
                    <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                      Journal of Smart Sensors and Materials (JSSM) is an interdisciplinary journal dedicated to publishing research and development in the field of sensing technology, chemical actuators and analytical microsystems, nanomaterial applications in sensing, solid-state devices for transducing physical signals. 
                    </p>
                    <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                    <div class="rounded-md shadow">
                        <a href="/register" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10"> Get started </a>
                    </div>
                    <!-- <div class="mt-3 sm:mt-0 sm:ml-3">
                        <a href="#" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 md:py-4 md:text-lg md:px-10"> Live demo </a>
                    </div> -->
                    </div>
                </div>
                </main>
            </div>
            </div>
            <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="/img/journalposter.jpeg" alt="" />
            </div>
        </div>
        <div class="py-12 bg-gradient-to-r from-indigo-600 to-indigo-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase"></h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-white sm:text-4xl">Scope</p>
                <p class="mt-4 max-w-2xl text-xl text-gray-300 lg:mx-auto">
                  The scope of Journal of Smart Sensors and Materials (JSSM) encompasses, but is not restricted to, the following areas:
                </p>
            </div>

            <div class="mt-10">
                <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                <div v-for="feature in features" :key="feature.name" class="relative">
                    <dt>
                    <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                        <component :is="feature.icon" class="h-6 w-6" aria-hidden="true" />
                    </div>
                    <p class="ml-16 text-lg leading-6 font-medium text-gray-100">{{ feature.name }}</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-gray-500">
                    {{ feature.description }}
                    </dd>
                </div>
                </dl>
            </div>
            </div>
        </div>
        <div class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
              <div class="mt-10">
                <div class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                  <div>
                    <div class="lg:text-center">
                        <p id="about" class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">About</p>
                    </div>
                    <div class="hidden sm:block" aria-hidden="true">
                      <div class="py-5">
                      <div class="border-t border-gray-200" />
                      </div>
                    </div>
                    <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                      The journal aims to promote original works in the experimental and theoretical that demonstrates significant progress beyond the current state of the art in these fields along with applicability to solve meaningful analytical problems.
                    </p>
                    <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                      This Journal is published by the Malaysian Society for Sensor Technology Development or SENSOR as the sole scientific publication of the Society since 2019. The Journal is published in three issues per volume (per year) i.e. in April, August and December.
                    </p>
                    <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                      Journal of Smart Sensors and Materials provides immediate open access to its content on the principle that making published articles freely access and downloadable to the public supports a greater global exchange of knowledge. Researchers from any countries are invited to publish their research articles in this journal.
                    </p>
                    <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                      <div class="rounded-md shadow">
                          <a href="/register" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10"> Get started </a>
                      </div>
                    </div>
                  </div>
                  <div>
                    <img class="" src="/img/journalposter.jpeg" alt="sensor-malaysia-poster">
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="bg-gray-50">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                <span class="block">Ready to dive in?</span>
                <span class="block text-indigo-600">Let's get started today.</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                <a href="/register" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700"> Get started </a>
                </div>
                <div class="ml-3 inline-flex rounded-md shadow">
                <a href="#about" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50"> Learn more </a>
                </div>
            </div>
            </div>
        </div>
        <footer class="p-4 bg-white sm:p-6 dark:bg-gray-800">
      <div class="md:flex md:justify-between">
      <div class="mb-6 md:mb-0">
      <a href="https://flowbite.com" class="flex items-center">
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
import { Popover, PopoverButton, PopoverPanel, PopoverGroup } from '@headlessui/vue'
import { MenuIcon, XIcon, AnnotationIcon, GlobeAltIcon, ChevronRightIcon, LightningBoltIcon, ScaleIcon, ChartBarIcon, CursorClickIcon, ShieldCheckIcon, ViewGridIcon, RefreshIcon, PlayIcon, PhoneIcon } from '@heroicons/vue/outline'
import { ChevronDownIcon } from '@heroicons/vue/solid'
import { Link } from '@inertiajs/inertia-vue3'

const navigation = [
  // { name: 'Product', href: '#' },
  { name: 'Journal Published', href: '/journals' },
]

const features = [
  {
    name: 'Sensing principles and mechanisms',
    description:
      '',
    icon: ChevronRightIcon,
  },
  {
    name: 'Materials for Sensor Technology Nanostructured materials',
    description:
      '',
    icon: ChevronRightIcon,
  },
  {
    name: 'Synthetic organic chemistry Synthetic inorganic chemistry',
    description:
      '',
    icon: ChevronRightIcon,
  },
  {
    name: 'Polymer composites',
    description:
      '',
    icon: ChevronRightIcon,
  },
  {
    name: 'New sensing transducers',
    description:
      '',
    icon: ChevronRightIcon,
  },
  {
    name: 'Sensor fabrication technology Actuators',
    description:
      '',
    icon: ChevronRightIcon,
  },
  {
    name: 'Optical sensors',
    description:
      '',
    icon: ChevronRightIcon,
  },
  {
    name: 'Electrochemical sensors',
    description:
      '',
    icon: ChevronRightIcon,
  },
  {
    name: 'Chemical sensors',
    description:
      '',
    icon: ChevronRightIcon,
  },
  {
    name: 'Biosensors',
    description:
      '',
    icon: ChevronRightIcon,
  },
  {
    name: 'Physical sensors',
    description:
      '',
    icon: ChevronRightIcon,
  },
  {
    name: 'Mass-sensitive devices',
    description:
      '',
    icon: ChevronRightIcon,
  },
  {
    name: 'Gas sensors',
    description:
      '',
    icon: ChevronRightIcon,
  },
  {
    name: 'Humidity sensors',
    description:
      '',
    icon: ChevronRightIcon,
  },
  {
    name: 'Lab-on-a-chip',
    description:
      '',
    icon: ChevronRightIcon,
  },
  {
    name: 'Sensor-array',
    description:
      '',
    icon: ChevronRightIcon,
  },
  {
    name: 'Optoelectronic sensors',
    description:
      '',
    icon: ChevronRightIcon,
  },
  {
    name: 'Mechanical sensors',
    description:
      '',
    icon: ChevronRightIcon,
  },
  {
    name: 'Thermal sensors',
    description:
      '',
    icon: ChevronRightIcon,
  },
  {
    name: 'Magnetic sensors',
    description:
      '',
    icon: ChevronRightIcon,
  },
  {
    name: 'μTAS - Micro Total Analysis Systems',
    description:
      '',
    icon: ChevronRightIcon,
  },
  {
    name: 'Remote Sensing',
    description:
      '',
    icon: ChevronRightIcon,
  },
  {
    name: 'Pressure Sensing',
    description:
      '',
    icon: ChevronRightIcon,
  },
  {
    name: 'Nuclear Sensing',
    description:
      '',
    icon: ChevronRightIcon,
  },
  {
    name: 'Acoustic Sensing',
    description:
      '',
    icon: ChevronRightIcon,
  },
]

const menuFeatures = [
  {
    name: 'Analytics',
    description: 'Get a better understanding of where your traffic is coming from.',
    href: '#',
    icon: ChartBarIcon,
  },
  {
    name: 'Engagement',
    description: 'Speak directly to your customers in a more meaningful way.',
    href: '#',
    icon: CursorClickIcon,
  },
  { name: 'Security', description: "Your customers' data will be safe and secure.", href: '#', icon: ShieldCheckIcon },
  {
    name: 'Integrations',
    description: "Connect with third-party tools that you're already using.",
    href: '#',
    icon: ViewGridIcon,
  },
  {
    name: 'Automations',
    description: 'Build strategic funnels that will drive your customers to convert',
    href: '#',
    icon: RefreshIcon,
  },
]

const callsToAction = [
  { name: 'Watch Demo', href: '#', icon: PlayIcon },
  { name: 'Contact Sales', href: '#', icon: PhoneIcon },
]

export default {
  components: {
    Popover,
    PopoverButton,
    PopoverPanel,
    MenuIcon,
    XIcon,
    AnnotationIcon, 
    GlobeAltIcon, 
    LightningBoltIcon, 
    ScaleIcon,
    ChevronDownIcon,
    PopoverGroup,
    Link
  },
  props: {
    auth: Object
  },
  setup() {
    return {
      navigation,
      features,
      menuFeatures,
      callsToAction
    }
  },
}
</script>