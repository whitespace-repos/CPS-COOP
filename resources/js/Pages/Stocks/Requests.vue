<template>
    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout>
        <section>
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="#" class="Btn mx-2 btn btn-outline-info btn-xs" data-toggle="modal" data-target="#myModal"> New Stock Request </a>
                    <Link :href="route('make-sale')" class="heading text-danger">
                        Return Back
                    </Link>
                </div>

                <hr />

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="pending-link" data-toggle="pill" href="#pending" role="tab" aria-controls="pills-pending" aria-selected="false">Pending Stock Request</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="completed-link" data-toggle="pill" href="#completed" role="tab" aria-controls="pills-completed" aria-selected="false">Completed Stock Request</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pills-pending-tab">
                        <div class="col-md-12" v-for="request in shop.stock_requests.filter((item) => {  return item.status != 'Completed' })" :key="request.id">
                            <div class="card today_sales mb-4">
                                <div class="card-header d-flex justify-content-between py-1">
                                    <h6 class="my-2">Status - {{ request.status }}    <sub> on {{ parseDate(request.updated_at) }} </sub> <small v-if="request.status != 'Requested'" class="ml-4">Actual Payment : {{ toDecimal(request.actual_payment) }} <sup>INR</sup></small> <small v-if="request.status == 'Completed'" class="ml-3"> Receive Payment : {{ toDecimal(request.payment_received) }} <sup>INR</sup> </small></h6>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#receiveStockConfirmModal" @click="openReceiveConfirmationModal(request.id)" v-if="request.status == 'Sent'">Receive Stock </button>
                                </div>
                                <div class="card-body d-flex  p-0">
                                    <div class="item" v-for="rp  in request.requested_products" :key="rp.id">
                                        <div class="itemBox">
                                            <span class="img w-25 h-25 mr-4"><img :src="rp.product.image" alt="icon"  class="img-fluid"></span>
                                            <span class="font-weight-bold">
                                                <h6 class="mb-0">{{ toDecimal(rp.stock_request) +' ' + rp.product.weight_unit }}</h6>
                                                <small class="d-block">{{ rp.product.product_name }}</small>
                                                <label class="small d-block mb-0 mt-1"> Supply Rate </label>
                                                <span  v-if="request.status != 'Requested'" class="small">{{ toDecimal(rp.supply_rate) }} <sup>INR</sup> / {{ rp.product.weight_unit }} </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-white d-flex align-items-center justify-content-between">
                                    <form v-if="request.status == 'Approved'" @submit.prevent="savePaymentOptionForStockRequest(request.id)">
                                        <div class="form-row align-items-center">
                                            <div class="col-auto">
                                                <label class="" for="inlineFormInputGroup">Choose Payment Method</label>
                                                <select class="custom-select" v-model="form.paymentOptions.payment_method">
                                                    <option value="Pay When Stock Received">Pay When Stock Received</option>
                                                    <option value="Pay After Sales Completed">Pay After Sales Completed</option>
                                                </select>
                                            </div>
                                            <div class="col-auto mt-auto">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                    <span class="font-weight-semibold">Created At <sub> {{ parseDate(request.created_at) }} </sub></span>
                                </div>
                            </div>
                        </div>
                        <div v-if="shop.stock_requests.filter((item) => {  return item.status != 'Completed' }).length == 0">
                            <div class="alert alert-warning" role="alert">
                                    No Record Found !
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="pills-completed-tab">
                        <div class="col-md-12" v-for="request in shop.stock_requests.filter((item) => {  return item.status == 'Completed' })" :key="request.id">
                            <div class="card today_sales mb-4">
                                <div class="card-header d-flex justify-content-between py-1">
                                    <h6 class="my-2">Status - {{ request.status }}    <sub> on {{ parseDate(request.updated_at) }} </sub> <small v-if="request.status != 'Requested'" class="ml-4">Actual Payment : {{ toDecimal(request.actual_payment) }} <sup>INR</sup></small> <small v-if="request.status == 'Completed'" class="ml-3"> Receive Payment : {{ toDecimal(request.payment_received) }} <sup>INR</sup> </small></h6>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#receiveStockConfirmModal" @click="openReceiveConfirmationModal(request.id)" v-if="request.status == 'Sent'">Receive Stock </button>
                                </div>
                                <div class="card-body d-flex  p-0">
                                    <div class="item" v-for="rp  in request.requested_products" :key="rp.id">
                                        <div class="itemBox">
                                            <span class="img w-25 h-25 mr-4"><img :src="rp.product.image" alt="icon"  class="img-fluid"></span>
                                            <span class="font-weight-bold">
                                                <h6 class="mb-0">{{ toDecimal(rp.stock_request) +' ' + rp.product.weight_unit }}</h6>
                                                <small class="d-block">{{ rp.product.product_name }}</small>
                                                <label class="small d-block mb-0 mt-1"> Supply Rate </label>
                                                <span  v-if="request.status != 'Requested'" class="small">{{ toDecimal(rp.supply_rate) }} <sup>INR</sup> / {{ rp.product.weight_unit }} </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-white d-flex align-items-center justify-content-between">
                                    <form v-if="request.status == 'Approved'" @submit.prevent="savePaymentOptionForStockRequest(request.id)">
                                        <div class="form-row align-items-center">
                                            <div class="col-auto">
                                                <label class="" for="inlineFormInputGroup">Choose Payment Method</label>
                                                <select class="custom-select" v-model="form.paymentOptions.payment_method">
                                                    <option value="Pay When Stock Received">Pay When Stock Received</option>
                                                    <option value="Pay After Sales Completed">Pay After Sales Completed</option>
                                                </select>
                                            </div>
                                            <div class="col-auto mt-auto">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                    <span class="font-weight-semibold">Created At <sub> {{ parseDate(request.created_at) }} </sub></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                </div>
            </div>
        </section>

        <div class="modal CmnModal" id="receiveStockConfirmModal">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal"><img src="/assets/img/cross_btn.png" alt=""  class="img-fluid"></button>

                <!-- Modal body -->

                <div class="modal-body">
                    <template v-if="isNotEmpty(selectedRequest)">
                <h6 class="mb-4">Confirm and Modify Stock Detail <small>Actual Payment : <sub>{{ selectedRequest.actual_payment }} </sub> </small></h6>
                <form method="POST" @submit.prevent="ReceiveStockOnShop(selectedRequest.id)" >
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Requested</th>
                        <th>Sent</th>
                        <th>Received</th>
                    </tr>
                    </thead>
                    <tbody>

                        <!--  -->
                        <tr v-for="rp in selectedRequest.requested_products" :key="rp.id">
                            <td>{{ rp.id }} </td>
                            <td>{{ rp.product.product_name }}</td>
                            <td>{{ toDecimal(rp.stock_request) + ' ' + rp.product.weight_unit }} </td>
                            <td>{{ toDecimal(rp.stock_sent) + ' ' + rp.product.weight_unit}}</td>
                            <td width="160">
                                <div class="input-group mb-2">
                                    <input type="number" class="form-control" id="inlineFormInputGroup" placeholder="Stock Receive" v-model="form.receiveStock.receive_stocks['product-' + rp.id]"/>
                                    <div class="input-group-prepend">
                                    <div class="input-group-text">{{ rp.product.weight_unit }}</div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary ml-auto">Yes ,I Confirm Receive Stock</button>
                </form>
                </template>
                </div>

            </div>
            </div>
        </div>

        <!-- The Modal -->
        <div class="modal" id="myModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="POST" @submit.prevent="sendStockRequest">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Request Stock</h4>
                            <button type="button" class="close" data-dismiss="modal"><img src="/assets/img/cross_btn.png" alt=""></button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body d-flex">
                            <div class="poupDiv">
                                <ul>
                                    <template v-for="product in shop.products" :key="product.id">
                                        <li v-if="product.stock">
                                            <div class="itemBox"> <span class="img"><img :src="product.image" alt="icon" class="img-fluid"></span> <span class="txt">
                                                <h3>{{ toDecimal(product.association.stock) +''+ product.weight_unit }}</h3>
                                                <p>{{ product.product_name }}</p>
                                                </span>
                                            </div>
                                            <div class="input-group" >
                                                <input type="text" class="form-control" placeholder="0" v-model="form.stockRequest.products['product-'+product.id]" />
                                                <div class="input-group-append">
                                                <smll class="input-group-text">{{ product.weight_unit }}</smll>
                                                </div>
                                            </div>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="submit" class="btn">Stock Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/BillingSystem.vue'
import { Head } from '@inertiajs/inertia-vue3'
import _ from 'lodash';
import moment from 'moment'
import { Link } from '@inertiajs/inertia-vue3';


export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Link
    },
    props:['products','shop','carts'],
    data () {
      return {
                form:{
                    paymentOptions:this.$inertia.form({
                                                payment_method:'Pay When Stock Received'
                    }),
                    receiveStock:this.$inertia.form({
                                receive_stocks:{}
                    }),
                    stockRequest : this
                                .$inertia
                                .form({
                                    products : {},
                    })
                },
                selectedRequest:null
      }
    } ,
    methods:{
        openReceiveConfirmationModal(id){
          this.selectedRequest = _.head(_.filter(this.shop.stock_requests, ['id', id]));
          var _this = this;
          _.forEach(this.selectedRequest.requested_products, function(rp) {
            _this.form.receiveStock.receive_stocks['product-' + rp.id] = rp.stock_sent;
          });
        },
        parseDate:function(date) {
            return moment(date).format("ddd, MMM Do YYYY, h:mm:ss a");
        },
        savePaymentOptionForStockRequest(id){
                this.form.paymentOptions.post(this.route('stock.request.payment.option',id), {
                    onSuccess: (response) => {
                                        this.form.paymentOptions.reset('payment_method');
                    },
                })
        },
        ReceiveStockOnShop(id){
            this.form.receiveStock.post(this.route('received.stock',id), {
                onSuccess: (response) => {
                                    this.form.receiveStock.reset();
                                    $("#receiveStockConfirmModal").modal("hide");
                },
            })
        },
        isEmpty:function(o){
          return _.isNil(o);
        },
        isNotEmpty:function(o){
          return !_.isNil(o);
        },
        sendStockRequest(event) {
            this.form.stockRequest.post(this.route('stock.request.submit'), {
                    onSuccess: (response) => {
                            $("#myModal").modal("hide");
                            this.form.stockRequest.products = [];
                            window.history.pushState('data', 'Add to Cart', '/make-sale');
                    }
            });
        }
   }

}
</script>

<style scoped>
  .today_sales .item:last-child > .itemBox{
    border-right:none !important;
  }
</style>
