<template>
    <div>
        <!-- <Toast v-show="errors != null"/> -->
        <Layout :auth="auth.user.data">
            <template v-slot:header>
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
                                {{ manuscript.data.status }}
                            </div>
                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                <CalendarIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                                {{ manuscript.data.created_at_date }}
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 flex lg:mt-0 lg:ml-4">

                        <span class="sm:ml-3" v-if="(manuscript.data.status == `Draft`) && (viewAs == `author` || viewAs == `corresponding author`)">
                            <a href="#" @click="showSubmitToEditorModal = true" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                <DocumentSearchIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                                Submit To Editor
                            </a>
                        </span>
                        <span class="sm:ml-3" v-if="(manuscript.data.status == `Rejected Invite To Resubmit` || manuscript.data.status == `Submit To Editor`) && (viewAs == `editor`)">
                            <a href="#" @click="showSubmitReviewModal = true" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                <DocumentSearchIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                                Submit For Review
                            </a>
                        </span>
                        <span class="sm:ml-3" v-if="manuscript.data.status == `Submit For Review` && (viewAs == `reviewer`) && canReview()">
                            <a href="#" @click="showRejectModal = true" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <XCircleIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                                Reject
                            </a>
                        </span>
                        <span class="sm:ml-3" v-if="manuscript.data.status == `Submit For Review` && (viewAs == `reviewer`) && canReview()">
                            <a href="#" @click="showAcceptModal = true" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <CheckCircleIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                                Accept
                            </a>
                        </span>
                        <span class="sm:ml-3" v-if="manuscript.data.status.includes('Accept') && (viewAs == `publisher`)">
                            <a href="#" @click="showPublishModal = true" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <PaperAirplaneIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                                Publish
                            </a>
                        </span>
                        <span class="sm:ml-3" v-if="manuscript.data.status == `Published`">
                            <a :href="`/admin/manuscripts/${manuscript.data.id}/download`" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" target="_blank">
                                <DownloadIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                                Build PDF
                            </a>
                        </span>

                        <!-- Dropdown -->
                        <!-- <Menu as="span" class="ml-3 relative sm:hidden">
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
                        </Menu> -->
                    </div>
                </div>
                <hr class="my-4">
                <div class="flex mt-1">
                    <!-- This example requires Tailwind CSS v2.0+ -->
                    <Listbox as="div" v-model="viewAs" class="w-64">
                        <ListboxLabel class="block text-sm font-medium text-gray-700">View As</ListboxLabel>
                        <div class="mt-1 relative">
                        <ListboxButton class="relative w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <span class="flex items-center">
                            <!-- <img :src="selected.avatar" alt="" class="flex-shrink-0 h-6 w-6 rounded-full" /> -->
                            <svg class="h-4 w-4 rounded-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span class="ml-3 block truncate capitalize">{{ viewAs }}</span>
                            </span>
                            <span class="ml-3 absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                            <SelectorIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                            </span>
                        </ListboxButton>

                        <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                            <ListboxOptions class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-56 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                            <ListboxOption as="template" v-for="person in viewAsList" :key="person" :value="person" v-slot="{ active, viewAs }">
                                <li :class="[active ? 'text-white bg-indigo-600' : 'text-gray-900', 'cursor-default select-none relative py-2 pl-3 pr-9']">
                                <div class="flex items-center">
                                    <!-- <img :src="person.avatar" alt="" class="flex-shrink-0 h-6 w-6 rounded-full" /> -->
                                    <svg class="h-4 w-4 rounded-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <span :class="[viewAs ? 'font-semibold' : 'font-normal', 'ml-3 block truncate']" class="capitalize">
                                    {{ person }}
                                    </span>
                                </div>

                                <span v-if="viewAs" :class="[active ? 'text-white' : 'text-indigo-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                                    <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                </span>
                                </li>
                            </ListboxOption>
                            </ListboxOptions>
                        </transition>
                        </div>
                    </Listbox>
                    <!-- <span class="flex-none pr-1" v-show="authIsAuthor()">
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
                    </span> -->
                </div>
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
                                                <select :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="www.example.com" v-model="attachForm.type">
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
                                                <textarea :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null" v-model="attachForm.description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="" />
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
                                                        <span :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null">Upload a file</span>
                                                        <input :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null" id="file-upload" ref="file"  @change="onChangeSubmitAttachFile" type="file" class="sr-only" />
                                                        <progress v-if="attachForm.progress" :value="attachForm.progress.percentage" max="100">
                                                        {{ attachForm.progress.percentage }}%
                                                        </progress>
                                                        </label>
                                                        <p class="pl-1">or drag and drop</p>
                                                    </div>
                                                    <p class="text-xs text-gray-500">
                                                        DOC, DOCX up to 50MB
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
                        <span :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer" @click="cannotEditOnSubmit() ? `` : submitAttach()">
                            Upload
                        </span>
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
                                                <select :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="www.example.com" v-model="updateAttachForm.type">
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
                                                        <span :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null">Upload a file</span>
                                                        <input :disabled="cannotEditOnSubmit()" id="update-file-upload" ref="file-update"  @change="onChangeUpdateAttachFile" type="file" class="sr-only" />
                                                        <progress v-if="updateAttachForm.progress" :value="updateAttachForm.progress.percentage" max="100">
                                                        {{ updateAttachForm.progress.percentage }}%
                                                        </progress>
                                                        </label>
                                                        <p class="pl-1">or drag and drop</p>
                                                    </div>
                                                    <p class="text-xs text-gray-500">
                                                        DOC, DOCX up to 50MB
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
                        <span :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer" @click="cannotEditOnSubmit() ? `` : updateAttach()">
                            Update
                        </span>
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="showUpdateAttachModel = false; clearUpdateAttachForm()" ref="cancelButtonRef">
                            Cancel
                        </button>
                    </template>
                </Modal>
                <Modal :show="showSubmitToEditorModal" @close="showSubmitToEditorModal = false;">
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
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="showSubmitToEditorModal = false">
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
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="showRejectModal = false">
                            Cancel
                        </button>
                    </template>
                </Modal>
                <Modal :show="showPublishModal" @close="showPublishModal = false;">
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
                    </template>
                    <template v-slot:footer>
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="showPublishModal = false">
                            Cancel
                        </button>
                    </template>
                </Modal>
                <div v-if="viewAs == `author` || viewAs == `corresponding author` || viewAs == `editor` || viewAs == `publisher`" class="mt-10 sm:mt-0">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">General Information</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                <span v-show="viewAs == `author` || viewAs == `corresponding author`">
                                    Please identify your submission's areas of interest and specialization by selecting one or more classifications.
                                </span>
                                <!--<span v-show="authIsReviewer()">
                                    You have been assigned to review this manuscript, please download the manuscript in the "Manuscript Attach Files" section below.
                                </span>-->
                                <span v-show="viewAs == `editor`">
                                    You have been assigned as an Editor. Please select reviewers and notify the reviewers to review manuscripts. Thank you
                                </span>
                                <span v-show="viewAs == `publisher`">
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
                                    <!-- <div class="col-span-3 sm:col-span-2">
                                        <label for="company-website" class="block text-sm font-medium text-gray-700">
                                        Manuscript Status
                                        </label>
                                        <select name="company-website" id="company-website" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="www.example.com" v-model="manuscriptForm.status">
                                            <option value="" selected>Select</option>
                                            <option v-for="status in manuscriptStatusList" :key="`status-${status.name}`">{{ status.name }}</option>
                                        </select>
                                    </div> -->
                                    <div class="col-span-3 sm:col-span-2">
                                        <label for="company-website" class="block text-sm font-medium text-gray-700">
                                        Article Type
                                        </label>
                                        <select :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null" name="company-website" id="company-website" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="www.example.com" v-model="manuscriptForm.type">
                                            <option value="" selected>Select</option>
                                            <option v-for="type in articleTypes" :key="type.id" :value="type.id">{{ type.name }}</option>
                                        </select>
                                    </div>
                                    <div class="col-span-3 sm:col-span-2">
                                        <label for="company-website" class="block text-sm font-medium text-gray-700">
                                        Co-Author(s)
                                        </label>
                                        <VueMultiselect 
                                        :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null"
                                        v-model="manuscriptForm.corresponding_authors_obj" id="ajax" label="first_name" :custom-label="(value) => `${value.first_name} ${value.last_name || ``} ${value.field == null ? `` : `- ${value.field}`} ${value.affiliation == null ? `` : `- ${value.affiliation}`}`" track-by="id" placeholder="Type to search" open-direction="bottom" :options="correspondingAuthorSelect.options" :multiple="true" :searchable="true" :loading="correspondingAuthorSelect.isLoading" :internal-search="false" :clear-on-select="false" :close-on-select="false" :options-limit="300" :max-height="600" :show-no-results="false" :hide-selected="true" @search-change="asyncFindCorrespondingAuthors">
                                            </VueMultiselect>
                                    </div>
                                    <div class="col-span-3 sm:col-span-2">
                                        <label for="company-website" class="block text-sm font-medium text-gray-700">
                                        Author(s)
                                        </label>
                                        <VueMultiselect :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null"
                                        v-model="manuscriptForm.authors_obj" id="ajax" label="first_name" :custom-label="(value) => `${value.first_name} ${value.last_name || ``} ${value.field == null ? `` : `- ${value.field}`} ${value.affiliation == null ? `` : `- ${value.affiliation}`}`" track-by="id" placeholder="Type to search" open-direction="bottom" :options="authorSelect.options" :multiple="true" :searchable="true" :loading="authorSelect.isLoading" :internal-search="false" :clear-on-select="false" :close-on-select="false" :options-limit="300" :max-height="600" :show-no-results="false" :hide-selected="true" @search-change="asyncFindAuthors">
                                            </VueMultiselect>
                                    </div>
                                    <div v-show="viewAs == `author` || viewAs == `corresponding author` || viewAs == `editor` || viewAs == `publisher`" class="col-span-3 sm:col-span-2">
                                        <div class="col-span-3 sm:col-span-2">
                                            <label for="company-website" class="block text-sm font-medium text-gray-700">
                                            Request Editor(s)
                                            </label>
                                            <VueMultiselect :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null"
                                            v-model="manuscriptForm.editors_obj" id="ajax" label="first_name" :custom-label="(value) => `${value.first_name} ${value.last_name || ``} ${value.field == null ? `` : `- ${value.field}`} ${value.affiliation == null ? `` : `- ${value.affiliation}`}`" track-by="id" placeholder="Type to search" open-direction="bottom" :options="editorSelect.options" :multiple="false" :searchable="true" :loading="editorSelect.isLoading" :internal-search="false" :clear-on-select="false" :close-on-select="false" :options-limit="300" :max-height="600" :show-no-results="false" :hide-selected="true" @search-change="asyncFindEditors">
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
                <div v-if="viewAs == `author` || viewAs == `corresponding author` || viewAs == `editor` || viewAs == `publisher`" class="hidden sm:block" aria-hidden="true">
                    <div class="py-5">
                        <div class="border-t border-gray-200" />
                    </div>
                </div>  
                <div>
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Review Preferences</h3>
                                <p v-show="viewAs == `reviewer`" class="mt-1 text-sm text-gray-600">
                                    In view of your work in the field, your name has been recommended, as a reviewer. Please suggest other reviewer's name if you are unable to review this manuscript. Thank You
                                </p>
                                <p v-show="viewAs == `author` || viewAs == `corresponding author`" class="mt-1 text-sm text-gray-600">
                                Please name specific reviewers to be assigned to your submission. The request will be taken under advisement by the Editor. If you do not request any reviewers, your submission will be assigned to the appropriate reviewer(s) as determined by the Editorial staff.
                                </p>
                                <p v-show="viewAs == `editor` || viewAs == `publisher`" class="mt-1 text-sm text-gray-600">
                                The reviewer(s) are to be assigned to the manuscript.
                                </p>
                            </div>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <form @submit.prevent="saveManuscript()" >
                                <div class="shadow sm:rounded-md">
                                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                    <div class="grid grid-cols-3 gap-6">
                                        <div class="col-span-3 sm:col-span-2">
                                            <label for="company-website" class="block text-sm font-medium text-gray-700">
                                            Suggest Reviewer(s)
                                            </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                            <VueMultiselect :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null"
                                            v-model="manuscriptForm.reviewers_obj" id="ajax" label="first_name" :custom-label="(value) => `${value.first_name} ${value.last_name || ``} ${value.field == null ? `` : `- ${value.field}`} ${value.affiliation == null ? `` : `- ${value.affiliation}`}`" track-by="id" placeholder="Type to search" open-direction="bottom" :options="reviewerSelect.options" :multiple="true" :searchable="true" :loading="reviewerSelect.isLoading" :internal-search="false" :clear-on-select="false" :close-on-select="false" :options-limit="300" :max-height="600" :show-no-results="false" :hide-selected="true" @search-change="asyncFindReviewers">
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
                <div v-show="viewAs == `editor` || viewAs == `publisher`" class="hidden sm:block" aria-hidden="true">
                    <div class="py-5">
                        <div class="border-t border-gray-200" />
                    </div>
                </div>  
                <div v-show="viewAs == `editor` || viewAs == `publisher`">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Reviewers Status</h3>
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
                                            <tr v-for="reviewer in $props.manuscript.data.reviewers" :key="reviewer.id">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $props.manuscript.data.reviewers_in_users.filter((v) => v.id == reviewer.user_id)[0]['first_name'] }} {{ $props.manuscript.data.reviewers_in_users.filter((v) => v.id == reviewer.user_id)[0]['last_name'] }}
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
                <div v-show="viewAs == `author` || viewAs == `corresponding author` || viewAs == `editor` || viewAs == `publisher`" class="hidden sm:block" aria-hidden="true">
                    <div class="py-5">
                        <div class="border-t border-gray-200" />
                    </div>
                </div>
                <div v-show="viewAs == `author` || viewAs == `corresponding author` || viewAs == `editor` || viewAs == `publisher`">
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
                <div>
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Manuscript Attach Files</h3>
                            <span v-show="viewAs == `reviewer`">
                                You have been assigned to review this manuscript, please download the manuscript in the "Manuscript Attach Files" section.
                            </span>
                            <p v-show="viewAs == `reviewer`" class="mt-1 text-sm text-gray-600">
                                Please upload your reviewer comments in a new file name using Words Document file.  Please make sure that your comments can be clearly understood by the authors. You are given 30 working days for this cycle of reviewing process. Thank You
                            </p>
                            <p v-show="viewAs == `author` || viewAs == `corresponding author`" class="mt-1 text-sm text-gray-600">
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
                                        <!-- <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                            Personal details and application.
                                        </p> -->
                                    </div>
                                    <div>
                                        <span class="sm:ml-3">
                                            <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"  @click="showUploadAttachModal = !showUploadAttachModal; ">
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
                                            <tr v-for="(attachment, index) in attachments.data.filter(function(attach) {if(viewAs == `reviewer` && (attach.type.name == `Cover Letter` || attach.type.name == `Conflict of Interest` || attach.type.name == `Declaration of Interest Statement`)) {return false;}return true;})" :key="attachment.id + '-attach'">
                                                <td class="px-6 py-4 word-break">
                                                    {{ attachments.meta.from + index }}
                                                </td>
                                                <td class="px-6 py-4 word-break">
                                                    <p>{{ attachment.type.name }}</p>
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
                                                    <span class="text-indigo-600 hover:text-indigo-900 cursor-pointer px-1" @click="showUpdateAttachModel = !showUpdateAttachModel; fillUpdateAttachForm(attachment);">View</span>
                                                    <!--<a :href="`/admin/manuscripts/${manuscript.data.id}/attach-files/${attachment.id}/download`" class="text-indigo-600 hover:text-indigo-900 px-1">Download</a>-->
                                                    <span :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null" @click="cannotEditOnSubmit() ? `` : deleteAttachFile(attachment)" class="text-indigo-600 hover:text-indigo-900 cursor-pointer px-1">Delete</span>
                                                </td>
                                            </tr>
                                            <tr v-if="attachments.data.length == 0">
                                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center">
                                                    No Data
                                                </td>
                                            </tr>
                                        </template>
                                    </Table>
                                </div>
                            </div>
                            <div class="my-2 flex justify-end">
                                <Pagination :links="attachments.meta.links" :meta="attachments.meta" />
                            </div>
                        </div>
                    </div>
                </div>
                <div v-show="viewAs == `author` || viewAs == `corresponding author`" class="hidden sm:block" aria-hidden="true">
                    <div class="py-5">
                        <div class="border-t border-gray-200" />
                    </div>
                </div>
                <div v-show="viewAs == `author` || viewAs == `corresponding author`" class="mt-10 sm:mt-0">
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
                                            <input :disabled="cannotEditOnSubmit()" :class="cannotEditOnSubmit() ? `cursor-not-allowed` : null" v-model="manuscriptForm.is_acknowledge" id="is_acknowledge" name="is_acknowledge" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
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
                                        In support of Open Science, Sensors and Actuators Reports offers its authors a free preprint posting service. Preprints provide early registration and dissemination of research, which facilitates early citations and collaboration. Please indicate below whether you would like to release your manuscript publicly as a preprint on the preprint server www.SSRN.com once it enters peer-review with the journal. Your choice will have no effect on the editorial process or outcome with the journal. Your preprint will remain globally available free to read whether the journal accepts or rejects your manuscript. For more information about posting to www.SSRN.com, please consult the SSRN Terms of Use and FAQs.</legend>
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
                                            :auth="auth"></CommentSectionCard>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
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
  import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions, Menu, MenuButton, MenuItem, MenuItems, DialogTitle } from '@headlessui/vue'
  import { useForm, Link } from '@inertiajs/inertia-vue3'
  import Toast from '../../Components/Toast'
  import CommentSectionCard from '../../Components/CommentSectionCard.vue'
  import { SelectorIcon } from '@heroicons/vue/solid'
  import Pagination from '../../Components/Pagination.vue'

  export default {
    components: {
        VueMultiselect,
        Layout,
        Table,
        Pagination,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        Listbox,
        ListboxButton,
        ListboxLabel,
        ListboxOption,
        ListboxOptions,
        SelectorIcon,
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
        attachments: Object,
        filters: Object,
        attachTypes: Array,
        articleTypes: Array,
        errors: Object,
        message: String,
        auth: Object,
        manuscriptStatusList: Array
    },
    data() {
        return {
            viewAsList: [],
            viewAs: 0,
            attach_files: [],
            showUploadAttachModal: false,
            showUpdateAttachModel: false,
            showPublishModal: false,
            showAcceptModal: false,
            showRejectModal: false,
            showSubmitReviewModal: false,
            showSubmitToEditorModal: false,
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
            this.manuscriptForm.authors = this.manuscriptForm.authors_obj.map((member) => member.id);
            this.manuscriptForm.corresponding_authors = this.manuscriptForm.corresponding_authors_obj.map((member) => member.id)
            if (Array.isArray(this.manuscriptForm.editors_obj)) {
                this.manuscriptForm.editors = this.manuscriptForm.editors_obj.map((member) => member.id);
            } else {
                this.manuscriptForm.editors = ([this.manuscriptForm.editors_obj]).map((member) => member.id);
            }
            
            this.manuscriptForm.reviewers = this.manuscriptForm.reviewers_obj.map((member) => member.id);
            this.manuscriptForm.post(`/admin/manuscripts/${this.$props.manuscript.data.id}/update`, {
                preserveScroll: true,
                onError: (errors) => {
                    Object.keys(errors).forEach((value, index) => {
                        this.notification(errors[value], 'error');
                    });
                },
                onSuccess: (res) => {
                    this.notification('Saved.', 'success');
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
            this.attachForm.post(`/admin/manuscripts/${this.$props.manuscript.data.id}/attach-files`, {
                preserveScroll: true,
                onError: (errors) => {
                    Object.keys(errors).forEach((value, index) => {
                        this.notification(errors[value], 'error');
                    });
                },
                onSuccess: () => {
                    this.notification('Saved', 'success');
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
                }
            });
        },
        submitForReview() {
            this.manuscriptForm.status = "Submit For Review";
            this.saveManuscript();
            this.showSubmitReviewModal = false;
        },
        submitToEditor() {
            this.manuscriptForm.status = "Submit To Editor";
            this.saveManuscript();
            this.showSubmitToEditorModal = false;
        },
        acceptWithoutChanges() {
            this.manuscriptForm.status = "Accepted Without Changes";
            this.saveManuscript();
            this.showAcceptModal = false;
        },
        acceptWithMinorChanges() {
            this.manuscriptForm.status = "Accepted With Minor Changes";
            this.saveManuscript();
            this.showAcceptModal = false;
        },
        acceptWithMajorChanges() {
            this.manuscriptForm.status = "Accepted With Major Changes";
            this.saveManuscript();
            this.showAcceptModal = false;
        },
        rejectInviteToResubmit() {
            this.manuscriptForm.status = "Rejected Invite To Resubmit";
            this.saveManuscript();
            this.showRejectModal = false;
        },
        reject() {
            this.manuscriptForm.status = "Rejected";
            this.saveManuscript();
            this.showRejectModal = false;
        },
        publishManuscript() {
            this.manuscriptForm.status = "Published";
            this.saveManuscript();
            this.showPublishModal = false;
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
        canReview() {
            let total = this.manuscript.data.reviewers.filter((v) => (v.user_id == this. $props.auth.user.data.id && (v.reviewed == null || v.reviewedVote == `Rejected Invite To Resubmit` || v.reviewedVote == `Rejected`)));
            return total.length > 0;
        },
        setRoleView() {
            this.viewAsList = [];
            if (this.authIsAuthor()) {
                this.viewAsList.push('author');
            }
            if (this.authIsCorrespondingAuthor()) {
                this.viewAsList.push('corresponding author');
            }
            if (this.authIsEditor()) {
                this.viewAsList.push('editor');
            }
            if (this.authIsReviewer()) {
                this.viewAsList.push('reviewer');
            }
            if (this.authIsPublisher()) {
                this.viewAsList.push('publisher');
            }
            if (this.viewAsList.length > 0) {
                this.viewAs = this.viewAsList[0];
            }
        },
        cannotEditOnSubmit(){
            return this.$props.auth.user.data.permissions_attribute.manuscripts.edit_after_submit == false && (this.manuscript.data.status == `Submit To Editor` || this.manuscript.data.status == `Submit For Review` || this.manuscript.data.status == `Rejected` || this.manuscript.data.status == `Accepted Without Changes` || this.manuscript.data.status == `Published`);
        }
    },
    setup (props) {

        const moment = require('moment');
        
        const manuscriptForm = useForm({
            type: props.manuscript.data.type.id,
            category: "",
            title: props.manuscript.data.title,
            short_title: props.manuscript.data.short_title,
            abstract: props.manuscript.data.abstract,
            keywords: props.manuscript.data.keywords,
            authors: props.manuscript.data.authors_in_users.map(function(val){return val.id;}),
            authors_obj: props.manuscript.data.authors_in_users,
            corresponding_authors: props.manuscript.data.corresponding_authors_in_users.map(function(val){return val.id;}),
            corresponding_authors_obj: props.manuscript.data.corresponding_authors_in_users,
            editors: props.manuscript.data.editors_in_users.map(function(val){return val.id;}),
            editors_obj: props.manuscript.data.editors_in_users,
            reviewers: props.manuscript.data.reviewers_in_users.map(function(val){return val.id;}),
            reviewers_obj: props.manuscript.data.reviewers_in_users,
            funding_information: props.manuscript.data.funding_information,
            is_confirm_grant_numbers: props.manuscript.data.is_confirm_grant_numbers,
            is_acknowledge: props.manuscript.data.is_acknowledge,
            status: props.manuscript.data.status
        });

        const attachForm = useForm({
            id: null,
            file: null,
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

        return { clearAttachForm, fillUpdateAttachForm, clearUpdateAttachForm, deleteAttachFile, manuscriptForm, attachForm, updateAttachForm, moment }
    },
    async created() {
        // console.log(this.$props.auth.user.data.permissions_attribute.manuscripts.edit_after_submit)
        console.log('attachments', this.attachments);
        this.setRoleView();
        this.asyncFindEditors()
        this.asyncFindReviewers()
        this.asyncFindAuthors()
        this.asyncFindCorrespondingAuthors()
    }
  }
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>