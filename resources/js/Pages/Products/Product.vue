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
            <div class="col-lg-4">
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
            <div class="col-lg-8">
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
                                <input type="checkbox" v-model="form.product.weight_range_flag" style="zoom:2" class="float-left mr-2"/> <span v-if="form.product.weight_range_flag"> Yes </span><span v-else>No</span>
                              </label>
                            </div>
                            <div class="col-md-7" v-if="form.product.weight_range_flag">
                              <label>Weight for wholesale</label>
                              <div class="form-group mb-0">
                                  <input class="border-gray w-25 border rounded border-bottom-0" v-model="form.product.weightUnits[0].from"/>
                                  -
                                  <input class="border-gray w-25 border rounded border-bottom-0" v-model="form.product.weightUnits[0].to"/>
                                  {{ form.product.weight_unit }}
                              </div>
                              <div class="form-group mb-0">
                                  <input class="border-gray w-25 border rounded border-bottom-0" v-model="form.product.weightUnits[1].from"/>
                                  -
                                  <input class="border-gray w-25 border rounded border-bottom-0" v-model="form.product.weightUnits[1].to"/>
                                  {{ form.product.weight_unit }}
                              </div>
                              <div class="form-group mb-0">
                                  <input class="border-gray w-25 border rounded"    v-model="form.product.weightUnits[2].from"/>
                                  -
                                  <input class="border-gray w-25 border rounded" v-model="form.product.weightUnits[2].to"/>
                                  {{ form.product.weight_unit }}
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
                        <div class="form-group">
                          <label>Weight unit</label>
                          <select class="form-control custom-select" v-model="form.product.weight_unit">
                            <option v-for="unit in weightUnits" :value="unit.key" :key="unit.id">{{ unit.value }} </option>
                          </select>
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
                                <span class="badge badge-danger font-weight-normal px-3" v-if="product.weight_ranges.length == 0">-</span>
                                <span class="badge badge-danger font-weight-normal mr-1" v-for="range in product.weight_ranges" :key="range.id">{{ range.from +'-'+range.to+' '+ product.weight_unit }}</span>
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

            <div class="modal-body">
              <div class="NewProAdd">
                <div class="NewProAddHr">
                  <h2>Edit Product Detail</h2>
                </div>
                <div class="NewProAddBody">
                  <form action="" method="POST" @submit.prevent="updateProduct">
                  <div class="NewProAddFrm">
                    <ul>
                      <li>
                        <label>Product name  </label>
                        <input v-model="form.editProduct.product_name"  placeholder="Type product name here" class="form-control">
                      </li>
                      <li class="d-flex" :class="{'mb-60':!form.editProduct.weight_range_flag}">
                        <div class="w-75">
                          <label>Add Weight Ranges</label>
                          <label class="form-check checkbox">
                            <input type="checkbox" v-model="form.editProduct.weight_range_flag" :checked="form.editProduct.weight_range_flag" style="zoom:2" class="float-left mr-2"/> <span v-if="form.editProduct.weight_range_flag"> Yes </span><span v-else>No</span>
                          </label>
                        </div>
                        <div v-if="form.editProduct.weight_range_flag">
                          <template v-if="selectedProduct.weight_ranges.length > 0">
                            <label>Weight for wholesale</label>
                            <div class="form-group mb-0" v-for="range in  selectedProduct.weight_ranges" :key="range.id">
                                <input class="border-gray w-25 border rounded" v-model="form.editProduct.weightRanges['range-from-'+range.id]"/>
                                -
                                <input class="border-gray w-25 border rounded" v-model="form.editProduct.weightRanges['range-to-'+range.id]"/>
                                {{ form.editProduct.weight_unit }}
                            </div>
                          </template>
                          <template v-else>
                            <label>Weight for wholesale</label>
                            <div class="form-group mb-0" v-for="(range,index) in  form.product.weightUnits" :key="range.id">
                                <input class="border-gray w-25 border rounded" v-model="form.editProduct.weightRanges['range-from-'+index]"/>
                                -
                                <input class="border-gray w-25 border rounded" v-model="form.editProduct.weightRanges['range-to-'+index]"/>
                                {{ form.editProduct.weight_unit }}
                            </div>
                          </template>
                        </div>
                      </li>
                      <li class="mb-0">
                        <label>Weight unit</label>
                        <select class="form-control custom-select" v-model="form.editProduct.weight_unit" >
                          <option v-for="unit in weightUnits" :value="unit.key" :key="unit.id">{{ unit.value }}</option>
                        </select>
                      </li>

                      <li class="mb-5">
                        <label>Product Image :</label>
                        <img :src="selectedProduct.image" />
                        <!-- <input type="file"  class="form-control p-3"  @input="form.editProduct.product_image = $event.target.files[0]"  /> -->
                      </li>


                      <li>
                          <label>Manage Stock</label>
                          <label class="form-check checkbox">
                            <input type="checkbox" v-model="form.editProduct.stock" :data-checked="selectedProduct.stock"  style="zoom:2" class="float-left mr-2"/> <span v-if="form.editProduct.stock"> Yes </span><span v-else>No</span>
                          </label>
                      </li>

                      <li v-if="!form.editProduct.stock">
                        <label>Parent Product</label>
                        <select class="form-control custom-select" v-model="form.editProduct.parent_product_id" >
                          <template v-for="product in products" :key="product.id">
                            <option  :value="product.id" v-if="product.stock">{{ product.product_name }}</option>
                          </template>
                        </select>
                      </li>

                      <li v-if="!form.editProduct.stock">
                        <label>Weight unit</label>
                        <input v-model="form.editProduct.conversion_rate" class="form-control"/>
                      </li>
                      <li>
                        <button class="btn btn-primary add-btn" type="submit">Update Product</button>
                      </li>
                    </ul>
                  </div>
                  </form>
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
import { Inertia } from '@inertiajs/inertia';
import useVuelidate from '@vuelidate/core'
import { required, email, minLength , numeric , integer ,helpers ,requiredIf} from '@vuelidate/validators'

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
    },
    props:['weightUnits','products','weightRanges'],
    mounted(){},
    computed: {},
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
                                            weight_unit:'KG',
                                            image:'',
                                            stock:false,
                                            product_image:'',
                                            weight_range_flag:false,
                                            weightUnits:[
                                                      {from:0,to:0},{from:0,to:0},{from:0,to:50000},
                                            ],
                                            parent_product_id:'',
                                            conversion_rate:0,
                }),
                editProduct:this
                                  .$inertia
                                  .form({
                                          product_name:'',
                                          wholesale_weight:0,
                                          weight_unit:'',
                                          stock:false,
                                          product_image:'',
                                          weightRanges:{},
                                          parent_product_id:'',
                                          conversion_rate:0,
                                          weight_range_flag:false,
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
        saveWeightUnit() {
            this.form.weightUnit.post(this.route('settings.store'), {
                onSuccess: (response) => {
                                    this.form.weightUnit.reset('value','key');
                                    console.log(response);
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
                                    this.form.product.reset('product_name','weight_unit','wholesale_weight','stock','weight_range_flag','product_image');
                                    this.form.product.weightUnits[0].from = this.form.product.weightUnits[0].to = this.form.product.weightUnits[1].from = this.form.product.weightUnits[1].to = this.form.product.weightUnits[2].from = 0;
                                    this.form.product.weightUnits[2].to = 50000;
                                    this.form.product.conversion_rate = 0;
                                    $("[type=file]").val("");
                                    this.v$.form.product.$reset();
                },
          })
        },

        updateProduct(){
          this.form.editProduct.patch(this.route('product.update',this.selectedProduct.id), {
                onSuccess: (response) => {
                  $("#editModal").modal("hide");
                },
          })
        },

        openEditModal($id){
          var _this = this;
          $.get(this.route('product.show',$id) , function(response){
            _this.selectedProduct = response;
            _this.form.editProduct.product_name =  _this.selectedProduct.product_name;
            _this.form.editProduct.stock = (_this.selectedProduct.stock) ? true : false;
            _this.form.editProduct.product_name =  _this.selectedProduct.product_name;
            _this.form.editProduct.weight_unit = _this.selectedProduct.weight_unit;
            _this.form.editProduct.parent_product_id = _this.selectedProduct.parent_product_id;
            _this.form.editProduct.conversion_rate = _this.selectedProduct.conversion_rate;
            $("#editModal").modal("show");
            if(_this.selectedProduct.weight_ranges.length > 0){
              _this.form.editProduct.weight_range_flag = true;
              $.each(_this.selectedProduct.weight_ranges,function(i,v){
                _this.form.editProduct.weightRanges['range-from-'+v.id] = v.from;
                _this.form.editProduct.weightRanges['range-to-'+v.id] = v.to;
              });
            }else{
              _this.form.editProduct.weight_range_flag = false;
            }

          })
        }
    }
}
</script>
<style scoped>
  .mb-60{
    margin-bottom: 60px;
  }
</style>
