<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
      <div class="main-panel">
        <div class="topBar">
          <div class="row">
            <div class="col-md-2">
              <h3 class="heading">Shops</h3>
            </div>
            <div class="col-lg-3">
              <label>Filter Product</label>
              <select class="custom-select" @change="filterShop" v-model="filterProduct" >
                <option v-for="item in products" :key="item.id" :value="item.id" :selected="item.id == product.id"> {{ item.product_name }}</option>
              </select>
            </div>
            <div class="col-lg-3 pt-2">
                  <input type="date" @change="filterShop" v-model="filterDate" class="form-control mt-4" />
            </div>

            <div class="col-lg-4">
              <div class="Btnarea">
                <label> <small>{{ totalStockRequest }}</small> Stock Request Pending</label>
                <Link class="btn add-btn" :href="route('shop.create')" >Add New Shop</Link> </div>
            </div>
          </div>
        </div>
        <!-- topBar-->

        <div class="ShopList">
          <ul>
            <li v-for="shop in product.shops" :key="shop.id">
              <div class="ShoplistBox">
                <div class="ShoplistBoxHr">
                  <h2>{{ shop.shop_name }}</h2>
                  <Link :href="route('shop.show',shop.id)" class="Btn position-relative" ><small style="right: -3px;top: -15px;" class="rounded-circle badge badge-danger font-weight-normal p-2 position-absolute">{{ shopStockReqeustSize(shop) }}</small> View Shop</Link>
                </div>
                <div class="ShoplistBoxBody px-0">
                  <ul>
                      <li>
                        <label>Wholesale Rate <span>{{ (product.rate == null) ? 0 : (JSON.parse(product.rate.wholesale_rate).length == 0) ? 0 : toDecimal(JSON.parse(product.rate.wholesale_rate)[0].rate) }} <sup>INR</sup></span></label>
                      </li>
                      <li>
                        <label>Retail Rate <span>{{ (product.rate == null) ? 0 : toDecimal(product.rate.retail_rate) }} <sup>INR</sup></span></label>
                      </li>
                      <li>
                        <label>Sale <span> {{ toDecimal(shop.today_sale) }} <sup>INR</sup></span></label>
                      </li>
                      <li v-if="product.stock">
                        <label>Stock <span> {{ toDecimal(shop.association.stock) +' '+ product.weight_unit }}</span></label>
                      </li>
                  </ul>
                </div>
              </div>
              <!-- ShoplistBox-->
            </li>
          </ul>
        </div>
        <!-- ShopList-->

      </div>
      <!--  main-panel-->
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head , Link } from '@inertiajs/inertia-vue3';
import moment from 'moment';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Link,
    },
    props:['products','shops','product','filterProduct','filterDate'],
    mounted() {
        console.log(this);
    },
    computed:{


      totalStockRequest(){
          let requestsCount = 0;
          //

          let _this  = this;
          _.forEach(this.product.shops, function(s) {
            _.forEach(s.stock_requests,function(r){
                  requestsCount += (r.status != "Completed") ? 1 : 0;
            });
          });
          //
          return  requestsCount;
      }
    },
    methods:{
       shopStockReqeustSize(s){
          let requestsCount = 0;
          _.forEach(s.stock_requests,function(r){
                requestsCount += (r.status != "Completed") ? 1 : 0;
          });
         return  requestsCount;
       },
       filterShop(event){
          this.$inertia.get('/filter/product/shops',
          {
            "id" : this.filterProduct,
            "date" : this.filterDate,
          },
          {
            onSuccess: (response) => {
                window.history.pushState('data', 'Filter Shop', '/shop');
            },
          });
       }
    }
}
</script>
