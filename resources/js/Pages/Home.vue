<template>
  <div>
    <Head>
      <title>Home</title>
    </Head>
    <Layout :auth="auth.user.data">
        <template v-slot:header>
          <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
              Dashboard
          </h2>
        </template>
        <template v-slot:default>
          <h4 class="font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate mb-4">Overview</h4>
          <div class="grid grid-cols-4 gap-3 mb-5">
            <div v-for="overview in overviewCards" :key="`overview-${overview.name}`" class="max-w-sm flex p-6 bg-gray-100 rounded-lg shadow">
              <div class="flex-shrink-0 self-center">
                <i :class="[overview.icon, overview.color]" class="fa fa-2xl"></i>
              </div>
              <div class="ml-6 pt-1">
                <h4 class="text-md text-gray-700">
                  {{ overview.name }}
                </h4>
                <p class="text-xl text-gray-500">
                  {{ overview.value }}
                </p>
              </div>
            </div>
          </div>
          <h4 class="font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate my-4">Next Step</h4>
          <Table>
            <template v-slot:header>
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Description
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Actions
                </th>
              </tr>
            </template>
            <template v-slot:body>
              <tr v-for="(step, index) in nextSteps.publisher.data" :key="`step-author-${index}`">
                <td class="px-6 py-4 whitespace-nowrap">
                  {{ `Manuscript "${step.title || step.type['name']}" is ready to be publish by you. Please review the manuscript.` }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <Link v-if="auth.user.data.permissions_attribute.manuscripts.edit == true" :href="`/admin/manuscripts/${step.id}/edit`" class="text-indigo-600 hover:text-indigo-900 px-2">Review</Link>
                </td>
              </tr>
              <tr v-for="(step, index) in nextSteps.reviewer.data" :key="`step-author-${index}`">
                <td class="px-6 py-4 whitespace-nowrap">
                  {{ `Manuscript "${step.title || step.type['name']}" is ready to be review by you. Please review the manuscript.` }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <Link v-if="auth.user.data.permissions_attribute.manuscripts.edit == true" :href="`/admin/manuscripts/${step.id}/edit`" class="text-indigo-600 hover:text-indigo-900 px-2">Review</Link>
                </td>
              </tr>
              <tr v-for="(step, index) in nextSteps.author.data" :key="`step-author-${index}`">
                <td class="px-6 py-4 whitespace-nowrap">
                  {{ `Manuscript "${step.title || step.type['name']}" is in status "${step.status}". Please review the manuscript.` }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <Link v-if="auth.user.data.permissions_attribute.manuscripts.edit == true" :href="`/admin/manuscripts/${step.id}/edit`" class="text-indigo-600 hover:text-indigo-900 px-2">Review</Link>
                </td>
              </tr>
            </template>
          </Table>

          <!-- <h4 class="font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate my-4">Recent Activities</h4>
          <Table>
            <template v-slot:header>
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Time
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Activity
                </th>
              </tr>
            </template>
            <template v-slot:body>
              <tr v-for="activity in activities.data" :key="`activity-${activity.id}`">
                <td class="px-6 py-4 whitespace-nowrap">
                  {{ activity.created_at }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <h4 class="text-gray-700">{{ activity.subject_type }}</h4>
                  <span v-if="activity.description == 'updated'">
                    <div class="grid grid-cols-3 justify-items-stretch" v-if="activity.properties['attributes'].length != 0">
                      <div>
                        <p v-for="(value, name) in activity.properties['old'] || []" :key="`prop-${value}`">
                          {{ name }}: <span class="text-red-700">{{ value }}</span>
                        </p>
                      </div>
                      <div class="justify-self-center">
                        ->
                      </div>
                      <div>
                        <p v-for="(value, name) in activity.properties['attributes']" :key="`prop-${value}`">
                          {{ name }}: <span class="text-green-700">{{ value }}</span>
                        </p>
                      </div>
                    </div>
                    <div v-else>
                      N/a
                    </div>
                  </span>
                </td>
              </tr>
            </template>
          </Table> -->
        </template>
    </Layout>
  </div>
</template>

<script>
  import Layout from '../Layout'
  import { Head } from '@inertiajs/inertia-vue3'
  import Table from '../Components/Table.vue'
  import { Link } from '@inertiajs/inertia-vue3'
  import { computed } from 'vue'
  import { usePage } from '@inertiajs/inertia-vue3'

  export default {
    components: {
        Head, 
        Layout,
        Table,
        Link
    },
    props: {
      auth: Object,
      manuscript_overview: Object,
      activities: Object,
      nextSteps: Object
    },
    setup(props) {
      const overviewCards = [
        {
          name: 'Draft Manuscripts',
          value: props.manuscript_overview.total_draft,
          color: 'text-gray-700',
          icon: 'fa-file-lines'
        },
        {
          name: 'In Review Manuscripts',
          value: props.manuscript_overview.total_review,
          color: 'text-blue-700',
          icon: 'fa-magnifying-glass'
        },
        {
          name: 'Rejected Manuscripts',
          value: props.manuscript_overview.total_rejected,
          color: 'text-red-700',
          icon: 'fa-thumbs-down'
        },
        {
          name: 'Approved Manuscripts',
          value: props.manuscript_overview.total_approved,
          color: 'text-green-700',
          icon: 'fa-thumbs-up'
        },
        {
          name: 'Published Manuscripts',
          value: props.manuscript_overview.total_published,
          color: 'text-teal-700',
          icon: 'fa-upload'
        },
      ];

      return {
        overviewCards
      };
    }
  }
</script>