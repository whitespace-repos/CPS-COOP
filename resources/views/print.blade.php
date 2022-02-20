
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>{{ "COOP - " . auth()->user()->shop->shop_name . " Receipts"}}</title>
    <style>
        @font-face {
            font-family: Junge;
            src: url(Junge-Regular.ttf);
        }

        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #001028;
            text-decoration: none;
        }

        body {
            font-family: Junge;
            position: relative;
            width: 21cm;              
            margin: 0 auto; 
            color: #001028;
            background: #FFFFFF; 
            font-size: 14px; 
        }

        .arrow {
            margin-bottom: 4px;
        }

        .arrow.back {
            text-align: right;
        }

        .inner-arrow {
            padding-right: 10px;
            height: 30px;
            display: inline-block;
            background-color: rgb(233, 125, 49);
            text-align: center;

            line-height: 30px;
            vertical-align: middle;
        }

        .arrow.back .inner-arrow {
            background-color: rgb(233, 217, 49);
            padding-right: 0;
            padding-left: 10px;
        }

        .arrow:before,
        .arrow:after {
            content:'';
            display: inline-block;
            width: 0; height: 0;
            border: 15px solid transparent;
            vertical-align: middle;
        }

        .arrow:before {
            border-top-color: rgb(233, 125, 49);
            border-bottom-color: rgb(233, 125, 49);
            border-right-color: rgb(233, 125, 49);
        }

        .arrow.back:before {
            border-top-color: transparent;
            border-bottom-color: transparent;
            border-right-color: rgb(233, 217, 49);
            border-left-color: transparent;
        }

        .arrow:after {
            border-left-color: rgb(233, 125, 49);
        }

        .arrow.back:after {
            border-left-color: rgb(233, 217, 49);
            border-top-color: rgb(233, 217, 49);
            border-bottom-color: rgb(233, 217, 49);
            border-right-color: transparent;
        }

        .arrow span { 
            display: inline-block;
            width: 103px; 
            margin-right: 20px;
            text-align: right; 
        }

        .arrow.back span { 
            margin-right: 0;
            margin-left: 20px;
            text-align: left; 
        }

        h1 {
            color: #5D6975;
            font-family: Junge;
            font-size: 2.4em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            border-top: 1px solid #5D6975;
            border-bottom: 1px solid #5D6975;
            margin: 0 0 2em 0;
        }

        h1 small { 
            font-size: 0.45em;
            line-height: 1.5em;
            float: left;
        } 

        h1 small:last-child { 
            float: right;
        } 

        #project { 
            float: left; 
        }

        #company { 
            float: right; 
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 30px;
        }

        table th,
        table td {
            text-align: center;
        }

        table th {
            padding: 5px 20px;
            color: #5D6975;
            border-bottom: 1px solid #C1CED9;
            white-space: nowrap;        
            font-weight: normal;
            text-align:left;
        }

        table .service,
        table .desc {
            text-align: left;
        }

        table td {
            padding: 20px;
            text-align: left;
        }

        table td.service,
        table td.desc {
            vertical-align: top;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        table td.sub {
            border-top: 1px solid #C1CED9;
        }

        table td.grand {
            border-top: 1px solid #5D6975;
        }

        table tr:nth-child(2n-1) td {
            background: #EEEEEE;
        }

        table tr:last-child td {
            background: #DDDDDD;
        }


    
    </style>
  </head>
  <body>
    <main style="margin-top:50px;">
      <h1  class="clearfix"><small><span>DATE</span><br />{{ Carbon::today()->toDayDateTimeString() }}</small> {{ "COOP - " . auth()->user()->shop->shop_name . " Receipts"}} <small><span>{{ $carts->first()->attributes->customer->name}}</span><br />{{ $carts->first()->attributes->customer->phone}}</small></h1>
      <table>
        <thead>
          <tr>
            <th class="service">Product</th>            
            <th>PRICE</th>
            <th>QTY</th>
            <th>TOTAL</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($carts as $cart)
            <tr>
                <td class="service">{{ $cart->attributes->product->product_name }}</td>                
                <td class="unit">{{ $cart->price }}</td>
                <td class="qty">{{ $cart->attributes->weight .' '. $cart->attributes->product->weight_unit }}</td>
                <td class="total">{{ $cart->price }}</td>
            </tr>
          @empty
            <tr><th colspan="4">Cart is empty.</th></tr>
          @endforelse         
        </tbody>
      </table>
      <div id="details" class="clearfix">
        <div id="project">
          <div class="arrow"><div class="inner-arrow"><span>Customer</span> {{ $carts->first()->attributes->customer->name}}</div></div>
          <div class="arrow"><div class="inner-arrow"><span>Customer Phone</span> {{ $carts->first()->attributes->customer->name}}</div></div>          
        </div>
        <div id="company">
          <div class="arrow back"><div class="inner-arrow">COOP <span>Company Name</span></div></div>
          <div class="arrow back"><div class="inner-arrow">{{ auth()->user()->shop->shop_name }} <span>Shop Name</span></div></div>
          <div class="arrow back"><div class="inner-arrow">{{ auth()->user()->shop->shop_id }}<span>Shop ID</span></div></div>
          <div class="arrow back"><div class="inner-arrow">{{  auth()->user()->shop->address }} <span>ADDRESS</span></div></div>                    
        </div>
      </div>
      <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
      </div>
    </main>
  </body>
</html>