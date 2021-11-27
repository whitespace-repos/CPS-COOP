<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />
        <!-- Core theme CSS (includes Bootstrap)-->
        
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.css"/> 
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.0.1/b-colvis-2.0.1/b-html5-2.0.1/b-print-2.0.1/fh-3.2.0/r-2.2.9/sc-2.0.5/sb-1.2.2/datatables.min.css"/>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <!--  -->
          <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />

        <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
   
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.0.1/b-colvis-2.0.1/b-html5-2.0.1/b-print-2.0.1/fh-3.2.0/r-2.2.9/sc-2.0.5/sb-1.2.2/datatables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.2.0/js/dataTables.fixedHeader.min.js"></script>
        <script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>    
        <script src="{{ asset('js/jquery.blockUI.js') }}"></script>    
        <script src="{{ asset('js/jquery.mask.min.js') }}"></script>   
        <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script> 
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


        <script src="https://unpkg.com/feather-icons"></script>
        <script src="{{ asset('plugins/validation/formValidation.min.js') }}" ></script>
        <script src="{{ asset('plugins/validation/framework/bootstrap.js') }}" ></script>
        <script src="{{ asset('plugins/ckeditor/ckeditor.js') }}" ></script>  

        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
        <script src="{{ asset('plugins/chosen/chosen.jquery.min.js') }}" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js" integrity="sha512-RdSPYh1WA6BF0RhpisYJVYkOyTzK4HwofJ3Q7ivt/jkpW6Vc8AurL1R+4AUcvn9IwEKAPm/fk7qFZW3OuiUDeg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    </head>
    <body>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar-->
            <div class="border-end bg-white" id="sidebar-wrapper">
                <div class="sidebar-heading border-bottom bg-light">CPS</div>
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!"><i data-feather="home" class="mr-1"></i> Dashboard</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="{{ route('employee.index') }}"><i data-feather="user" class="mr-1"></i> Employees</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="{{ route('rate.index') }}" onclick="$.blockUI()"><i data-feather="dollar-sign" class="mr-1"></i> Rates</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3"  href="{{ route('sales.index') }}" onclick="$.blockUI()"><i data-feather="activity" class="mr-1"></i> Sales</a>
                </div>                
            </div>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper">
                <!-- Top navigation-->              
                <!-- Page content-->
                <div class="container-fluid">
                    {{ $slot }}
                </div>
            </div>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{ asset('js/scripts.js') }}"></script>
        <!--  -->
        <style>
            .datatable-header , .datatable-footer {
                justify-content: space-between !important;
                display: flex;
            }
        </style>

        <!--  -->
        <!-- Modal -->
        <div class="modal fade" id="dynamicModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="dynamicModalLabel" aria-hidden="true"></div>

        <script>
            var sidebar = new Vue({
                el: '#sidebar-wrapper',
                data: {
                        message: 'Hello Vue!'
                }
            })
        </script>
        <button class="btn btn-primary" id="sidebarToggle" style="position: fixed;bottom: 6px;right: 50px;">Toggle Menu</button>

    </body>
</html>
