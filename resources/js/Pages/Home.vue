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
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-5">
            <div v-for="overview in overviewCards" :key="`overview-${overview.name}`" class="max-w-sm flex p-6 bg-white rounded-lg shadow">
                <div class="flex-shrink-0 self-center">
                  <i :class="[overview.icon, overview.color]" class="fa fa-2xl"></i>
                </div>
                <div class="ml-6 pt-1">
                  <Link :href="overview.link == `` ? `#` : `/admin/manuscripts?${overview.link}`">
                    <h4 class="text-md text-gray-700">
                      {{ overview.name }}
                    </h4>
                    <p class="text-xl text-gray-500">
                      {{ overview.value }}
                    </p>
                  </Link>
                </div>
            </div>
          </div>
          <h4 class="font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate my-4">Actions</h4>
          <Table>
            <template v-slot:header>
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Description
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  
                </th>
              </tr>
            </template>
            <template v-slot:body>
              <tr v-for="(step, index) in nextSteps.publisher.data" :key="`step-author-${index}`">
                <td class="px-6 py-4 word-break">
                  {{ `Manuscript "${step.manuscript_no} - ${step.title || step.type['name']}" has been reviewed by reviewers. Please review the manuscript.` }}
                </td>
                <td class="px-6 py-4 word-break">
                  <Link v-if="auth.user.data.permissions_attribute.manuscripts.edit == true" :href="`/admin/manuscripts/${step.id}/edit`" class="text-indigo-600 hover:text-indigo-900 px-2">View</Link>
                </td>
              </tr>
              <tr v-for="(step, index) in nextSteps.editor.data" :key="`step-author-${index}`">
                <td class="px-6 py-4 word-break">
                  {{ `Manuscript "${step.manuscript_no} - ${step.title || step.type['name']}" is ready to be edit by you. Please review the manuscript.` }}
                </td>
                <td class="px-6 py-4 word-break">
                  <Link v-if="auth.user.data.permissions_attribute.manuscripts.edit == true" :href="`/admin/manuscripts/${step.id}/edit`" class="text-indigo-600 hover:text-indigo-900 px-2">View</Link>
                </td>
              </tr>
              <tr v-for="(step, index) in nextSteps.reviewer.data" :key="`step-author-${index}`">
                <td class="px-6 py-4 word-break">
                  {{ `Manuscript "${step.manuscript_no} - ${step.title || step.type['name']}" is ready to be review by you. Please review the manuscript.` }}
                </td>
                <td class="px-6 py-4 word-break">
                  <Link v-if="auth.user.data.permissions_attribute.manuscripts.edit == true" :href="`/admin/manuscripts/${step.id}/edit`" class="text-indigo-600 hover:text-indigo-900 px-2">View</Link>
                </td>
              </tr>
              <tr v-for="(step, index) in nextSteps.author.data" :key="`step-author-${index}`">
                <td class="px-6 py-4 word-break">
                  {{ `Manuscript "${step.manuscript_no} - ${step.title || step.type['name']}" is in status "${step.status}". Please review the manuscript.` }}
                </td>
                <td class="px-6 py-4 word-break">
                  <Link v-if="auth.user.data.permissions_attribute.manuscripts.edit == true" :href="`/admin/manuscripts/${step.id}/edit`" class="text-indigo-600 hover:text-indigo-900 px-2">View</Link>
                </td>
              </tr>
              <tr v-if="nextSteps.author.data.length == 0 && nextSteps.reviewer.data.length == 0 && nextSteps.editor.data.length == 0 && nextSteps.publisher.data.length == 0">
                <td colspan="2" class="text-center text-gray-600 px-6 py-4">
                  No Data
                </td>
              </tr>
            </template>
          </Table>
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
      nextSteps: Object
    },
    setup(props) {
      const overviewCards = [
        {
          name: 'Draft Manuscripts',
          value: props.manuscript_overview.total_draft,
          link: props.manuscript_overview.total_draft_link,
          color: 'text-gray-700',
          icon: 'fa-file-lines'
        },
        {
          name: 'Submit to Editor Manuscripts',
          value: props.manuscript_overview.total_submit_to_editor,
          link: props.manuscript_overview.total_submit_to_editor_link,
          color: 'text-blue-700',
          icon: 'fa-file-lines'
        },
        {
          name: 'In Review Manuscripts',
          value: props.manuscript_overview.total_review,
          link: props.manuscript_overview.total_review_link,
          color: 'text-blue-700',
          icon: 'fa-magnifying-glass'
        },
        {
          name: 'Rejected Manuscripts',
          value: props.manuscript_overview.total_rejected,
          link: props.manuscript_overview.total_rejected_link,
          color: 'text-red-700',
          icon: 'fa-thumbs-down'
        },
        {
          name: 'Approved Manuscripts',
          value: props.manuscript_overview.total_approved,
          link: props.manuscript_overview.total_approved_link,
          color: 'text-green-700',
          icon: 'fa-thumbs-up'
        },
      ];

      return {
        overviewCards
      };
    }
  }
</script>