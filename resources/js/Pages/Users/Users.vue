<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
      <div class="main-panel">
        <div class="d-flex justify-content-between">
          <h4>Users </h4>
          <inertia-link :href="this.route('user.create')"  class="btn add-btn btn-primary" as="button" type="button" >Add New Employee</inertia-link>
        </div>

        <hr class="border-danger bg-danger border w-100"/>

        <div class="card">
          <table class="table table-striped table-hover mb-0">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Role</th>
                <th>Shop</th>
                <th>Contact</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <template v-for="user in users" :key="user.id">
                <tr>
                  <td><kbd>{{ '# '+user.id }}</kbd></td>
                  <td>{{ user.name }}</td>
                  <td><span class="badge badge-danger"> {{ (isEmpty(user)) ? '' : user.roles[0].name  }}</span></td>
                  <td><span class="badge badge-warning" :class="{'px-4':isEmpty(user.shop)}"> {{ isEmpty(user.shop) ? '-' : user.shop.shop_name }}</span></td>
                  <td><span class="badge badge-secondary font-weight-normal" :class="{'px-4':isEmpty(user.phone)}"> {{ isEmpty(user.phone) ? '-' : user.phone }}</span></td>
                  <td><inertia-link href="#">Edit</inertia-link></td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
      </div>
      <!--  main-panel-->
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';
import _ from 'lodash'

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
    },
    props:['users'],
    methods:{
       isEmpty:function(o){
         return  _.isNil(o);
       }
    }
}
</script>
