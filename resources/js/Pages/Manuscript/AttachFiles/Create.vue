<template>
    <div>
        <Layout :auth="auth.user.data">
            <template v-slot:header>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Submit Manuscript
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
                                                Article Type
                                                </label>
                                                <select name="company-website" id="company-website" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="www.example.com" v-model="input.type">
                                                    <option value="" selected>Select</option>
                                                    <option v-for="type in types" v-bind:key="type.id" :value="type.id">{{ type.name }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        
                                    </div>
                                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                        <!-- <Link href="/admin/manuscripts/1/edit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Save
                                        </Link> -->
                                        <button class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" type="submit">
                                            Proceed
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
  import Layout from '../../../Layout'
  import { Link } from '@inertiajs/inertia-vue3'
  import { Inertia } from '@inertiajs/inertia'

  export default {
    components: {
        Layout,
        Link
    },
    data() {
        return {
            input: {
                type: "",
            },
            types: []
        };
    },
    methods: {
        async submit() {
            if (this.input.type != "") {
                let resp = await window.axios.post('/api/manuscripts', {
                    'type': this.input.type
                })
                    .then((resp) => {
                        let data = resp.data;
                        Inertia.get(`/admin/manuscripts/${data.id}/edit`);
                    })
                    .catch((err) => {
                        alert(err);
                    });
            } else {
                alert('Article Type is required.');
            }
        },
        async fetchTypes() {
            let resp = await window.axios.get('/api/manuscript-types');
            if (resp.status == 200) {
                return resp.data;
            }
            return [];
        }
    },
    async mounted() {
        this.types = await this.fetchTypes();
    },
    props: {
        auth: Object
    },
  }
</script>