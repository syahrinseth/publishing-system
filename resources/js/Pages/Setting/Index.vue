<template>
    <div>
        <Layout :auth="auth.user.data">
            <template v-slot:header>
                <div class="lg:flex lg:items-center lg:justify-between">
                    <div class="flex-1 min-w-0">
                        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                            System Settings
                        </h2>
                    </div>
                    <div class="mt-5 flex lg:mt-0 lg:ml-4">
                        
                    </div>
                </div>
            </template>
            <template v-slot:default>
                <div>
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Manuscript</h3>
                        <p class="mt-1 text-sm text-gray-600">Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda, fugit odit incidunt tempora placeat repudiandae voluptatum corporis. Ut quo natus nostrum. Alias voluptas laboriosam obcaecati eum deserunt nesciunt beatae repellendus?</p>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form @submit.prevent="submit">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                <div v-for="setting in settings.data" :key="setting.name" class="grid grid-cols-3 gap-6">
                                    <div class="col-span-3 sm:col-span-2">
                                    <label :for="setting.name" class="block text-sm font-medium text-gray-700"> {{ setting.label }} </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="text" :name="setting.name" :id="setting.name" v-model="settingForm[setting.name]" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300" :placeholder="setting.note" />
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</button>
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
            </template>
        </Layout>
    </div>
</template>
<script>
import { useForm } from '@inertiajs/inertia-vue3'
import Layout from '../../Layout.vue'
import Toast from '../../Components/Toast'

export default {
    components: { Layout, Toast },
    methods: {
        notification(message, type = 'success') {
            this.$toast.open({
                message: message,
                type: type,
                duration: 5000,
                dismissible: true
            });
        },
        submit() {
            this.settingForm.post(`/admin/settings`, {
                preserveScroll: true,
                onError: (errors) => {
                    Object.keys(errors).forEach((value, index) => {
                        this.notification(errors[value], 'error');
                    });
                },
                onSuccess: (res) => {
                    this.notification('Manuscript Imported.', 'success');
                }
            });
        }
    },
    setup(props) {
        let formParam = {};
        for (let i = 0; i < props.settings.data.length; i++) {
            let tempSetting = props.settings.data[i];
            formParam[tempSetting.name] = tempSetting.value;
        }
        const settingForm = useForm(formParam);
        return {
            settingForm
        };
    },
    props: {
        auth: Object,
        settings: Object
    }
}
</script>
