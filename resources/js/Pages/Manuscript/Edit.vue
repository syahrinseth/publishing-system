<template>
    <div>
        <!-- <Toast v-show="errors != null"/> -->
        <Layout :auth="auth.user.data">
            <template v-slot:header>
                <div class="lg:flex lg:items-center lg:justify-between">
                        <div class="flex-1 min-w-0">
                            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                                {{ manuscript.data.title }}
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
                                    <UserIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                                    {{ manuscript.data.authors.map(x => x.name).join(', ') }}
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 flex lg:mt-0 lg:ml-4">

                        <span class="sm:ml-3">
                            <a :href="`/admin/manuscripts/${manuscript.data.id}/download`" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" target="_blank">
                                <DownloadIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                                Build PDF
                            </a>
                        </span>

                        <!-- Dropdown -->
                        <Menu as="span" class="ml-3 relative sm:hidden">
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
                        </Menu>
                    </div>
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
                                                <select class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="www.example.com" v-model="attachForm.type">
                                                    <option value="" selected>Select</option>
                                                    <option v-for="type in attachTypes" :key="type.id" :value="type.id">{{ type.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-span-3 sm:col-span-2 mb-2">
                                                <label for="company-website" class="block text-sm font-medium text-gray-700">
                                                Description
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
                                            Description
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
                        <a href="#" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm" @click="updateAttach()">
                            Upload
                        </a>
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="showUpdateAttachModel = false; clearUpdateAttachForm()" ref="cancelButtonRef">
                            Cancel
                        </button>
                    </template>
                </Modal>

                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
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
                                        Order
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Items
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Description
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        File Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Size
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Last Modified
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </template>
                            <template v-slot:body>
                                <tr v-for="(attachment, index) in manuscript.data.attachments" :key="attachment.id + '-attach'">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ attachment.type.name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ attachment.description }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ attachment.file_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ attachment.size}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ attachment.updated_at}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900 px-1" @click="showUpdateAttachModel = !showUpdateAttachModel; fillUpdateAttachForm(attachment);">Edit</a>
                                        <a :href="`/admin/manuscripts/${manuscript.data.id}/attach-files/${attachment.id}/download`" class="text-indigo-600 hover:text-indigo-900 px-1">Download</a>
                                        <a href="#" @click="deleteAttachFile(attachment)" class="text-indigo-600 hover:text-indigo-900 px-1">Delete</a>
                                    </td>
                                </tr>
                            </template>
                        </Table>
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
                            <h3 class="text-lg font-medium leading-6 text-gray-900">General Information</h3>
                            <p class="mt-1 text-sm text-gray-600">
                            Please identify your submission's areas of interest and specialization by selecting one or more classifications.
                            </p>
                        </div>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                        <form @submit.prevent="saveManuscript()">
                            <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                <div class="grid grid-cols-3 gap-6">
                                    <div class="col-span-3 sm:col-span-2">
                                        <label for="company-website" class="block text-sm font-medium text-gray-700">
                                        Manuscript Status
                                        </label>
                                        <select name="company-website" id="company-website" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="www.example.com" v-model="manuscriptForm.status">
                                            <option value="" selected>Select</option>
                                            <option v-for="status in manuscriptStatusList" :key="`status-${status.name}`">{{ status.name }}</option>
                                        </select>
                                    </div>
                                    <div class="col-span-3 sm:col-span-2">
                                        <label for="company-website" class="block text-sm font-medium text-gray-700">
                                        Article Type
                                        </label>
                                        <select name="company-website" id="company-website" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="www.example.com" v-model="manuscriptForm.type">
                                            <option value="" selected>Select</option>
                                            <option v-for="type in articleTypes" :key="type.id" :value="type.id">{{ type.name }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <button class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Review Preferences</h3>
                                    <p class="mt-1 text-sm text-gray-600">
                                    You may request that a specific editor be assigned to your submission. The request will be taken under advisement by the publication. If you do not request an editor, your submission will be assigned to the appropriate editor(s) as determined by the publication staff.
                                    </p>
                                </div>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <form @submit.prevent="saveManuscript()" >
                                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                        <div class="grid grid-cols-3 gap-6">
                                            <div class="col-span-3 sm:col-span-2">
                                                <label for="company-website" class="block text-sm font-medium text-gray-700">
                                                Request Editor
                                                </label>
                                                <select name="company-website" id="company-website" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" v-model="manuscriptForm.editors" placeholder="www.example.com" >
                                                    <option value="">Select</option>
                                                    <option v-for="user in users" :key="user.id + '-user'" :value="user.id">{{ user.name }} - {{ user.email }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3 gap-6">
                                            <div class="col-span-3 sm:col-span-2">
                                                <label for="company-website" class="block text-sm font-medium text-gray-700">
                                                Suggest Reviewers
                                                </label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                <select name="suggest-reviewers" id="suggest-reviewers" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" v-model="manuscriptForm.reviewers" placeholder="www.example.com" >
                                                    <option value="">Select</option>
                                                    <option v-for="user in users" :key="user.id + '-user'" :value="user.id">{{ user.name }} - {{ user.email }}</option>
                                                </select>
                                                </div>
                                            </div>
                                        </div>

                                        
                                    </div>
                                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                        <button class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Manuscript Data</h3>
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
                                        <textarea v-model="manuscriptForm.title" id="title" name="title" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="" />
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">
                                        
                                    </p>
                                    </div>

                                    <div>
                                    <label for="short_title" class="block text-sm font-medium text-gray-700">
                                        Short Title
                                    </label>
                                    <div class="mt-1">
                                        <textarea v-model="manuscriptForm.short_title" id="short_title" name="short_title" rows="1" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="" />
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Limit 20 words
                                    </p>
                                    </div>

                                    <div>
                                    <label for="abstract" class="block text-sm font-medium text-gray-700">
                                        Abstract
                                    </label>
                                    <div class="mt-1">
                                        <textarea v-model="manuscriptForm.abstract" id="abstract" name="abstract" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="" />
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Limit 250 words
                                    </p>
                                    </div>

                                    <div>
                                    <label for="keywords" class="block text-sm font-medium text-gray-700">
                                        Keywords
                                    </label>
                                    <div class="mt-1">
                                        <textarea v-model="manuscriptForm.keywords" id="keywords" name="keywords" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="" />
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
                                        <textarea v-model="manuscriptForm.authors" id="authors" name="authors" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="" />
                                    </div> -->
                                    <p class="mt-2 text-sm text-gray-500">
                                    </p>
                                    </div>

                                    <div>
                                    <label for="funding_information" class="block text-sm font-medium text-gray-700">
                                        Funding Information
                                    </label>
                                    <div class="mt-1">
                                        <textarea v-model="manuscriptForm.funding_information" id="funding_information" name="funding_information" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="" />
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">

                                    </p>
                                    </div>

                                    
                                </div>
                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
                                                <input v-model="manuscriptForm.is_confirm_grant_numbers" id="is_confirm_grant_numbers" name="is_confirm_grant_numbers" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
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
                                        <legend class="text-base font-medium text-gray-900">Sensors and Actuators Reports is an open access journal which charges an Article Publishing Charge (APC) to cover the cost associated with the publication process. All articles published Open Access will be immediately and permanently free on ScienceDirect for users to read, download, and use in accordance with the author’s selected Creative Commons user license. </legend>
                                        <div class="mt-4 space-y-4">
                                            <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input v-model="manuscriptForm.is_acknowledge" id="is_acknowledge" name="is_acknowledge" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
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
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Save
                                    </button>
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
  PaperClipIcon
} from '@heroicons/vue/solid'
  import { Menu, MenuButton, MenuItem, MenuItems, DialogTitle } from '@headlessui/vue'
  import { useForm, Link } from '@inertiajs/inertia-vue3'
  import Toast from '../../Components/Toast'

  export default {
    components: {
        Layout,
        Table,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        BriefcaseIcon,
        CalendarIcon,
        CheckIcon,
        ChevronDownIcon,
        CurrencyDollarIcon,
        LinkIcon,
        DownloadIcon,
        LocationMarkerIcon,
        UserIcon,
        StatusOnlineIcon,
        DocumentReportIcon,
        PencilIcon,
        Modal,
        Link,
        DialogTitle,
        Toast,
        PaperClipIcon
    },
    props: {
        manuscript: Object,
        users: Array,
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
            isShow: false
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
            this.manuscriptForm.authors = this.manuscriptForm.authors.map((user) => user.id);
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
    },
    setup (props) {

        const manuscriptForm = useForm({
            type: props.manuscript.data.type.id,
            category: "",
            title: props.manuscript.data.title,
            short_title: props.manuscript.data.short_title,
            abstract: props.manuscript.data.abstract,
            keywords: props.manuscript.data.keywords,
            authors: props.manuscript.data.authors,
            corresponding_authors: [],
            editors: props.manuscript.data.editors,
            reviewers: props.manuscript.data.reviewers,
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
            updateAttachForm.file_name = attach.file_name;
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
        // console.log(this.$page.props.auth)
    }
  }
</script>