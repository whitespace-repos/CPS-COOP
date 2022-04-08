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
                                <input class="form-control" name="retail_rate" v-model="v$.form.rate.retail_rate.$model"/>
                                <template v-for="(error, index) of v$.form.rate.retail_rate.$errors" :key="index">
                                  <small>{{ error.$message }}</small>
                                </template>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col" v-for="(range , index ) in selectedProduct.weight_ranges" :key="range.id" >
                            <div class="form-group" v-if = "range.from != 0 || range.to != 0 " :class="{'has-error':v$.form.rate.range['range-'+range.id].$error}">
                                <label>Range {{index + 1 }} : <label class="badge badge-danger font-weight-normal"> {{ range.from + '-' + range.to + ' ' + selectedProduct.weight_unit }} </label> </label>
                                <input class="form-control" :name="range.id" v-model="v$.form.rate.range['range-'+range.id].$model"/>
                                <small v-if="v$.form.rate.range['range-'+range.id].$error">{{ 'Please Enter a Valid Rate' }} </small>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group py-1">
                                <button class="btn btn-danger btn-block my-4" type="submit" :disabled="v$.form.rate.$invalid">Save Rate</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
            </div>
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header bg-white heading m-0">
                  Today's Rate chart
                </div>
                <div class="cord-body">
                  <div class="table-responsive">
                    <table cellpadding="0" cellspacing="0" border="0" class="table mb-0 table-striped  table-hover">
                      <thead>
                        <tr>
                          <th>Product</th>
                          <th>Wholesale Rate</th>
                          <th>Retail Rate</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="rate in rates" :key="rate.id">
                          <td>{{ rate.product.product_name }}</td>
                          <td>
                            <span class="badge badge-danger font-weight-normal mr-2" v-for="range in rate.product.weight_ranges" :key="range.id">
                                {{range.from +"-"+ range.to +" "+ rate.product.weight_unit }} : {{  range.wholesale_rate }} <sup>INR </sup>
                            </span>
                           </td>
                          <td> <span class="badge badge-danger font-weight-normal "> {{  rate.retail_rate }} <sup>INR </sup> {{ " / "+ rate.product.weight_unit }} </span> </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
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
import { required, email, minLength , numeric , integer ,helpers} from '@vuelidate/validators'
const rateValidation = helpers.regex(/^[1-9][0-9]*$/);
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
        weightRangeValidation(){
            let validation= {};
            //
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
                                            wholesale_rate:0
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
                },
            });
        },
    },
    mounted(){
      this.form.rate.product_id = this.selectedProduct.id;
      this._token = $('meta[name="csrf-token"]').attr('content');
     // $('select').selectpicker();
    }
}
</script>
