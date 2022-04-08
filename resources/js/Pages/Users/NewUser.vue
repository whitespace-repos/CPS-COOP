<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
      <div class="main-panel">
        <form method="POST" @submit.prevent="saveUser">
          <div class="card">
            <div class="cord-body row">
              <div class="form-group">
                <label>Full Name</label>
                <input v-model="form.user.name" placeholder="Type name here" class="form-control" />
              </div>

              <div class="form-group">
                <label>Email</label>
                <input v-model="form.user.email" placeholder="Type email address here" class="form-control" />
              </div>

              <div class="form-group">
                <label>Phone</label>
                <input v-model="form.user.phone" placeholder="Type phone number here" class="form-control" />
              </div>

              <div class="form-group">
                <label>Password</label>
              <input v-model="form.user.password" placeholder="Type password here" class="form-control" />
              </div>


              <div class="form-group">
                <label>Full Name</label>
                <v-select
                      :filter="fuseSearch"
                      :options="shops"
                      :get-option-key="(option) => option.id"
                      :get-option-label="(option) => option.shop_name"
                      :key="(option) => option.id"
                      multiple
                    >
                    <template #option="{ shop_name, shop_id }">
                        {{ shop_name }}
                        <br />
                        <cite>{{ shop_id }}</cite>
                      </template>
                  </v-select>
              </div>
            </div>
          </div>
        </form>
      </div>
      <!-- main-panel -->
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
    },
    props:['shops'],
    computed (){
      $('select').selectpicker();
    },
    data () {
        return {
                  form:{
                        user:this
                                  .$inertia
                                  .form({
                                          name:'',
                                          email:'',
                                          phone:'',
                                          shop_id:'',
                        })
                  }

        }
    },
    methods: {
        saveUser() {
            this.form.user.post(this.route('user.store'), {
                onSuccess: (response) => {
                                    this.form.user.reset();
                },
            })
        },
    },
    mounted() {
      $('select').selectpicker();
    }
}
</script>
