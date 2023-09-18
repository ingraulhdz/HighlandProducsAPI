<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use App\Models\Product;
use App\Models\ProductApi;
use App\Models\ProductApiOk;
use App\Models\ProductNull;
use App\Models\ProductsShopify;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class ProductController extends Controller
{

    public function index()
    {


//$products = ProductNull::get();
//$products= ProductApiOk::whereBetween('id', [346 ,500])->get();
// seedData($products);


         //$product = ProductNull::get();
//         $product = getProduct('033674143278');
//$products = ProductsShopify::where('title', '!=', "")->get();

//$products = ProductsShopify::where('description', '!=', "")->whereBetween('id', [1 ,22890])->get();

  return Excel::download(new ProductsExport, 'unpdate_weight.csv', \Maatwebsite\Excel\Excel::CSV);

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



	

	
	




//$items = DB::table('items')->whereIn('id', [1, 2, 3])->get();


$products = ProductApiOk::where('title', '!=', '')->whereNotNull('handle')->get();


$products = ProductApiOk::whereBetween('id', [1 ,10000])->orderBy('id', 'DESC')->get();



        
    }

    public function api()
    {

//seedData(5000,5010);

        $products = ProductApi::orderBy('id', 'ASC')->get();
        return view('products.api', compact('products'));
    }

    public function syncData()
    {


       //$products =    \DB::select("SELECT * FROM `higland_products_upc` WHERE `image_src`IS NULL OR `image_src` = '';");
       // $products = ProductsShopify::where('image_src', '')->get();
     //  seedData(12100,12500);

$products_api = ProductApi::get();


        \Session::flash('message', $message);
        $products = Product::orderBy('id', 'ASC')->get();
        return view('products.index', compact('products'));

    }

    public function toShopify()
    {

        return Excel::download(new ProductsExport, 'products.csv', \Maatwebsite\Excel\Excel::CSV);

    }

    public function show($id)
    {

        
        $product = ProductApi::find($id);
if($product->specs){
            $specs = json_decode($product->specs, true);

}else{
    $specs=null;

}


        return view('products.show', compact('product', 'specs'));

    }

    public function shopify()
    {

        $productsApi = ProductsShopify::orderBy('id', 'ASC')->get();
        return view('products.shopify', compact('productsApi'));
    }

    public function getDataApi()
    {

    }

    public function excel(Request $request)
    {

        //Excel::import(new PrudctsImport, request()->file('voucher'));
        //1 handle
        // 2 Title
        // 24 image src
        // 23 upc

        $maxId = Product::find(\DB::table('products_hl')->max('id'))->id;

        $collection = Excel::toArray(new ProductsImport, request()->file('voucher'));
        $col = collect([]);

        $calls = 0;

        // $upc = $collection[0][20][23];
        $total = count($collection[0]);

        //$total = 5;
        for ($i = 1; $i < $total; $i++) {

            $img = $collection[0][$i][24];
            $title = $collection[0][$i][1];
            $handle = $collection[0][$i][0];

            if ($collection[0][$i][23]) {
                $upc = $collection[0][$i][23];

                if ($upc) {
                    $api = getProduct($upc);
                }
                if ($api) {
if($api->product){
$product = $api->product;

                    $new = ProductApi::firstOrNew(['handle' => $handle]);
                    $new->handle = $handle;
                    $new->name = \Str::limit($product->name, 300);
                    $new->upc = $upc;
                    $new->description =  \Str::limit($product->description, 500);
                    $new->brand = $product->brand;
                    $new->img = $product->imageUrl;
                    $new->category = $product->category;
                    $new->ean = $product->ean;
                    $new->img_alt = \Str::limit($product->name, 300);
                    $new->region = $product->region;
                    $new->barcode_img = @$api->barcodeUrl;
                    $new->specs = json_encode($product->specs);
                    $new->save();

}else {
    $new = ProductApi::firstOrNew(['handle' => $handle]);
                    $new->api_error = @$api->error;

 
    $new->save();


}



                }

            }

        }

        $products = ProductApi::orderBy('id', 'ASC')->where('id', '>', 23428)->get();
          Excel::download($products, 'products.csv', \Maatwebsite\Excel\Excel::CSV);

        return view('products.api', compact('products', 'calls'));

       

    }

}

function getProduct($upc)
{
    $product_code = $upc;

    // $api_key_raul = 'c80590a21befd1baba40c5b12bc1ab551d1cc7b92a6f6cb716ba4c6b2300c919';
    $api_key = '039feb63527a835e6b085095608f1591aee92968b61f60f8fa19554ba70c6969';

    $api_base_url = 'https://go-upc.com/api/v1/code/';
    $url = $api_base_url . $product_code;

    $ch = curl_init();
    $data = get_product_data($url, $api_key, $ch);

    $product_data = json_decode($data);

    //var_dump($product_data);

    // $product = ($product_data->product);
    return $product_data;
}

function get_product_data($url, $api_key, $ch)
{
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $api_key,
    ));
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

function seedData($products){
    

    foreach ($products as $pp) {
        $api = getProduct($pp->upc);

        if ($api) {
            $product = @$api->product;
                     if ($product) {
            $new = ProductApiOk::firstOrNew(['handle' => $pp->handle]);
            $new->name = \Str::limit($product->name, 300);
            $new->description =  \Str::limit($product->description, 500);
            $new->brand = $product->brand;
            $new->img = $product->imageUrl;
            $new->category = $product->category;
            $new->ean = $product->ean;
            $new->img_alt = \Str::limit($product->name, 300);
            $new->region = $product->region;
            $new->barcode_img = @$api->barcodeUrl;
            $new->specs = json_encode($product->specs);
            $new->save();
          
        } else {
            $new = ProductApi::firstOrNew(['handle' => $pp->handle]);
                            $new->api_error = @$api->error;

         
            $new->save();
        }

        }

    }

}

function seedElement($upc){
    
        // $id = 4830;
        // $pp = ProductApi::where('id', $id)->first();
        // $api = getProduct($pp->upc);
//         if ($api) {
// $product = @$api->product;
//             if ($product) {
//                 $new = ProductApi::firstOrNew(['handle' => $pp->handle]);
//                 $new->name = $product->name;
//                 $new->description = $product->description;
//                 $new->brand = $product->brand;
//                 $new->img = $product->imageUrl;
//                 $new->category = $product->category;
//                 $new->ean = $product->ean;
//                 $new->img_alt = $product->name;
//                 $new->region = $product->region;
//                 $new->specs = json_encode($product->specs);

//$new->barcode_img = $api->barcodeUrl;
//                 $new->save();
              
//             } else {dd($api);
//                 $new = ProductApi::firstOrNew(['handle' => $pp->handle]);
//                 $new->api_error = @$api->error;
//                 $new->save();
//             }
//         }
//         $pp = ProductApi::where('id', $id)->first();
//         dd($pp);

}