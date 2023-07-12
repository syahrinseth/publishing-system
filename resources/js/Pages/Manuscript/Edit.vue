<template>
    <div>
        <Layout :auth="auth.user.data">
            <template v-slot:header>
                <div class="">
                    <div class="lg:flex lg:items-center lg:justify-between">
                        <div class="flex-1 min-w-0">
                            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                                {{ manuscript.data.manuscript_no }} - {{ manuscript.data.title || 'Untitled' }}
                            </h2>
                            <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                <BriefcaseIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                                {{ manuscript.data.type.name }}
                                </div>
                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                    <DocumentReportIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                                    <span class="px-3 py-2 rounded-full text-white" :class="{
                                        'bg-gray-400': isDraft(),
                                        'bg-blue-400': isSubmitForReview() || isSubmitToEditor(),
                                        'bg-red-400': isRejected(),
                                        'bg-green-400': isAccepted(),
                                        'bg-indigo-400': isPublished(),
                                    }">{{ manuscript.data.status }}</span>
                                </div>
                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                    <CalendarIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                                    {{ manuscript.data.created_at }}
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 flex lg:mt-0 lg:ml-4">
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="flex mt-1">
                        <!-- This example requires Tailwind CSS v2.0+ -->
                        <Listbox as="div" v-model="data.viewAs" class="w-64 rounded-md p-4 flex-1" :class="getRoleBgColor()">
                            <ListboxLabel class="block text-sm font-medium text-gray-100">View As</ListboxLabel>
                            <div class="mt-1 relative">
                            <ListboxButton class="relative w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-pointer focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <span class="flex items-center">
                                <!-- <img :src="selected.avatar" alt="" class="flex-shrink-0 h-6 w-6 rounded-full" /> -->
                                <svg class="h-4 w-4 rounded-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span class="ml-3 block truncate capitalize">{{ data.viewAs }}</span>
                                </span>
                                <span class="ml-3 absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                <SelectorIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                </span>
                            </ListboxButton>

                            <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                <ListboxOptions class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-56 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                                <ListboxOption as="template" v-for="person in data.viewAsList" :key="person" :value="person" v-slot="{ active }">
                                    <li :class="[active ? 'text-white bg-indigo-600' : 'text-gray-900', 'cursor-pointer select-none relative py-2 pl-3 pr-9']">
                                        <div class="flex items-center">
                                            <!-- <img :src="person.avatar" alt="" class="flex-shrink-0 h-6 w-6 rounded-full" /> -->
                                            <svg class="h-4 w-4 rounded-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                            <span :class="[data.viewAs ? 'font-semibold' : 'font-normal', 'ml-3 block truncate']" class="capitalize">
                                            {{ person }}
                                            </span>
                                        </div>

                                        <span v-if="data.viewAs == person" :class="[active ? 'text-white' : 'text-indigo-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                                            <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                        </span>
                                    </li>
                                </ListboxOption>
                                </ListboxOptions>
                            </transition>
                            </div>
                        </Listbox>
                        <div class="text-right">
                            <span class="sm:ml-3" v-if="canSubmitToEditor()">
                                <button type="button" @click="data.showSubmitToEditorModal = true" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                    <DocumentSearchIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                                    Submit To Editor
                                </button>
                            </span>
                            <span class="sm:ml-3" v-if="(isRejectedToResubmit() || isSubmitToEditor()) && (isEditor())">
                                <a href="#" @click="data.showSubmitReviewModal = true" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                    <DocumentSearchIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                                    Submit For Review
                                </a>
                            </span>
                            <span class="sm:ml-3" v-if="isSubmitForReview() && isReviewer() && canReview() && !isReviewerPending()">
                                <a href="#" @click="data.showRejectModal = true" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <XCircleIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                                    Reject
                                </a>
                            </span>
                            <span class="sm:ml-3" v-if="isSubmitForReview() && isReviewer() && canReview() && !isReviewerPending()">
                                <a href="#" @click="data.showAcceptModal = true" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <CheckCircleIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                                    Accept
                                </a>
                            </span>
                            <span class="sm:ml-3" v-if="canPublish()">
                                <a href="#" @click="data.showPublishModal = true" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <PaperAirplaneIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                                    Publish
                                </a>
                            </span>
                            <span class="sm:ml-3" v-if="isPublished()">
                                <a :href="`/admin/manuscripts/${manuscript.data.id}/download`" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <DownloadIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                                    Download PDF
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </template>
            <template v-slot:default>
                <Modal :show="data.showUploadAttachModal" @close="data.showUploadAttachModal = false;">
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
                                                <select :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? 'cursor-not-allowed' : null" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" v-model="attachForm.type">
                                                    <option value="" selected>Select</option>
                                                    <option v-for="type, index in filterAttachTypes(attachTypes)" :key="type.id" :value="type.id">{{ type.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-span-3 sm:col-span-2 mb-2">
                                                <label for="company-website" class="block text-sm font-medium text-gray-700">
                                                Notes
                                                </label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                <textarea :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null" v-model="attachForm.description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="" />
                                                </div>
                                            </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">
                                                Files
                                            </label>
                                            <FileInput
                                                :key-value="`attach-file-upload`"
                                                @on-select="onChangeSubmitAttachFile"
                                                :url="attachForm.selected_file">
                                                <requirements>
                                                    <p v-show="attachForm.type == 14" class="text-center mb-2 text-xs leading-5 text-gray-600">
                                                        PDF up to 10MB
                                                    </p>
                                                    <p v-show="attachForm.type != 14" class="text-center mb-2 text-xs leading-5 text-gray-600">
                                                        DOC, DOCX, PDF up to 10MB
                                                    </p>
                                                </requirements>
                                                <template v-if="attachForm.type == 1 || attachForm.type == 14">
                                                    <div class="bg-blue-100 border-blue-100 px-4 py-5 text-blue-500 w-full rounded-md mt-2">
                                                        Please upload manuscript based on "{{ app.name }}"" guidelines found in <a class="font-extrabold hover:underline" href="/guidelines/TemplateforJournalofSmartSensorandMaterials.pdf" target="_blank">here</a>.
                                                    </div>
                                                </template>
                                            </FileInput>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-slot:footer>
                        <span :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer" @click="cannotEditOnSubmit() ? `` : submitAttach()">
                            Upload
                        </span>
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="data.showUploadAttachModal = false" ref="cancelButtonRef">
                            Cancel
                        </button>
                    </template>
                </Modal>
                <Modal :show="data.showUpdateAttachModel" @close="data.showUpdateAttachModel = false; clearUpdateAttachForm()">
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
                                                <select :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="www.example.com" v-model="updateAttachForm.type">
                                                    <option value="" selected>Select</option>
                                                    <option v-for="type, index in attachTypes" :key="type.id" :value="type.id">{{ type.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-span-3 sm:col-span-2 mb-2">
                                            <label for="company-website" class="block text-sm font-medium text-gray-700">
                                            Notes
                                            </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                            <textarea :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null" v-model="updateAttachForm.description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="" />
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
                                        <FileInput
                                            :key-value="`attach-file-upload-update`"
                                            @on-select="onChangeUpdateAttachFile"
                                            :url="updateAttachForm.selected_file">
                                            <requirements>
                                                <p v-show="updateAttachForm.type == 14" class="text-center mb-2 text-xs leading-5 text-gray-600">
                                                    PDF up to 10MB
                                                </p>
                                                <p v-show="updateAttachForm.type != 14" class="text-center mb-2 text-xs leading-5 text-gray-600">
                                                    DOC, DOCX, PDF up to 10MB
                                                </p>
                                            </requirements>
                                            <template v-if="updateAttachForm.type == 1 || updateAttachForm.type == 14">
                                                <div class="bg-blue-100 border-blue-100 px-4 py-5 text-blue-500 w-full rounded-md mt-2">
                                                    Please upload manuscript based on "{{ app.name }}"" guidelines found in <a class="font-extrabold hover:underline" href="/guidelines/TemplateforJournalofSmartSensorandMaterials.pdf" target="_blank">here</a>.
                                                </div>
                                            </template>
                                        </FileInput>
                                        <div class="hidden sm:block" aria-hidden="true">
                                            <div class="py-5">
                                                <div class="border-t border-gray-200" />
                                            </div>
                                        </div>
                                        <CommentSectionCard
                                            :manuscript-id="manuscript.data.id"
                                            :manuscript-attach-id="updateAttachForm.id"
                                            :auth="auth"
                                            :from="data.viewAs"></CommentSectionCard>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-slot:footer>
                        <span :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer" @click="cannotEditOnSubmit() ? `` : updateAttach()">
                            Update
                        </span>
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="data.showUpdateAttachModel = false; clearUpdateAttachForm()" ref="cancelButtonRef">
                            Cancel
                        </button>
                    </template>
                </Modal>
                <Modal :show="data.showSubmitToEditorModal" @close="data.showSubmitToEditorModal = false;">
                    <template v-slot:default>
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <ExclamationIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Submit To Editor </DialogTitle>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Are you sure to submit this manuscript to the editor(s)?</p>
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
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="data.showSubmitToEditorModal = false">
                            Cancel
                        </button>
                    </template>
                </Modal>
                <Modal :show="data.showSubmitReviewModal" @close="data.showSubmitReviewModal = false;">
                    <template v-slot:default>
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <ExclamationIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Submit For Review </DialogTitle>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Are you sure to submit this manuscript to the reviewer(s)?</p>
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
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="data.showSubmitReviewModal = false">
                            Cancel
                        </button>
                    </template>
                </Modal>
                <Modal :show="data.showAcceptModal" @close="data.showAcceptModal = false;">
                    <template v-slot:default>
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <ExclamationIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Accept Manuscript </DialogTitle>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Are you sure to accept this manuscript?</p>
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
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="data.showAcceptModal = false">
                            Cancel
                        </button>
                    </template>
                </Modal>
                <Modal :show="data.showRejectModal" @close="data.showRejectModal = false;">
                    <template v-slot:default>
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <ExclamationIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Reject Manuscript </DialogTitle>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Are you sure to reject this manuscript?</p>
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
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="data.showRejectModal = false">
                            Cancel
                        </button>
                    </template>
                </Modal>
                <Modal :show="data.showPublishModal" @close="data.showPublishModal = false;">
                    <template v-slot:default>
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                            <ExclamationIcon class="h-6 w-6 text-indigo-600" aria-hidden="true" />
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Publish Manuscript </DialogTitle>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Are you sure to publish this manuscript?</p>
                                </div>
                                <div class="w-full mt-3 grid grid-col-1 gap-4">
                                    <a href="#" @click="publishManuscript" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm">
                                        Publish
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- <div v-else>
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                            <ExclamationIcon class="h-6 w-6 text-indigo-600" aria-hidden="true" />
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Missing Manuscript to Publish </DialogTitle>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Before proceeding with publishing, please ensure that you have selected one of the attached files to be included for publish.</p>
                                </div>
                                <div class="w-full mt-3 grid grid-col-1 gap-4">
                                    <a href="#manuscript-attach-files" @click="data.showPublishModal = false" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm">
                                        Okey
                                    </a>
                                </div>
                            </div>   
                        </div>  -->

                    </template>
                    <template v-slot:footer>
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="data.showPublishModal = false">
                            Cancel
                        </button>
                    </template>
                </Modal>
                <Modal :show="data.showThanksModal" @close="data.showThanksModal = false;">
                    <template v-slot:default>
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                            <ExclamationIcon class="h-6 w-6 text-green-600" aria-hidden="true" />
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Thank you for your review. </DialogTitle>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">The manuscript status will update once the majority of the reviewers reviewed the manuscript.data.</p>
                                </div>
                                <div class="w-full mt-3 grid grid-col-1 gap-4">
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-slot:footer>
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="data.showThanksModal = false">
                            Done
                        </button>
                    </template>
                </Modal>
                <Modal :show="data.showAddReviewerModal" @close="data.showAddReviewerModal = false;">
                    <template v-slot:default>
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">
                                    Suggest Reviewer
                                </DialogTitle>
                                <div class="mt-2 h-80">
                                    <form>
                                        <div class="grid grid-cols-3 gap-6 mb-2">
                                            <div class="col-span-3 sm:col-span-3">
                                                <VueMultiselect 
                                                    :disabled="cannotEditOnSubmit()" 
                                                    :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null"
                                                    v-model="reviewerForm.members" label="first_name" 
                                                    :custom-label="(value) => `${value.first_name} ${value.last_name} ${value.field == null ? `` : `- ${value.field}`} ${value.affiliation == null ? `` : `- ${value.affiliation}`}`" 
                                                    track-by="id"
                                                    placeholder="Type to search" 
                                                    open-direction="bottom" 
                                                    :options="data.reviewerSelect.options" 
                                                    :multiple="true" 
                                                    :searchable="true" 
                                                    :loading="data.reviewerSelect.isLoading" 
                                                    :internal-search="false" 
                                                    :options-limit="300" 
                                                    :max-height="600" 
                                                    :max="1"
                                                    @search-change="asyncFindReviewers" 
                                                    :taggable="true" 
                                                    @tag="createNewReviewerModal" 
                                                    tag-placeholder="Press enter to add new user">
                                                    </VueMultiselect>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-slot:footer>
                        <span :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer" @click="cannotEditOnSubmit() ? `` : submitAddReviewer()">
                            Submit
                        </span>
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="data.showAddReviewerModal = false" ref="cancelButtonRef">
                            Cancel
                        </button>
                        <span v-show="reviewerForm.recentlySuccessful" class="py-2 text-gray-600">Submitted</span>
                    </template>
                </Modal>
                <div v-if="isAuthor() || isEditor() || isReviewer() || isPublisher()">
                    <div v-if="isAssigned()" class="mt-10 sm:mt-0">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">General Information</h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    <span v-show="isAuthor()">
                                        Please identify your submission's areas of interest and specialization by selecting one or more classifications.
                                    </span>
                                    <!--<span v-show="authIsReviewer()">
                                        You have been assigned to review this manuscript, please download the manuscript in the "Manuscript Attach Files" section below.
                                    </span>-->
                                    <span v-show="isEditor()">
                                        You have been assigned as an Editor. Please select reviewers and notify the reviewers to review manuscripts. Thank you
                                    </span>
                                    <span v-show="isPublisher()">
                                        Manuscript general information.
                                    </span>
                                </p>
                            </div>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                            <form @submit.prevent="saveManuscript()">
                                <div class="shadow sm:rounded-md">
                                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                    <div class="grid grid-cols-3 gap-6">
                                        <div class="col-span-3 sm:col-span-2">
                                            <label for="company-website" class="block text-sm font-medium text-gray-700">
                                            Article Type
                                            </label>
                                            <select :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null" name="company-website" id="company-website" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="www.example.com" v-model="manuscriptForm.type">
                                                <option value="" selected>Select</option>
                                                <option v-for="type, index in articleTypes" :key="type.id" :value="type.id">{{ type.name }}</option>
                                            </select>
                                        </div>
                                        <div class="col-span-3 sm:col-span-2">
                                            <label for="company-website" class="block text-sm font-medium text-gray-700">
                                            Co-Author(s)
                                            </label>
                                            <VueMultiselect 
                                            :disabled="cannotEditOnSubmit() || (isPublisher() || isEditor())" :class="cannotEditOnSubmit() || (isPublisher() || isEditor()) ? `cursor-not-allowed` : null"
                                            v-model="manuscriptForm.corresponding_authors" id="ajax" label="first_name" :custom-label="(value) => `${value.first_name} ${value.last_name || ``} ${value.field == null ? `` : `- ${value.field}`} ${value.affiliation == null ? `` : `- ${value.affiliation}`}`" track-by="id" placeholder="Type to search" open-direction="bottom" :options="data.correspondingAuthorSelect.options" :multiple="true" :searchable="true" :loading="data.correspondingAuthorSelect.isLoading" :internal-search="false" :clear-on-select="false" :close-on-select="false" :options-limit="300" :max-height="600" :show-no-results="false" :hide-selected="true" @search-change="asyncFindCorrespondingAuthors" :taggable="true" @tag="createNewCoAuthorModal" tag-placeholder="Press enter to add new user">
                                                </VueMultiselect>
                                        </div>
                                        <div class="col-span-3 sm:col-span-2">
                                            <label for="company-website" class="block text-sm font-medium text-gray-700">
                                            Author(s)
                                            </label>
                                            <VueMultiselect :disabled="cannotEditOnSubmit() || (isPublisher() || isEditor())" :class="cannotEditOnSubmit() || (isPublisher() || isEditor()) ? `cursor-not-allowed` : null"
                                            v-model="manuscriptForm.authors" id="ajax" label="first_name" :custom-label="(value) => `${value.first_name} ${value.last_name || ``} ${value.field == null ? `` : `- ${value.field}`} ${value.affiliation == null ? `` : `- ${value.affiliation}`}`" track-by="id" placeholder="Type to search" open-direction="bottom" :options="data.authorSelect.options" :multiple="true" :searchable="true" :loading="data.authorSelect.isLoading" :internal-search="false" :clear-on-select="false" :close-on-select="false" :options-limit="300" :max-height="600" :show-no-results="false" :hide-selected="true" @search-change="asyncFindAuthors" :taggable="true" @tag="createNewAuthorModal" tag-placeholder="Press enter to add new user">
                                                </VueMultiselect>
                                        </div>
                                        <div v-show="isAssigned()" class="col-span-3 sm:col-span-2">
                                            <div class="col-span-3 sm:col-span-2">
                                                <label for="company-website" class="block text-sm font-medium text-gray-700">
                                                    Request Editor(s)
                                                </label>
                                                <VueMultiselect :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null"
                                                v-model="manuscriptForm.editors" id="ajax" label="first_name" :custom-label="(value) => `${value.first_name} ${value.last_name || ``} ${value.field == null ? `` : `- ${value.field}`} ${value.affiliation == null ? `` : `- ${value.affiliation}`}`" track-by="id" placeholder="Type to search" open-direction="bottom" :options="data.editorSelect.options" :multiple="true" :searchable="true" :loading="data.editorSelect.isLoading" :internal-search="false" :clear-on-select="false" :close-on-select="false" :options-limit="300" :max-height="600" :show-no-results="false" :hide-selected="true" @search-change="asyncFindEditors" :taggable="true" @tag="createNewEditorModal" tag-placeholder="Press enter to add new user">
                                                    </VueMultiselect>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <button :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Save
                                    </button>
                                </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                    <div v-if="isAssigned()" class="hidden sm:block" aria-hidden="true">
                        <div class="py-5">
                            <div class="border-t border-gray-200" />
                        </div>
                    </div>  
                    <div v-if="isAssigned() && !isReviewer()">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <div class="px-4 sm:px-0">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Review Preferences</h3>
                                    <p v-show="isReviewer()" class="mt-1 text-sm text-gray-600">
                                        In view of your work in the field, your name has been recommended, as a reviewer. Please suggest other reviewer's name if you are unable to review this manuscript.data. Thank You
                                    </p>
                                    <p v-show="isAuthor()" class="mt-1 text-sm text-gray-600">
                                    Please name specific reviewers to be assigned to your submission. The request will be taken under advisement by the Editor. If you do not request any reviewers, your submission will be assigned to the appropriate reviewer(s) as determined by the Editorial staff.
                                    </p>
                                    <p v-show="isEditor() || isPublisher()" class="mt-1 text-sm text-gray-600">
                                    The reviewer(s) are to be assigned to the manuscript.data.
                                    </p>
                                </div>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <form>
                                    <div class="bg-white rounded-md">
                                        <div class="">
                                            <div class="">
                                                <div class="flex justify-between p-5">
                                                    <div class="">
                                                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                                                            Reviewer(s)
                                                        </h3>
                                                        <JetInputError :message="manuscriptForm.errors.reviewers" class="mt-2" />
                                                    </div>
                                                    <div>
                                                        <span class="sm:ml-3">
                                                            <button v-if="canSuggestReviewer()" @click="onAddReviewer" type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                                Suggest Reviewer
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-span-3 border-gray-200 text-sm">
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
                                                                    Status
                                                                </th>
                                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                </th>
                                                            </tr>
                                                        </template>
                                                        <template v-slot:body>
                                                            <tr v-for="(reviewer, index) in manuscriptForm.reviewers" :key="reviewer.id + '-reviewer'">
                                                                <td class="px-6 py-4 word-break">
                                                                    {{ index + 1 }}
                                                                </td>
                                                                <td class="px-6 py-4 word-break">
                                                                    <p>{{ reviewer?.user?.first_name }} {{ reviewer?.user?.last_name }}</p>
                                                                    <small class="text-gray-500">
                                                                        {{ reviewer?.user?.email }}
                                                                    </small>
                                                                </td>
                                                                <td class="px-6 py-4 word-break">
                                                                    <span :class="{
                                                                        'text-green-600': (reviewer.status == 'Active'),
                                                                        'text-red-600': (reviewer.status == 'Rejected'),
                                                                        'text-blue-600': (reviewer.status == 'Accepted'),
                                                                        'text-orange-600': (reviewer.status == 'Pending')
                                                                    }">{{ reviewer.status }} <span v-show="reviewer.status == 'Accepted'">(Invitation Sent to Reviewer)</span></span>
                                                                </td>
                                                                <td class="px-6 py-4 word-break">
                                                                    <button v-if="canEditReviewerReviewStatus(reviewer)" @click="onAcceptReviewer(reviewer.id)" type="button" class="mx-1 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:w-auto sm:text-sm">
                                                                        Accept
                                                                    </button>
                                                                    <button v-if="canEditReviewerReviewStatus(reviewer)" @click="onRejectReviewer(reviewer.id)" type="button" class="mx-1 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                                                                        Reject
                                                                    </button>
                                                                    <button v-if="canRemoveReviewer()" @click="onRemoveReviewer(reviewer)" type="button" class="mx-1 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                                                                        Remove
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <tr v-if="manuscriptForm.reviewers.length == 0">
                                                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center">
                                                                    No Data
                                                                </td>
                                                            </tr>
                                                        </template>
                                                    </Table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div v-show="canViewReviewerStatus()" class="hidden sm:block" aria-hidden="true">
                        <div class="py-5">
                            <div class="border-t border-gray-200" />
                        </div>
                    </div>  
                    <div v-show="canViewReviewerStatus()">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <div class="px-4 sm:px-0">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Reviewers Review Status</h3>
                                    <p class="mt-1 text-sm text-gray-600">
                                        Here's the list of reviewer(s) review status.
                                    </p>
                                </div>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <Table>
                                    <template v-slot:header>
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Name
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Review
                                            </th>
                                        </tr>
                                    </template>
                                    <template v-slot:body>
                                        <tr v-for="reviewer in manuscript.data.reviewers" :key="reviewer.id">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ manuscript.data.reviewers_in_users.filter((v) => v.id == reviewer.user_id)[0]['first_name'] }} {{ manuscript.data.reviewers_in_users.filter((v) => v.id == reviewer.user_id)[0]['last_name'] }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ reviewer.reviewed == null ? 'N/a' : `Reviewed at ${moment(reviewer.reviewed).format("DD/MM/YYYY")}` }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap" :class="(reviewer.reviewedVote == null ? false : reviewer.reviewedVote.includes('Accepted')) ? 'text-green-600' : 'text-red-600'">
                                                {{ reviewer.reviewedVote == null ? 'N/a' : reviewer.reviewedVote }}
                                            </td>
                                        </tr>
                                    </template>
                                </Table>
                            </div>
                        </div>
                    </div>
                    <div v-show="canViewManuscriptData()" class="hidden sm:block" aria-hidden="true">
                        <div class="py-5">
                            <div class="border-t border-gray-200" />
                        </div>
                    </div>
                    <div v-show="canViewManuscriptData()">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Manuscript Data</h3>
                                <!--<p v-show="authIsReviewer()" class="mt-1 text-sm text-gray-600">
                                    Please make sure the manuscript attached here is the same manuscript as registered here.
                                </p>-->
                                <p class="mt-1 text-sm text-gray-600">
                                    When possible these fields will be populated with information collected from your uploaded submission file. Steps requiring review will be marked with a warning icon. Please review these fields to be sure we found the correct information and fill in any missing details.
                                </p>
                            </div>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                            <form @submit.prevent="saveManuscript()">
                                <div class="shadow sm:rounded-md sm:overflow-hidden">
                                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                    <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700">
                                        Full Title
                                    </label>
                                    <div class="mt-1">
                                        <textarea :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null" v-model="manuscriptForm.title" id="title" name="title" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="" />
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">
                                        
                                    </p>
                                    </div>

                                    <div>
                                    <!--<label for="short_title" class="block text-sm font-medium text-gray-700">
                                        Short Title
                                    </label>
                                    <div class="mt-1">
                                        <textarea :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null" v-model="manuscriptForm.short_title" id="short_title" name="short_title" rows="1" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="" />
                                    </div>
                                    </div>

                                    <div>-->
                                    <label for="abstract" class="block text-sm font-medium text-gray-700">
                                        Abstract
                                    </label>
                                    <div class="mt-1">
                                        <textarea :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null" v-model="manuscriptForm.abstract" id="abstract" name="abstract" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="" />
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Limit 300 words
                                    </p>
                                    </div>

                                    <div>
                                    <label for="keywords" class="block text-sm font-medium text-gray-700">
                                        Keywords
                                    </label>
                                    <div class="mt-1">
                                        <textarea :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null" v-model="manuscriptForm.keywords" id="keywords" name="keywords" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="" />
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Please enter keywords separated by semicolons. Each individual keyword may be up to 256 characters in length.
                                    </p>
                                    </div>

                                    <div>
                                    <!-- <label for="authors" class="block text-sm font-medium text-gray-700">
                                        Authors
                                    </label>
                                    <div class="mt-1">
                                        <textarea  v-model="manuscriptForm.authors" id="authors" name="authors" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="" />
                                    </div> -->
                                    <p class="mt-2 text-sm text-gray-500">
                                    </p>
                                    </div>

                                    <div>
                                    <label for="funding_information" class="block text-sm font-medium text-gray-700">
                                        Funding Information
                                    </label>
                                    <div class="mt-1">
                                        <textarea :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null" v-model="manuscriptForm.funding_information" id="funding_information" name="funding_information" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="" />
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">

                                    </p>
                                    </div>

                                    
                                </div>
                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <button :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null" type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
                    <div id="manuscript-attach-files">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Manuscript Attach Files</h3>
                                <span v-show="isReviewer()">
                                    You have been assigned to review this manuscript, please download the manuscript in the "Manuscript Attach Files" section.
                                </span>
                                <p v-show="isReviewer()" class="mt-1 text-sm text-gray-600">
                                    Please upload your reviewer comments in a new file name using Words Document file.  Please make sure that your comments can be clearly understood by the authors. You are given 30 working days for this cycle of reviewing process. Thank You
                                </p>
                                <p v-show="isAuthor()" class="mt-1 text-sm text-gray-600">
                                    When possible these fields will be populated with information collected from your uploaded submission file. Steps requiring review will be marked with a warning icon. Please review these fields to be sure we found the correct information and fill in any missing details.
                                </p>
                            </div>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <div class="bg-white shadow sm:rounded-lg">
                                    <div class="flex justify-between px-4 py-5 sm:px-6">
                                        <div class="">
                                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                                Attach Files
                                            </h3>
                                            <JetInputError :message="manuscriptForm.errors.status" class="mt-2" />
                                            <!-- <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                                Personal details and application.
                                            </p> -->
                                        </div>
                                        <div>
                                            <span class="sm:ml-3">
                                                <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"  @click="data.showUploadAttachModal = !data.showUploadAttachModal; ">
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
                                                <tr v-for="(attachment, index) in filterAttachments(attachments)" :key="attachment.id + '-attach'">
                                                    <td class="px-6 py-4 word-break">
                                                        {{ attachments.meta.from + index }}
                                                    </td>
                                                    <td class="px-6 py-4 word-break">
                                                        <p>
                                                            {{ attachment.type.name }} 
                                                            <Badge
                                                                v-show="attachment.unread_comment_notifications?.length > 0"
                                                                :text="attachment.unread_comment_notifications?.length"
                                                                :tooltip="`You have ${attachment.unread_comment_notifications?.length} unread comment(s).`">
                                                            </badge>
                                                            
                                                        </p>
                                                        <small class="text-gray-500">
                                                            {{ attachment.description }}
                                                        </small>
                                                    </td>
                                                    <td class="px-6 py-4 word-break">
                                                        {{ attachment.size}}
                                                    </td>
                                                    <td class="px-6 py-4 word-break">
                                                        {{ attachment.updated_at }}
                                                    </td>
                                                    <td class="px-6 py-4 word-break">
                                                        
                                                        <span class="text-indigo-600 hover:text-indigo-900 cursor-pointer px-1" @click="data.showUpdateAttachModel = !data.showUpdateAttachModel; fillUpdateAttachForm(attachment); markAsRead(attachment.unread_comment_notifications)">View</span>
                                                        <!--<a :href="`/admin/manuscripts/${manuscript.data.id}/attach-files/${attachment.id}/download`" class="text-indigo-600 hover:text-indigo-900 px-1">Download</a>-->
                                                        <span :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null" @click="cannotEditOnSubmit() ? `` : deleteAttachFile(attachment)" class="text-indigo-600 hover:text-indigo-900 cursor-pointer px-1">Delete</span>
                                                    </td>
                                                </tr>
                                                <tr v-if="attachments.length == 0">
                                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center">
                                                        No Data
                                                    </td>
                                                </tr>
                                            </template>
                                        </Table>
                                    </div>
                                </div>
                                <!-- <div class="my-2 flex justify-end">
                                    <Pagination :links="attachments.meta.links" :meta="attachments.meta" />
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div v-show="canViewAdditionalInformation()" class="hidden sm:block" aria-hidden="true">
                        <div class="py-5">
                            <div class="border-t border-gray-200" />
                        </div>
                    </div>
                    <div v-show="canViewAdditionalInformation()" class="mt-10 sm:mt-0">
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
                            <form @submit.prevent="saveManuscript()">
                                <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                        <fieldset>
                                        <legend class="text-base font-medium text-gray-900">Please confirm that you have mentioned all organizations that funded your research in the Acknowledgements section of your submission, including grant numbers where appropriate.</legend>
                                        <div class="mt-4 space-y-4">
                                            <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null" v-model="manuscriptForm.is_confirm_grant_numbers" id="is_confirm_grant_numbers" name="is_confirm_grant_numbers" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="is_confirm_grant_numbers" class="font-medium text-gray-700">I Confirm</label>
                                                <p class="text-gray-500">I confirm that I have mentioned all organizations that funded my research in the Acknowledgements section of my submission, including grant numbers where appropriate.</p>
                                            </div>
                                            </div>
                                        </div>
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
                                                <input :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null" v-model="manuscriptForm.is_acknowledge" id="is_acknowledge" name="is_acknowledge" type="checkbox"  class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="is_acknowledge" class="font-medium text-gray-700">I Acknowledge</label>
                                                <p class="text-gray-500">As an Author, I acknowledge I need to pay the Article Publishing Charge if my manuscript is accepted for publication</p>
                                            </div>
                                            </div>
                                        </div>
                                        </fieldset>
                                        <!-- <div class="hidden sm:block" aria-hidden="true">
                                            <div class="py-5">
                                                <div class="border-t border-gray-200" />
                                            </div>
                                        </div>
                                        <fieldset>
                                        <div>
                                            <legend class="text-base font-medium text-gray-900">
                                            In support of Open Science, Sensors and Actuators Reports offers its authors a free preprint posting service. Preprints provide early registration and dissemination of research, which facilitates early citations and collaboration. Please indicate below whether you would like to release your manuscript publicly as a preprint on the preprint server www.SSRN.com once it enters peer-review with the journal. Your choice will have no effect on the editorial process or outcome with the journal. Your preprint will remain globally available free to read whether the journal accepts or rejects your manuscript.data. For more information about posting to www.SSRN.com, please consult the SSRN Terms of Use and FAQs.</legend>
                                        </div>
                                        <div class="mt-4 space-y-4">
                                            <div class="flex items-center">
                                            <input id="push-everything" name="push-notifications" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                            <label for="push-everything" class="ml-3 block text-sm font-medium text-gray-700">
                                                Please select a response
                                            </label>
                                            </div>
                                            <div class="flex items-center">
                                            <input id="push-email" name="push-notifications" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                            <label for="push-email" class="ml-3 block text-sm font-medium text-gray-700">
                                                YES, I want to share my research early and openly as a preprint.
                                            </label>
                                            </div>
                                            <div class="flex items-center">
                                            <input id="push-nothing" name="push-notifications" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                            <label for="push-nothing" class="ml-3 block text-sm font-medium text-gray-700">
                                                NO, I don't want to share my research early and openly as a preprint.
                                            </label>
                                            </div>
                                        </div>
                                        </fieldset> -->
                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <button :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null" type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Comments</h3>
                                <p class="mt-1 text-sm text-gray-600">
                                Please identify your submission's areas of interest and specialization by selecting one or more classifications.
                                </p>
                            </div>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                            <form @submit.prevent="saveManuscript()">
                                <div class="shadow overflow-hidden sm:rounded-md">
                                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                        <div class="grid gap-6">
                                            <CommentSectionCard
                                                :manuscript-id="manuscript.data.id"
                                                :auth="auth"
                                                :from="data.viewAs"></CommentSectionCard>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                    <Modal :show="data.showAddUserModal" @close="data.showAddUserModal = false;">
                        <template v-slot:default>
                            <div class="mt-2">
                                <div>
                                    <div class="md:grid md:grid-cols-3 md:gap-6">
                                    <div class="md:col-span-1">
                                        <div class="px-4 sm:px-0">
                                        <h3 class="text-lg font-medium leading-6 text-gray-900">Add New User</h3>
                                        </div>
                                    </div>
                                    <div class="mt-5 md:mt-0 md:col-span-2">
                                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                                <div class="col-span-12 sm:col-span-12">
                                                    <label for="first-name" class="block text-sm font-medium text-gray-700">First Name</label>
                                                    <input v-model="userForm.first_name" type="text" name="first-name" id="first-name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                                </div>
                                                <div class="col-span-12 sm:col-span-12">
                                                    <label for="last-name" class="block text-sm font-medium text-gray-700">Last Name</label>
                                                    <input v-model="userForm.last_name" type="text" name="last-name" id="last-name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                                </div>
                                                <div class="col-span-12 sm:col-span-12">
                                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                                    <input v-model="userForm.email" type="text" name="email" id="email" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template v-slot:footer>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <span @click="submitUserForm()" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer">Add</span>
                            </div>
                        </template>
                    </Modal>
                </div>
                <div v-else>
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Unable to access manuscript.</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">To access the content, you must be a member of this manuscript and have received an invitation. Without membership, you will not be able to view the content.</p>
                            </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </template>
        </Layout>
    </div>
</template>
<script setup>
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
    import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions, Menu, MenuButton, MenuItem, MenuItems, DialogTitle } from '@headlessui/vue'
    import { useForm, Link } from '@inertiajs/inertia-vue3'
    import CommentSectionCard from '../../Components/CommentSectionCard.vue'
    import { SelectorIcon } from '@heroicons/vue/solid'
    import Pagination from '../../Components/Pagination.vue'
    import JetInputError from '../../Components/InputError.vue';
    import { onMounted, reactive, defineProps, getCurrentInstance } from 'vue'
    import Badge from '../../Components/Badge.vue'
    import FileInput from '../../Components/FileInput.vue'

    const props = defineProps({
        manuscript: Object,
        attachments: Object,
        filters: Object,
        attachTypes: Array,
        articleTypes: Array,
        errors: Object,
        message: String,
        auth: Object,
        manuscriptStatusList: Array,
        manuscriptStatus: Array,
        roleAndPermissions: Array,
        app: Object
    });

    const vm = getCurrentInstance();

    const data = reactive({
        showAddUserModal: false,
        showAddUserModalDataIncludeIntoInput: 'corresponding_authors',
        viewAsList: [],
        viewAs: null,
        attach_files: [],
        showUploadAttachModal: false,
        showUpdateAttachModel: false,
        showPublishModal: false,
        showAcceptModal: false,
        showRejectModal: false,
        showSubmitReviewModal: false,
        showSubmitToEditorModal: false,
        showThanksModal: false,
        showAddReviewerModal: false,
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
    });

    const moment = require('moment');
    const helper = require('../../helper.js');

    const hasManuscriptToPublish = () => {
        return props.attachments?.data?.filter(v => v.for_publish)?.length > 0 ? true : false;
    }

    const manuscriptForm = useForm({
        type: props.manuscript.data.type.id,
        category: "",
        title: props.manuscript.data.title,
        short_title: props.manuscript.data.short_title,
        abstract: props.manuscript.data.abstract,
        keywords: props.manuscript.data.keywords,
        authors: props.manuscript.data.authors.map(v => v?.user),
        corresponding_authors: props.manuscript.data.corresponding_authors.map(v => v?.user),
        editors: props.manuscript.data.editors?.map(v => v?.user),
        reviewers: props.manuscript.data.reviewers?.map(v => v),
        funding_information: props.manuscript.data.funding_information,
        is_confirm_grant_numbers: props.manuscript.data.is_confirm_grant_numbers,
        is_acknowledge: props.manuscript.data.is_acknowledge
    });

    const attachForm = useForm({
        id: null,
        file: null,
        selected_file: null,
        type: "",
        description: null
    });

    const updateAttachForm = useForm({
        _method: 'post',
        id: null,
        file: null,
        type: "",
        description: null
    });

    const userForm = useForm({
        first_name: null,
        last_name: null,
        email: null,
        password: helper.generateString(8),
        password_confirmation: null
    });

    const isDraft = () => {
        return props.manuscript?.data?.status == "Draft";
    }

    const isSubmitForReview = () => {
        return props.manuscript?.data?.status == "Submit For Review";
    }

    const isSubmitToEditor = () => {
        return props.manuscript?.data?.status == "Submit To Editor";
    }

    const isRejected = () => {
        return [
            'Rejected',
            'Rejected Invite To Resubmit'
        ].includes(props.manuscript?.data.status);
    }

    const isAccepted = () => {
        return [
            'Accepted Without Changes',
            'Accepted With Minor Changes',
            'Accepted With Major Changes'
        ].includes(props.manuscript?.data.status);
    }

    const isRejectedToResubmit = () => {
        return props.manuscript?.data.status == "Rejected Invite To Resubmit";
    }

    const isPublished = () => {
        return props.manuscript?.data.status == "Published";
    }

    const fillUpdateAttachForm = (attach) => {
        updateAttachForm.id = attach.id;
        updateAttachForm.file = null;
        updateAttachForm.type = attach.type.id;
        updateAttachForm.description = attach.description;
        updateAttachForm.file_name = attach.file_name;
    }

    const clearUpdateAttachForm = () => {
        updateAttachForm.id = null;
        updateAttachForm.file = null;
        updateAttachForm.type = "";
        updateAttachForm.description = null;
        updateAttachForm.file_name = null;
    }

    const clearAttachForm = () => {
        attachForm.id = null;
        attachForm.file = null;
        attachForm.type = "";
        attachForm.description = null;
    }

    const deleteAttachFile = (attach) => {
        const deleteAttachForm = useForm({
            _method: 'delete'
        });
        if (confirm('Are you sure to delete "' + attach.type.name + '"?')) {
            deleteAttachForm.post(`/admin/manuscripts/${props.manuscript.data.id}/attach-files/${attach.id}`, {
                preserveScroll: true,
            });
        }
    }

    const submitUserForm = async () => {
        await window.axios.post('/api/users', {
            first_name: userForm.first_name,
            last_name: userForm.last_name,
            email: userForm.email,
            password: userForm.password,
            password_confirmation: userForm.password
        })
            .then((res) => {
                if (res.status >= 200 && res.status < 300) {
                    let user = res.data;
                    notification('User added', 'success');
                    if (data.showAddUserModalDataIncludeIntoInput == 'authors') {
                        manuscriptForm.authors.push(user);
                    } else if(data.showAddUserModalDataIncludeIntoInput == 'corresponding_authors') {
                        manuscriptForm.corresponding_authors.push(user);
                    } else if (data.showAddUserModalDataIncludeIntoInput == 'editors') {
                        manuscriptForm.editors.push(user);
                    } else {
                        manuscriptForm.reviewers.push(user);
                    }
                    data.showAddUserModal = false;
                    userForm.email = null;
                }
            })
            .catch((err) => {
                if (err.response) {
                    let errors = err.response.errors;
                    Object.keys(errors).forEach((value, index) => {
                        notification(errors[value][0], 'error');
                    });
                } else {
                    notification(err.message, 'error');
                }
                
            });
        
    };

    const manuscriptStatusForm = useForm({
        'status': null
    });

    const updateManuscriptStatus = () => {
        manuscriptStatusForm.post(`/admin/manuscripts/${props.manuscript.data.id}/update-status`, {
            preserveScroll: true,
            onError: (errors) => {
                Object.keys(errors).forEach((value, index) => {
                    notification(errors[value], 'error');
                });
            },
            onSuccess: (res) => {

            }
        });
    }

    const createNewAuthorModal = (newUser) => {
        assignNewUserIntoUserFormInputs(newUser);
        data.showAddUserModal = true;
        data.showAddUserModalDataIncludeIntoInput = 'authors';
    };

    const createNewCoAuthorModal = (newUser) => {
        assignNewUserIntoUserFormInputs(newUser);
        data.showAddUserModal = true;
        data.showAddUserModalDataIncludeIntoInput = 'corresponding_authors';
    };

    const createNewEditorModal = (newUser) => {
        assignNewUserIntoUserFormInputs(newUser);
        data.showAddUserModal = true;
        data.showAddUserModalDataIncludeIntoInput = 'editors';
    }

    const createNewReviewerModal = (newUser) => {
        assignNewUserIntoUserFormInputs(newUser);
        data.showAddUserModal = true;
        data.showAddUserModalDataIncludeIntoInput = 'reviewers';
    };

    const assignNewUserIntoUserFormInputs = (newUser) => {
        const parts = newUser.split(' ');

        const tag = {
            id: 0,
            last_name: parts.pop(),
            first_name: parts.pop()
        };

        userForm.first_name = tag['first_name'];
        userForm.last_name = tag['last_name'];
    };

    const notification = (message, type = 'success', duration = 5000) => {
        vm.appContext.provides.$toast.open({
            message: message,
            type: type,
            duration: duration,
            dismissible: true
        }) 
    };

    const saveManuscript = () => {
        manuscriptForm.post(`/admin/manuscripts/${props.manuscript.data.id}/update`, {
            preserveScroll: true,
            onError: (errors) => {
                Object.keys(errors).forEach((value, index) => {
                    notification(errors[value], 'error');
                });
            },
            onSuccess: (res) => {
                notification('Saved.', 'success');
            }
        });
    };

    const onChangeSubmitAttachFile = (file) => {
        // attachForm.file = e.target.files[0];
        attachForm.file = file;
    };

    const onChangeUpdateAttachFile = (file) => {
        updateAttachForm.file = file;
    }

    const submitAttach = () => {
        attachForm.post(`/admin/manuscripts/${props.manuscript.data.id}/attach-files`, {
            preserveScroll: true,
            onError: (errors) => {
                Object.keys(errors).forEach((value, index) => {
                    notification(errors[value], 'error');
                });
            },
            onSuccess: () => {
                notification('Saved', 'success');
                data.showUploadAttachModal = false;
                clearAttachForm();
            }
        });
    };

    const updateAttach = () => {
        updateAttachForm.post(`/admin/manuscripts/${props.manuscript.data.id}/attach-files/${updateAttachForm.id}/update`, {
            preserveScroll: true,
            onError: (errors) => {
                Object.keys(errors).forEach((value, index) => {
                    notification(errors[value], 'error');
                });
            },
            onSuccess: () => {
                notification('Saved', 'success');
                data.showUpdateAttachModel = false;
            }
        });
    };

    const submitForReview = () => {
        manuscriptStatusForm.status = "Submit For Review";
        updateManuscriptStatus();
        data.showSubmitReviewModal = false;
    };

    const submitToEditor = () => {
        manuscriptStatusForm.status = "Submit To Editor";
        updateManuscriptStatus();
        data.showSubmitToEditorModal = false;
    };

    const acceptWithoutChanges = async () => {
        manuscriptStatusForm.status = "Accepted Without Changes";
        updateManuscriptStatus();
        data.showAcceptModal = false;
        await new Promise(r => setTimeout(r, 1000));
        data.showThanksModal = true;
    };

    const acceptWithMinorChanges = async () => {
        manuscriptStatusForm.status = "Accepted With Minor Changes";
        updateManuscriptStatus();
        data.showAcceptModal = false;
        await new Promise(r => setTimeout(r, 1000));
        data.showThanksModal = true;
    };

    const acceptWithMajorChanges = async () => {
        manuscriptStatusForm.status = "Accepted With Major Changes";
        updateManuscriptStatus();
        data.showAcceptModal = false;
        await new Promise(r => setTimeout(r, 1000));
        data.showThanksModal = true;
    };

    const rejectInviteToResubmit = async () => {
        manuscriptStatusForm.status = "Rejected Invite To Resubmit";
        updateManuscriptStatus();
        data.showRejectModal = false;
        await new Promise(r => setTimeout(r, 1000));
        data.showThanksModal = true;
    };

    const reject = async () => {
        manuscriptStatusForm.status = "Rejected";
        updateManuscriptStatus();
        data.showRejectModal = false;
        await new Promise(r => setTimeout(r, 1000));
        data.showThanksModal = true;
    };

    const publishManuscript = () => {
        manuscriptStatusForm.status = "Published";
        updateManuscriptStatus();
        data.showPublishModal = false;
    };

    const asyncFindEditors = _.debounce(async (query) => {
        data.editorSelect.isLoading = true;
        let resp = await window.axios.get('/api/users', {
            params: {
                search: query,
                role: 'Editor',
            }
        });
        data.editorSelect.isLoading = false;
        if (resp.status == 200) {
            data.editorSelect.options = resp.data;
            return 0;
        }
        data.editorSelect.options = [];
        return 0;
    }, 300);

    const asyncFindReviewers = _.debounce(async (query) => {
        data.reviewerSelect.isLoading = true;
        let resp = await window.axios.get('/api/users', {
            params: {
                search: query,
                role: 'Reviewer',
            }
        });
        data.reviewerSelect.isLoading = false;
        if (resp.status == 200) {
            data.reviewerSelect.options = resp.data;
            return 0;
        }
        data.reviewerSelect.options = [];
        return 0;
    }, 300);

    const asyncFindAuthors = _.debounce(async (query) => {
        data.authorSelect.isLoading = true;
        let resp = await window.axios.get('/api/users', {
            params: {
                search: query,
                role: 'Author',
            }
        });
        data.authorSelect.isLoading = false;
        if (resp.status == 200) {
            data.authorSelect.options = resp.data;
            return 0;
        }
        data.authorSelect.options = [];
        return 0;
    }, 300);

    const asyncFindCorrespondingAuthors = _.debounce(async (query) => {
        data.correspondingAuthorSelect.isLoading = true;
        let resp = await window.axios.get('/api/users', {
            params: {
                search: query,
                role: 'Author',
            }
        });
        data.correspondingAuthorSelect.isLoading = false;
        if (resp.status == 200) {
            data.correspondingAuthorSelect.options = resp.data;
            return 0;
        }
        data.correspondingAuthorSelect.options = [];
        return 0;
    }, 300);

    const getAuthID = () => {
        return props.auth.user.data.id;
    }

    const authIsAuthor = () => {
        
        let manuscriptAuthors = props.manuscript.data.authors;
        // Filter auth roles
        let result = manuscriptAuthors.filter(function(member) {
            if (member.user_id == getAuthID()) {
                return true;
            }
            return false;
        });
        return result.length > 0;
    };

    const authIsCorrespondingAuthor = () => {
        let manuscriptAuthors = props.manuscript.data.corresponding_authors;
        // Filter auth roles
        let result = manuscriptAuthors.filter(function(member) {
            if (member.user_id == getAuthID()) {
                return true;
            }
            return false;
        });
        return result.length > 0;
    };

    const authIsEditor = () => {
        let manuscriptEditors = props.manuscript.data.editors;
        // Filter auth roles
        let result = manuscriptEditors.filter(function(member) {
            if (member.user_id == getAuthID()) {
                return true;
            }
            return false;
        });
        return result.length > 0;
    };

    const authIsReviewer = () => {
        let manuscriptReviewers = props.manuscript.data.reviewers;
        // Filter auth roles
        let result = manuscriptReviewers.filter(function(member) {
            if (member.user_id == getAuthID()) {
                return true;
            }
            return false;
        });
        return result.length > 0;
    };

    const authIsPublisher = () => {
        let authRoles = props.auth.user.data.roles;
        // Filter auth roles
        let result = authRoles.filter(function(role) {
            if (role.name == 'Super Admin' || role.name == 'Admin' || role.name == 'Publisher') {
                return true;
            }
            return false;
        });
        return result.length > 0;
    };

    const canReview = () => {
        // let total = this.manuscript.data.reviewers.filter((v) => (v.user_id == this. props.auth.user.id && (v.reviewed == null || v.reviewedVote == `Rejected Invite To Resubmit` || v.reviewedVote == `Rejected`)));
        let total = props.manuscript.data.reviewers.filter((v) => (v.user_id == props.auth.user.data.id && (v.reviewed == null)));
        return total.length > 0;
    };

    const setRoleView = () => {
        data.viewAsList = [];
        if (authIsAuthor()) {
            data.viewAsList.push('author');
        }
        if (authIsCorrespondingAuthor()) {
            data.viewAsList.push('corresponding author');
        }
        if (authIsEditor()) {
            data.viewAsList.push('editor');
        }
        if (authIsReviewer()) {
            data.viewAsList.push('reviewer');
        }
        if (authIsPublisher()) {
            data.viewAsList.push('publisher');
        }
        if (data.viewAsList.length > 0) {
            data.viewAs = data.viewAsList[0];
        } else {
            data.viewAsList.push('unassigned role');
            data.viewAs = data.viewAsList[0];
        }
    };

    const cannotEditOnSubmit = () => {
        return props.auth.user.data.permissions_attribute.manuscripts.edit_after_submit == false && (isSubmitToEditor() || isSubmitForReview() || props.manuscript.data.status == `Rejected` || props.manuscript.data.status == `Accepted Without Changes` || isPublished());
    }

    const onRemoveReviewer = (reviewer) => {
        if (confirm(`Are you sure to remove "${reviewer?.user?.first_name} ${reviewer?.user?.last_name}"?`)) {
            const deleteReviewerForm = useForm({
                _method: 'POST'
            });
            deleteReviewerForm.post(`/admin/manuscripts/${props.manuscript.data.id}/members/${reviewer.id}/destroy`,{
                preserveScroll: true,
                onSuccess: () => {
                    manuscriptForm.reviewers = props.manuscript.data.reviewers;
                }
            });
        }
    }

    const onAddReviewer = () => {
        data.showAddReviewerModal = true;
    }

    const reviewerForm = useForm({
        _method: 'POST',
        members: [],
        role: 'reviewer',
        status: 'Pending',
    });

    const submitAddReviewer = () => {
        reviewerForm.post(`/admin/manuscripts/${props.manuscript.data.id}/member-create`, {
            preserveScroll: true,
            onSuccess: () => {
                manuscriptForm.reviewers = props.manuscript.data.reviewers;
                reviewerForm.members = [];
            }
        });
    }

    const onAcceptReviewer = (member_id) => {
        const form = useForm({
            _method: 'POST',
            status: 'Accepted',
            role: 'reviewer'
        });
        form.post(`/admin/manuscripts/${props.manuscript.data.id}/members/${member_id}/update`, {
            preserveScroll: true,
            onError: (errors) => {
                Object.keys(errors).forEach((value, index) => {
                    notification(errors[value], 'error');
                });
            },
            onSuccess: (res) => {
                notification('Saved.', 'success');
                manuscriptForm.reviewers = props.manuscript.data.reviewers;
            }
        });
    }

    const onRejectReviewer = (member_id) => {
        const form = useForm({
            _method: 'POST',
            status: 'Rejected',
            role: 'reviewer'
        });
        form.post(`/admin/manuscripts/${props.manuscript.data.id}/members/${member_id}/update`, {
            preserveScroll: true,
            onError: (errors) => {
                Object.keys(errors).forEach((value, index) => {
                    notification(errors[value], 'error');
                });
            },
            onSuccess: (res) => {
                notification('Saved.', 'success');
                manuscriptForm.reviewers = props.manuscript.data.reviewers;
            }
        });
    }

    const getRoleBgColor = () => {
        return (data.viewAs == 'author' || data.viewAs == 'corresponding author') ? 'bg-indigo-500' : (data.viewAs == 'editor' ? 'bg-yellow-700' : (data.viewAs == 'reviewer' ? 'bg-orange-500' : (data.viewAs == 'publisher' ? 'bg-red-500' : 'bg-gray-500')));
    }

    const canSubmitToEditor = () => {
        return (isDraft()) && (data.viewAs == `author` || data.viewAs == `corresponding author` || data.viewAs == `publisher`);
    }

    const canViewAdditionalInformation = () => {
        return data.viewAs == `author` || data.viewAs == `corresponding author`;
    }

    const filterAttachments = (attachments) => {
        // Filter attachments according to current view as permission.
        return attachments.data.filter(
            function(attach) {
                if(data.viewAs == `reviewer` && (attach.type.id == 1 || attach.type.id == 2)) {
                    return true;
                }
                if (data.viewAs != 'reviewer') {
                    return true;
                }
                return false;
            }
        );
    }

    const filterAttachTypes = (attachTypes) => {
        return attachTypes.filter(
            function(type) {
                if (data.viewAs == 'reviewer') {
                    if (type.id == 1 || type.id == 2) {
                        return true;
                    }
                    return false;
                }
                return true;
            }
        );
    }

    const isReviewer = () => {
        return data.viewAs == `reviewer`;
    }

    const isAuthor = () => {
        return data.viewAs == `author` || data.viewAs == `corresponding author`;
    }

    const isEditor = () => {
        return data.viewAs == `editor`;
    }

    const isPublisher = () => {
        return data.viewAs == `publisher`;
    }

    const isAssigned = () => {
        return isAuthor() || isEditor() || isPublisher();
    }

    const getAuthReviewer = () => {
        return props.manuscript.data.reviewers.filter(v => v.user_id == getAuthID())?.[0];
    }

    const isReviewerPending = () => {
        let reviewer = getAuthReviewer();
        return isReviewer() && (reviewer.status == 'Pending' || reviewer.status == 'Accepted');
    }

    const canViewManuscriptData = () => {
        return isAuthor() || isEditor() || isPublisher();
    }

    const canViewReviewerStatus = () => {
        return isEditor() || isPublisher();
    }

    const canRemoveReviewer = () => {
        return !(isReviewer());
    }

    const canEditReviewerReviewStatus = (reviewer) => {
        return reviewer.status == 'Pending' && (isEditor() || isPublisher());
    }

    const canSuggestReviewer = () => {
        return !(isReviewer());
    }

    const canPublish = () => {
        return props.manuscript.data.status != 'Published' && (data.viewAs == `publisher`);
    }

    const markAsRead = async (notifications) => {
        if (notifications.length == 0) {
            return 0;
        }
        await window.axios.put('/api/notifications/mark-as-read', {
            ids: notifications?.map(v => v.id),
        })
            .then((res) => {
                if (res.status >= 200 && res.status < 300) {
                    
                }
            })
            .catch((err) => {
            });
    }

    const displayErrors = () => {
        if (props.errors?.status != null) {
            notification(props.errors.status, 'error');
        }
        
    }

    onMounted(() => {
        setRoleView();
        asyncFindEditors()
        asyncFindReviewers()
        asyncFindAuthors()
        asyncFindCorrespondingAuthors()
        displayErrors()
    });

</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>