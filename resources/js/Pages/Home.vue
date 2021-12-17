<template>
  <div>
    <Layout>
    <H1>Welcome</H1>
    <p>Hello {{ user.name }}, welcome to your first Inertia app!</p>
    </Layout>
  </div>
</template>

<script>
  import Layout from '../Layout'

  export default {
    // Using a render function
    layout: (h, page) => h(Layout, () => child),

    // Using the shorthand
    layout: Layout,

    props: {
      user: Object,
    },
  }
</script>