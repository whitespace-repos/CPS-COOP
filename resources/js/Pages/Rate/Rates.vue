<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>

      <!-- sideBar-->
      <div class="main-panel" >
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
                <div class="SetRate mb-4">
                    <h3>Set / Update Today's Rate</h3>
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
                            <div class="form-group">
                                <label>Retail Rate </label>
                                <input class="form-control" name="retail_rate" v-model="form.rate.retail_rate"/>
                            </div>
                          </div>
                          <!-- <div class="col-md-3">
                            <div class="form-group">
                                <label>Type</label>
                                <input class="form-control" name="wholesale_rate" :v-model="form.rate.wholesale_rate"/>
                            </div>
                          </div> -->
                        </div>
                        <div class="row">
                          <div class="col" v-for="(range , index ) in selectedProduct.weight_ranges" :key="range.id">
                            <div class="form-group" v-if = "range.from != 0 || range.to != 0 ">
                                <label>Range {{index + 1 }} : <span class="badge badge-danger font-weight-normal"> {{ range.from + '-' + range.to + ' ' + selectedProduct.weight_unit }} </span> </label>
                                <input class="form-control" :name="range.id" v-model="form.rate.range['range-'+range.id]"/>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group py-1">
                                <button class="btn btn-danger btn-block my-4" type="submit">Save Rate</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
            </div>
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header bg-white font-weight-bold">
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
            <!--<div class="col-lg-4 ">
              <div class="calendarDiv">
                <div id="calendar">
                  <div id="calendar_header"><i class="icon-chevron-left"></i>
                    <h5></h5>
                    <i class="icon-chevron-right"></i> </div>
                  <div id="calendar_weekdays"></div>
                  <div id="calendar_content"></div>
                </div>
              </div>
            </div>-->
          </div>
        </div>
      </div>
      <!-- main-panel -->
  <!-- The Modal
<div class="modal" id="editModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <button type="button" class="close" data-dismiss="modal"><img src="/assets/img/cross_btn.png" alt=""></button>

       Modal body
     <div class="modal-body p-5">


            <form method="POST"  @submit.prevent="updateRate">
              <div class="row">
                <div class="col-md-8">
                  <div class="form-group">
                      <label> Select Product </label>
                      <div class="form-control">
                        {{ form.selectedRate.product.product_name }}
                      </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                      <label>Retail Rate </label>
                      <input class="form-control" name="retail_rate" v-model="form.selectedRate.retail_rate"/>
                  </div>
                </div> -->
                <!-- <div class="col-md-3">
                  <div class="form-group">
                      <label>Type</label>
                      <input class="form-control" name="wholesale_rate" :v-model="form.rate.wholesale_rate"/>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col" v-for="(range , index ) in form.selectedRate.product.weight_ranges" :key="range.id">
                  <div class="form-group" v-if = "range.from != 0 || range.to != 0 ">
                      <label>Range {{index + 1 }} : <span class="badge badge-danger font-weight-normal"> {{ range.from + '-' + range.to + ' ' + selectedProduct.weight_unit }} </span> </label>
                      <input class="form-control" :name="range.id" v-model="form.selectedRate.product.weight_ranges[index].wholesale_rate"/>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group py-1">
                      <button class="btn btn-danger add-btn btn-block my-4" type="submit">Update Rate</button>
                  </div>
                </div>
              </div>
            </form>


      </div>
    </div>
  </div>
</div> -->
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
    computed:{
                currentDate() {
                    const current = new Date();
                    const date = `${current.getDate()}-${current.getMonth()+1}-${current.getFullYear()}`;
                    return date;
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
    methods:{
        addRate:function(e){
            this.form.rate.post(this.route('rate.store'), {
                onSuccess: (response) => {
                                    this.form.rate.reset();
                },
            })
            console.log("Add Rate");
            console.log(this.form.rate);
        },
        // openEditModal($id){
        //   var _this = this;
        //   $.get(this.route('rate.edit',$id) , function(response){
        //      _this.form.selectedRate = Object.assign( {}, _this.form.selectedRate, response );
        //   })
        // },
        // updateRate(){
        //   this.form.selectedRate.patch(this.route('rate.update',this.form.selectedRate.id), {
        //         onSuccess: (response) => {
        //           $("#editModal").modal("hide");
        //         },
        //   })
        // }
    },
    mounted(){
      this.form.rate.product_id = this.selectedProduct.id;
      this._token = $('meta[name="csrf-token"]').attr('content');
     // $('select').selectpicker();
      $(function() {
                    function c() {
                        p();
                        var e = h();
                        var r = 0;
                        var u = false;
                        l.empty();
                        while (!u) {
                            if (s[r] == e[0].weekday) {
                                u = true
                            } else {
                                l.append('<div class="blank"></div>');
                                r++
                            }
                        }
                        for (var c = 0; c < 42 - r; c++) {
                            if (c >= e.length) {
                                l.append('<div class="blank"></div>')
                            } else {
                                var v = e[c].day;
                                var m = g(new Date(t, n - 1, v)) ? '<div class="today"><span>' : "<div>";
                                l.append(m + "" + v + "</span></div>")
                            }
                        }
                        var y = o[n - 1];
                        a.css("background-color", y).find("h5").text(i[n - 1] + " " + t);
                        f.find("div").css("color", y);
                        l.find(".today").css("background-color", y);
                        d()
                    }

                    function h() {
                        var e = [];
                        for (var r = 1; r < v(t, n) + 1; r++) {
                            e.push({
                                day: r,
                                weekday: s[m(t, n, r)]
                            })
                        }
                        return e
                    }

                    function p() {
                        f.empty();
                        for (var e = 0; e < 7; e++) {
                            f.append("<div>" + s[e].substring(0, 2) + "</div>")
                        }
                    }

                    function d() {
                        var t;
                        var n = $("#calendar").css("width", e + "px");
                        n.find(t = "#calendar_weekdays, #calendar_content").css("width", e + "px").find("div").css({
                            width: e / 7 + "px",
                            height: e / 9 + "px",
                            "line-height": e / 7 + "px"
                        });
                        n.find("#calendar_header").css({
                            height: e * (1 / 9) + "px"
                        }).find('i[class^="icon-chevron"]').css("line-height", e * (1 / 9) + "px")
                    }

                    function v(e, t) {
                        return (new Date(e, t, 0)).getDate()
                    }

                    function m(e, t, n) {
                        return (new Date(e, t - 1, n)).getDay()
                    }

                    function g(e) {
                        return y(new Date) == y(e)
                    }

                    function y(e) {
                        return e.getFullYear() + "/" + (e.getMonth() + 1) + "/" + e.getDate()
                    }

                    function b() {
                        var e = new Date;
                        t = e.getFullYear();
                        n = e.getMonth() + 1
                    }
                    var e = 375;
                    var t = 2013;
                    var n = 9;
                    var r = [];
                    var i = ["JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE", "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER"];
                    var s = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                    var o = ["#ffffff"];
                    var u = $("#calendar");
                    var a = u.find("#calendar_header");
                    var f = u.find("#calendar_weekdays");
                    var l = u.find("#calendar_content");
                    b();
                    c();
                    a.find('i[class^="icon-chevron"]').on("click", function() {
                        var e = $(this);
                        var r = function(e) {
                            n = e == "next" ? n + 1 : n - 1;
                            if (n < 1) {
                                n = 12;
                                t--
                            } else if (n > 12) {
                                n = 1;
                                t++
                            }
                            c()
                        };
                        if (e.attr("class").indexOf("left") != -1) {
                            r("previous")
                        } else {
                            r("next")
                        }
                    })
                })
    }
}
</script>
