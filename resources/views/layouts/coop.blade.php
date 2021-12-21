<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Coop Billing System</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
                <h4 style="align-self:center; color:brown;">{{ auth()->user()->shop->shop_name  }}</h4>
                <div class="header-top-language d-flex">
                    <button class="btn dropdown-toggle header-action-btn" type="button" id="languageButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <label>{{ auth()->user()->name }}</label>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="languageButton">
                        <li> 
                              <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item" href="{{ route('logout') }}"  onclick="event.preventDefault();
                                this.closest('form').submit();">Logout</a> </li>

                            </form>
                
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


            Vue.directive('weight', {
                bind: function (el, binding, vnode) {             
                    el.innerHTML = "<span>"+el.innerText+"<sup class='small'> "+binding.value+"</sup> </span>";
                }
            });       
        </script>
        @stack('append-scripts')
    </body>
</html>
