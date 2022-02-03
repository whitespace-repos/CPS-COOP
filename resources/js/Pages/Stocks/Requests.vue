<template>
    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout>
        <section>
            <div class="BodyTop">
                <div class="row">
                    <div class="col" v-for="request in shop.stock_requests" :key="request.id">                     
                        <div class="card today_sales">
                            <div class="card-header CS_header">
                                <h6 class="my-2">Status - {{ request.status }}    <sub> on {{ parseDate(request.created_at) }} </sub> </h6> 
                            </div>
                            <div class="card-body d-flex  p-0">
                                <div class="item" v-for="rp  in request.requested_products" :key="rp.id">
                                    <div class="itemBox pb-4 pt-4">
                                        <span class="img mr-2 my-2"><img :src="rp.product.image" alt="icon"></span> <span class="">
                                            <h6>{{ rp.stock_request +' ' + rp.product.weight_unit }}</h6>
                                            <p>{{ rp.product.product_name }}</p>
                                        </span> 
                                    </div>
                                </div>               
                            </div>
                        </div>
                    </div>            
                </div>      
            </div>     
        </section>
    </BreezeAuthenticatedLayout>
</template>

<script>          
import { SplitCarousel, SplitCarouselItem } from  'vue-split-carousel'
import BreezeAuthenticatedLayout from '@/Layouts/BillingSystem.vue'
import { Head } from '@inertiajs/inertia-vue3'
import _ from 'lodash';
import moment from 'moment'


export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        SplitCarousel,
        SplitCarouselItem
    },
    props:['products','shop','carts'],
    data () {
      return {}
    } ,
    methods:{
      parseDate:function(date) {
         return moment(date).format("ddd, MMM Do YYYY, h:mm:ss a");
      }
   }

}
</script>

<style scoped>
  .today_sales .item:last-child > .itemBox{
    border-right:none !important;
  }
</style>

