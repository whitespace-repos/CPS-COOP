<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Coop Billing System</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Bootstrap CSS File -->
        <link href="{{ asset('assets/lib/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- Libraries CSS Files -->
        <link href="{{ asset('assets/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

        <!-- Main Stylesheet File -->
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    </head>

    <body>

        <header id="header" >
            <div class="custom-container">
                <div class="logo"><a href="#"><img src="{{ asset('assets/img/logo.png') }}" alt="logo"></a></div>
                <div class="header-top-language d-flex">
                    <button class="btn dropdown-toggle header-action-btn" type="button" id="languageButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <label>Robert Del Naja</label>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="languageButton">
                        <li> <a class="dropdown-item" href="#">Logout</a> </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main id="main">
            {{ $slot }}
        </main>




        <main id="main">
        
        </main>



        <!-- The Modal -->
        <div class="modal" id="myModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"> 
            
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Request Stock</h4>
                <button type="button" class="close" data-dismiss="modal"><img src="{{ asset('assets/img/cross_btn.png') }}" alt=""></button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                <div class="poupDiv">
                <ul>
                    <li>
                    <div class="itemBox"> <span class="img"><img src="{{ asset('assets/img/hean.png') }}" alt="icon"></span> <span class="txt">
                        <h3>243 kg</h3>
                        <p>Broiler Live</p>
                        </span> </div>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="10" >
                        <div class="input-group-append">
                        <small class="input-group-text">kg</small>
                        </div>
                    </div>
                    </li>
                    <li>
                    <div class="itemBox"> <span class="img"><img src="{{ asset('assets/img/egg.png') }}" alt="icon"></span> <span class="txt">
                        <h3>9000 Nr.</h3>
                        <p>Eggs</p>
                        </span> </div>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="10" >
                        <div class="input-group-append">
                        <small class="input-group-text">kg</small>
                        </div>
                    </div>
                    </li>
                    <li>
                    <div class="itemBox"> <span class="img"><img src="{{ asset('assets/img/hean1.png') }}" alt="icon"></span> <span class="txt">
                        <h3>243 kg</h3>
                        <p>Layer Live</p>
                        </span> </div>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="10" >
                        <div class="input-group-append">
                        <small class="input-group-text">kg</small>
                        </div>
                    </div>
                    </li>
                </ul>
                </div>
            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Stock Request</button>
            </div>
            </div>
        </div>
        </div>

        <!-- JavaScript Libraries --> 
        <script src="{{ asset('assets/lib/jquery/jquery.min.js') }}"></script> 
        <script src="{{ asset('assets/lib/jquery/jquery-migrate.min.js') }}"></script> 
        <script src="{{ asset('assets/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script> 
        <script src="{{ asset('assets/lib/owlcarousel/owl.carousel.min.js') }}"></script> 
        <script src="{{ asset('assets/js/main.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
        {{--  --}}
        <script src="{{ asset('js/jquery.mask.min.js') }}" defer></script>
        <script src="{{ asset('js/jquery.numeric.js') }}" defer></script> 
        <script src="https://unpkg.com/feather-icons"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

        <script>
            feather.replace(); 
            Vue.directive('currency', {
                bind: function (el, binding, vnode) {
                    el.innerHTML = "<sup class='small'>INR</sup> <span class='pro-price'>"+el.innerText+"</span>";
                }
            });       
        </script>
        @stack('append-scripts')
    </body>
</html>
