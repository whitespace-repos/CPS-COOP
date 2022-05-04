<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>

       <div class="main-panel px-2 pt-5 pb-3">
        <div class="container-fluid">
          <!-- <div class="alert alert-danger alert-dismissible fade show" role="alert"> Error message
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
          </div> -->
          <div class="row">
            <div class="col-lg-7 col-md-12 ">
              <div class="ShopDtlsHdr align-self-center justify-content-between mt-3">
                <h6>{{ 'COOP - ' + shop.shop_name }}</h6>
                <h6 class="dueAmount">Due Amount  -  {{ due_amount }} <sup>INR</sup></h6>
                <h6 class="dueAmount">Activate Expense</h6>
                <label class="switch mt-0">
                  <input type="checkbox" checked>
                  <span class="slider round"></span> </label>
              </div>
            </div>
            <div class="col-lg-5 col-md-12 ">
              <div class="Btnarea Btnarea2">
                <select class="selectpicker" title="Assign User" v-model="form.assignEmployee.employee">
                  <template v-for="user in users" :key="user.id">
                    <option  :value="user.id">{{ user.name }}</option>
                  </template>
                </select>
                <button class="btn add-btn" type="button" >Balance Sheet</button>
              </div>
            </div>
          </div>
        </div>

        <!-- topBar-->

        <div class="mt-4">
          <div class="container-fluid">
            <div class="row no-gutters">
              <div class="col-lg-3">
                <div class="card  h-100 rounded-0  ">
                  <div class="ShopAdrs pb-0"> <span class="PhNo  px-5"> <img src="/assets/img/PhIcon.png" alt="" class="img-fluid"/> {{ shop.phone }} </span>
                    <ul class="adrs">
                      <li><span class="ImgDiv"><img src="/assets/img/ShopAdrsIcon1.png" alt="" class="img-fluid"/></span> <span><span>Address:</span> {{ shop.address }}</span></li>
                      <li><span class="ImgDiv"><img src="/assets/img/ShopAdrsIcon2.png" alt="" class="img-fluid"/></span> <span><span>Distance:</span> {{ shop.distance_from_cps }}</span></li>
                      <li><span class="ImgDiv"><img src="/assets/img/ShopAdrsIcon3.png" alt="" class="img-fluid"/></span> <span><span>Dimensive:</span> {{ shop.shop_dimentions }}</span></li>
                      <li><span class="ImgDiv"><img src="/assets/img/ShopAdrsIcon4.png" alt="" class="img-fluid"/></span> <span><span>Max Sale Estimation:</span> {{ shop.max_sale_estimate_per_day }}</span></li>
                      <li><span class="ImgDiv"><img src="/assets/img/ShopAdrsIcon5.png" alt="" class="img-fluid"/></span> <span><span>Max stock capacity:</span> {{ shop.stock_capacity_per_day }}</span></li>
                      <li><span class="ImgDiv"><img src="/assets/img/ShopAdrsIcon6.png" alt="" class="img-fluid"/></span> <span><span>Estimated Start Date:</span> {{ shop.estimated_start_date }}</span></li>
                    </ul>
                  </div>
                  <div class="PrdtPnl">
                    <div class="Hdr">
                      <h3 class="heading">Product</h3>
                      <a data-toggle="modal" href="#Add_Product" class="AddPrdt">+</a> </div>
                      <ul class="Prdt">
                        <li v-for="product in shop.products" :key="product.id">
                              <span class="ImgDiv"><img :src="product.image" alt="" class="img-fluid"/></span> <span>{{ product.product_name }}</span></li>
                      </ul>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="card  h-100 rounded-0  border-left-0 border-right-0">
                  <div class="PnlHdr">
                    <h3>Today's Sales</h3>
                  </div>
                  <div class="d-flex flex-wrap">

                    <!-------- item 1 -------->

                    <div class="item" v-for="product in shop.products" :key="product.id">
                      <div class="ItemWrapper">
                        <div class="itemBox px-5 m-2"> <span class="img"><img :src="product.image" alt="icon" class="img-fluid"></span> <span class="txt">
                          <h3>{{ 0 +' '+ product.weight_unit }}</h3>
                          <p>{{ product.product_name }}</p>
                          </span> </div>
                        <span class="Price">0<sup>INR</sup></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3">
                <div class="card  h-100 rounded-0 ">
                  <div class="PnlHdr">
                    <h3>Current Stock</h3>
                  </div>
                  <ul class="m-2">
                    <li v-for="product in shop.products" :key="product.id">
                      <div class="itemBox mb-2" v-if="product.stock"> <span class="img"><img :src="product.image" alt="icon" class="img-fluid"></span> <span class="txt">
                        <h3>{{ product.association.stock +' '+ product.weight_unit }}</h3>
                        <p>{{ product.product_name }} </p>
                        </span> </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>

            <hr />

            <div class="row no-gutters">
              <div class="col-lg-3">
                <div class="card h-100 rounded-0">
                  <div class="heading">
                    <h5 class="my-3 text-center">Today's Rate</h5>
                    <div class="setRateList text-center  mx-4">
                      <ul>
                        <li>
                          <select class="selectpicker" aria-label="Default select example" data-live-search="false" @change="filterProduct($event.target.value)">
                            <option v-for="product in shop.products" :key="product.id" :value="product.id">{{ product.product_name }}</option>
                          </select>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="BtmRatePnl">
                    <div class="WhlSaleWrapper">
                      <div class="Hdr">
                        <h4>Wholesale:</h4>
                        <span class="AddRate"><a data-toggle="modal" href="#Add_Rate" class="AddRate">+</a></span> </div>
                        <p v-if="productRate.rate != null && productRate.rate != ''">
                          <span class="badge badge-danger font-weight-normal d-block my-1" v-for="range in parseToJSON(productRate.rate.wholesale_rate)" :key="range.id" style="font-size:11px">{{ range.rate }} <sup>INR </sup> {{ ' : ' + range.from +'-'+range.to+' '+ productRate.weight_unit }}</span>
                        </p>
                    </div>
                    <div class="RetailSaleWrapper">
                      <div class="Hdr">
                        <h4>Retail:</h4>
                      </div>
                      <p v-if="productRate.rate != null && productRate.rate != ''">
                        <span class="badge badge-danger font-weight-normal d-block">{{ productRate.rate.retail_rate }} <sup>INR </sup> {{ productRate.weight_unit }}</span>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-9">
                <div class="card border-left-0 rounded-0">
                  <div class="StockPnlHdr">
                    <!-- <label class="StkReqPndng"> <small>01</small> Stock Request Pending</label> -->

                    <!-- Tab Start -->

                    <div class="TabWrapper">
                      <ul class="nav nav-tabs rounded-0">
                        <li class="nav-item"> <a id="StkReq" class="nav-link active p-2" data-toggle="tab" href="#StockRequest">Stock Request</a> </li>
                        <li class="nav-item"> <a id="SndStk" class="nav-link p-2" data-toggle="tab" href="#SendNewStock">Send New Stock</a> </li>
                        <li class="nav-item"> <a id="comStkReq" class="nav-link p-2" data-toggle="tab" href="#ComStockRequest">Completed Requests</a> </li>
                      </ul>
                      <div class="tab-content px-1 py-3">
                        <div id="StockRequest" class="tab-pane active">
                          <div class="container-fluid">
                            <div class="row">
                              <div class="col-md-12" v-for="request in shop.stock_requests" :key="request.id">
                                  <div class="card today_sales mb-4" v-if="request.status != 'Completed'">
                                      <div class="card-header d-flex justify-content-between">
                                          <template v-if="request.status != 'Requested'">
                                            <h6 class="my-2">Status - {{ request.status }}  <small>Actual Payment :{{ request.actual_payment }} <sup>INR</sup></small></h6>
                                          </template>
                                          <template v-else>
                                            <h6 class="my-2">Status - {{ request.status }} </h6>
                                          </template>

                                          <button type="button" data-target="#sendStockConfirmRequest" data-toggle="modal" class="btn btn-primary" v-if="request.status == 'Processing'" @click="openSendConfirmationModal(request.id)">Send</button>
                                          <button type="button" class="btn btn-primary" data-target="#completeStockRequestConfirmationModal" data-toggle="modal" v-if="request.status == 'Received'"  @click="openSendConfirmationModal(request.id)">Completed</button>
                                      </div>
                                      <div class="card-body d-flex  p-0">
                                        <form @submit.prevent="approveStockRequest(request.id)" class="w-100">
                                          <div class="d-flex">
                                            <template  v-for="rp  in request.requested_products" :key="rp.id">
                                              <div class="item  w-25 border-right">
                                                  <div class="itemBox p-2">
                                                      <span class="img mr-2"><img :src="rp.product.image" alt="icon"  class="img-fluid"></span> <span class="">
                                                          <h6 v-if="request.type == 'Direct'">{{ rp.stock_sent +' ' + rp.product.weight_unit }}</h6>
                                                          <h6 v-else>{{ rp.stock_request +' ' + rp.product.weight_unit }}</h6>
                                                          <p>{{ rp.product.product_name }}</p>
                                                          <span  v-if="request.status != 'Requested'">Supply Rate : {{ rp.supply_rate }} <sup>INR</sup> </span>
                                                      </span>
                                                  </div>
                                                  <div class="form-row align-items-center w-75 my-2 ml-1" v-if="request.status == 'Requested'">
                                                    <div class="col-auto">
                                                      <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                          <div class="input-group-text">INR</div>
                                                        </div>
                                                        <input type="number" class="form-control" id="inlineFormInputGroup" placeholder="Supply Rate" v-model="form.approvedStockRequest.supply_rates['product-' + rp.id]" />
                                                      </div>
                                                    </div>
                                                  </div>
                                              </div>
                                            </template>
                                            <button type="submit" class="btn btn-primary mb-2 ml-auto px-5 mx-2 float-right" v-if="request.status == 'Requested'">Confirm</button>
                                          </div>
                                        </form>
                                      </div>
                                      <div class="card-footer bg-white d-flex align-items-center justify-content-between">
                                          <span class="font-weight-semibold">Created At <sub> {{ parseDate(request.created_at) }} </sub></span>
                                      </div>
                                  </div>
                              </div>
                             </div>
                          </div>
                        </div>
                        <div id="ComStockRequest" class="tab-pane">
                          <div class="container-fluid">
                            <div class="row">
                              <div class="col-md-12" v-for="request in shop.stock_requests" :key="request.id">
                                  <div class="card today_sales mb-4" v-if="request.status == 'Completed'">
                                      <div class="card-header d-flex justify-content-between">
                                          <h6 class="my-2">Status - {{ request.status }}  <small>Actual Payment :{{ request.actual_payment }} <sup>INR</sup>, Receive Payment : {{ request.payment_received }} <sup>INR</sup></small></h6>
                                          <button type="button" data-target="#sendStockConfirmRequest" data-toggle="modal" class="btn btn-primary" v-if="request.status == 'Processing'" @click="openSendConfirmationModal(request.id)">Send</button>
                                          <button type="button" class="btn btn-primary" data-target="#completeStockRequestConfirmationModal" data-toggle="modal" v-if="request.status == 'Received'"  @click="openSendConfirmationModal(request.id)">Completed</button>
                                      </div>
                                      <div class="card-body d-flex  p-0">
                                        <form @submit.prevent="approveStockRequest(request.id)" class="w-100 d-flex">
                                          <template  v-for="rp  in request.requested_products" :key="rp.id">
                                            <div class="item">
                                                <div class="itemBox p-2">
                                                    <span class="img mr-2"><img :src="rp.product.image" alt="icon" class="img-fluid"></span> <span class="">
                                                        <h6 v-if="request.type == 'Direct'">{{ rp.stock_sent +' ' + rp.product.weight_unit }}</h6>
                                                        <h6 v-else>{{ rp.stock_request +' ' + rp.product.weight_unit }}</h6>
                                                        <p>{{ rp.product.product_name }}</p>
                                                        <span  v-if="request.status != 'Requested'">Supply Rate : {{ rp.supply_rate }} <sup>INR</sup> </span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-row align-items-center w-75 my-2 ml-1" v-if="request.status == 'Requested'">
                                              <div class="col-auto">
                                                <div class="input-group mb-2">
                                                  <div class="input-group-prepend">
                                                    <div class="input-group-text">INR</div>
                                                  </div>
                                                  <input type="number" class="form-control" id="inlineFormInputGroup" placeholder="Supply Rate" v-model="form.approvedStockRequest.supply_rates['product-' + rp.id]" />
                                                </div>
                                              </div>
                                            </div>
                                          </template>
                                          <button type="submit" class="btn btn-primary mb-2 ml-auto px-5 mx-2 float-right" v-if="request.status == 'Requested'">Confirm</button>
                                        </form>
                                      </div>
                                      <div class="card-footer bg-white d-flex align-items-center justify-content-between">
                                          <span class="font-weight-semibold">Created At <sub> {{ parseDate(request.created_at) }} </sub></span>
                                      </div>
                                  </div>
                              </div>
                             </div>
                          </div>
                        </div>
                        <div id="SendNewStock" class="tab-pane fade">
                          <form method="POST" @submit.prevent="directStockRequest">
                          <button class="btn btn-primary  px-5" type="submit">Confirm</button>
                          <label class="ml-5"> Total Price : {{ calculateTotalPrice }} <sup>INR </sup></label>
                            <hr />
                          <div class="modal-body StockFRm">

                            <div class="setRateList">

                              <ul class="Frm">
                                <template v-for="product in shop.products" :key="product.id">
                                    <template v-if="product.stock">
                                      <li>
                                        <div class="itemBox flex-column"> <span class="img"><img :src="product.image" alt="icon" class="img-fluid"></span> <span class="txt">
                                            <h3>{{ product.association.stock +' '+ product.weight_unit }}</h3>
                                            <p>{{ product.product_name }}</p>
                                            </span>
                                            <div class="d-flex" >
                                              <label>
                                                <small>Request Quantity</small>
                                                <input type="text" class="form-control" @input="calculateSupplyRate($event,product.id)" placeholder="0" v-model="form.directStockRequest.products['product-'+product.id]" />
                                              </label>
                                              <label>
                                                <small>Supply Rate </small>
                                                <input type="text" class="form-control" @input="calculateSupplyRate($event,product.id)" placeholder="0" v-model="form.directStockRequest.products['product-'+product.id+'-supply-rate']" />
                                              </label>
                                            </div>
                                            <p>{{ form.directStockRequest.products['product-'+product.id+'-total-price'] }} <sup>INR</sup></p>
                                        </div>
                                      </li>
                                    </template>
                                </template>
                              </ul>
                            </div>
                          </div>
                          </form>
                        </div>

                      </div>
                    </div>

                    <!-- Tab End -->

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal CmnModal" id="sendStockConfirmRequest">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal"><img src="/assets/img/cross_btn.png" alt=""></button>

            <!-- Modal body -->

            <div class="modal-body">
              <h6 class="mb-4">Confirm and Modify Stock Detail </h6>
              <form method="POST" @submit.prevent="sendStockToShop(selectedRequest.id)" >
              <table class="table table-bordered">
                <thead>
                  <tr>
                      <th>#</th>
                      <th>Product</th>
                      <th>Requested</th>
                      <th>Send</th>
                  </tr>
                </thead>
                <tbody>
                    <template v-if="isNotEmpty(selectedRequest)">
                    <!--  -->
                    <tr v-for="rp in selectedRequest.requested_products" :key="rp.id">
                        <td>{{ rp.id }} </td>
                        <td>{{ rp.product.product_name }}</td>
                        <td>{{ rp.stock_request + ' ' + rp.product.weight_unit }} </td>
                        <td width="180">
                          <div class="input-group mb-2">
                            <input type="number" class="form-control" id="inlineFormInputGroup" placeholder="Stock Send" v-model="form.sendStock.send_stocks['product-' + rp.id]"/>
                            <div class="input-group-prepend">
                              <div class="input-group-text">{{ rp.product.weight_unit }}</div>
                            </div>
                          </div>
                        </td>
                    </tr>
                    </template>
                </tbody>
              </table>
              <button type="submit" class="btn btn-primary ml-auto">Send Stock To Shop</button>
            </form>
            </div>

          </div>
        </div>
      </div>

      <div class="modal CmnModal" id="completeStockRequestConfirmationModal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal"><img src="/assets/img/cross_btn.png" alt=""></button>

            <!-- Modal body -->

            <div class="modal-body">
              <template v-if="isNotEmpty(selectedRequest)">
                <h6 class="mb-4">Review Stock Detail  <small>Actual Payment : {{ selectedRequest.actual_payment }} <sup>INR</sup></small></h6>

                <table class="table table-bordered">
                  <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Requested</th>
                        <th>Send</th>
                        <th>Received</th>
                        <th>Wastage</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="rp in selectedRequest.requested_products" :key="rp.id">
                        <td>{{ rp.id }} </td>
                        <td>{{ rp.product.product_name }}</td>
                        <td>{{ rp.stock_request + ' ' + rp.product.weight_unit }} </td>
                        <td>{{ rp.stock_sent + ' ' + rp.product.weight_unit }}</td>
                        <td>{{ rp.stock_received + ' ' + rp.product.weight_unit }}</td>
                        <td>{{ rp.stock_wastage + ' ' + rp.product.weight_unit }}</td>
                    </tr>
                  </tbody>
                </table>
                <div class="form-group w-25 float-left mr-4">
                  <label>Received Amount </label>
                  <input v-model="receiveStockPayment" class="form-control" placeholder="Receive Amount"/>
                </div>
                <button @click="completeStockRequest(selectedRequest.id)" class="btn btn-primary p-3 mt-3">I , Yes Reviewed</button>
              </template>
            </div>

          </div>
        </div>
      </div>


      <!--  main-panel-->
      <div class="modal CmnModal" id="Add_Product">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal"><img src="/assets/img/cross_btn.png" alt=""></button>

            <!-- Modal body -->

            <div class="modal-body">
              <div class="SetRate">
                <h3>Add New Product</h3>
                <div class="ShopFrm">
                  <form method="POST" @submit.prevent="addProductsToShop">
                    <ul>
                      <li>
                        <label>Select Product</label>
                        <select class="selectpicker" multiple aria-label="Default select example" data-live-search="false" id="style-3" v-model="form.addProduct.products">
                          <option v-for="product in products" :key="product.id" :value="product.id">{{ product.product_name }}</option>
                        </select>
                      </li>
                      <li>
                        <button class="btn btn-primary add-btn" type="submit" >Add Product</button>
                      </li>
                    </ul>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </BreezeAuthenticatedLayout>
</template>
<script type="text/javascript">
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';
import moment from 'moment'
import Button from '@/Components/Button.vue';
import _ from 'lodash'
import { Inertia } from '@inertiajs/inertia'
import Input from '@/Components/Input.vue';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Button,
        Input,
    },
    props:['products','shop','users','due_amount'],
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
                                          products:[]
                        }),
                        assignEmployee:this.$inertia.form({ employee : '' }),
                        addProduct:this.$inertia.form({
                                  products:[]
                        }),
                        approvedStockRequest:this.$inertia.form({
                                  supply_rates:{}
                        }),
                        sendStock:this.$inertia.form({
                                  send_stocks:{}
                        }),
                        directStockRequest:this.$inertia.form({
                                  products:{},
                                  actual_payment:0,
                                  shop_id:'',
                        })
                  },
                  selectedRequest:null,
                  receiveStockPayment:0,
                  productRate:{},

        }
    },
    mounted (){
      var _this = this;
      $.each(this.shop.products,function(i,e){
        _this.form.addProduct.products.push(e.id);
      });
      $('select').selectpicker();
      //

      this.form.assignEmployee.employee = this.isEmpty(this.shop.employee) ? '' : this.shop.employee.id;
      setTimeout(function(){
        $('select').selectpicker('refresh');
      },1000);

      _.forEach(this.shop.products,function(e,i){
          _this.form.directStockRequest.products['product-'+e.id+'-total-price'] = 0;
      })

      //
      this.productRate = _.head(this.products);
    },
    computed:{
       calculateTotalPrice:function(){
         let directStockTotalCost = 0;
         var _this = this;
          _.forEach(this.shop.products,function(e,i){
              directStockTotalCost += _this.form.directStockRequest.products['product-'+e.id+'-total-price'];
          })

          return directStockTotalCost;
       }
    },
    methods: {
        openSendConfirmationModal(id){
          this.selectedRequest = _.head(_.filter(this.shop.stock_requests, ['id', id]));

          var _this = this;
          this.receiveStockPayment = this.selectedRequest.actual_payment;
          _.forEach(this.selectedRequest.requested_products, function(rp) {
            _this.form.sendStock.send_stocks['product-' + rp.id] = rp.stock_request;
          });

        },
        completeStockRequest(id){
          Inertia.post(this.route('completed.stock',id),{"payment_received":this.receiveStockPayment},{
              onSuccess: (page) => {
                $("#completeStockRequestConfirmationModal").modal("hide");
              }
          })
        },
        addProductsToShop() {
            this.form.addProduct.patch(this.route('shop.update',this.shop.id), {
                onSuccess: (response) => {
                                    this.form.addProduct.reset();
                                    $("#Add_Product").modal("hide");
                                    $('select').selectpicker('refresh');
                },
            })
        },
        approveStockRequest(id) {
            this.form.approvedStockRequest.post(this.route('approve.stock.approved',id), {
                onSuccess: (response) => {
                                    this.form.approvedStockRequest.reset('supply_rate');
                },
            })
        },
        sendStockToShop(id) {
            this.form.sendStock.post(this.route('send.stock',id), {
                onSuccess: (response) => {
                                    this.form.sendStock.reset();
                                    $("#sendStockConfirmRequest").modal("hide");
                },
            })
        },
        directStockRequest(){
            this.form.directStockRequest.actual_payment = this.calculateTotalPrice;
            this.form.directStockRequest.shop_id = this.shop.id;
            this.form.directStockRequest.post(this.route('direct.requested'),{
               onSuccess:(response) => {
                                     this.form.directStockRequest.products = {};
                },
            })
        },
        parseDate:function(date) {
          return moment(date).format("ddd, MMM Do YYYY, h:mm:ss a");
        },
        isEmpty:function(o){
          return _.isNil(o);
        },
        isNotEmpty:function(o){
          return !_.isNil(o);
        },
        calculateSupplyRate:function(e,id){
          let _this = this;
          let weight = _.isNaN(parseFloat(_this.form.directStockRequest.products['product-'+id])) ? 0 : parseFloat(this.form.directStockRequest.products['product-'+id]);
          let supplyRate = _.isNaN(parseFloat(_this.form.directStockRequest.products['product-'+id+'-supply-rate'])) ? 0 : parseFloat(this.form.directStockRequest.products['product-'+id+'-supply-rate']);
          let total = weight * supplyRate;
          this.form.directStockRequest.products['product-'+id+'-total-price'] = total;
        },
        parseToJSON(data){
          return JSON.parse(data);
        },
        filterProduct(id){
          let url = this.route('filter.product',id);
          let _this = this;
          //
          $.get(url,function(response){
            _this.productRate = response.productRate;
          })
        }
    }
}
</script>
