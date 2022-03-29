<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>          
      <div class="main-panel">
        <div class="StoreDiv">
          <h3>Add New User</h3>
          <form method="POST" @submit.prevent="saveUser">
          <div class="ShopFrm">
            <ul>
              <li>
                <label>Full Name</label>
                <input v-model="form.user.name" placeholder="Type name here" class="form-control" />
              </li>
              <li>
                <label>Email</label>
                <input v-model="form.user.email" placeholder="Type email address here" class="form-control" />
              </li>
              <li>
                <label>Phone</label>
                <input v-model="form.user.phone" placeholder="Type phone number here" class="form-control" />
              </li>
              <li>
                <label>Password</label>
                <input v-model="form.user.password" placeholder="Type password here" class="form-control" />
              </li>
              <li>
                <label>Shop</label>
                <select class="form-control" v-model="form.user.shop_id">
                    <template v-for="shop in shops" :key="shop.id">
                      <option  :value="shop.id">{{ shop.shop_name }}</option>
                    </template>
                  </select>
              </li>
              <li>
                <button class="btn btn-primary add-btn" type="submit" >Add Employee</button>                
              </li>
            </ul>
          </div>
          </form>
        </div>
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
