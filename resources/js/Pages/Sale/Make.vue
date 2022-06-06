<template>
    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout>
    <section>
      <div class="BodyTop">
        <div class="row">
            <div class="col" >
              <div class="card current_stock">
                <div class="card-header CS_header justify-content-start">
                  <h5 class="align-self-center mb-0 mr-auto heading">Current Stock </h5>
                  <!-- <a href="#" class="Btn mx-2" data-toggle="modal" data-target="#myModal"></a> -->
                  <inertia-link :href="route('stock.view.request')" class="Btn">Stock Request</inertia-link>
                </div>
                <div class="card-body d-flex justify-content-center">
                    <div class="item mr-3" v-for="product in productCurrentStock" :key="product.id">
                    <div class="itemBox px-4" v-if="product.stock"> <span class="img mr-2"><img :src="product.image" alt="icon" class="img-fluid"></span> <span class="">
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
                  <h5 class="my-2 heading">Today's Sales</h5>
                </div>
                <div class="card-body d-flex justify-content-center p-0" :class="{'p-4':(sales.length == 0)}" >
                  <template v-if="sales.length > 0">
                    <div class="item" v-for="sale  in sales" :key="sale.id">
                        <div class="itemBox pb-4 pt-4">
                            <span class="img mr-2 my-2"><img :src="sale.product.image" alt="icon" class="img-fluid"></span> <span class="">
                                <h6>{{ sale.total_sales }} <sup>INR</sup> </h6>
                                <p>{{ sale.product.product_name }}</p>
                            </span>
                        </div>
                    </div>
                  </template>
                  <template v-else>
                        <h6 class="p-4 mb-0">No Sale Found For Today</h6>
                  </template>

                </div>
              </div>
            </div>
        </div>
    </div>
    <div class="BodyBottom">
        <div class="row">
            <div class="col-lg-3">
                <div class="customer_info card">
                    <div class=" card-header p-0 px-2">
                        <h3 class="heading">Customer Info</h3>
                    </div>
                    <div class="CI_body card-body p-0" style="height: 242px;overflow: auto;">
                        <div class="info_input">
                            <form action="#" method="POST" class="container my-4" @submit.prevent="saveCustomerForm">
                                <ul>
                                    <li>
                                        <input placeholder="Mobile" id="customer" autocomplete="off" v-model="v$.form.customer.phone.$model" :disabled="Object.keys(carts).length > 0">
                                        <template v-for="(error, index) of v$.form.customer.phone.$errors" :key="index">
                                            <small class="text-danger">{{ error.$message }}</small>
                                        </template>
                                    </li>
                                    <li :class="{'border-0 text-danger': existingCustomer }" class="pb-0">
                                        <h4 v-if="existingCustomer" class="text-center"> {{ form.customer.name }}</h4>
                                        <div class="input-group" v-else>
                                            <input name="name"  placeholder="Name" class="form-control" autocomplete="off" v-model="v$.form.customer.name.$model" />
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary border-0 btn-sm rounded" type="submit" id="button-addon2">Save</button>
                                            </div>
                                        </div>
                                        <template v-for="(error, index) of v$.form.customer.name.$errors" :key="index">
                                            <small class="text-danger">{{ error.$message }}</small>
                                        </template>
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
                                        <td>{{ cart.attributes.rate }} <sup>INR</sup> </td>
                                        <td>{{ cart.attributes.weight }} <sup>{{ cart.attributes.product.weight_unit }}</sup></td>
                                        <td>{{ Number(cart.price).toFixed(2) }}</td>
                                        <td>
                                            <form  method="POST" class="mr-2 small" @submit.prevent="removeCart($event,cart)">
                                                <input type="hidden" :value="cart.id" name='id' />
                                                <button class="btn text-danger small" type="submit">x</button>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer p-0 border-0 bg-transparent" :class="{'d-none':!Object.keys(carts).length}">
                        <inertia-link :href="this.route('cart.clear')" @click="clearCart" type="button" method="POST" class="btn btn-warning btn-sm m-1"> Clear Cart </inertia-link>
                        <inertia-link :href="this.route('cart.list')"  type="button" class="btn btn-primary btn-sm m-1"> Generate Bill </inertia-link>
                        <strong><sup>INR</sup> {{ Number(totalAmount).toFixed(2) }}</strong>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 ">
                <div class="customer_info" v-if="existingCustomer">
                    <div class="heading">
                        <h3>Billing System</h3>
                    </div>
                    <div class="CI_body">
                        <div class="Stock_list" id="style-3">
                            <ul>
                                <li v-for="product in shop.products" :key="product.product_name">
                                    <span class="product_info">
                                        <em class="img"><img :src="product.image" alt="icon" class="img-fluid"></em>
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
                                        <label class="radioPart" v-if="product.wholesale_weight_range">
                                            Wholesale:
                                            <!-- JSON.parse(product.rate.wholesale_rate) -->
                                            <p v-if="product.rate != null && product.rate != ''">
                                               <span class="font-weight-normal d-block" v-for="range in parseToJSON(product.rate.wholesale_rate)" :key="range.id" style="font-size:11px">{{ range.rate }} <sup>INR </sup> {{ ' : ' + range.from +' - ' }} {{ (range.to == 50000) ? 'MAX' : range.to  }}  {{ product.weight_unit }}</span>
                                            </p>
                                            <input type="radio" :name="'product_'+product.id+'_radio'"  :class="['tbName' , 'product_' +product.id+ '_wholesale_radio' ]" value="wholesale" data-btn="submit1">
                                            <span class="checkmark"></span>
                                        </label>
                                    </span>
                                    <span class="product_btn">
                                        <form action="#" method="POST" class="font-weight-bold" @submit.prevent="addToCart">
                                            <div class="input-group">
                                                <input  class="form-control" placeholder="0"  name="weight" v-model="billingWeightInput['product-'+product.id]" @input="calateprice($event,product.wholesale_weight_range)" :data-wholesale-range="(product.rate != null && product.rate != '') ? product.rate.wholesale_rate : []"  :data-retail-rate="(product.rate == null ) ? 0 : product.rate.retail_rate" :data-product="product.product_name" :data-product-id="product.id" :data-wholesale-weight="product.wholesale_weight" autocomplete="off" data-amount="0" data-rate="0"/>
                                                <div class="input-group-append">
                                                    <small class="input-group-text">{{product.weight_unit}}</small>
                                                    <p class="price">0 <sup>INR</sup></p>
                                                </div>
                                                <button class="btn btn-primary submit ml-1" type="submit" :class="{'cursor-not-allowed': (product.rate == null || disableAddToCartButton(product.id))}" :disabled="product.rate == null || disableAddToCartButton(product.id)">ADD</button>
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
                <div class="Purchase_History" v-if="Object.keys(purchaseHistory).length > 0 ">
                    <h6 class="p-2 text-white"> Purchase History </h6>
                    <div class="accordion" id="accordionExample">
                        <div class="card" v-for="(data,index) in purchaseHistory" :key="index">
                            <div class="card-header p-0" id="headingOne">
                                <ul class="d-flex small justify-content-around align-items-center">
                                    <li>
                                        <button class="btn btn-link btn-block text-left p-1 collapsed border-0" type="button" data-toggle="collapse" :data-target="'#collapse'+index" aria-expanded="true" :aria-controls="'collapse'+index">
                                            {{ parseDate(index,'YY/MM/D') }}
                                        </button>
                                    </li>
                                    <li> Total : {{ _.sumBy(data, 'total') }} INR</li>
                                    <li> Received  : {{ _.sumBy(data, 'receive') }}  INR</li>
                                </ul>
                            </div>

                            <div :id="'collapse'+index" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body p-1" style="overflow-y: auto; max-height:8em;">
                                    <table class="table table-striped table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th class="border-0 p-0">Pro</th>
                                                <th class="border-0 p-0">qty</th>
                                                <th class="border-0 p-0">totl</th>
                                                <th class="border-0 p-0">Recv</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="history in data" :key="history.id" >
                                                <td class="border-0 p-0">{{ "-" }}</td>
                                                <td class="border-0 p-0">{{ history.quantity }}</td>
                                                <td class="border-0 p-0">{{ history.total }} <sup>INR </sup></td>
                                                <td class="border-0 p-0">{{ history.receive }} <sup>INR </sup></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
  </section>

    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/BillingSystem.vue'
import { Head , Link} from '@inertiajs/inertia-vue3'
import _ from 'lodash'
import moment from 'moment'
import useVuelidate from '@vuelidate/core'
import { required, email, minLength , numeric , integer ,helpers} from '@vuelidate/validators'


const options = {
  name: '_blank',
  specs: [
    'fullscreen=yes',
    'titlebar=yes',
    'scrollbars=yes'
  ],
  styles: [
    'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
    'https://unpkg.com/kidlat-css/css/kidlat.css'
  ],
  timeout: 1000, // default timeout before the print window appears
  autoClose: true, // if false, the window will not close after printing
  windowTitle: window.document.title, // override the window title
}

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        moment
    },
    props:['products','shop','carts','sales'],
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
                  currentStock:[],
                  billingWeightInput:{},
                  _,
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
      //
      this.currentStock = this.shop.products;
      //
      if(Object.keys(this.carts).length > 0 ){
          this.existingCustomer = true;
          this.form.customer = _.get(_.values(this.carts), 0).attributes.customer;
          //
          let _this = this;
          _.forIn(this.carts, function(o, k) {
            _this.currentStock.filter(function(s){
                 if(o.attributes.product.id == s.id){
                     s.association.stock = s.association.stock - o.attributes.weight;
                 }
            })
          });
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
                        //
                        if(_this.existingCustomer)  {
                            _.merge(_this.form.customer,response.data.customer);
                            _this.purchaseHistory = response.data.purchase_history;
                        }
                    }
                )
          },
          onChange:function(){
              _this.existingCustomer = false;
              _this.form.customer.name="";
          }
      });
    },
      computed:{
              // Make a request for a user with a given ID
              // get only
              totalAmount: function () {
                  //
                  let total = 0;
                   _.forIn(this.carts, function(o, k) {
                       total += o.price;
                   });
                  return total;
              },
              productCurrentStock(){
                return this.currentStock;
              }
      },
      methods: {
          saveCustomerForm(event) {
            if(this.v$.form.customer.$invalid){
                this.v$.form.customer.$touch();
                return
            }
            //
            this.form.customer.post(this.route('customer.store',), {
                only: ["existingCustomer","customer","totalCartItem"],
                onSuccess: (response) => {
                                    this.form.customer.reset('name');
                                    window.history.pushState('data', 'Save Customer', '/make-sale');
                                    //
                                    this.existingCustomer = response.props.existingCustomer;
                                    //
                                    if(this.existingCustomer)
                                        _.merge(this.form.customer,response.props.customer);

                                    window.history.pushState('data', 'Add to Cart', '/make-sale');
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
          addToCart(event){
              //
              var $form = $(event.target),
                  $el = $form.find('[name=weight]');
            //
            let _this = this;
            let InsufficientStock = false;
            this.form.cart.customer = this.form.customer.phone;
            this.form.cart.product = $el.data('productId');
            this.form.cart.weight = $el.val();
            //
            this.currentStock.filter(function(o) {
                    console.log("o.id"+ o.id);
                    console.log("_this.form.cart.product"+ _this.form.cart.product);

                    if(o.id == _this.form.cart.product){
                        if(o.association.stock < $el.val()){
                            InsufficientStock = true;
                        }
                    }
            })

            //
            if(InsufficientStock){
                $.jGrowl("Insufficient Stock ! Please request for stock", {
                    theme: 'jGrowl-bg text-white'
                });
                return false;
            }
            //

            this.form.cart.amount = $el.data('amount');
            this.form.cart.rate = $el.data('rate');
            this.form.cart.type = $("[name=product_"+this.form.cart.product+"_radio]:checked").val();

                this.form.cart.post(this.route('cart.store'), {
                    only: ["carts"],
                    onSuccess: (response) => {
                                    window.history.pushState('data', 'Add to Cart', '/make-sale');

                                    this.currentStock.filter(function(o) {
                                            if(o.id == _this.form.cart.product){
                                                o.association.stock = o.association.stock - _this.form.cart.weight;
                                            }
                                    })
                                    this.billingWeightInput["product-"+this.form.cart.product] = 0;
                                    $el.closest('form').find(".price").html(parseFloat(0));
                                    $(".product_"+_this.form.cart.product+"_retail_radio").prop("checked",true);
                    },
                })

            //   var data = {
            //               product:$el.data('product'),
            //               customer:vue.form.customer.phone,
            //               weight:$el.val(),
            //               _token:$("[name='csrf-token']").attr("content"),
            //           };

            //   $.post(url,data,function(response){
            //       vue.carts = response;;
            //       if(_.size(vue.carts))
            //           vue.cartFlag = true;
            //       else
            //           vue.cartFlag = false;
            //       //
            //       $el.val(0);
            //       $form.find(".pro-price").html(parseFloat(0));
            //   });
          },
          removeCart(event,item){
              var  $form = $(event.target),
                    $el = $form.find("[name='id']");
              this.form.removeCart.id = $el.val();
              this.form.removeCart.post(this.route('cart.remove') ,{
                    only: ["carts"],
                    onSuccess: (response) => {
                                    window.history.pushState('data', 'Remove from Cart', '/make-sale');
                                    //
                                    this.currentStock.filter(function(o) {
                                        if(o.id == item.attributes.product.id){
                                            o.association.stock = o.association.stock + item.attributes.weight;
                                        }
                                    })
                                    //
                                    // if(Object.keys(this.carts).length == 0 ){

                                    // }
                    },
                })
            //   event.preventDefault();
            //   $form = $(event.target);
            //   $.post($form.attr("action"),$form.serialize(),function(response){
            //       vue.carts = response;
            //       if(_.size(vue.carts))
            //           vue.cartFlag = true;
            //       else
            //           vue.cartFlag = false;

            //   });
          },
          calateprice(event , wholesale_weight_range){
                let $el = $(event.target) ,
                weight = $el.val(),
                wholesale = (wholesale_weight_range) ? _.find($el.data('wholesaleRange'), function(r) { return  (r.from <= weight && weight <= r.to) ; }) : null,
                retail = $el.data('retailRate'),
                rate = (_.isNaN(wholesale) || _.isNil(wholesale)) ? parseFloat(retail) : parseFloat(wholesale.rate),
                product = $el.data('product'),
                productId = $el.data('productId'),
                totalCost = Number(parseFloat(rate) * parseFloat(weight)).toFixed(2);
                //
                if(_.isNaN(wholesale) || _.isNil(wholesale)){
                    $(".product_"+productId+"_retail_radio").prop("checked",true);
                }else{
                    $(".product_"+productId+"_wholesale_radio").prop("checked",true);
                }
                //
                if(weight > 0){
                    $el.closest('form').find(".price").html(parseFloat(totalCost)+"<sup>INR</sup>");
                    $el.attr('data-amount',totalCost).attr('data-rate',rate);
                }else{
                    $el.closest('form').find(".price").html(parseFloat(weight));
                    $(".product_"+productId+"_retail_radio").prop("checked",false);
                    $(".product_"+productId+"_wholesale_radio").prop("checked",false);
                    $el.attr('data-amount',0).attr('data-rate',0);
                }
          },
          parseToJSON(data){
               return JSON.parse(data);
          },
          parseDate(d,f = 'DD-MM-YYYY'){
              return moment(d).format(f);
          },
          disableAddToCartButton(id){
            let product = this.productCurrentStock.find(function(p){ return p.id == id; });
            return (product.association.stock > 0 ) ? false : true ;
          },
          clearCart(){
                let _this = this;
                _.forIn(this.carts, function(o, k) {
                    _this.currentStock.filter(function(s){
                        if(o.attributes.product.id == s.id){
                            s.association.stock = s.association.stock + o.attributes.weight;
                        }
                    })
                });
        }
    },
    validations() {
        return {
                form:{
                      customer :{
                                            name:{required},
                                            phone:{required}
                      }
                }
        }
    },
    setup () {
        return { v$: useVuelidate() }
    }
}
</script>

<style scoped>
  .today_sales .item:last-child > .itemBox{
    border-right:none !important;
  }
  .cursor-not-allowed{
      cursor:not-allowed;
  }
</style>
