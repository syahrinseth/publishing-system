<template>
    <div>
        <!-- <Toast v-show="errors != null"/> -->
        <Layout :auth="auth.user.data">
            <template v-slot:header>
                <div class="lg:flex lg:items-center lg:justify-between">
                    <div class="flex-1 min-w-0">
                        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                            Submit Manuscript: {{ manuscript.data.manuscript_no }} - {{ manuscript.data.title || 'Untitled' }}
                        </h2>
                        <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                        </div>
                    </div>
                    <div class="mt-5 flex lg:mt-0 lg:ml-4">
                    </div>
                </div>
                <!-- <div class="flex mt-1">
                    <span class="flex-none pr-1" v-show="authIsAuthor()">
                        <div href="#" class="inline-flex items-center px-4 py-2 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" target="_blank">
                            <UserIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                            You are an Author
                        </div>
                    </span>
                    <span class="flex-none pr-1" v-show="authIsCorrespondingAuthor()">
                        <div href="#" class="inline-flex items-center px-4 py-2 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" target="_blank">
                            <UserIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                            You are a Co-Author
                        </div>
                    </span>
                    <span class="flex-none pr-1" v-show="authIsEditor()">
                        <div href="#" class="inline-flex items-center px-4 py-2 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" target="_blank">
                            <UserIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                            You are an Editor
                        </div>
                    </span>
                    <span class="flex-none pr-1" v-show="authIsReviewer()">
                        <div href="#" class="inline-flex items-center px-4 py-2 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500" target="_blank">
                            <UserIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                            You are a Reviewer
                        </div>
                    </span>
                    <span class="flex-none pr-1" v-show="authIsPublisher()">
                        <div href="#" class="inline-flex items-center px-4 py-2 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500" target="_blank">
                            <UserIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                            You are a Publisher
                        </div>
                    </span>
                </div> -->
            </template>
            <template v-slot:default>
                <Modal :show="showUploadAttachModal" @close="showUploadAttachModal = false;">
                    <template v-slot:default>
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">
                                    Upload Attach File
                                </DialogTitle>
                                <div class="mt-2">
                                    <form @submit.prevent="submitAttach">
                                        <div class="grid grid-cols-3 gap-6 mb-2">
                                            <div class="col-span-3 sm:col-span-3">
                                                <label for="company-website" class="block text-sm font-medium text-gray-700">
                                                Type
                                                </label>
                                                <select class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="www.example.com" v-model="attachForm.type">
                                                    <option value="" selected>Select</option>
                                                    <option v-for="type in attachTypes" :key="type.id" :value="type.id">{{ type.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-span-3 sm:col-span-2 mb-2">
                                                <label for="company-website" class="block text-sm font-medium text-gray-700">
                                                Notes
                                                </label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                <textarea v-model="attachForm.description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="" />
                                                </div>
                                            </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">
                                                Files
                                            </label>
                                            <div class="mt-1 flex justify-center pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                                <div class="space-y-1 text-center">
                                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    <p v-if="attachForm.file != null">
                                                        {{ attachForm.file.name }}
                                                    </p>
                                                    <div class="flex text-sm text-gray-600">
                                                        <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                        <span>Upload a file</span>
                                                        <input id="file-upload" ref="file"  @change="onChangeSubmitAttachFile" type="file" class="sr-only" />
                                                        <progress v-if="attachForm.progress" :value="attachForm.progress.percentage" max="100">
                                                        {{ attachForm.progress.percentage }}%
                                                        </progress>
                                                        </label>
                                                        <p class="pl-1">or drag and drop</p>
                                                    </div>
                                                    <p v-if="attachForm.type == 1" class="text-xs text-gray-500">
                                                        DOC, DOCX up to 50MB
                                                    </p>
                                                    <p v-else class="text-xs text-gray-500">
                                                        DOC, DOCX, PDF up to 50MB
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-slot:footer>
                        <a href="#" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm" @click="submitAttach()">
                            Upload
                        </a>
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="showUploadAttachModal = false" ref="cancelButtonRef">
                            Cancel
                        </button>
                    </template>
                </Modal>
                <Modal :show="showUpdateAttachModel" @close="showUpdateAttachModel = false; clearUpdateAttachForm()">
                    <template v-slot:default>
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">
                                    Update Attach File
                                </DialogTitle>
                                <div class="mt-2">
                                    <form @submit.prevent="updateAttach">
                                        <div class="grid grid-cols-3 gap-6 mb-2">
                                            <div class="col-span-3 sm:col-span-3">
                                                <label for="company-website" class="block text-sm font-medium text-gray-700">
                                                Type
                                                </label>
                                                <select class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="www.example.com" v-model="updateAttachForm.type">
                                                    <option value="" selected>Select</option>
                                                    <option v-for="type in attachTypes" :key="type.id" :value="type.id">{{ type.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-span-3 sm:col-span-2 mb-2">
                                            <label for="company-website" class="block text-sm font-medium text-gray-700">
                                            Notes
                                            </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                            <textarea v-model="updateAttachForm.description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="" />
                                            </div>
                                        </div>
                                        <div v-show="updateAttachForm.file_name != null">
                                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                <label for="company-website" class="block text-sm font-medium text-gray-700">
                                                    Uploaded Files
                                                </label>
                                                <ul role="list" class="mt-1 border border-gray-200 rounded-md divide-y divide-gray-200">
                                                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                                        <div class="w-0 flex-1 flex items-center">
                                                        <PaperClipIcon class="flex-shrink-0 h-5 w-5 text-gray-400" aria-hidden="true" />
                                                        <span class="ml-2 flex-1 w-0 truncate"> {{ updateAttachForm.file_name }} </span>
                                                        </div>
                                                        <div class="ml-4 flex-shrink-0">
                                                        <a :href="`/admin/manuscripts/${manuscript.data.id}/attach-files/${updateAttachForm.id}/download`" class="font-medium text-indigo-600 hover:text-indigo-500"> Download </a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </dd>
                                        </div>
                                        <div>
                                            <label class="mt-1 block text-sm font-medium text-gray-700">
                                                Files
                                            </label>
                                            <div class="mt-1 flex justify-center pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                                <div class="space-y-1 text-center">
                                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    <p v-if="updateAttachForm.file != null">
                                                        {{ updateAttachForm.file.name }}
                                                    </p>
                                                    <div class="flex text-sm text-gray-600">
                                                        <label for="update-file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                        <span>Upload a file</span>
                                                        <input id="update-file-upload" ref="file-update"  @change="onChangeUpdateAttachFile" type="file" class="sr-only" />
                                                        <progress v-if="updateAttachForm.progress" :value="updateAttachForm.progress.percentage" max="100">
                                                        {{ updateAttachForm.progress.percentage }}%
                                                        </progress>
                                                        </label>
                                                        <p class="pl-1">or drag and drop</p>
                                                    </div>
                                                    <p v-if="updateAttachForm.type == 1" class="text-xs text-gray-500">
                                                        DOC, DOCX, PDF up to 50MB
                                                    </p>
                                                    <p v-else class="text-xs text-gray-500">
                                                        DOC, DOCX, PDF up to 50MB
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="hidden sm:block" aria-hidden="true">
                                            <div class="py-5">
                                                <div class="border-t border-gray-200" />
                                            </div>
                                        </div>
                                        <span v-if="updateAttachForm.id != null">
                                            <CommentSectionCard
                                                :manuscript-id="manuscript.data.id"
                                                :manuscript-attach-id="updateAttachForm.id"
                                                :auth="auth"></CommentSectionCard>
                                        </span>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-slot:footer>
                        <a href="#" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm" @click="updateAttach()">
                            Update
                        </a>
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="showUpdateAttachModel = false; clearUpdateAttachForm()" ref="cancelButtonRef">
                            Cancel
                        </button>
                    </template>
                </Modal>

                <Modal :show="showSubmitReviewModal" @close="showSubmitReviewModal = false;">
                    <template v-slot:default>
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <ExclamationIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Submit For Review </DialogTitle>
                                <div class="mt-2">
                                    <!-- <p class="text-sm text-gray-500">Lorem ipsum dolor sit amet, consectetur adipisicing elit. In quidem asperiores, beatae deserunt ipsam est. In vero, expedita neque ex, debitis, odio animi quisquam deserunt beatae fuga rerum blanditiis id?</p> -->
                                </div>
                                <div class="w-full mt-3 grid grid-col-1 gap-4">
                                    <a href="#" @click="submitForReview" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:w-auto sm:text-sm">
                                        Submit For Review
                                    </a>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-slot:footer>
                        
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="showSubmitReviewModal = false">
                            Cancel
                        </button>
                    </template>
                </Modal>

                <Modal :show="showAcceptModal" @close="showAcceptModal = false;">
                    <template v-slot:default>
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <ExclamationIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Accept Manuscript </DialogTitle>
                                <div class="mt-2">
                                    <!-- <p class="text-sm text-gray-500">Lorem ipsum dolor sit amet, consectetur adipisicing elit. In quidem asperiores, beatae deserunt ipsam est. In vero, expedita neque ex, debitis, odio animi quisquam deserunt beatae fuga rerum blanditiis id?</p> -->
                                </div>
                                <div class="w-full mt-3 grid grid-col-1 gap-4">
                                    <a href="#" @click="acceptWithoutChanges" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:w-auto sm:text-sm">
                                        Accepted Without Changes
                                    </a>
                                    <a href="#" @click="acceptWithMinorChanges" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:w-auto sm:text-sm">
                                        Accept with minor changes
                                    </a>
                                    <a href="#" @click="acceptWithMajorChanges" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:w-auto sm:text-sm">
                                        Accept with major changes
                                    </a>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-slot:footer>
                        
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="showAcceptModal = false">
                            Cancel
                        </button>
                    </template>
                </Modal>

                <Modal :show="showRejectModal" @close="showRejectModal = false;">
                    <template v-slot:default>
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <ExclamationIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Reject Manuscript </DialogTitle>
                                <div class="mt-2">
                                    <!-- <p class="text-sm text-gray-500">Lorem ipsum dolor sit amet, consectetur adipisicing elit. In quidem asperiores, beatae deserunt ipsam est. In vero, expedita neque ex, debitis, odio animi quisquam deserunt beatae fuga rerum blanditiis id?</p> -->
                                </div>
                                <div class="w-full mt-3 grid grid-col-1 gap-4">
                                    <a href="#" @click="rejectInviteToResubmit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:w-auto sm:text-sm">
                                        Reject invite to resubmit
                                    </a>
                                    <a href="#" @click="reject" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                                        Reject
                                    </a>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-slot:footer>
                        
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="showRejectModal = false">
                            Cancel
                        </button>
                    </template>
                </Modal>
                <form @submit.prevent="">
                    <div>
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Manuscript Attach Files</h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    When possible these fields will be populated with information collected from your uploaded submission file. Steps requiring review will be marked with a warning icon. Please review these fields to be sure we found the correct information and fill in any missing details.
                                </p>
                            </div>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                                    <div class="flex justify-between px-4 py-5 sm:px-6">
                                        <div class="">
                                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                                Attach Files <span class="text-red-700">*</span>
                                            </h3>
                                            <JetInputError :message="manuscriptForm.errors.status" class="mt-2" />
                                            <!-- <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                                Personal details and application.
                                            </p> -->
                                        </div>
                                        <div>
                                            <span class="sm:ml-3">
                                                <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" @click="showUploadAttachModal = !showUploadAttachModal; ">
                                                    Upload File 
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="border-t border-gray-200 text-sm">
                                        <Table>
                                            <template v-slot:header>
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        #
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Name
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Size
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Modified
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        
                                                    </th>
                                                </tr>
                                            </template>
                                            <template v-slot:body>
                                                <tr v-for="(attachment, index) in manuscript.data.attachments.filter(function(attach) {if(auth.user.data.permissions_attribute.manuscripts.cover_letter == false && attach.type.name == `Cover Letter` || auth.user.data.permissions_attribute.manuscripts.conflict_of_interest == false && attach.type.name == `Conflict of Interest` || auth.user.data.permissions_attribute.manuscripts.declaration_of_interest_statement == false && attach.type.name == `Declaration of Interest Statement`) {return false;}return true;})" :key="attachment.id + '-attach'">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        {{ index + 1 }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <p>{{ attachment.type.name }}</p>
                                                        <small class="text-gray-500">
                                                            {{ attachment.description }}
                                                        </small>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        {{ attachment.size}}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        {{ attachment.updated_at}}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <!--<span class="text-indigo-600 hover:text-indigo-900 cursor-pointer px-1" @click="showUpdateAttachModel = !showUpdateAttachModel; fillUpdateAttachForm(attachment);">View</span>-->
                                                        <a :href="`/admin/manuscripts/${manuscript.data.id}/attach-files/${attachment.id}/download`" class="text-indigo-600 hover:text-indigo-900 px-1">Download</a>
                                                        <span @click="deleteAttachFile(attachment)" class="text-indigo-600 hover:text-indigo-900 cursor-pointer px-1">Delete</span>
                                                    </td>
                                                </tr>
                                                <tr v-show="manuscript.data.attachments.length == 0">
                                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center">
                                                        No Data
                                                    </td>
                                                </tr>
                                            </template>
                                        </Table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-show="authIsAuthor()" class="hidden sm:block" aria-hidden="true">
                        <div class="py-5">
                            <div class="border-t border-gray-200" />
                        </div>
                    </div>
                    <div v-show="authIsAuthor()" class="mt-10 sm:mt-0">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Additional Information</h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    Please respond to the presented questions/statements.
                                </p>
                            </div>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <div class="shadow overflow-hidden sm:rounded-md">
                                    <div class="px-4 py-5 bg-white sm:p-6">
                                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                            <fieldset>
                                            <legend class="text-base font-medium text-gray-900">Please confirm that you have mentioned all organizations that funded your research in the Acknowledgements section of your submission, including grant numbers where appropriate.</legend>
                                            <div class="mt-4 space-y-4">
                                                <div class="flex items-start">
                                                <div class="flex items-center h-5">
                                                    <input v-model="manuscriptForm.is_confirm_grant_numbers" id="is_confirm_grant_numbers" name="is_confirm_grant_numbers" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="is_confirm_grant_numbers" class="font-medium text-gray-700">I Confirm <span class="text-red-600">*</span></label>
                                                    <p class="text-gray-500">I confirm that I have mentioned all organizations that funded my research in the Acknowledgements section of my submission, including grant numbers where appropriate.</p>
                                                </div>
                                                </div>
                                            </div>
                                            <JetInputError :message="manuscriptForm.errors.is_confirm_grant_numbers" class="mt-2" />
                                            </fieldset>
                                            <div class="hidden sm:block" aria-hidden="true">
                                                <div class="py-5">
                                                    <div class="border-t border-gray-200" />
                                                </div>
                                            </div>
                                            <fieldset>
                                            <legend class="text-base font-medium text-gray-900">Sensors Malaysia is an open access journal which charges an Article Publishing Charge (APC) to cover the cost associated with the publication process. All articles published Open Access will be immediately and permanently free on ScienceDirect for users to read, download, and use in accordance with the author’s selected Creative Commons user license. </legend>
                                            <div class="mt-4 space-y-4">
                                                <div class="flex items-start">
                                                <div class="flex items-center h-5">
                                                    <input v-model="manuscriptForm.is_acknowledge" id="is_acknowledge" name="is_acknowledge" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="is_acknowledge" class="font-medium text-gray-700">I Acknowledge <span class="text-red-600">*</span></label>
                                                    <p class="text-gray-500">As an Author, I acknowledge I need to pay the Article Publishing Charge if my manuscript is accepted for publication</p>
                                                </div>
                                                </div>
                                            </div>
                                            <JetInputError :message="manuscriptForm.errors.is_acknowledge" class="mt-2" />
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="py-3 text-right">
                        <button type="submit" @click="saveManuscript()" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2">
                            Save to Draft
                        </button>
                        <button type="submit" @click="showSubmitToEditorModal = true" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Submit to Editor
                        </button>
                    </div>
                </form>
                <Modal :show="showSubmitToEditorModal" @close="showSubmitToEditorModal = false;">
                    <template v-slot:default>
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <ExclamationIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Submit To Editor </DialogTitle>
                                <div class="mt-2">
                                    <!-- <p class="text-sm text-gray-500">Lorem ipsum dolor sit amet, consectetur adipisicing elit. In quidem asperiores, beatae deserunt ipsam est. In vero, expedita neque ex, debitis, odio animi quisquam deserunt beatae fuga rerum blanditiis id?</p> -->
                                </div>
                                <div class="w-full mt-3 grid grid-col-1 gap-4">
                                    <a href="#" @click="submitToEditor()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:w-auto sm:text-sm">
                                        Submit To Editor
                                    </a>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-slot:footer>
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="showSubmitToEditorModal = false">
                            Cancel
                        </button>
                    </template>
                </Modal>
            </template>
        </Layout>
    </div>
</template>
<script>
  import Layout from '../../Layout'
  import Table from '../../Components/Table'
  import Modal from '../../Components/Modal'
  import VueMultiselect from 'vue-multiselect'
  import {
  BriefcaseIcon,
  CalendarIcon,
  DownloadIcon,
  CheckIcon,
  ChevronDownIcon,
  CurrencyDollarIcon,
  LinkIcon,
  LocationMarkerIcon,
  UserIcon,
  StatusOnlineIcon,
  DocumentReportIcon,
  PencilIcon,
  PaperClipIcon,
  DocumentSearchIcon,
  ExclamationIcon,
  PaperAirplaneIcon,
  NewspaperIcon,
  XCircleIcon,
  BadgeCheckIcon,
  CheckCircleIcon,
  CloudUploadIcon
} from '@heroicons/vue/solid'
  import { Menu, MenuButton, MenuItem, MenuItems, DialogTitle } from '@headlessui/vue'
  import { useForm, Link } from '@inertiajs/inertia-vue3'
  import Toast from '../../Components/Toast'
  import CommentSectionCard from '../../Components/CommentSectionCard.vue'
  import JetInputError from '../../Components/InputError.vue';

  export default {
    components: {
        VueMultiselect,
        JetInputError,
        Layout,
        Table,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        BriefcaseIcon,
        CalendarIcon,
        CheckIcon,
        DocumentSearchIcon,
        ChevronDownIcon,
        CurrencyDollarIcon,
        LinkIcon,
        DownloadIcon,
        LocationMarkerIcon,
        UserIcon,
        StatusOnlineIcon,
        DocumentReportIcon,
        ExclamationIcon,
        PencilIcon,
        UserIcon,
        PaperAirplaneIcon,
        NewspaperIcon,
        XCircleIcon,
        BadgeCheckIcon,
        CheckCircleIcon,
        CloudUploadIcon,
        Modal,
        Link,
        DialogTitle,
        Toast,
        PaperClipIcon,
        CommentSectionCard
    },
    props: {
        manuscript: Object,
        attachTypes: Array,
        articleTypes: Array,
        errors: Object,
        message: String,
        auth: Object,
        manuscriptStatusList: Array
    },
    data() {
        return {
            attach_files: [],
            showUploadAttachModal: false,
            showUpdateAttachModel: false,
            showSubmitToEditorModal: false,
            showAcceptModal: false,
            showRejectModal: false,
            showSubmitReviewModal: false,
            isShow: false,
            authorSelect: {
                isLoading: false,
                options: []
            },
            correspondingAuthorSelect: {
                isLoading: false,
                options: []
            },
            editorSelect: {
                isLoading: false,
                options: []
            },
            reviewerSelect: {
                isLoading: false,
                options: []
            },
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
        saveManuscript() {
            this.manuscriptForm.post(`/admin/manuscripts/${this.$props.manuscript.data.id}/update`, {
                preserveScroll: true,
                onError: (errors) => {
                    Object.keys(errors).forEach((value, index) => {
                        this.notification(errors[value], 'error');
                    });
                },
                onSuccess: (res) => {
                    this.notification('Saved to Draft.', 'success');
                }
            });
        },
        submitToEditor() {
            this.manuscriptForm.post(`/admin/manuscripts/${this.$props.manuscript.data.id}/store-final`, {
                preserveScroll: true,
                onError: (errors) => {
                    Object.keys(errors).forEach((value, index) => {
                        this.notification(errors[value], 'error');
                    });
                },
                onSuccess: (res) => {
                    this.notification('Thank you for your submission. Your manuscript is in review.', 'success');
                }
            });
        },
        onChangeSubmitAttachFile(e) {
            this.attachForm.file = e.target.files[0];
        },
        onChangeUpdateAttachFile(e) {
            this.updateAttachForm.file = e.target.files[0];
        },
        submitAttach() {
            this.attachForm.redirectBack = true;
            this.attachForm.post(`/admin/manuscripts/${this.$props.manuscript.data.id}/attach-files`, {
                preserveScroll: true,
                onError: (errors) => {
                    Object.keys(errors).forEach((value, index) => {
                        this.notification(errors[value], 'error');
                    });
                },
                onSuccess: () => {
                    this.notification('Saved', 'success');
                    this.showUpdateAttachModel = false;
                }
            });
            this.clearAttachForm();
        },
        updateAttach() {
            this.updateAttachForm.post(`/admin/manuscripts/${this.$props.manuscript.data.id}/attach-files/${this.updateAttachForm.id}/update`, {
                preserveScroll: true,
                onError: (errors) => {
                    Object.keys(errors).forEach((value, index) => {
                        this.notification(errors[value], 'error');
                    });
                },
                onSuccess: () => {
                    this.notification('Saved', 'success');
                    this.showUpdateAttachModel = false;
                }
            });
        },
        submitForReview() {
            this.manuscriptForm.status = "Submit For Review";
            this.saveManuscript();
        },
        acceptWithoutChanges() {
            this.manuscriptForm.status = "Accepted Without Changes";
            this.saveManuscript();
        },
        acceptWithMinorChanges() {
            this.manuscriptForm.status = "Accepted With Minor Changes";
            this.saveManuscript();
        },
        acceptWithMajorChanges() {
            this.manuscriptForm.status = "Accepted With Major Changes";
            this.saveManuscript();
        },
        rejectInviteToResubmit() {
            this.manuscriptForm.status = "Rejected Invite To Resubmit";
            this.saveManuscript();
        },
        reject() {
            this.manuscriptForm.status = "Rejected";
            this.saveManuscript();
        },
        asyncFindEditors: _.debounce(async function(query) {
            this.editorSelect.isLoading = true;
            let resp = await window.axios.get('/api/users', {
                params: {
                    search: query,
                    role: 'Editor',
                }
            });
            this.editorSelect.isLoading = false;
            if (resp.status == 200) {
                this.editorSelect.options = resp.data;
                return 0;
            }
            this.editorSelect.options = [];
            return 0;
        }, 300),
        asyncFindReviewers: _.debounce(async function(query) {
            this.reviewerSelect.isLoading = true;
            let resp = await window.axios.get('/api/users', {
                params: {
                    search: query,
                    role: 'Reviewer',
                }
            });
            this.reviewerSelect.isLoading = false;
            if (resp.status == 200) {
                this.reviewerSelect.options = resp.data;
                return 0;
            }
            this.reviewerSelect.options = [];
            return 0;
        }, 300),
        asyncFindAuthors: _.debounce(async function(query) {
            this.authorSelect.isLoading = true;
            let resp = await window.axios.get('/api/users', {
                params: {
                    search: query,
                    role: 'Author',
                }
            });
            this.authorSelect.isLoading = false;
            if (resp.status == 200) {
                this.authorSelect.options = resp.data;
                return 0;
            }
            this.authorSelect.options = [];
            return 0;
        }, 300),
        asyncFindCorrespondingAuthors: _.debounce(async function(query) {
            this.correspondingAuthorSelect.isLoading = true;
            let resp = await window.axios.get('/api/users', {
                params: {
                    search: query,
                    role: 'Author',
                }
            });
            this.correspondingAuthorSelect.isLoading = false;
            if (resp.status == 200) {
                this.correspondingAuthorSelect.options = resp.data;
                return 0;
            }
            this.correspondingAuthorSelect.options = [];
            return 0;
        }, 300),
        authIsAuthor() {
            let auth_id = this.$props.auth.user.data.id;
            let manuscriptAuthors = this.manuscript.data.authors;
            // Filter auth roles
            let result = manuscriptAuthors.filter(function(member) {
                if (member.user_id == auth_id) {
                    return true;
                }
                return false;
            });
            return result.length > 0;
        },
        authIsCorrespondingAuthor() {
            let auth_id = this.$props.auth.user.data.id;
            let manuscriptAuthors = this.manuscript.data.corresponding_authors;
            // Filter auth roles
            let result = manuscriptAuthors.filter(function(member) {
                if (member.user_id == auth_id) {
                    return true;
                }
                return false;
            });
            return result.length > 0;
        },
        authIsEditor() {
            let auth_id = this.$props.auth.user.data.id;
            let manuscriptEditors = this.manuscript.data.editors;
            // Filter auth roles
            let result = manuscriptEditors.filter(function(member) {
                if (member.user_id == auth_id) {
                    return true;
                }
                return false;
            });
            return result.length > 0;
        },
        authIsReviewer() {
            let auth_id = this.$props.auth.user.data.id;
            let manuscriptReviewers = this.manuscript.data.reviewers;
            // Filter auth roles
            let result = manuscriptReviewers.filter(function(member) {
                if (member.user_id == auth_id) {
                    return true;
                }
                return false;
            });
            return result.length > 0;
        },
        authIsPublisher() {
            let authRoles = this.$props.auth.user.data.roles;
            // Filter auth roles
            let result = authRoles.filter(function(role) {
                if (role.name == 'Super Admin' || role.name == 'Admin' || role.name == 'Publisher') {
                    return true;
                }
                return false;
            });
            return result.length > 0;
        },
    },
    setup (props) {

        const manuscriptForm = useForm({
            title: props.manuscript.data.title,
            type: props.manuscript.data.type.id,
            is_confirm_grant_numbers: props.manuscript.data.is_confirm_grant_numbers,
            is_acknowledge: props.manuscript.data.is_acknowledge,
            status: null
        });

        const attachForm = useForm({
            id: null,
            file: null,
            type: "",
            redirectBack: false,
            description: null
        });

        const updateAttachForm = useForm({
            _method: 'post',
            id: null,
            file: null,
            type: "",
            description: null
        });

        function fillUpdateAttachForm(attach) {
            updateAttachForm.id = attach.id;
            updateAttachForm.file = null;
            updateAttachForm.type = attach.type.id;
            updateAttachForm.description = attach.description;
            updateAttachForm.file_name = attach.file_name;
        }

        function clearUpdateAttachForm() {
            updateAttachForm.id = null;
            updateAttachForm.file = null;
            updateAttachForm.type = "";
            updateAttachForm.description = null;
            updateAttachForm.file_name = null;
        }

        function clearAttachForm() {
            attachForm.id = null;
            attachForm.file = null;
            attachForm.type = "";
            attachForm.description = null;
        }

        function deleteAttachFile(attach) {
            const deleteAttachForm = useForm({
                _method: 'delete'
            });
            if (confirm('Are you sure to delete "' + attach.type.name + '"?')) {
                deleteAttachForm.post(`/admin/manuscripts/${props.manuscript.data.id}/attach-files/${attach.id}`, {
                    preserveScroll: true,
                });
            }
        }

        return { clearAttachForm, fillUpdateAttachForm, clearUpdateAttachForm, deleteAttachFile, manuscriptForm, attachForm, updateAttachForm }
    },
    async mounted() {
        // console.log(this.$page.props.auth.user)
    }
  }
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>