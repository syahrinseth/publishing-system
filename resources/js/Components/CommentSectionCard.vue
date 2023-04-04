<template>
    <div>
        <div>
            <label for="">Comments</label>
        </div>
        <div class="mb-2 mt-1 w-full">
            <!-- <div>
                <div class="flex">
                    <div class="flex-none p-2">
                        <div class="max-w-xs bg-gray-800 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                            <svg class="h-8 w-8 rounded-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="grow">
                        <p class="text-gray-700">Syahrin Seth</p>
                        <small class="text-gray-500">Author</small>
                    </div>
                    <div class="flex-none">
                        <small class="text-gray-500">1 hour ago</small>
                    </div>
                </div>
                <div class="flex">
                    <div class="grow">
                        <p class="text-gray-500">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nisi asperiores totam neque temporibus in, quidem nemo ex ab ducimus amet odio sed, porro ratione quos explicabo illum est, hic distinctio!</p>
                    </div>
                </div>
                <div class="hidden sm:block" aria-hidden="true">
                    <div class="py-5">
                        <div class="border-t border-gray-200" />
                    </div>
                </div>
            </div> -->
            <div class="col-span-3 sm:col-span-2 mb-2 mt-1">
                <label for="company-website" class="block text-sm font-medium text-gray-700 mt-1">
                Send to
                </label>
                <select v-model="commentForm.to" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    <option value="" selected>Select</option>
                    <option value="authors">Authors</option>
                    <option value="editors">Editors</option>
                    <option value="reviewers">Reviewers</option>
                    <option value="publishers">Publishers</option>
                </select>
                <label for="company-website" class="block text-sm mt-3 font-medium text-gray-700">
                Add your comment
                </label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <textarea v-model="commentForm.text" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="" />
                </div>
            </div>
            <div class="col-span-3 sm:col-span-2 mb-2 mt-1 flex">
                <div class="grow"></div>
                <div href="#" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:w-auto sm:text-sm cursor-pointer" @click="postComment()">
                    Post
                </div>
            </div>
            <div v-for="comment in comments" :key="comment.id" >
                <div class="flex">
                    <div class="flex-none pr-2 py-2">
                        <div class="max-w-xs bg-gray-800 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                            <img v-if="comment.user.photo != null" class="h-8 w-8 rounded-full" :src="`/storage/${comment.user.photo}`" alt="" />
                            <svg v-else class="h-8 w-8 rounded-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="grow">
                        <p class="text-gray-700">
                        <span v-if="comment.user.id == auth.user.data.id">You</span>
                            <span v-else>{{ comment.from }}</span>
                        </p>
                        <small class="text-gray-500">
                            <!-- {{ comment.from_role }} -->
                        </small>
                    </div>
                    <div class="flex-none">
                        <small class="text-gray-500">
                            {{ comment.created_at }}
                        </small>
                    </div>
                </div>
                <div class="flex">
                    <div class="grow">
                        <p class="text-gray-500">
                            {{ comment.text }}
                        </p>
                    </div>
                </div>
                <div class="hidden sm:block" aria-hidden="true">
                    <div class="py-5">
                        <div class="border-t border-gray-200" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { RefreshIcon } from "@heroicons/vue/outline";
import { useForm } from "@inertiajs/inertia-vue3";
import Toast from './Toast'

export default {
    component: {
        Toast
    },
    data() {
        return {
            comments: [],
        };  
    },
    methods: {
        async fetchComments() {
            if (this.$props.manuscriptAttachId == null) {
                let resp = await window.axios.get(`/api/manuscripts/${this.$props.manuscriptId}/comments`, {
                    params: {
                        from: this.$props.from,
                        user_id: this.$props.auth.user.data.id,
                        to: this.$props.from,
                        createdAt: 'desc'
                    }
                });
                if (resp.status == 200) {
                    return resp.data;
                }
            } else {
                let resp = await window.axios.get(`/api/manuscripts/${this.$props.manuscriptId}/attach-files/${this.$props.manuscriptAttachId}/comments`, {
                    params: {
                        from: this.$props.from,
                        user_id: this.$props.auth.user.data.id,
                        to: this.$props.from,
                        createdAt: 'desc'
                    }
                });
                if (resp.status == 200) {
                    return resp.data;
                }
            }
            
            return [];
        },
        async refresh(){
            this.comments = await this.fetchComments();
            this.commentForm.to = "";
            this.commentForm.text = "";
        },
        notification(message, type = 'success') {
            this.$toast.open({
                message: message,
                type: type,
                duration: 5000,
                dismissible: true
            })
        },
        postComment() {
            if (this.$props.manuscriptAttachId == null) {
                this.commentForm.post(`/admin/manuscripts/${this.$props.manuscriptId}/comments`, {
                    preserveScroll: true,
                    onError: (errors) => {
                        Object.keys(errors).forEach((value, index) => {
                            this.notification(errors[value], 'error');
                        });
                    },
                    onSuccess: (res) => {
                        this.refresh();
                    }
                });
            } else {
                this.commentForm.post(`/admin/manuscripts/${this.$props.manuscriptId}/attach-files/${this.$props.manuscriptAttachId}/comments`, {
                    preserveScroll: true,
                    onError: (errors) => {
                        Object.keys(errors).forEach((value, index) => {
                            this.notification(errors[value], 'error');
                        });
                    },
                    onSuccess: (res) => {
                        this.refresh();
                    }
                });
            }
        }
    },
    watch: {
        manuscriptAttachId: function(newVal, oldVal) {
            this.refresh();
        },
        from: function(newVal, oldVal) {
            this.commentForm.from = newVal;
            this.refresh();
        }
    },
    mounted() {
        this.refresh();
    },
    setup(props) {
        const commentForm = useForm({
            text: "",
            to: "",
            from: props.from
        });
        return {
            commentForm
        };
    },
    props: {
        manuscriptId: Number,
        manuscriptAttachId: Number,
        auth: Object,
        from: String
    }
}
</script>