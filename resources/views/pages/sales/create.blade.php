<x-cps-layout>
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-tabs-x@1.3.5/css/bootstrap-tabs-x-bs4.min.css" media="all" rel="stylesheet" type="text/css" >
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-tabs-x@1.3.5/js/bootstrap-tabs-x.min.js" type="text/javascript"></script>

    <h4 class="mt-4">Bhuvan Sales</h4>   
    
    <hr class="mb-5 mt-4" />    
    <div class="content">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
            <button class="nav-link active ajax-call" id="response-container-tab" data-bs-toggle="tab" data-bs-target="#response-container" type="button" role="tab" aria-controls="response-container" aria-selected="true" data-ajax-url="{{ route('load.current.sales.tab','Broiler Live Sales') }}" >Broiler Live</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link ajax-call" id="response-container-tab" data-bs-toggle="tab" data-bs-target="#response-container" type="button" role="tab" aria-controls="response-container" aria-selected="false" data-ajax-url="{{ route('load.current.sales.tab','Broiler Chicken Sales') }}">Broiler Chicken</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link ajax-call" id="layer-tab" data-bs-toggle="tab" data-bs-target="#layer" type="button" role="tab" aria-controls="layer" aria-selected="false" data-ajax-url="{{ route('load.current.sales.tab','Layer Sales') }}">Layer</button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link ajax-call" id="egg-tab" data-bs-toggle="tab" data-bs-target="#egg" type="button" role="tab" aria-controls="egg" aria-selected="false" data-ajax-url="{{ route('load.current.sales.tab','Egg Sales') }}">Egg</button>
            </li>

            <a href="{{ route('print') }}" class="btn btn-sm align-self-center ml-auto btn-primary">Print</a>    
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="response-container" role="tabpanel" aria-labelledby="blive-tab"> 
                @include('pages.sales.ajax.broilerLive')
            </div>           
        </div>
    </div> 
</x-cps-layout>
