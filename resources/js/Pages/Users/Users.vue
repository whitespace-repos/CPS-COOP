<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>          
      <div class="main-panel">
        <div class="topBar">
        
          <div class="row" style="vertical-align: middle;justify-content: center;align-items: center;">
            <div class="col-lg-7">
              <div class="SelProduct">
                <h3>List Employees</h3>
              </div>
            </div>
            <div class="col-lg-5 col-md-12 ">
              <div class="Btnarea Btnarea2">
                <button class="btn add-btn" type="button" >Add employee</button>
              </div>
            </div>
          </div>
        </div>
        <!-- topBar-->
        
        <div class="listTable">
          <table class="table table-bordered table-hover dt-responsive">
            <thead>
              <tr>
                <th>Date</th>
                <th>Name</th>
                <th>Shop</th>
                <th>Role</th>
                <th>Email</th>
                <th>Phone number</th>
                <th>Action</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>07/01/2022</td>
                <td>Cristiano Ronaldo</td>
                <td>Broiler Live, Egg</td>
                <td>Blank</td>
                <td>ronaldo@gmail.com</td>
                <td>0215456789</td>
                <td><button type="button" class="btn dt-edit"> Edit </button>
                  <button type="button" class="btn dt-delete"> Delete </button></td>
                <td><button type="button" class="btn btn-act"> Active </button></td>
              </tr>
              <tr>
                <td>07/01/2022</td>
                <td>Cristiano Ronaldo</td>
                <td>Broiler Live, Egg</td>
                <td>Blank</td>
                <td>ronaldo@gmail.com</td>
                <td>0215456789</td>
                <td><button type="button" class="btn dt-edit"> Edit </button>
                  <button type="button" class="btn dt-delete"> Delete </button></td>
                <td><button type="button" class="btn btn-inact">  Inactive </button></td>
              </tr>
              <tr>
                <td>07/01/2022</td>
                <td>Cristiano Ronaldo</td>
                <td>Broiler Live, Egg</td>
                <td>Blank</td>
                <td>ronaldo@gmail.com</td>
                <td>0215456789</td>
                <td><button type="button" class="btn dt-edit"> Edit </button>
                  <button type="button" class="btn dt-delete"> Delete </button></td>
                <td><button type="button" class="btn btn-act"> Active </button></td>
              </tr>
             <tr>
                <td>07/01/2022</td>
                <td>Cristiano Ronaldo</td>
                <td>Broiler Live, Egg</td>
                <td>Blank</td>
                <td>ronaldo@gmail.com</td>
                <td>0215456789</td>
                <td><button type="button" class="btn dt-edit"> Edit </button>
                  <button type="button" class="btn dt-delete"> Delete </button></td>
                <td><button type="button" class="btn btn-inact">  Inactive </button></td>
              </tr>
              <tr>
                <td>07/01/2022</td>
                <td>Cristiano Ronaldo</td>
                <td>Egg</td>
                <td>Blank</td>
                <td>ronaldo@gmail.com</td>
                <td>0215456789</td>
                <td><button type="button" class="btn dt-edit"> Edit </button>
                  <button type="button" class="btn dt-delete"> Delete </button></td>
                <td><button type="button" class="btn btn-act"> Active </button></td>
              </tr>
             <tr>
                <td>07/01/2022</td>
                <td>Cristiano Ronaldo</td>
                <td>Broiler Live, Egg</td>
                <td>Blank</td>
                <td>ronaldo@gmail.com</td>
                <td>0215456789</td>
                <td><button type="button" class="btn dt-edit"> Edit </button>
                  <button type="button" class="btn dt-delete"> Delete </button></td>
                <td><button type="button" class="btn btn-inact">  Inactive </button></td>
              </tr>
            </tbody>
          </table>
        </div>
        
        <!-- List Table--> 
        
      </div>
      <!--  main-panel--> 
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
    },
}
</script>
