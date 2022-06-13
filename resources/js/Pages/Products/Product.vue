<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
      <div class="main-panel">
        <div class="topBar">
          <div class="row">
            <div class="col-lg-12 ">
              <div class="ShopDtlsHdr">
                <h3 class="heading">Products</h3>
              </div>
            </div>
          </div>
        </div>

        <!-- topBar -->
        <div class="ProTop mt-4">
          <div class="row TopDiv">
            <div class="col-lg-4" v-if="auth.isAdmin">
              <div class="card h-100">
                <div class="card-header font-weight-normal"> Create Weight Units </div>
                <div class="card-body px-0">
                  <form action="" method="POST" @submit.prevent="saveWeightUnit">
                    <div class="d-flex">
                      <div class="form-group m-2" :class="{ 'has-error': v$.form.weightUnit.value.$errors.length }">
                          <input v-model="v$.form.weightUnit.value.$model" class="form-control" placeholder="Value"/>
                          <template v-for="(error, index) of v$.form.weightUnit.value.$errors" :key="index">
                            <small>{{ error.$message }}</small>
                          </template>
                      </div>
                      <div class="form-group m-2" :class="{ 'has-error': v$.form.weightUnit.key.$errors.length }">
                          <input v-model="v$.form.weightUnit.key.$model"  class="form-control" placeholder="Key" />
                          <template v-for="(error, index) of v$.form.weightUnit.key.$errors" :key="index">
                            <small>{{ error.$message }}</small>
                          </template>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary  px-5 m-2"  :disabled="v$.form.weightUnit.$invalid">Add</button>
                  </form>
                  <div class="proHistory pb-0">
                    <div class="px-2">
                      <h6>Unit History</h6>
                    </div>
                    <div class="table-responsive p-0 small">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Group </th>
                            <th>Value</th>
                            <th>Action </th>
                          </tr>
                        </thead>
                        <tbody id="tbodyBar">
                          <tr v-for="unit in weightUnits" :key="unit.id">
                            <td>Weight Unit</td>
                            <td>{{ unit.value +'( '+unit.key + ' )' }}</td>
                            <td><inertia-link :href="this.route('settings.destroy',unit.id)" method="POST" :data="{_method:'DELETE'}"><img src="/assets/img/delete_icon.png" alt="icon"> Delete</inertia-link></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-8" :class="{'mx-auto':auth.isSupplier}">
              <div class="card h-100">
                <div class="card-header"> Add New Product </div>
                <div class="card-body">
                  <form action="" class="small" method="POST" @submit.prevent="saveProduct">
                    <div class="row">
                      <div class="col">
                        <div class="form-group" :class="{ 'has-error': v$.form.product.product_name.$errors.length }">
                          <label>Product name</label>
                          <input v-model="v$.form.product.product_name.$model" placeholder="Type product name here" class="form-control">
                          <template v-for="(error, index) of v$.form.product.product_name.$errors" :key="index">
                            <small>{{ error.$message }}</small>
                          </template>
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                            <div class="row">
                              <div class="col mb-5">
                                  <label>Add Weight Ranges</label>
                                  <label class="form-check checkbox">
                                  <input type="checkbox" v-model="form.product.wholesale_weight_range" style="zoom:2" class="float-left mr-2"/> <span v-if="form.product.wholesale_weight_range"> Yes </span><span v-else>No</span>
                                  </label>
                              </div>
                              <div class="col-md-7" v-if="form.product.wholesale_weight_range">
                                <label>Add Weight Ranges</label>
                                <div class="d-flex mb-2">
                                  <div>
                                    <div class="form-group d-flex mb-0" v-for="(r,i) in form.product.weightRanges" :key="i">
                                        <input class="border-gray border rounded border-bottom-0 w-50" v-model="form.product.weightRanges[i].from"/>
                                        -
                                        <template v-if="i == form.product.weightRanges.length - 1">
                                          <input type="hidden" class="border-gray border rounded border-bottom-0 mr-1 w-50" v-model="form.product.weightRanges[i].to"/>
                                          <input class="border-gray border rounded border-bottom-0 mr-1 w-50" value="MAX" disabled/>
                                        </template>
                                        <template v-else>
                                          <input class="border-gray border rounded border-bottom-0  mr-1 w-50" v-model="form.product.weightRanges[i].to"/>
                                        </template>

                                        {{ form.product.weight_unit }}
                                    </div>
                                  </div>
                                  <div>
                                    <a href="javascript:void(0)" class="btn btn-link btn-sm small ml-2 pt-0 align-self-start" @click="addRange(form.product.weightRanges)" v-if="(form.product.weightRanges.length < 3)"> Add </a>
                                    <a href="javascript:void(0)" class="btn btn-link btn-sm small ml-2 pt-0 align-self-start" @click="form.product.weightRanges = []" v-if="(form.product.weightRanges.length > 0)"> Reset</a>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-5">
                        <div class="form-group" :class="{ 'has-error': v$.form.product.product_image.$errors.length }">
                          <label>Product Image</label>
                          <input type="file"  class="form-control p-1" @input="form.product.product_image = $event.target.files[0]"  />
                          <template v-for="(error, index) of v$.form.product.product_image.$errors" :key="index">
                            <small>{{ error.$message }}</small>
                          </template>
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group" :class="{ 'has-error': v$.form.product.weight_unit.$errors.length }">
                          <label>Weight unit</label>
                          <select class="form-control custom-select" v-model="v$.form.product.weight_unit.$model">
                            <option v-for="unit in weightUnits" :value="unit.key" :key="unit.id">{{ unit.value }} </option>
                          </select>
                          <template v-for="(error, index) of v$.form.product.weight_unit.$errors" :key="index">
                            <small>{{ error.$message }}</small>
                          </template>
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label>Manage Stock</label>
                          <label class="form-check checkbox">
                            <input type="checkbox" v-model="form.product.stock" style="zoom:2" class="float-left mr-2"/> <span v-if="form.product.stock"> Yes </span><span v-else>No</span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4" v-if="!form.product.stock">
                          <div class="form-group" :class="{ 'has-error': v$.form.product.parent_product_id.$errors.length }">
                            <label>Select Parent Product : </label>
                            <select class="custom-select" v-model="v$.form.product.parent_product_id.$model">
                              <template v-for="product in products" :key="product.id">
                                <option  :value="product.id" v-if="product.stock">{{ product.product_name }}</option>
                              </template>
                            </select>
                            <template v-for="(error, index) of v$.form.product.parent_product_id.$errors" :key="index">
                              <small>{{ error.$message }}</small>
                            </template>
                          </div>
                      </div>

                      <div class="col-md-4" v-if="!form.product.stock">
                          <div class="form-group">
                            <label>Convertion Rate : </label>
                            <input v-model="form.product.conversion_rate" class="form-control"/>
                          </div>
                      </div>

                      <div class="col-md-12 text-right">
                         <hr />
                        <button class="btn btn-primary add-btn py-2 px-5" type="submit">Add Product</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- TopDiv -->

          <div class="row ">
            <div class="col-lg-12">
              <div class="Product_List">
                <div class="proHistory">
                  <div class="px-2">
                    <h6>Product List</h6>
                  </div>
                  <div class="">
                    <table class="table">
                      <thead class="small">
                        <tr>
                          <th>Product Name</th>
                          <th>Shop</th>
                          <th>Wholesale Weight</th>
                          <th> Weight Unit</th>
                          <th>Action </th>
                        </tr>
                      </thead>
                      <tbody id="tbodyBar">
                        <tr v-for="product in products" :key="product.id">
                          <td>{{ product.product_name }}</td>
                          <td>
                              <span class="badge badge-danger font-weight-normal px-3" v-if="product.shops.length == 0">0</span>
                              <span class="badge badge-danger font-weight-normal mr-1" v-for="shop in product.shops" :key="shop.id">{{ shop.shop_name }}</span>
                          </td>
                          <td>
                                <span class="badge badge-danger font-weight-normal" v-if="product.wholesale_weight_range == 0">
                                  {{ "-" }}
                                </span>
                                <span class="badge badge-danger font-weight-normal ml-1" v-for="range in product.weight_ranges" :key="range.id">{{ toDecimal(range.from) +' - ' }} {{ (range.to == 50000) ? 'MAX' : toDecimal(range.to)  }} {{ product.weight_unit }}</span>
                          </td>
                          <td>{{ product.weight_unit }}</td>
                          <td>
                              <a href="#" class="mr-2" @click="openEditModal(product.id)"><img src="/assets/img/edit_icon2.png" alt="icon"> Edit</a>
                              <inertia-link :href="this.route('product.destroy',product.id)" method="POST" :data="{_method:'DELETE',status:(product.status == 'Active')?'Inactive':'Active'}">
                                <span v-if="product.status == 'Active'">
                                  <img src="/assets/img/delete_icon.png" alt="icon"> Make Inactive
                                </span>
                                <span v-else>
                                   Make Active
                                </span>
                              </inertia-link>
                          </td>
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

      <!-- main-panel -->

      <!-- The Modal -->

    <div class="modal" id="editModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal"><img src="/assets/img/cross_btn.png" alt=""></button>

            <!-- Modal body -->

            <div class="modal-body p-5">
                  <form action="" class="small" method="POST" @submit.prevent="updateProduct" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col">
                        <div class="form-group" :class="{ 'has-error': v$.form.editProduct.product_name.$errors.length }">
                          <label>Product name</label>
                          <input v-model="v$.form.editProduct.product_name.$model" placeholder="Type product name here" class="form-control">
                          <template v-for="(error, index) of v$.form.editProduct.product_name.$errors" :key="index">
                            <small>{{ error.$message }}</small>
                          </template>
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <div class="row">
                            <div class="col mb-5">
                              <label>Add Weight Ranges</label>
                              <label class="form-check checkbox">
                                <input type="checkbox" v-model="form.editProduct.wholesale_weight_range" :checked="form.editProduct.wholesale_weight_range"  style="zoom:2" class="float-left mr-2"/> <span v-if="form.editProduct.wholesale_weight_range"> Yes </span><span v-else>No</span>
                              </label>
                            </div>
                            <div class="col-md-7" v-if="form.editProduct.wholesale_weight_range">
                                <label>Add Weight Ranges</label>
                                <div class="d-flex mb-2">
                                  <div>
                                    <div class="form-group d-flex mb-0" v-for="(r,i) in form.editProduct.weightRanges" :key="i">
                                        <input class="border-gray border rounded border-bottom-0 w-50" v-model="form.editProduct.weightRanges[i].from"/>
                                        -
                                        <template v-if="i == form.editProduct.weightRanges.length - 1">
                                          <input type="hidden" class="border-gray border rounded border-bottom-0 mr-1 w-50" v-model="form.editProduct.weightRanges[i].to"/>
                                          <input class="border-gray border rounded border-bottom-0 mr-1 w-50" value="MAX" disabled/>
                                        </template>
                                        <template v-else>
                                          <input class="border-gray border rounded border-bottom-0  mr-1 w-50" v-model="form.editProduct.weightRanges[i].to"/>
                                        </template>

                                        {{ form.editProduct.weight_unit }}
                                    </div>
                                  </div>
                                  <div>
                                    <a href="javascript:void(0)" class="btn btn-link btn-sm small ml-2 pt-0 align-self-start" @click="addRange(form.editProduct.weightRanges)" v-if="(form.editProduct.weightRanges.length < 3)"> Add </a>
                                    <a href="javascript:void(0)" class="btn btn-link btn-sm small ml-2 pt-0 align-self-start" @click="form.editProduct.weightRanges = []" v-if="(form.editProduct.weightRanges.length > 0)"> Reset</a>
                                  </div>
                                </div>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-2">
                        <label>Product Image </label>
                        <img :src="selectedProduct.image" class="img-fluid w-50 d-block m-auto" />
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label>Add New Image </label>
                          <input type="file"  class="form-control p-1" @input="form.editProduct.product_image = $event.target.files[0]"  />
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label>Weight unit</label>
                          <select class="form-control custom-select" v-model="form.editProduct.weight_unit">
                            <option v-for="unit in weightUnits" :value="unit.key" :key="unit.id">{{ unit.value }} </option>
                          </select>
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label>Manage Stock</label>
                          <label class="form-check checkbox">
                            <input type="checkbox" v-model="form.editProduct.stock" style="zoom:2" class="float-left mr-2"/> <span v-if="form.editProduct.stock"> Yes </span><span v-else>No</span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4" v-if="!form.editProduct.stock">
                          <div class="form-group" :class="{ 'has-error': v$.form.editProduct.parent_product_id.$errors.length }">
                            <label>Select Parent Product : </label>
                            <select class="custom-select" v-model="v$.form.editProduct.parent_product_id.$model">
                              <template v-for="product in products" :key="product.id">
                                <option  :value="product.id" v-if="product.stock">{{ product.product_name }}</option>
                              </template>
                            </select>
                            <template v-for="(error, index) of v$.form.editProduct.parent_product_id.$errors" :key="index">
                              <small>{{ error.$message }}</small>
                            </template>
                          </div>
                      </div>

                      <div class="col-md-4" v-if="!form.editProduct.stock">
                          <div class="form-group">
                            <label>Convertion Rate : </label>
                            <input v-model="form.editProduct.conversion_rate" class="form-control"/>
                          </div>
                      </div>

                      <div class="col-md-12 text-right">
                         <hr />
                        <button class="btn btn-primary add-btn py-2 px-5" type="submit">Update Product</button>
                      </div>
                    </div>
                  </form>
              </div>
            </div>
          </div>
        </div>

    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import useVuelidate from '@vuelidate/core'
import { required, email, minLength , numeric , integer ,helpers ,requiredIf} from '@vuelidate/validators'
import _ from 'lodash'

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
    },
    props:['weightUnits','products','weightRanges','auth'],
    mounted(){},
    computed: {

    },
    data(){
      return{
          form : {
                weightUnit : this
                                  .$inertia
                                  .form({
                                            setting_group_id:1,
                                            value:'',
                                            key:'',
                }),
                product : this
                                  .$inertia
                                  .form({
                                            product_name:'',
                                            wholesale_weight:0,
                                            weight_unit:'',
                                            image:'',
                                            stock:false,
                                            product_image:null,
                                            wholesale_weight_range:false,
                                            weightRanges:[],
                                            weightUnits:[
                                                      {from:0,to:0},{from:0,to:0},{from:0,to:50000},
                                            ],
                                            defaultWeightRange:[
                                                                  {from:100,to:50000}
                                            ],
                                            parent_product_id:'',
                                            conversion_rate:0,
                                            default_wholesale_weight:0,
                }),
                editProduct:this
                                  .$inertia
                                  .form({
                                          product_name:'',
                                          wholesale_weight:0,
                                          weight_unit:'',
                                          stock:false,
                                          '_method':'PATCH',
                                          product_image:null,
                                          parent_product_id:'',
                                          conversion_rate:0,
                                          wholesale_weight_range:false,
                                          weightRanges:[],
                                          defaultWeightRange:[
                                                                {from:100,to:50000}
                                          ],
                                          weightUnits:[
                                                    {from:0,to:0},{from:0,to:0},{from:0,to:50000},
                                          ],
                                          default_wholesale_weight:0,
              }),
          },
          selectedProduct:{}
      }
    },
    validations() {
      return {
              form:{
                      weightUnit:{
                                setting_group_id:1,
                                value:{required},
                                key:{required},
                      },
                      product : {
                                    product_name:{required},
                                    product_image:{required},
                                    weight_unit:{required},
                                    parent_product_id:{
                                      required: requiredIf(!this.form.product.stock)
                                    }
                      },
                      editProduct : {
                            product_name:{required},
                            parent_product_id:{
                              required: requiredIf(!this.form.product.stock)
                            }
                      }
          }
      }
    },
    setup () {
      return { v$: useVuelidate() }
    },
    methods: {
        addRange(range){
            let countRange = range.length;
            switch(countRange) {
            case 0:
              // code block
              range.push({from:10,to:50000});
              break;
            case 1:
              // code block
              var from = parseInt(range[0].from);
              var to = range[0].to = from + 100;
              //
              range.push({from:(to + 1),to:50000});
              break;
            case 2:
              // code block
              var from = parseInt(range[1].from);
              var to = range[1].to = from + 100;
              //
              range.push({from:(to + 1),to:50000});
              break;
            default:
              // code block
          }
        },
        saveWeightUnit() {
            this.form.weightUnit.post(this.route('settings.store'), {
                onSuccess: (response) => {
                                    this.form.weightUnit.reset('value','key');
                                    this.v$.form.weightUnit.$reset();
                },
            })
        },
        saveProduct(){
          if(this.v$.form.product.$invalid){
            this.v$.form.product.$touch();
            return
          }
          //

          this.form.product.post(this.route('product.store'), {
                onSuccess: (response) => {
                                    this.form.product.reset('product_name','weight_unit','wholesale_weight','stock','wholesale_weight_range','product_image');
                                    this.form.product.weightUnits[0].from = this.form.product.weightUnits[0].to = this.form.product.weightUnits[1].from = this.form.product.weightUnits[1].to = this.form.product.weightUnits[2].from = 0;
                                    this.form.product.weightUnits[2].to = 50000;
                                    this.form.product.conversion_rate = 0;
                                    $("[type=file]").val("");
                                    this.v$.form.product.$reset();
                },
          })
        },

        updateProduct(){
          console.log(this.form.editProduct);

          this.form.editProduct.post(this.route('product.update',this.selectedProduct.id), {
                onSuccess: (response) => {
                  $("#editModal").modal("hide");
                },
          })
        },

        openEditModal($id){
          let _this = this;
          axios.get(this.route('product.show',$id)).then(function(response){
            _.assignIn(_this.form.editProduct, response.data)
            _this.selectedProduct = response.data;
            _this.form.editProduct.weightRanges = [];
            _this.form.editProduct.stock = (_this.selectedProduct.stock) ? true : false;
            if(_this.selectedProduct.weight_ranges.length > 0){
              _this.form.editProduct.wholesale_weight_range = true;
              $.each(_this.selectedProduct.weight_ranges,function(i,v){
                _this.form.editProduct.weightRanges.push(v);
              });
            }else{
              _this.form.editProduct.wholesale_weight_range = false;
            }
            //
            $("#editModal").modal("show");
          }).
          catch(function(){

          });
        }
    }
}
</script>
<style scoped>
  .mb-60{
    margin-bottom: 60px;
  }
</style>
