<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
      <div class="main-panel">
        <div class="StoreDiv pt-0">
          <h3 class="mb-4">Add New Store</h3>
          <form method="POST" @submit.prevent="saveShop">
            <div class="card">
              <div class="card-body row">
                <div class="form-group col-md-4" :class="{ 'has-error': v$.form.shop.shop_name.$errors.length }">
                  <label>Shop Full Name</label>
                  <input v-model="v$.form.shop.shop_name.$model" placeholder="Type shop name here" class="form-control" />
                  <template v-for="(error, index) of v$.form.shop.shop_name.$errors" :key="index">
                    <small>{{ error.$message }}</small>
                  </template>
                </div>

                <!-- -->
                <div class="form-group col-md-4" :class="{ 'has-error': v$.form.shop.address.$errors.length }">
                  <label>Shop Address</label>
                  <input v-model="v$.form.shop.address.$model" placeholder="Type shop address here" class="form-control" />
                  <template v-for="(error, index) of v$.form.shop.address.$errors" :key="index">
                    <small>{{ error.$message }}</small>
                  </template>
                </div>

                <!-- -->
                <div class="form-group col-md-4" :class="{ 'has-error': v$.form.shop.shop_dimentions.$errors.length }">
                  <label>Shop Dimentions</label>
                  <input v-model="v$.form.shop.shop_dimentions.$model" placeholder="Type shop dimentions here" class="form-control" />
                  <template v-for="(error, index) of v$.form.shop.shop_dimentions.$errors" :key="index">
                    <small>{{ error.$message }}</small>
                  </template>
                </div>

                <!-- -->
                <div class="form-group col-md-4" :class="{ 'has-error': v$.form.shop.stock_capacity_per_day.$errors.length }">
                  <label>Stock Capacity Per Day</label>
                  <input v-model="v$.form.shop.stock_capacity_per_day.$model" placeholder="Type stock capacity here (per day)" class="form-control" />
                  <template v-for="(error, index) of v$.form.shop.stock_capacity_per_day.$errors" :key="index">
                    <small>{{ error.$message }}</small>
                  </template>
                </div>
                <!-- -->
                <div class="form-group col-md-4" :class="{ 'has-error': v$.form.shop.max_sale_estimate_per_day.$errors.length }">
                  <label>Max Sale Estimate<label class="small mb-0">(amount calculated in INR)</label></label>
                  <input v-model="v$.form.shop.max_sale_estimate_per_day.$model" placeholder="Type max sale estimate here" class="form-control" />
                  <template v-for="(error, index) of v$.form.shop.max_sale_estimate_per_day.$errors" :key="index">
                    <small>{{ error.$message }}</small>
                  </template>
                </div>

                 <!-- -->
                <div class="form-group col-md-4" :class="{ 'has-error': v$.form.shop.distance_from_cps.$errors.length }">
                  <label>Distance From CPS</label>
                  <input v-model="v$.form.shop.distance_from_cps.$model" placeholder="Type distance here" class="form-control" />
                  <template v-for="(error, index) of v$.form.shop.distance_from_cps.$errors" :key="index">
                    <small>{{ error.$message }}</small>
                  </template>
                </div>

                 <!-- -->
                <div class="form-group col-md-4" :class="{ 'has-error': v$.form.shop.estimated_start_date.$errors.length }">
                  <label>Estimated Start Date</label>
                  <input  placeholder="Type max sale estimate here" class="form-control" type="date" v-model="v$.form.shop.estimated_start_date.$model"/>
                  <template v-for="(error, index) of v$.form.shop.estimated_start_date.$errors" :key="index">
                    <small>{{ error.$message }}</small>
                  </template>
                </div>

                 <!-- -->
                <div class="form-group col-md-4" :class="{ 'has-error': v$.form.shop.products.$errors.length }">
                  <label>Select Product</label>
                  <v-select
                    v-model="v$.form.shop.products.$model"
                    :options="products"
                    :get-option-key="(option) => option.id"
                    :get-option-label="(option) => option.product_name"
                    :key="(option) => option.id"
                    multiple
                  >
                  </v-select>
                  <template v-for="(error, index) of v$.form.shop.products.$errors" :key="index">
                    <small>{{ error.$message }}</small>
                  </template>
                </div>

                 <!-- -->
                <div class="form-group col-md-4" :class="{ 'has-error': v$.form.shop.phone.$errors.length }">
                  <label>Contact Number</label>
                  <input v-model="v$.form.shop.phone.$model" class="form-control" />
                  <template v-for="(error, index) of v$.form.shop.phone.$errors" :key="index">
                    <small>{{ error.$message }}</small>
                  </template>
                </div>

                <div class="form-group col-md-4" >
                  <label>Choose Supplier</label>
                  <select v-model="form.shop.supplier_id" class="form-control">
                    <option :value="supplier.id" v-for="supplier in suppliers" :key="supplier.id">{{ supplier.name }}</option>
                  </select>
                </div>

                <!-- -->
                <div class="col-md-12">
                  <div class="form-group py-1">
                      <button class="btn btn-danger px-5 my-4" type="submit" :disabled="v$.form.shop.$invalid">Save New Shop</button>
                  </div>
                </div>
              </div>
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
import useVuelidate from '@vuelidate/core'
import { required, email, minLength , numeric , integer ,helpers} from '@vuelidate/validators'

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
    },
    props:['products','suppliers'],
    computed (){

    },
    data () {
        return {
                  form:{
                        shop:this
                                  .$inertia
                                  .form({
                                          shop_name:'',
                                          address:'',
                                          distance_from_cps:'',
                                          shop_dimentions:'',
                                          stock_capacity_per_day:'',
                                          max_sale_estimate_per_day:'',
                                          estimated_start_date:'',
                                          products:[],
                                          phone:'',
                                          supplier_id:'',
                        })
                  }

        }
    },
    methods: {
        saveShop() {
            this.form.shop.post(this.route('shop.store'), {
                onSuccess: (response) => {
                                    this.form.shop.reset();
                },
            })
        },
    },
    mounted() {

    },
    validations() {
      return {
              form:{
                        shop:{
                                shop_name:{required},
                                address:{required},
                                shop_dimentions:{required},
                                stock_capacity_per_day:{required , numeric},
                                max_sale_estimate_per_day:{required , numeric},
                                products:{required},
                                phone:{required , numeric},
                                estimated_start_date:{required},
                                distance_from_cps:{required , numeric}
                      }
                }
      }
    },
    setup () {
      return { v$: useVuelidate() }
    }
}
</script>
