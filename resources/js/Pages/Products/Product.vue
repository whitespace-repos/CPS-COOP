<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
      <div class="main-panel">
        <div class="topBar">
          <div class="row">
            <div class="col-lg-12 ">
              <div class="ShopDtlsHdr">
                <h3>Products</h3>
              </div>
            </div>
          </div>
        </div>
        
        <!-- topBar -->
        
        <div class="ProTop mt-4">
          <div class="row TopDiv">
            <div class="col-lg-4">
              <div class="Pro_info  overflow-hidden">
                <div class="Pro_infoHr">
                  <h2>Create Weight Units</h2>
                </div>
                <div class="Pro_infoBody">
                  <div class="proAdd"> 
                    <form action="" method="POST" @submit.prevent="saveWeightUnit">
                      <span>
                          <label>Value</label>
                          <input v-model="form.weightUnit.value" />
                      </span> 
                      <span>
                          <label>Key</label>
                          <input v-model="form.weightUnit.key"  />
                      </span>
                      <button type="submit" class="btn">Add</button>
                    </form>
                  </div>
                  <div class="proHistory pb-0">
                    <div class="proHistoryHr">
                      <h3>Unit History</h3>
                    </div>
                    <div class="table-responsive pl-2 pr-0">
                      <table class="table table-fixed">
                        <thead>
                          <tr>
                            <th scope="col" class="col-4">Group </th>
                            <th scope="col" class="col-4">Value</th>
                            <th scope="col" class="col-2">Key </th>
                            <th scope="col" class="col-2">Action </th>
                          </tr>
                        </thead>
                        <tbody id="tbodyBar">
                          <tr v-for="unit in weightUnits" :key="unit.id">
                            <td scope="row" class="col-4">Weight Unit</td>
                            <td class="col-4">{{ unit.value }}</td>
                            <td class="col-2">{{ unit.key }}</td>
                            <td class="col-2"><a href="#"><img src="/assets/img/delete_icon.png" alt="icon"> Delete</a></td>
                          </tr>                         
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-8">
              <div class="NewProAdd">
                <div class="NewProAddHr">
                  <h2>Add New Product</h2>
                </div>
                <div class="NewProAddBody">
                  <form action="" method="POST" @submit.prevent="saveProduct">
                  <div class="NewProAddFrm">
                    <ul>
                      <li>
                        <label>Product name</label>
                        <input v-model="form.product.product_name" placeholder="Type product name here" class="form-control">
                      </li>
                      <li class="mb-5">
                        <div class="row">
                          <div class="col-md-5 mb-5">
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
                     </li>
                      <li>
                        <label>Weight unit</label>
                        <select class="form-control custom-select" v-model="form.product.weight_unit">
                          <option v-for="unit in weightUnits" :value="unit.key" :key="unit.id">{{ unit.value }} </option>
                        </select>
                      </li>

                      <li>
                        <label>Product Image</label>
                        <input type="file"  class="form-control p-3"  @input="form.product.product_image = $event.target.files[0]"  />
                      </li>


                      <li>
                          <label>Manage Stock</label>
                          <label class="form-check checkbox">
                            <input type="checkbox" v-model="form.product.stock" style="zoom:2" class="float-left mr-2"/> <span v-if="form.product.stock"> Yes </span><span v-else>No</span>
                          </label>
                        </li>
                      <li>
                        <button class="btn btn-primary add-btn" type="submit">Add Product</button>
                      </li>  
                    </ul>
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
                  <div class="proHistoryHr">
                    <h3>Product List</h3>
                  </div>
                  <div class="">
                    <table class="table">
                      <thead>
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
                                <span class="badge badge-danger font-weight-normal px-3" v-if="product.weight_ranges.length == 0">0</span> 
                                <span class="badge badge-danger font-weight-normal mr-1" v-for="range in product.weight_ranges" :key="range.id">{{ range.from +'-'+range.to+' '+ product.weight_unit }}</span>
                          </td>
                          <td>{{ product.weight_unit }}</td>
                          <td>
                              <a href="#" class="mr-2" @click="openEditModal(product.id)"><img src="/assets/img/edit_icon2.png" alt="icon"></a> 
                              <a href="#"><img src="/assets/img/delete_icon.png" alt="icon"></a>
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
                      <li>
                        <label>Weight for wholesale</label>
                       
                        <div class="form-group mb-0" v-for="range in  selectedProduct.weight_ranges" :key="range.id">
                            <input class="border-gray w-25 border rounded" v-model="form.editProduct.weightRanges['range-from-'+range.id]"/>
                            - 
                            <input class="border-gray w-25 border rounded" v-model="form.editProduct.weightRanges['range-to-'+range.id]"/> 
                            {{ form.editProduct.weight_unit }}                           
                        </div>   
                      </li>
                      <li>
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

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
    },
    props:['weightUnits','products','weightRanges'],
    mounted(){
      
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
                                            weight_unit:'KG',
                                            image:'',
                                            stock:false,
                                            product_image:'',
                                            weight_range_flag:false,
                                            weightUnits:[
                                                      {from:0,to:0},{from:0,to:0},{from:0,to:0},
                                            ]
                }),
                editProduct:this 
                                  .$inertia
                                  .form({
                                          product_name:'',
                                          wholesale_weight:0,
                                          weight_unit:'',
                                          stock:false,
                                          product_image:'',
                                          weightRanges:{}
              }),          
          },
          selectedProduct:{}
      }
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
          this.form.product.post(this.route('product.store'), {
                onSuccess: (response) => { 
                                    this.form.product.reset('product_name','weight_unit','wholesale_weight','stock');
                                    this.form.product.weightUnits[0].from = this.form.product.weightUnits[0].to = this.form.product.weightUnits[1].from = this.form.product.weightUnits[1].to = this.form.product.weightUnits[2].from = this.form.product.weightUnits[2].to = 0;
                                    console.log(response);
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
            $("#editModal").modal("show");
            $.each(_this.selectedProduct.weight_ranges,function(i,v){
               _this.form.editProduct.weightRanges['range-from-'+v.id] = v.from;
               _this.form.editProduct.weightRanges['range-to-'+v.id] = v.to;
            });
          })          
        }
    }
}
</script>
