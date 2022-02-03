<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>          
      
       <div class="main-panel">
        <div class="topBar">
          <div class="alert alert-danger alert-dismissible fade show" role="alert"> Error message
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
          </div>
          <div class="row">
            <div class="col-lg-7 col-md-12 ">
              <div class="ShopDtlsHdr">
                <h3>{{ 'COOP - ' + shop.shop_name }}</h3>
                <h3 class="dueAmount">Due Amount  -  12000<sup>INR</sup></h3>
                <h3 class="dueAmount">Activate Expense</h3>
                <label class="switch">
                  <input type="checkbox" checked>
                  <span class="slider round"></span> </label>
              </div>
            </div>
            <div class="col-lg-5 col-md-12 ">
              <div class="Btnarea Btnarea2">
                <select class="selectpicker" title="Assign User" aria-label="Default select example" data-live-search="false" id="AssignUser">
                  <option value="">Sumit Ghosh (980698969)</option>
                  <option value="">Arijit Biswas (854589666)</option>
                  <option value="">Manish Bhattacharya (728963698)</option>
                  <option value="">Sumon Das (8582952962)</option>
                  <option value="">Moloy Roy (6291875689)</option>
                  <option value="">Sumit Agarwal (646449797)</option>
                </select>
                <button class="btn add-btn" type="button" >Balance Sheet</button>
              </div>
            </div>
          </div>
        </div>
        
        <!-- topBar-->
        
        <div class="BodyBottom">
          <div class="WrapperDiv">
            <div class="row TopDiv">
              <div class="col-lg-3">
                <div class="customer_info">
                  <div class="ShopAdrs pb-0"> <span class="PhNo"> <img src="/assets/img/PhIcon.png" alt=""/> +91-888-888-8888 </span>
                    <ul class="adrs">
                      <li><span class="ImgDiv"><img src="/assets/img/ShopAdrsIcon1.png" alt=""/></span> <span><span>Address:</span> {{ shop.address }}</span></li>
                      <li><span class="ImgDiv"><img src="/assets/img/ShopAdrsIcon2.png" alt=""/></span> <span><span>Distance:</span> {{ shop.distance_from_cps }}</span></li>
                      <li><span class="ImgDiv"><img src="/assets/img/ShopAdrsIcon3.png" alt=""/></span> <span><span>Dimensive:</span> {{ shop.shop_dimentions }}</span></li>
                      <li><span class="ImgDiv"><img src="/assets/img/ShopAdrsIcon4.png" alt=""/></span> <span><span>Max Sale Estimation:</span> {{ shop.max_sale_estimate_per_day }}</span></li>
                      <li><span class="ImgDiv"><img src="/assets/img/ShopAdrsIcon5.png" alt=""/></span> <span><span>Max stock capacity:</span> {{ shop.stock_capacity_per_day }}</span></li>
                      <li><span class="ImgDiv"><img src="/assets/img/ShopAdrsIcon6.png" alt=""/></span> <span><span>Estimated Start Date:</span> {{ shop.estimated_start_date }}</span></li>
                    </ul>
                  </div>
                  <div class="PrdtPnl">
                    <div class="Hdr">
                      <h3>Product</h3>
                      <a data-toggle="modal" href="#Add_Product" class="AddPrdt">+</a> </div>
                      <ul class="Prdt">
                        <li v-for="product in shop.products" :key="product.id">
                              <span class="ImgDiv"><img :src="product.image" alt=""/></span> <span>{{ product.product_name }}</span></li>
                      </ul>
                  </div>
                </div>
              </div>
              <div class="col-lg-7">
                <div class="customer_info overflow-hidden">
                  <div class="PnlHdr">
                    <h3>Today's Sales</h3>
                  </div>
                  <div class="d-flex flex-wrap"> 
                    
                    <!-------- item 1 -------->
                    
                    <div class="item" v-for="product in shop.products" :key="product.id">
                      <div class="ItemWrapper">
                        <div class="itemBox px-5 m-2"> <span class="img"><img :src="product.image" alt="icon"></span> <span class="txt">
                          <h3>{{ 0 +' '+ product.weight_unit }}</h3>
                          <p>{{ product.product_name }}</p>
                          </span> </div>
                        <span class="Price">0<sup>INR</sup></span> 
                      </div>                  
                    </div>                    
                  </div>
                </div>
              </div>
              <div class="col-lg-2">
                <div class="customer_info">
                  <div class="PnlHdr">
                    <h3>Current Stock</h3>
                  </div>
                  <ul class="CurrentStock">
                    <li v-for="product in shop.products" :key="product.id">
                      <div class="itemBox" v-if="product.stock"> <span class="img"><img :src="product.image" alt="icon"></span> <span class="txt">
                        <h3>{{ product.association.stock +' '+ product.weight_unit }}</h3>
                        <p>{{ product.product_name }} </p>
                        </span> </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3">
                <div class="customer_info  overflow-hidden">
                  <div class="PnlHdr TodayRate">
                    <h3>Today's Rate</h3>
                    <div class="setRateList">
                      <ul>
                        <li>
                          <select class="selectpicker" aria-label="Default select example" data-live-search="false">
                            <option value="Broiler">Broiler Live</option>
                            <option value="Eggs">Eggs</option>
                            <option value="Layer">Layer Live</option>
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
                      <ul>
                        <li>
                          <div class="Lft"> <span class="EditField">
                            <input class="" name="" type="text" value="125">
                            <label>125<sup>INR</sup></label>
                            </span> <span class="Wgt">10-15kg</span> </div>
                          <div class="Rht"> <a href="javascript:void(0);" class="EditRate"><img src="/assets/img/EditIcon.png" alt=""/></a> <a href="javascript:void(0);" class="SaveRate"><img src="img/SaveIcon.png" alt=""/></a> <a href="javascript:void(0);" class="DelRate"><img src="img/DelIcon.png" alt=""/></a> </div>
                        </li>
                        <li>
                          <div class="Lft"> <span class="EditField">
                            <input class="" name="" type="text" value="120">
                            <label>120<sup>INR</sup></label>
                            </span> <span class="Wgt">16-20kg</span> </div>
                          <div class="Rht"> <a href="javascript:void(0);" class="EditRate"><img src="/assets/img/EditIcon.png" alt=""/></a> <a href="javascript:void(0);" class="SaveRate"><img src="img/SaveIcon.png" alt=""/></a> <a href="javascript:void(0);" class="DelRate"><img src="img/DelIcon.png" alt=""/></a> </div>
                        </li>
                        <li>
                          <div class="Lft"> <span class="EditField">
                            <input class="" name="" type="text" value="115">
                            <label>115<sup>INR</sup></label>
                            </span> <span class="Wgt">21-25kg</span> </div>
                          <div class="Rht"> <a href="javascript:void(0);" class="EditRate"><img src="/assets/img/EditIcon.png" alt=""/></a> <a href="javascript:void(0);" class="SaveRate"><img src="img/SaveIcon.png" alt=""/></a> <a href="javascript:void(0);" class="DelRate"><img src="img/DelIcon.png" alt=""/></a> </div>
                        </li>
                      </ul>
                    </div>
                    <div class="RetailSaleWrapper">
                      <div class="Hdr">
                        <h4>Retail:</h4>
                      </div>
                      <ul class="Retl">
                        <li>
                          <label>140<sup>INR</sup></label>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-9">
                <div class="customer_info">
                  <div class="StockPnlHdr">
                    <label class="StkReqPndng"> <small>01</small> Stock Request Pending</label>
                    
                    <!-- Tab Start -->
                    
                    <div class="TabWrapper">
                      <ul class="nav nav-tabs">
                        <li class="nav-item"> <a id="StkReq" class="nav-link active" data-toggle="tab" href="#StockRequest">Stock Request</a> </li>
                        <li class="nav-item"> <a id="SndStk" class="nav-link" data-toggle="tab" href="#SendNewStock">Send New Stock</a> </li>
                      </ul>
                      <div class="tab-content">
                        <div id="StockRequest" class="tab-pane active">
                          <ul class="StkReq">
                            <li>
                              <div class="itemBox"> <span class="img"><img src="/assets/img/hean.png" alt="icon"></span> <span class="txt">
                                <h3>243 kg</h3>
                                <p>Broiler Live</p>
                                </span> <span class="txt"> <a href="javascript:void(0);" class="snd" id="notiSend">Send</a> </span> <span class="Notify"> <a href="#" class="NotiFyNo">01</a> </span> </div>
                            </li>
                            <li>
                              <div class="itemBox"> <span class="img"><img src="/assets/img/egg.png" alt="icon"></span> <span class="txt">
                                <h3>3500 Nr.</h3>
                                <p>Eggs</p>
                                </span><span class="txt">
                                <div class="Pcs"><img src="/assets/img/ProcessIcon.png" alt="icon">
                                  <p>Process</p>
                                </div>
                                </span> </div>
                            </li>
                            <li>
                              <div class="itemBox"> <span class="img"><img src="/assets/img/hean1.png" alt="icon"></span> <span class="txt">
                                <h3>243 kg</h3>
                                <p>Layer Live</p>
                                </span> <span class="txt"> <a href="javascript:void(0);" class="snd">Send</a> </span> </div>
                            </li>
                          </ul>
                        </div>
                        <div id="SendNewStock" class="tab-pane fade">
                          <div class="modal-body StockFRm">
                            <div class="setRateList">
                              <ul class="Frm">
                                <li>
                                  <label>Select Shop</label>
                                  <select class="selectpicker" aria-label="Default select example" data-live-search="false">
                                    <option value="">Coop - Bhuvan-1</option>
                                    <option value="">Coop - Bhuvan-2</option>
                                    <option value="">Coop - Bhuvan-3</option>
                                    <option value="">Coop - Bhuvan-1</option>
                                    <option value="">Coop - Bhuvan-2</option>
                                    <option value="">Coop - Bhuvan-3</option>
                                    <option value="">Coop - Bhuvan-1</option>
                                    <option value="">Coop - Bhuvan-2</option>
                                    <option value="">Coop - Bhuvan-3</option>
                                    <option value="">Coop - Bhuvan-1</option>
                                    <option value="">Coop - Bhuvan-2</option>
                                    <option value="">Coop - Bhuvan-3</option>
                                    <option value="">Coop - Bhuvan-1</option>
                                    <option value="">Coop - Bhuvan-2</option>
                                    <option value="">Coop - Bhuvan-3</option>
                                    <option value="">Coop - Bhuvan-1</option>
                                    <option value="">Coop - Bhuvan-2</option>
                                    <option value="">Coop - Bhuvan-3</option>
                                    <option value="">Coop - Bhuvan-1</option>
                                    <option value="">Coop - Bhuvan-2</option>
                                    <option value="">Coop - Bhuvan-3</option>
                                    <option value="">Coop - Bhuvan-1</option>
                                    <option value="">Coop - Bhuvan-2</option>
                                    <option value="">Coop - Bhuvan-3</option>
                                    
                                  </select>
                                </li>
                                <li>
                                  <label>Products</label>
                                  <select class="selectpicker" aria-label="Default select example" data-live-search="false">
                                    <option value="Broiler">Broiler Live</option>
                                    <option value="Eggs">Eggs</option>
                                    <option value="Layer">Layer Live</option>
                                  </select>
                                </li>
                                <li>
                                  <label>Supplier Rate</label>
                                  <input type="text" placeholder="0" class="form-control">
                                </li>
                                <li>
                                  <label>Amount</label>
                                  <input type="text" placeholder="0" class="form-control">
                                </li>
                                <li>
                                  <label>Comfirm</label>
                                  <button class="btn btn-primary add-btn" type="button">Confirm</button>
                                </li>
                              </ul>
                            </div>
                          </div>
                          <div class="modal-body NotiFRm">
                            <div class="setRateList">
                              <ul class="Frm">
                                <li>
                                  <label>Products</label>
                                  <h5>Broiler Live</h5>
                                </li>
                                <li>
                                  <label>Requested Qty</label>
                                  <h5>300Kg</h5>
                                </li>
                                <li>
                                  <label>Supplier Rate</label>
                                  <input type="text" placeholder="0" class="form-control">
                                </li>
                                <li>
                                  <label>Amount</label>
                                  <input type="text" placeholder="0" class="form-control">
                                </li>
                                <li>
                                  <label>Comfirm</label>
                                  <button class="btn btn-primary add-btn" type="button">Confirm</button>
                                </li>
                              </ul>
                            </div>
                          </div>
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

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
    },
    props:['products','shop'],
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
                        addProduct:this.$inertia.form({
                                  products:[]
                        })
                  }
                 
        }
    },
    mounted (){
      var _this = this;
      $.each(this.shop.products,function(i,e){
        _this.form.addProduct.products.push(e.id);
      });
      
      $('select').selectpicker();
         
    },
    methods: {
        addProductsToShop() {           
            this.form.addProduct.patch(this.route('shop.update',this.shop.id), {
                onSuccess: (response) => { 
                                    this.form.addProduct.reset();
                                    $("#Add_Product").modal("hide");
                },
            })
        },
    }
}
</script>
