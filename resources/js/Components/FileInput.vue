<template>
    <div 
        class="mt-2 rounded-lg border border-dashed border-gray-900/25 px-6 py-10"
        @dragover.prevent
        @dragenter.prevent
        @dragleave.prevent
        @drop="handleDrop"
    >
        <div class="flex justify-center">
            <div class="text-center">
                <svg v-show="data.fileLocalDisplayURL == null && url == null" class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                </svg>
                <span v-if="data.fileLocalDisplayURL">
                    <img 
                        :src="data.fileLocalDisplayURL"/>
                </span>
                <span v-else-if="url">
                    <img 
                        :src="url"/>
                </span>
                <span v-else>
                    <p>{{ data.file?.name }}</p>
                </span>
                <div class="mt-4 flex text-sm leading-6 text-gray-600">
                    <label :for="keyValue" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                    <span>Upload a file</span>
                    <input :id="keyValue" :name="keyValue" type="file" class="sr-only" @change="onChange">
                    </label>
                    <p class="pl-1">or drag and drop</p>
                </div>
                
                <slot name="requirements"></slot>
                
            </div>
            
        </div>
        <slot></slot>
    </div>
</template>
<script setup>
import { defineEmits, defineProps, reactive } from 'vue'

const props = defineProps({
    keyValue: {
        default: 'file',
        type: String
    },
    url: {
        default: null,
        type: String
    }
});

const emits = defineEmits([
    'onSelect'
])

const data = reactive({
    file: null,
    fileLocalDisplayURL: null,
    show_file_name: false
});

const onChange = ($event) => {

    data.file = $event.target.files[0];
    if (data.file && data.file.type?.includes('image')) {

        data.show_file_name = false;
        data.fileLocalDisplayURL = URL.createObjectURL(data.file);

    } else {

        data.show_file_name = true;
        data.fileLocalDisplayURL = null;

    }

    emits('onSelect', data.file)

}

const handleDrop = ($event) => {

    $event.preventDefault();
    data.file = $event.dataTransfer.files[0];

    if (data.file && data.file.type?.includes('image')) {

        data.show_file_name = false;
        data.fileLocalDisplayURL = URL.createObjectURL(data.file);

    } else {

        data.show_file_name = true;
        data.fileLocalDisplayURL = null;

    }

    emits('onSelect', data.file)

}

</script>