<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
      <div class="main-panel">
        <div class="StoreDiv">
          <h3>Add New Store</h3>
          <form method="POST" @submit.prevent="saveShop">
          <div class="ShopFrm">
            <ul>
              <li>
                <label>Shop Full Name</label>
                <input v-model="form.shop.shop_name" placeholder="Type shop name here" class="form-control" />
              </li>
              <li>
                <label>Shop Address</label>
                <input v-model="form.shop.address" placeholder="Type shop address here" class="form-control" />
              </li>
              <li>
                <label>Shop Dimentions</label>
                <input v-model="form.shop.shop_dimentions" placeholder="Type shop dimentions here" class="form-control" />
              </li>
              <li>
                <label>Stock Capacity Per Day </label>
                <input v-model="form.shop.stock_capacity_per_day" placeholder="Type stock capacity here (per day)" class="form-control" />
              </li>
              <li>
                <label>Max Sale Estimate<em>(amount calculated in INR)</em></label>
                <input v-model="form.shop.max_sale_estimate_per_day" placeholder="Type max sale estimate here" class="form-control" />
              </li>
              <li>
                <label>Distance From CPS</label>
                <input v-model="form.shop.distance_from_cps" placeholder="Type distance here" class="form-control" />
              </li>
              <li>
                <label>Estimated Start Date</label>
                <input v-model="form.shop.estimated_start_date" placeholder="Type estimated start date here" class="form-control" id="inputDate" />
              </li>
              <li>
                <label>Select Product</label>
                <select class="selectpicker" v-model="form.shop.products" multiple aria-label="Default select example" data-live-search="false" id="style-3">
                  <option v-for="product in products" :key="product.id" :value="product.id"> {{ product.product_name }}</option>
               </select>
              </li>
              <li>
                <label>Contact Number</label>
                <input v-model="form.shop.phone" class="form-control" />
              </li>
              <li>
                <button class="btn btn-primary add-btn" type="submit" >Add New Shop</button>
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
    props:['products'],
    computed (){
      $('select').selectpicker();
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
                                          phone:''
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
      $('select').selectpicker();
    }
}
</script>
