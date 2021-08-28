<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\menu_list;
use App\order_list;
use App\orders;
// use App\Auth;
use DateTime;
use Carbon\Carbon;


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
        $menuList=menu_list::all()->toArray();
      // echo '<pre>';  print_r($menuList);die;
        return view('pages/menu_list',['menuList'=>$menuList]);
    }

    public function menu_save(Request $res)
    {
    // dd($res->category);
        menu_list::create(['name' => $res->menu_name,'category' =>$res->category,'price' => $res->price,'status' => $res->status]);
        // $menuList=menu_list::all()->toArray();
        return redirect('menu');
        //  return view('pages/menu_list',['menuList'=>$menuList]);
    }

    public function new_order()
    {
        $respose=[];
        
        $all_order = orders::where('created_at', '>', Carbon::today())->get()->toArray();
        // echo '<pre>';print_r($all_order);die;
        //allorder();
        
        foreach($all_order as $key=>$val){
            // echo $val['id'];die;
           $orderDeatils = order_list::where('order_id','=',$val['id'])->get()->toArray();
           $all_order[$key]['order_lists']=$orderDeatils;
           
        }
        // echo '<pre>';  print_r($all_order);die;
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
       $user = auth()->user();
       $employee = $user->name; 
       $lastrecord= orders::all()->last()
    //    ->get()
        ->toArray();
        $createDate = new DateTime($lastrecord['created_at']);
        $createDate = $createDate->format('Y-m-d');

        //print_r($createDate);
        //echo '<br>';
        // die;
       // print_r(date('y-d-m h:i:s',time()));
    //   print_r($lastrecord['created_at'] - date('m/d/Y h:i:s a', time()));die;
       
       $now = new DateTime();
      // echo $date_ifi=date("Y-m-d");
      // echo '<br>';
       //die;
    //    $difference = $createDate->diff($date_ifi);
       $createdates = date_create($createDate);
       $createcurrent = date_create(date("Y-m-d"));
       $difference =date_diff($createdates,$createcurrent);
        // print_r($difference);
        // die;
        $token=0;
       if($difference->d==0){
        $token = @$lastrecord['bill_no']+1;
       }else{
        $token=1;
       }
    //   echo $token;die;
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
        $order->emp_name=$employee;
        $order->cust_phone=$res->cust_phone;
        $order->total_price=$res->totall_amount;
        $order->order_type=$res->order_type;
        $order->discount_per=$res->discount_per;
        $order->dis_amount=$res->dis_amount;
        $order->orderStatus='Active';
        $order->bill_no=$token;
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
        //die('check');
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
        $orderName= order_list::distinct()->whereBetween('created_at', [$fromDate." 00:00:00", $toDate." 23:59:59"])
        
        ->pluck('name')->toArray();
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
       
        $ordertype= orders::select('order_type','total_price')
        ->whereNotIn('orderStatus', ['Cancel','Delete'])
        ->whereBetween('created_at', [$fromDate." 00:00:00", $toDate." 23:59:59"])->get()->toArray();
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

        $respose['orderType']['Zomato']['totalcost']=$zomato_cost;
        $respose['orderType']['Cash']['totalcost']=$cash_cost;
        $respose['orderType']['Online']['totalcost']=$online_cost;

        $respose['orderType']['Zomato']['orderNo']=$zomato;
        $respose['orderType']['Online']['orderNo']=$online;
        $respose['orderType']['Cash']['orderNo']=$cash;
        

        $ordercancel= orders::select('order_type','total_price')
        ->whereIn('orderStatus', ['Cancel'])
        ->whereBetween('created_at', [$fromDate." 00:00:00", $toDate." 23:59:59"])->get()->toArray();


        $zomato_c=$online_c=$cash_c=0;
        $zomato_cost_c=$online_cost_c=$cash_cost_c=0;
        foreach($ordercancel as $key=>$val){
            if($val['order_type']=='Zomato'){
                $zomato_c++; 
                $zomato_cost_c +=$val['total_price'];
            }
            if($val['order_type']=='Cash'){
                $cash_c++;
                $cash_cost_c +=$val['total_price'];
            }
            if($val['order_type']=='Online'){
                $online_c++;
                $online_cost_c +=$val['total_price'];
            } 
        }

        $respose['orderType_c']['Zomato']['totalcost']=$zomato_cost_c;
        $respose['orderType_c']['Cash']['totalcost']=$cash_cost_c;
        $respose['orderType_c']['Online']['totalcost']=$online_cost_c;

        $respose['orderType_c']['Zomato']['orderNo']=$zomato_c;
        $respose['orderType_c']['Online']['orderNo']=$online_c;
        $respose['orderType_c']['Cash']['orderNo']=$cash_c;


        $orderDiscount = orders::select('order_type','dis_amount')
        ->whereNotIn('orderStatus', ['Cancel','Delete'])
        ->whereBetween('created_at', [$fromDate." 00:00:00", $toDate." 23:59:59"])->get()->toArray();

        $zomato_d=$online_d=$cash_d=0;
        $zomato_dost_d=$online_dost_d=$cash_dost_d=0;
        foreach($orderDiscount as $key=>$val){
            if($val['order_type']=='Zomato'){
                $zomato_d++; 
                $zomato_dost_d +=$val['dis_amount'];
            }
            if($val['order_type']=='Cash'){
                $cash_d++;
                $cash_dost_d +=$val['dis_amount'];
            }
            if($val['order_type']=='Online'){
                $online_d++;
                $online_dost_d +=$val['dis_amount'];
            } 
        }

        $respose['orderType_d']['Zomato']['totalcost']=$zomato_dost_d;
        $respose['orderType_d']['Cash']['totalcost']=$cash_dost_d;
        $respose['orderType_d']['Online']['totalcost']=$online_dost_d;

        $respose['orderType_d']['Zomato']['orderNo']=$zomato_d;
        $respose['orderType_d']['Online']['orderNo']=$online_d;
        $respose['orderType_d']['Cash']['orderNo']=$cash_d;
        // dd($ordercancel);
        //$ordertype = array_count_values($ordertype);    
        //$respose[2'order_types']=$ordertype;

      // echo '<pre>'; print_r($respose);
        return view('pages/report',$respose);
    }

    function menuStatus(Request $res){
        $result= menu_list::where('id',$res->id)->update(['status'=>$res->type]);
       //echo "<pre>"; print_r($result);
        if($result==1){
            return 'success';
        }else{
            return 'Failed';
        }
    }

    function updatePrice(Request $res){

        $result= menu_list::where('id',$res->id)->update(['price'=>$res->updatePrice]);
       //echo "<pre>"; print_r($result);
        if($result==1){
            return 'success';
        }else{
            return 'Failed';
        }

    }
}

    