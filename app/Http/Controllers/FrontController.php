<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    public function shop() 
    {
        $items = Item::orderBy('id','DESC')->paginate(8);
        // var_dump($items);
        return view('front.shops',compact('items'));
    }

    public function shopItem($id)
    {
        // echo $id;
        $item = Item::find($id);
        $category_id = $item->category_id;
        $related_items = Item::where('category_id',$category_id)->where('id','!=',$id)->orderBy('id','DESC')->limit(4)->get();
        // $feature_post = Item::where('category_id',$category_id)->orderBy('id','DESC')->limit(1)->first();

        return view('front.shop-item',compact('item','related_items'));
    }

    public function carts() {
        $payments = Payment::all();
        return view('front.carts',compact('payments'));
    }

    public function orderNow(Request $request) {
        // dd($request);
        $dataArray = json_decode($request->orderItems);
        // var_dump($dataArray);
        $voucher_no = time();
        // echo $voucher_no;

        //file upload
        $file_name = time().'.'.$request->payment_slip->extension(); //123412343434.png

        $upload = $request->payment_slip->move(public_path('images/payment-slips/'),$file_name); //folder ထဲကို upload လုပ်တာ
        // $data နဲ့ယူတာတွေသည် localStorage ထဲမှာသိမ်းထားတဲ့ data
        // $request နဲ့ယူတာတွေသည် input data တွေ 
        foreach($dataArray as $data) {
            $order = new Order();

            $order->voucher_no = $voucher_no;
            $order->total = $data->qty*($data->price - ($data->price*($data->discount/100)));
            $order->qty = $data->qty;
            $order->payment_slip = '/images/payment-slips/'.$file_name;
            $order->status = 'Pending';
            $order->address = $request->address;
            $order->item_id = $data->id;
            $order->payment_id = $request->payment_method;
            $order->user_id = Auth::id();
            $order->save();
        }

        return 'Your Order Successful';
    }

    public function itemCategory($category_id) {
        $items = Item::where('category_id',$category_id)->orderBy('id','DESC')->paginate(8);
        return view('front.item-category',compact('items'));
    }   
}
