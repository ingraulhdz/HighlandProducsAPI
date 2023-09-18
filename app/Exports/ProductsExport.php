<?php

namespace App\Exports;

use App\Models\ProductApiOk;
use App\Models\ProductsShopify;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductsExport implements FromView
{
    public function view(): View
    {
        //return view('products.excel', ['products' => ProductApiOk::where('id', '>', 19714)->whereNotNull('handle')->get()
        //$products = ProductApiOk::whereBetween('id', [1 ,15])->whereNotNull('handle')->get();
       // $products = ProductsShopify::where('description', '!=', "")->whereBetween('id', [1 ,22890])->get();
       $products = ProductsShopify::select(
        "july_now.Item_description", 
        "july_now.Item",
        "july_now.Case_Qty",
        "july_now.LxWxH_Case",
        "july_now.Wgt_Unit",
        "july_now.Container",
        "july_now.LxWxH_Bottle",
        "july_now.Pallet_Qty",
        "july_now.Sales_Class",
        "products_api_ok.handle", 
        "products_api_ok.description", 
        "products_api_ok.img", 
    )
    ->join("products_api_ok", "products_api_ok.upc", "=", "july_now.Upc")
    ->get();
        
        return view('products.excel', compact('products'));
    }
}