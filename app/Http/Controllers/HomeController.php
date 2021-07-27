<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\menu_list;
use App\order_list;
use App\orders;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function menu()
    {
        return view('pages/menu_list');
    }

    public function menu_save(Request $res)
    {
        
        menu_list::create(['name' => $res->menu_name,'price' => $res->price,'status' => $res->status]);
         
         return view('pages/menu_list');
    }

    public function new_order()
    {
        $respose=[];
        $all_order = orders::all()->toArray();
        //echo '<pre>';print_r($all_order);die;
        //allorder();
        
        foreach($all_order as $key=>$val){
            // echo $val['id'];die;
           $orderDeatils = order_list::where('order_id','=',$val['id'])->take(50)->get()->toArray();
           $all_order[$key]['order_lists']=$orderDeatils;
           
        }
        //echo '<pre>';  print_r($all_order);die;
        $respose['all_order']=$all_order;
        
        $respose['menu_lists'] = menu_list::select('name', 'price')
        ->where('status','=','A')
        ->get()->toArray();   
        // print_r($menu_lists);
        
        return view('pages/new_order',$respose);
    }

    public function popupOpenItem(){
        $respose['menu_lists'] = menu_list::select('name', 'price')
        ->where('status','=','A')
        ->get()->toArray();   
        // print_r($menu_lists);
        
        return view('pages/ajax_popupOpenItem',$respose);
    }

    public function save_order(Request $res){
       $menu=$respose=[];
        $cust_name = $res->cust_name;
        $cust_phone = $res->cust_phone;
        $item_name = $res->item_name;
       // print_r($item_name);// comming
        $item_price = $res->item_price;
        // print_r($item_price);//die;
        $item_total_price = $res->item_total_price;
        // print_r($item_total_price);
        $item_quantity = $res->item_quantity;
        // print_r($item_quantity);
        $totall_amount=$res->totall_amount;
        $order=new orders();
        $order->cust_name=$res->cust_name;
        $order->cust_phone=$res->cust_phone;
        $order->total_price=$res->totall_amount;
        $order->order_type=$res->order_type;
        $order->save();
        $respose['order']=$order;
        //echo $order->id;die;
        foreach($item_name as $key=>$val){
              $arr= $menu[$val]=[];
            // echo '$item_price[$key]'.$val[$key];
            // die;
            // $data = array(
            //     "Item"=>$val,
            //     "item_price"=>$item_price[$key],
            //     "item_total_price"=>$item_total_price[$key],
            //     "item_quantity"=>$item_quantity[$key]
            // );
             //print_r($data);die;
           // $data1 = array_merge($arr,$data);
           // die('before query');
            $order_list = new order_list();
            $order_list->order_id=$order->id;
            $order_list->name=$val;
            $order_list->quantity=$item_quantity[$key];
            $order_list->price=$item_price[$key];
            $order_list->total_cost=$item_total_price[$key];
            $order_list->save();
            
            //order_list::create(['name' => $res->menu_name,'price' => $res->price,'status' => $res->status]);
            
        }

        $respose['order_lists'] = order_list::select('name', 'price','quantity','total_cost')
        ->where('order_id','=',$order->id)
        ->get()->toArray();   
        
        return view('print/index',$respose);
        //print_r($data1);die('checks');   
    }

    public function allorder(){
        $all_order = order_list::all();
        p($all_order);
    }

    public function orderStatus(Request $res){
        
       $result= orders::where('id',$res->id)->update(['orderStatus'=>$res->type]);
       //echo "<pre>"; print_r($result);
        if($result==1){
            return 'success';
        }else{
            return 'Failed';
        }
    }
    public function customReport(Request $res){
        $respose=[];        
          $fromDate=@$res->from;
         $toDate=@$res->to;
        
        //$fromDate='2021-07-15';
        //$toDate='2021-07-23';
       // echo gettype($fromDate);die;
        $orderName= order_list::distinct()->whereBetween('created_at', [$fromDate." 00:00:00", $toDate." 23:59:59"])->pluck('name')->toArray();
        //echo '<pre>'; print_r($orderName);die;
        //$respose['item_reports'];
        foreach($orderName as $keyName){
            //echo $key;die;
            $orderNameList= order_list::select()->where('name',$keyName)->whereBetween('created_at', [$fromDate." 00:00:00", $toDate." 23:59:59"])->get()->toArray();
          //  echo '<pre>'; print_r($orderNameList);die;
            $qty=$tcost=0;
            foreach($orderNameList as $key=>$value){
                $qty += $value['quantity'];
                $tcost += $value['total_cost'];
            }
            $respose['item_reports'][$keyName]['quantity']=$qty;
            $respose['item_reports'][$keyName]['total_cost']=$tcost;
            
        }
       
        $ordertype= orders::select('order_type','total_price')->whereBetween('created_at', [$fromDate." 00:00:00", $toDate." 23:59:59"])->get()->toArray();
        $zomato=$online=$cash=0;
        $zomato_cost=$online_cost=$cash_cost=0;
        foreach($ordertype as $key=>$val){
            if($val['order_type']=='Zomato'){
                $zomato++; 
                $zomato_cost +=$val['total_price'];
            }
            if($val['order_type']=='Cash'){
                $cash++;
                $cash_cost +=$val['total_price'];
            }
            if($val['order_type']=='Online'){
                $online++;
                $online_cost +=$val['total_price'];
            } 
        }
        //$ordertype = array_count_values($ordertype);    
        //$respose[2'order_types']=$ordertype;

       echo '<pre>'; print_r($ordertype);
        return view('pages/report',$respose);
    }
}

    