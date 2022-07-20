<template>
    <Layout :auth="auth.user.data">
        <template v-slot:header>
            <div class="lg:flex lg:items-center lg:justify-between">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    FAQs
                </h2>
            </div>
        </template>
        <template v-slot:default>
            <div class="container mx-auto max-w-screen-md">
                <h2 class="text-gray-800 text-center text-2xl font-bold">
                    Frequently Asked Questions
                </h2>
                <div v-for="faq in faqs" :key="faq.name">
                    <hr class="my-6 border-gray-300 sm:mx-auto dark:border-gray-300 lg:my-8"/>
                    <div class="container mx-auto">
                        <div class="flex cursor-pointer" @click="faq.hide = !faq.hide">
                            <h2 class="text-gray-800 text-xl mb-5 font-bold flex-1">
                                {{ faq.name }}
                            </h2>
                            <ChevronLeftIcon :class="faq.hide ? '' : 'hidden'" class="flex-none mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                            <ChevronDownIcon :class="faq.hide ? 'hidden' : ''" class="flex-none mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                        </div>
                        <div v-show="!faq.hide" v-html="faq.desc">
                            
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </Layout>
</template>
<script>
import Layout from '../../Layout.vue';
import { ChevronLeftIcon, ChevronDownIcon } from '@heroicons/vue/solid'
const faqs = [
    {
        name: "How to assign reviewers in manuscript as an editor?",
        desc: `<h2 class="text-gray-700 text-lg font-bold">
                Step 1:
            </h2>
            <img src="/img/faq/faq1.png" class="rounded shadow-full w-3/4 mx-auto border-gray-400 my-3" alt="faq1">
            <p class="text-gray-600">
                On the <b>Dashboard</b> page, navigate to the Action section. This section will suggest to you what to do next. Click <b>'View'</b> button on the desired list to view the related manuscript.
            </p>
            <h2 class="text-gray-700 text-lg font-bold mt-3">
                Step 2:
            </h2>
            <img src="/img/faq/faq2.png" class="rounded shadow-full w-3/4 mx-auto border-gray-400 my-3" alt="faq1"/>
            <p class="text-gray-600">
                On the Manuscript edit page, navigate to the <b>Review Preferences</b> section, and include reviewers by selecting or typing the reviewer's name or email.
            </p>
            <h2 class="text-gray-700 text-lg font-bold mt-3">
                Step 3:
            </h2>
            <p class="text-gray-600">
                Click <b>'Save'</b> button to save the changes.
            </p>`,
        role: 'Editor',
        hide: true
    },
    {
        name: "How to submit manuscript to reviewers?",
        desc: `<p class="text-gray-600">
                After inviting <b>Reviewers</b> into the manuscript, it's time to submit manuscript for review. This will <b>Notify</b> the reviewers associated with the manuscript.
            </p>
            <h2 class="text-gray-700 text-lg font-bold mt-3">
                Step 1:
            </h2>
            <img src="/img/faq/faq3.png" class="rounded shadow-full w-3/4 mx-auto border-gray-400 my-3" alt="faq3">
            <p class="text-gray-600">
                Go to the <b>Manuscripts</b> Page by clicking the <b>Manuscripts</b> menu at the top of the screen.
            </p>
            <h2 class="text-gray-700 text-lg font-bold mt-3">
                Step 2:
            </h2>
            <img src="/img/faq/faq4.png" class="rounded shadow-full w-3/4 mx-auto border-gray-400 my-3" alt="faq4">
            <p class="text-gray-600">
                Select <b>Manuscript</b> you want to edit, and click <b>View</b> button to go to the selected manuscript page.
            </p>
            <h2 class="text-gray-700 text-lg font-bold mt-3">
                Step 3:
            </h2>
            <img src="/img/faq/faq5.png" class="rounded shadow-full w-3/4 mx-auto border-gray-400 my-3" alt="faq5"/>
            <p class="text-gray-600">
                Before submiting the manuscript to reviewers, make sure the manuscript status is <b>Submit to Editor</b> as shown at the header part of the manuscript page.
            </p>
            <img src="/img/faq/faq6.png" class="rounded shadow-full w-3/4 mx-auto border-gray-400 my-3" alt="faq6"/>
            <p class="text-gray-600">
                You will be able to see the <b>Submit for Review</b> button at the header section on the top right corner.  
            </p>
            <div class="rounded-lg border-red-500 p-3 bg-red-100 my-2">
                <h2 class="text-red-900">* If you can't see the <b>Submit for Review</b> button, this might be you have access more than one role on the selected manuscript. To solve this, select your role as an <b>Editor</b> at the left corner on the header section of the page. You will see a dropdown menu with the label <b>View As</b></h2>
                <img src="/img/faq/faq7.png" class="rounded shadow-full w-3/4 mx-auto border-gray-400 my-3" alt="faq7"/>
            </div>
            <h2 class="text-gray-700 text-lg font-bold mt-3">
                Step 4:
            </h2>
            <p class="text-gray-600">
                Click the <b>Submit to Reviewer</b> button to submit the manuscript to the reviewers.
            </p>
            <div class="rounded-lg border-red-500 p-3 bg-red-100 my-2">
                <h2 class="text-red-900">* The <b>Reviewers</b> will be notified through <b>Email</b>.</h2>
            </div>`,
        role: 'Editor',
        hide: true
    },
];
export default {
    components: {
        Layout,
        ChevronLeftIcon,
        ChevronDownIcon,
    },
    props: {
        auth: Object,
    },
    data() {
        return {
            faqs: faqs
        };
    },
    methods: {
        expands(index) {
            this.faqs[index].hide = !this.faqs[index].hide;
        }
    },
    setup(props) {
        return {
            
        };
    }
}
</script>