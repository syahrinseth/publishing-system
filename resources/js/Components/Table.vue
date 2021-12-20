<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Order
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Item
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
                <th scope="col" class="relative px-6 py-3">
                  <span class="sr-only">Edit</span>
                  <span class="sr-only">Download</span>
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="person in people" :key="person.email">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <!-- <div class="flex-shrink-0 h-10 w-10">
                      <img class="h-10 w-10 rounded-full" :src="person.order" alt="" />
                    </div> -->
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">
                        {{ person.order }}
                      </div>
                      <div class="text-sm text-gray-500">
                        <!-- {{ person.email }} -->
                      </div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ person.item }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <!-- <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                  </span> -->
                  {{ person.desc }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ person.fileName }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ person.size }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ person.dateUpdated }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a> | 
                  <a href="#" class="text-indigo-600 hover:text-indigo-900">Download</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
const people = [
  {
    order: 1,
    item: '*Manuscript',
    desc: 'Manuscript',
    fileName: 'ANSN_Double.pdf',
    size: '47.5 KB',
    dateUpdated:
      'Desc 08 2021',
  },
  {
    order: 2,
    item: '*Manuscript',
    desc: 'Manuscript',
    fileName: 'ANSN_Double.pdf',
    size: '47.5 KB',
    dateUpdated:
      'Desc 08 2021',
  },
  {
    order: 3,
    item: '*Manuscript',
    desc: 'Manuscript',
    fileName: 'ANSN_Double.pdf',
    size: '47.5 KB',
    dateUpdated:
      'Desc 08 2021',
  },
  {
    order: 4,
    item: '*Manuscript',
    desc: 'Manuscript',
    fileName: 'ANSN_Double.pdf',
    size: '47.5 KB',
    dateUpdated:
      'Desc 08 2021',
  },
  // More people...
]

export default {
  setup() {
    return {
      people,
    }
  },
}
</script>