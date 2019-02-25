<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\PriceBoard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Formolcalc extends DataController
{
    public function calc(Request $request)
    {
        $no_t=0;
        dd($request->all());
        $customer_group_id=DB::table('customers')->where('customers_id',$request->customer_id)->select('customers_group_id');
        $customer_pay=DB::table('product_customer_group_pay_cent')->where('id_customer_group',$customer_group_id)->where('id_product',$request->prodcuts_id)->get();
        $customer_group=DB::table('customer_group')->where('customers_group_id',$customer_group_id)->get();
        $product=DB::table('products')->where('products_id',$request->prodcuts_id)->first();
        $g=$product->products_weight;
        $price= PriceBoard::find(2);
        if($customer_pay==null)
            $k=$o=1;
        else {
            $k = $customer_pay[0]->pay / 100 + 1;
            $o = $customer_pay[0]->pay_make;
        }
        $m=$customer_group[0]->tax_customer_group/100+1;
        $s=$customer_group[0]->profit_customer_group/100+1;
        $atrr_products=DB::table('products_attributes')->where('products_id',$request->prodcut_id)->whereّIn('products_attributes_id',$request->attrid)->get();
        foreach ($atrr_products as $atrr_product)
        {
              if($atrr_product->product_attr_mode==0)
                  $o=$o+$atrr_product->options_values_price;
              elseif($atrr_product->product_attr_mode==1)
                  $k=$k+($atrr_product->options_values_price/100+1);
              elseif($atrr_product->product_attr_mode==2)
                  $g=$g+($atrr_product->options_values_price);
        }

      return $result=(($g*$k*$s*$m)*$price->price)+$no_t+$o;
    }

}
