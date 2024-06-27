
<template>
 <AdminLayout title="mama">
      <h1>admin Page</h1>
 </AdminLayout>

</template>
<script>
import {defineComponent} from "vue";
import AdminLayout from "@AdminModule/Layouts/AdminLayout.vue";

export default defineComponent({
    components: {
        AdminLayout
    },
    setup() {
        return {
            title: "Admin Page"
        }
    }
})



</script>

<style scoped>

</style>