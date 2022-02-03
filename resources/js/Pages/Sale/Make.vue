<template>
    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout>
    <section>
      <div class="BodyTop">
        <div class="row">
            <div class="col" >
              <div class="card current_stock">
                <div class="card-header CS_header justify-content-start">
                  <h5 class="align-self-center mb-0 mr-auto">Current Stock</h5>
                  <a href="#" class="Btn mx-2" data-toggle="modal" data-target="#myModal">Stock Request</a>                  
                  <inertia-link :href="route('stock.view.request')" class="Btn">View All</inertia-link>
                </div>
                <div class="card-body d-flex justify-content-center">
                    <div class="item mr-3" v-for="product in shop.products" :key="product.id">
                    <div class="itemBox px-4" v-if="product.stock"> <span class="img mr-2"><img :src="product.image" alt="icon"></span> <span class="">
                      <h3>{{ product.association.stock +' ' + product.weight_unit }}</h3>
                      <p>{{ product.product_name }}</p>
                      </span> </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card today_sales">
                <div class="card-header CS_header">
                  <h5 class="my-2">Today's Sales</h5> 
                </div>
                <div class="card-body d-flex justify-content-center p-0">
                  <div class="item" v-for="product  in shop.products" :key="product.id">
                    <div class="itemBox pb-4 pt-4"> <span class="img mr-2 my-2"><img :src="product.image" alt="icon"></span> <span class="">
                       <h6>{{ product.association.stock +' ' + product.weight_unit }}</h6>
                      <p>{{ product.product_name }}</p>
                      </span> 
                    </div>
                  </div>               
                </div>
              </div>
            </div>            
        </div>      
    </div>
    <div class="BodyBottom">
        <div class="row">
            <div class="col-lg-3">
                <div class="customer_info">
                    <div class="CI_header">
                        <h3>Customer Info</h3>
                    </div>
                    <div class="CI_body">
                        <div class="info_input">
                            <form action="#" method="POST" class="container my-4" @submit.prevent="saveCustomerForm">                               
                                <ul>
                                    <li>                                     
                                        <input placeholder="Mobile" id="customer" autocomplete="off" v-model="form.customer.phone" :disabled="cartFlag ? true : false">
                                    </li>
                                    <li :class="{'border-0 text-danger': existingCustomer }" class="pb-0">
                                        <h4 v-if="existingCustomer" class="text-center"> {{ form.customer.name }}</h4>
                                        <div class="input-group" v-else>
                                            <input name="name"  placeholder="Name" class="form-control" autocomplete="off" v-model="form.customer.name" />
                                            <div class="input-group-append">
                                            <button class="btn btn-outline-secondary border-0 btn-sm rounded" type="submit" id="button-addon2">Save</button>
                                            </div>
                                        </div>                              
                                    </li>
                                </ul>
                            </form>
                        </div>
 
                        <div class="info_table" v-if="Object.keys(carts).length > 0">
                            <table class="table">
                                <thead>
                                    <tr class="font-weight-bold">
                                        <th>Product</th>
                                        <th>Rate</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="cart in carts" :key="cart.id">
                                        <td>{{ cart.name }}</td>
                                        <td>{{ cart.attributes.rate }}</td>
                                        <td>{{ cart.attributes.weight }} <sup>kg</sup></td>                                                     
                                        <td>{{ cart.price }}</td>   
                                        <td>
                                            <form  method="POST" class="mr-2 small" @submit.prevent="removeCart">
                                                <input type="hidden" :value="cart.id" name='id' />
                                                <button class="btn text-danger small" type="submit">x</button>
                                            </form> 
                                        </td>                                           
                                    </tr>
                                    <tr>
                                        <td colspan="3"><strong>Total Amount:</strong></td>
                                        <td colspan="2"><strong>Rs.0</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button class="btn btn-primary" type="button"  >Generate Bill</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 ">                                       
                <div class="customer_info" v-if="existingCustomer">
                    <div class="CI_header">
                        <h3>Stock Request</h3>
                    </div>
                    <div class="CI_body">
                        <div class="Stock_list" id="style-3">
                            <ul>
                                <li v-for="product in shop.products" :key="product.product_name"> 
                                    <span class="product_info"> 
                                        <em class="img"><img :src="product.image" alt="icon"></em> 
                                        <em class="txt">
                                            <h4>{{ product.product_name}}</h4>
                                        </em> 
                                    </span> 
                                    <span class="product_radio">
                                        <label class="radioPart mr-2">
                                            Retail:
                                            <p>
                                               <span class="font-weight-normal d-block"  style="font-size:12px">{{ (product.rate == null ) ? ' - ' : product.rate.retail_rate }} <sup v-if="product.rate != null">INR </sup>  {{ ' : ' + product.weight_unit  }} </span>                                              
                                            </p>
                                            <input type="radio"  :class="['tbName' , 'product_' +product.id+ '_retail_radio' ]" :name="'product_'+product.id+'_radio'" value="retail" data-btn="submit1" />
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radioPart">
                                            Wholesale: 
                                            <p>
                                               <span class="font-weight-normal d-block" v-for="range in product.weight_ranges" :key="range.id" style="font-size:11px">{{ range.wholesale_rate }} <sup>INR </sup> {{ ' : ' + range.from +'-'+range.to+' '+ product.weight_unit }}</span>                                              
                                            </p>
                                            <input type="radio" :name="'product_'+product.id+'_radio'"  :class="['tbName' , 'product_' +product.id+ '_wholesale_radio' ]" value="wholesale" data-btn="submit1">
                                            <span class="checkmark"></span>
                                        </label>
                                    </span>
                                    <span class="product_btn">
                                        <form action="#" method="POST" class="font-weight-bold" @submit.prevent="addToCart">
                                            <div class="input-group">
                                                <input  class="form-control" placeholder="0"  name="weight"  @input="calateprice" :data-wholesale-range="JSON.stringify(product.weight_ranges)"  :data-retail-rate="(product.rate == null ) ? 0 : product.rate.retail_rate" :data-product="product.product_name" :data-product-id="product.id" :data-wholesale-weight="product.wholesale_weight" autocomplete="off" data-amount="0" data-rate="0"/>
                                                <div class="input-group-append">
                                                    <small class="input-group-text">{{product.weight_unit}}</small>
                                                    <p class="price">0 <sup>INR</sup></p>
                                                </div>
                                                <button class="btn btn-primary submit" type="submit" :disabled="product.rate == null">ADD</button>
                                            </div>
                                        </form>                                            
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="customer_info black" v-else>
                    <img src="assets/img/blank_img1.png" alt="icon">
                    <h6>Please add customer information to show order list.</h6>                    
                </div> 
            </div>
    
            <div class="col-lg-3 displayNoneIpad">
                <div class="Purchase_History" v-if="existingCustomer">
                    <div class="PH_header">
                        <h3>Purchase History</h3>
                    </div>
                    <div class="PH_body">                   
                        <div class="table-responsive">
                            <table class="table table-fixed">
                                <thead>
                                    <tr>
                                        <th scope="col" class="col-3">Date</th>
                                        <th scope="col" class="col-4">Total</th>
                                        <th scope="col" class="col-5">Received Amt</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyBar">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="Purchase_History black-history " v-else>                    
                    <img src="/assets/img/blank_img2.png" alt="icon">
                    <h6>No History Available</h6>                    
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
            <div class="modal-body">
                <div class="poupDiv">
                <ul>
                    <template v-for="product in shop.products" :key="product.id">
                        <li v-if="product.stock">
                            <div class="itemBox"> <span class="img"><img :src="product.image" alt="icon"></span> <span class="txt">
                                <h3>{{ product.association.stock +''+ product.weight_unit }}</h3>
                                <p>Broiler Live</p>
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
  </section>
    </BreezeAuthenticatedLayout>
</template>

<script>          
import { SplitCarousel, SplitCarouselItem } from  'vue-split-carousel'
import BreezeAuthenticatedLayout from '@/Layouts/BillingSystem.vue'
import { Head } from '@inertiajs/inertia-vue3'
import _ from 'lodash'


export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        SplitCarousel,
        SplitCarouselItem
    },
    props:['products','shop','carts'],
    data () {
      return {
                  existingCustomer:false,
                  token:$("[name='csrf-token']").attr("content"),
                  formUrl:"{{ route('customer.store') }}",
                  rate:0, 
                  purchaseHistory:[],     
                  customer:'',
                  cartFlag:false,
                  paymentMethod:'EMI',
                  form:{
                      customer :this
                                  .$inertia
                                  .form({
                                            name:null,
                                            email:null,
                                            location:null,
                                            phone:null,
                      }),
                      cart :this
                                  .$inertia
                                  .form({
                                            product:"",                          
                                            customer:"",
                                            weight:0,
                                            amount:0,
                                            rate:0,
                                            type:''
                      }),
                      removeCart : this
                                        .$inertia
                                        .form({
                                            id : ""
                      }),
                      stockRequest : this
                                        .$inertia
                                        .form({
                                            products : {},
                                            
                      })
                  }
            }
      },
    mounted(){
      var _this = this;

      if(Object.keys(this.carts).length > 0 ){
          this.existingCustomer = true;
          this.form.customer = _.get(_.values(this.carts), 0).attributes.customer;
      }

      $('#customer').mask('0000000000',{
          onComplete: function(phone) {  
                    this
                        .axios
                        .post(
                                this.route('customer.existance'),
                                {
                                  "phone":phone , 
                                  "_token":_this.token
                                }
                        )                        
                        .then(response => {
                               _this.existingCustomer = response.data.existingCustomer;
                               _this.form.customer = response.data.customer;
                               console.log(_this.existingCustomer);
                            }
                        )

            // alert(phone);
            //   vue.rate;
            //   $.post("{{ route('customer.existance') }}",{"phone":phone , "_token":vue.token},function(response){   
            //       vue.existingCustomer = response.existance;
            //       if(vue.existingCustomer){
            //           _.assignIn(vue.form.customer,response.customer);                        
            //       } else{
            //           vue.form.customer.name = "";
            //           vue.form.customer.email = "";
            //           vue.form.customer.location = "";
            //       }
                  
            //       //vue.formUrl = (response.existance) ? "{{ route('cart.store') }}" : " {{ route('login') }}";                           
            //   });
          },
          onChange:function(){
              _this.existingCustomer = false;
              // vue.existingCustomer = false;
              // vue.form.customer.name = "";
              // vue.form.customer.email = "";
              // vue.form.customer.location = "";
          }
      }); 
    },

      computed:{
              // Make a request for a user with a given ID
              // get only
              totalAmount: function () {
                  // 
                  this.form.cart.customer = this.form.customer.phone;
                  this.form.cart.rate = this.rate;
                  // 
                  this.form.cart.amount =  parseFloat(this.form.cart.weight) * parseFloat(this.rate);
                  return this.form.cart.amount;
              } 
              

      },
      methods: {
          saveCustomerForm(event) {
            this.form.customer.post(this.route('customer.store',), {
                only: ["existance","customer","totalCartItem"],
                onSuccess: (response) => { 
                                    this.form.customer.reset('name');
                                    window.history.pushState('data', 'Save Customer', '/make-sale');   
                                    //  
                                    this.existingCustomer = response.props.existingCustomer;
                },
            })
              // this
              //           .axios
              //           .post( this.route('customer.store')
                        
              //           )
               //                             
              // let url = "{{ route('customer.store') }}";
              // let data = this.form.customer;
              
              // $.post(url,data,function(response){                                                                      
              //     vue.existingCustomer = response.existance;
              //     _.assignIn(vue.form.customer,response.customer);
              // });
          },
          sendStockRequest(event) {
              console.log(this.form.stockRequest);
               this.form.stockRequest.post(this.route('stock.request.submit'), {                        
                        onSuccess: (response) => {
                             $("#myModal").modal("hide");
                             this.form.stockRequest.products = [];
                        }
               });                            
          },
          addToCart(event){
              // 
              var $form = $(event.target),
                  $el = $form.find('[name=weight]');
              //   
              this.form.cart.customer = this.form.customer.phone;
              this.form.cart.product = $el.data('productId');
              this.form.cart.weight = $el.val();
              this.form.cart.amount = $el.data('amount');
              this.form.cart.rate = $el.data('rate');
              this.form.cart.type = $("[name=product_"+this.form.cart.product+"_radio]:checked").val();
              this.form.cart.post(this.route('cart.store'), {
                    only: ["carts"],
                    onSuccess: (response) => {                                    
                                    window.history.pushState('data', 'Add to Cart', '/make-sale'); 
                    },
                })

            //   var data = {
            //               product:$el.data('product'),
            //               customer:vue.form.customer.phone,
            //               weight:$el.val(),
            //               _token:$("[name='csrf-token']").attr("content"),
            //           }; 
              
            //   $.post(url,data,function(response){                                  
            //       vue.carts = response;
            //       // console.log(response);
            //       if(_.size(vue.carts))
            //           vue.cartFlag = true;
            //       else 
            //           vue.cartFlag = false;
            //       // 
            //       $el.val(0);
            //       $form.find(".pro-price").html(parseFloat(0));
            //   });                    
          },
          removeCart(event){
              var  $form = $(event.target),
                    $el = $form.find("[name='id']");

            
              this.form.removeCart.id = $el.val();
              console.log(this.form.removeCart);

              this.form.removeCart.post(this.route('cart.remove') ,{
                    only: ["carts"],
                    onSuccess: (response) => {                                     
                                    window.history.pushState('data', 'Remove from Cart', '/make-sale'); 
                                    if(Object.keys(this.carts).length == 0 ){
                                        this.existingCustomer = false; 
                                        this.form.customer.name = null;                                       
                                    }
                    },
                })
            //   event.preventDefault();
            //   $form = $(event.target);
            //   $.post($form.attr("action"),$form.serialize(),function(response){                                  
            //       vue.carts = response;
            //       // console.log(response);
            //       if(_.size(vue.carts))
            //           vue.cartFlag = true;
            //       else 
            //           vue.cartFlag = false;                        
              
            //   });
          },
          calateprice(event){
            let $el = $(event.target) ,
                weight = $el.val(),
                wholesale = _.find($el.data('wholesaleRange'), function(r) { return  (r.from <= weight && weight <= r.to) ; }),
                retail = $el.data('retailRate'),
                rate = (_.isNaN(wholesale) || _.isNil(wholesale)) ? parseFloat(retail) : parseFloat(wholesale.wholesale_rate),
                product = $el.data('product'),
                productId = $el.data('productId'),
                totalCost = parseFloat(rate) * parseFloat(weight);

                if(_.isNaN(wholesale) || _.isNil(wholesale)){
                    $(".product_"+productId+"_retail_radio").prop("checked",true);
                }else{
                    $(".product_"+productId+"_wholesale_radio").prop("checked",true);
                }

                if(weight > 0){
                    $el.closest('form').find(".price").html(parseFloat(totalCost));
                    $el.attr('data-amount',totalCost).attr('data-rate',rate);
                }else{
                    $el.closest('form').find(".price").html(parseFloat(weight));
                    $(".product_"+productId+"_retail_radio").prop("checked",false);
                    $(".product_"+productId+"_wholesale_radio").prop("checked",false);
                    $el.attr('data-amount',0).attr('data-rate',0);
                }
          }
      },
}
</script>

<style scoped>
  .today_sales .item:last-child > .itemBox{
    border-right:none !important;
  }
</style>

