<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>

      <!-- sideBar-->
      <div class="main-panel" >
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
                <div class="SetRate mb-4">
                    <h3 class="heading">Set / Update Today's Rate</h3>
                    <h4>Date: <strong>{{ currentDate }}</strong></h4>
                    <div class="setRateList">
                      <form method="POST"  @submit.prevent="addRate">
                        <div class="row">
                          <div class="col-md-8">
                            <div class="form-group">
                                <label> Select Product </label>
                                <select class="custom-select" name="product_id" v-model="form.rate.product_id" @change="this.$inertia.get('/rate/'+$event.target.value)">
                                  <option v-for="product in products" :key="product.id" :value="product.id">{{ product.product_name }}</option>
                                </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group" :class="{ 'has-error': v$.form.rate.retail_rate.$errors.length }">
                                <label>Retail Rate </label>
                                <input v-maska="'#*.##'" class="form-control" name="retail_rate" v-model="v$.form.rate.retail_rate.$model"/>
                                <template v-for="(error, index) of v$.form.rate.retail_rate.$errors" :key="index">
                                  <small>{{ error.$message }}</small>
                                </template>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                            <div class="col" v-for="(range , index ) in selectedProduct.weight_ranges" :key="range.id" >
                              <div class="form-group" v-if = "range.from != 0 || range.to != 0 " :class="{'has-error':v$.form.rate.range['range-'+range.id].$error}">
                                  <label>Range {{index + 1 }} : <label class="badge badge-danger font-weight-normal"> {{ toDecimal(range.from) + ' - ' }} {{ (range.to == 50000) ? 'MAX' : toDecimal(range.to)  }} {{ selectedProduct.weight_unit }} </label> </label>
                                  <input v-maska="'#*.##'" class="form-control" :name="range.id" v-model="v$.form.rate.range['range-'+range.id].$model"/>
                                  <small v-if="v$.form.rate.range['range-'+range.id].$error">{{ 'Please Enter a Valid Rate' }} </small>
                              </div>
                            </div>
                          <div class="col-md-3  align-self-end">
                            <div class="form-group">
                                <button class="btn btn-danger btn-block" type="submit" :disabled="v$.form.rate.$invalid">Save Rate</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
            </div>
            <div class="col-lg-9">
              <div class="card">
                <div class="card-header bg-white heading m-0">
                  Today's Rate chart
                </div>
                <div class="cord-body">
                  <div class="table-responsive">
                    <table cellpadding="0" cellspacing="0" border="0" class="table mb-0 table-striped table-sm table-hover">
                      <thead>
                        <tr>
                          <th>Product</th>
                          <th>Date</th>
                          <th>Wholesale Rate</th>
                          <th>Retail Rate</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <template v-if="rates.length > 0 ">
                          <tr v-for="r in rates" :key="r.id">
                            <td>{{ r.product.product_name }}</td>
                            <td>{{ r.date }}</td>
                            <td>
                              <template v-if="r.wholesale_rate != null && r.wholesale_rate != '[]'">
                                <template  v-for="(range,index) in parseToJSON(r.wholesale_rate)" :key="range.id">
                                  <span class="badge badge-danger font-weight-normal mr-2" v-if="index==0">
                                      {{toDecimal(range.from) +" - "+ toDecimal(range.to) +" "+ r.product.weight_unit }} : {{  toDecimal(range.rate) }} <sup>INR </sup>
                                  </span>
                                </template>
                              </template>
                            </td>
                            <td> <span class="badge badge-danger font-weight-normal "> {{  toDecimal(r.retail_rate) }} <sup>INR </sup> {{ " / "+ r.product.weight_unit }} </span> </td>
                            <td> <span class="badge badge-danger font-weight-normal ">{{ r.status }} </span> </td>
                          </tr>
                        </template>
                        <template v-else>
                          <tr>
                            <td colspan="5" class="p-3 text-center"> No Record Found.</td>
                          </tr>
                        </template>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3">
            <v-calendar is-expanded
                          title-position="left"
                          show-weeknumbers="right"
                          @dayclick="getRateDetail"
                />
            </div>
          </div>
        </div>
      </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';
import useVuelidate from '@vuelidate/core'
import { required, email, minLength , numeric , integer ,helpers , requiredIf} from '@vuelidate/validators'
const rateValidation = helpers.regex(/^\d+(?:\.\d{1,2})?$/);
import _ from 'lodash'


export default {
    setup () {
      return { v$: useVuelidate() }
    },
    components: {
        BreezeAuthenticatedLayout,
        Head,
    },
    computed:{
        currentDate() {
            const current = new Date();
            const date = `${current.getDate()}-${current.getMonth()+1}-${current.getFullYear()}`;
            return date;
        },
        defaultWholesaleWeightValidation(){
            let validation= {};
            //
            if(this.selectedProduct.wholesale_weight_range == 0){
              return {
                        rateValidation:helpers.withMessage('Please Enter a Valid Rate',rateValidation),
                        required: requiredIf(this.selectedProduct.wholesale_weight_range == 0)
                    };
            }

            return validation;
        },
        weightRangeValidation(){
            let validation= {};
            //
            if(this.selectedProduct.wholesale_weight_range == 1){
              this.selectedProduct.weight_ranges.filter(function(obj,index){
                  let key = "range-"+obj.id;
                  let ObjString = '{"range-'+obj.id+'" : null}';
                  let Objest = JSON.parse(ObjString);
                  //
                  _.set(Objest, key,{
                    rateValidation:helpers.withMessage('Please Enter a Valid Rate',rateValidation),
                    required
                  });
                  //
                  _.assign(validation, Objest);
              })
            }

            console.log(validation);

            return validation;
        }


    },
    props:['products','selectedProduct','rates'],

    data(){
        return {
                form:{
                        rate:this
                                  .$inertia
                                  .form({
                                            product_id:null,
                                            range:{},
                                            retail_rate:0,
                                            wholesale_rate:0,
                                            default_wholesale_weight:0
                          }),
                        selectedRate:this
                                  .$inertia
                                  .form({
                                            id:0,
                                            product_id:null,
                                            product:{product_name:''},
                                            range:{},
                                            retail_rate:0,
                                            wholesale_rate:0
                          }),
                },
                _token:'',
                date: new Date()
        }
    },
    validations() {
      return {
              form:{
                        rate:{
                                retail_rate:{
                                    rateValidation:helpers.withMessage('Please Enter a Valid Rate',rateValidation),
                                    required
                                },
                                range:this.weightRangeValidation
                      }
                }
      }
    },
    methods:{
        addRate:function(e){
            const result = this.v$.form.rate.$validate();
            if (!result) {
              return
            }

            this.form.rate.post(this.route('rate.store'), {
                onSuccess: (response) => {
                                    this.form.rate.reset();
                                    // reset the validation
                                    this.v$.form.rate.$reset();
                },
            });
        },
        getRateDetail:function(d){
          console.log({date:d.id});

          this.$inertia.get(this.route('get.rate'),{ date:d.id}, {
                only: ["rates"],
                onSuccess: (response) => {
                    window.history.pushState('data', 'Get Rate For Particular Date', '/rate');
                },
            })
        },
        parseToJSON(data){
               return JSON.parse(data);
        }
    },
    mounted(){
      this.form.rate.product_id = this.selectedProduct.id;
      this._token = $('meta[name="csrf-token"]').attr('content');
     // $('select').selectpicker();
    }
}
</script>
