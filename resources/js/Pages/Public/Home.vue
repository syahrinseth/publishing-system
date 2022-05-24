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
                            <img class="mx-auto h-12 w-auto" src="/storage/logo.jpeg" alt="Workflow" />
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
                            <img class="h-8 w-auto" src="/storage/logo.jpeg" alt="" />
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
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="/storage/journalposter.jpeg" alt="" />
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
                    <img class="" src="/storage/journalposter.jpeg" alt="sensor-malaysia-poster">
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