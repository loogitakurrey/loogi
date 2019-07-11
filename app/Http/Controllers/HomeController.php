<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function currentCurrencyRate()
    {
        $api_key='d4ec30171e';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://data.fixer.io/api/latest?access_key=d4ec30171e&symbols=INR,USD,EUR,GBP,ILS');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $result= curl_exec($ch);
        curl_close($ch);
        //print_r(json_decode($result,true));
        $data = json_decode($result,true);
        $data1 = $data['rates'];
        $inr = $data1['INR'];
        $usd = $data1['USD'];
        $eur = $data1['EUR'];
        $gbp = $data1['GBP'];
        $ils = $data1['ILS'];
        $k = DB::table('current_rate')->where(["date"=>date('Y-m-d')])->first();
        if(! $k)
        {
        DB::table('current_rate')->insert(["date"=>date('Y-m-d'),"INR"=>$inr,"USD"=>$usd,"EUR"=>$eur,"GBP"=>$gbp,"ILS"=>$ils]);
        }
        else
        {
        DB::table('current_rate')->where("date",date('Y-m-d'))->update(["INR"=>$inr,"USD"=>$usd,"EUR"=>$eur,"GBP"=>$gbp,"ILS"=>$ils]);
        }
        return view('home',["data"=>$data]);
    }

    public function selectedcountry(Request $request)
    {
        $input = $request->all();
        $input = $request->input('selcted_country');
        $k = DB::table('current_rate')->where('date',date('Y-m-d'))->select($input)->get();
        foreach($k as $data)
        {
            $input = $data->$input;
        }
        return ($input);
    }
    public function base_cur(Request $request)
    {
        $input = $request->all();
        $input = $request->input('base_cur');
        $api_key='d4ec30171e8d13fc2a03138e1aae3800';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://data.fixer.io/api/latest?access_key=d4ec30171e&base='.$input.'&symbols=INR,USD,EUR,GBP,ILS');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $result= curl_exec($ch);
        curl_close($ch);
        //print_r(json_decode($result,true));
        $data = json_decode($result,true);
        $data1 = $data['rates'];
        $inr = $data1['INR'];
        $usd = $data1['USD'];
        $eur = $data1['EUR'];
        $gbp = $data1['GBP'];
        $ils = $data1['ILS'];
        $k = DB::table('current_rate')->where(["date"=>date('Y-m-d')])->first();
        if(! $k)
        {
        DB::table('current_rate')->insert(["date"=>date('Y-m-d'),"INR"=>$inr,"USD"=>$usd,"EUR"=>$eur,"GBP"=>$gbp,"ILS"=>$ils]);
        }
        else
        {
        DB::table('current_rate')->where("date",date('Y-m-d'))->update(["INR"=>$inr,"USD"=>$usd,"EUR"=>$eur,"GBP"=>$gbp,"ILS"=>$ils]);
        }
        return view('home',["data"=>$data]);        
    }
    
    public function base(Request $request)
    {
        $input=$request->all();
        $to_country=$request->input('to_country');
        $from_country=$request->input('from_country');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://free.currconv.com/api/v7/convert?q=".$to_country."_".$from_country."&compact=ultra&apiKey=d4ec30171e");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $headers = array();
        $headers[] = "Content-Type:application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);
        //echo "<pre>";
        $data = json_decode($result,true);
        $data = $data[$to_country.'_'.$from_country];
        return ($data);

    }
   
     public function history(Request $request)
    {
        $input=$request->all();
        $date=$request->input('date');
        //return ($date);
        $date = date('Y-m-d',strtotime($date));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://data.fixer.io/api/".$date."?access_key=d4ec30171e&symbols=INR,USD,EUR,GBP,ILS");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $headers = array();
        $headers[] = "Content-Type:application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);
        //echo "<pre>";
        $data = json_decode($result,true);
        $rates = $data['rates'];
        //$data = $data[$to_country.'_'.$from_country];
        return json_encode($rates);
    }
}
