<?php 

namespace App\Http\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * trait ZoomMeetingTrait
 */
trait  CPSTrait
{
    protected $client;
    private $url;
    private $headers;

    public function __construct() {    
        $this->url = env('AIRTABLE_URL', '');
        $this->headers = [
            'Authorization' => 'Bearer '.env('AIRTABLE_KEY',''),
            'Content-Type'  => 'application/json'          
        ];
    }

    public function getList($table,$max=10,$sort = "Date" , $direction = 'desc')
    {       
        $url = $this->url.$table.'?sort[0][field]='.$sort.'&sort[0][direction]='.$direction.'&maxRecords='.$max;      
        $response = Http::withHeaders($this->headers)->get($url);
        //  
        return  ($response->successful()) ? $response->collect()['records'] : [];
    }

    public function getCustomerSalesList($table,$phone,$max=10,$sort = "Date" , $direction = 'desc')
    {       
        $url = $this->url.$table."?filterByFormula=({Customer}='".$phone."')&sort[0][field]=".$sort."&sort[0][direction]=".$direction."&maxRecords=".$max;      
        $response = Http::withHeaders($this->headers)->get($url);
        //  
        return  ($response->successful()) ? $response->collect()['records'] : [];
    }
  
    private function getRecord($table,$id)
    {
        $url = $this->url.$table.'/'.$id;
        $response = Http::withHeaders($this->headers)->get($url);
        // 
        return  ($response->successful()) ? $response->collect() : [];        
    }

    public function getTodayRates(){       
        $url = $this->url.'Rate?filterByFormula=SEARCH(TODAY(),DATE)&sort[0][field]=ID&sort[0][direction]=desc&maxRecords=1';        
        $response = Http::withHeaders($this->headers)->get($url);
        //     
        return  ($response->successful()) ? $response->collect()['records'] : [];
    }


    public function getDataOfToday($table){
        $url = $this->url.$table.'?filterByFormula=SEARCH(TODAY(),DATE)';        
        $response = Http::withHeaders($this->headers)->get($url);
        //     
        return  ($response->successful()) ? $response->collect()['records'] : [];        
    }


    public function getCustomerByPhoneNumber($phone){       
        $url = $this->url."Customers?filterByFormula=({Phone}='".$phone."')";        
        $response = Http::withHeaders($this->headers)->get($url);
        //     
        return  ($response->successful()) ? $response->collect()['records'] : []; 
    }


    public function saveRecord($table,$data){       
        $url = $this->url.$table;             
        $response = Http::withHeaders($this->headers)->post($url, [
                                                                                "records" => [
                                                                                                    [
                                                                                                        "fields" => $data
                                                                                                    ]
                                                                                ]
                                                                            ]);
        //       
        return  $response;
    }


    public function patchRecord($table,$data, $id){       
        $url = $this->url.$table;             
        $response = Http::withHeaders($this->headers)->patch($url, [
                                                                                "records" => [
                                                                                                    [
                                                                                                        "id"     => $id ,
                                                                                                        "fields" => $data
                                                                                                    ]
                                                                                ]
                                                                            ]);
        //          
        return  $response;
    }

    
    


    private function getRecordDate($table,$id)
    { 
         return $this->getRecord($table,$id)['fields']['Date'];   
    }


    public function fixArrayKey(&$arr)
    {
        $arr = array_combine(
            array_map(
                function ($str) {
                    return str_replace("_", " ", $str);
                },
                array_keys($arr)
            ),
            array_values($arr)
        );
    
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                fixArrayKey($arr[$key]);
            }
        }
    }
}