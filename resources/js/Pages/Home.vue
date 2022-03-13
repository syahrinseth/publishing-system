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
            <H1>Welcome</H1>
            <p>Hello {{ user.name }}, welcome to your first Inertia app!</p>
        </template>
    </Layout>
  </div>
</template>

<script>
  import Layout from '../Layout'
  import { Head } from '@inertiajs/inertia-vue3'

  export default {
    components: {
        Head, 
        Layout
    },
    props: {
      user: Object,
      auth: Object
    },
  }
</script>