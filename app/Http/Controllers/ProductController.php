<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Discount;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // create instance from product model
        $modelInstance = new Product();

        // calling get product function in product model
        $products = $modelInstance->getProducts();

        // going to products page in resources/view with and listing products there 
        return view('products', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // retrieve all of the incoming request's input data as an array
        $products = $request->all();

        // initialize variables
        $subtotal = 0;
        $shipping = 0;
        $topsProduct = 0;
        $jacketNum = 0;
        $jacketDiscount = 0;
        $shoesDiscount = 0;
        $shippingDiscount = 0;

        // get discounts ratio from discount tables
        $modelInstance = new Discount();
        $discounts = $modelInstance->getDiscounts();
        
        // get products discount in an array:
        // product name as key and discount as value  
        $modelInstance = new Product();
        $productsDiscount = $modelInstance->getProductsDiscount();
        
        foreach($products as $product){
            // get subtotal by looping on cart products and adding products price
            $subtotal = $subtotal + $product['price'];

            // convert the weight from kg to g then divided on ratio of shipping
            $weight = ($product['weight'] * 1000) / $discounts['rate_per_gram'] ;
            
            // get shipping by adding the shipping value of last products
            // with weight of the product multiplied with country rate
            $shipping = $shipping + ($product['country']['rate'] * $weight);

            // making sure user bought any two tops (t-shirt or blouse)
            if($product['name'] == "Blouse" || $product['name'] == "T-shirt"){
                $topsProduct = ++$topsProduct;

            }
            
            // make sure user bought a jacket and number of jackets he bought
            // and set jacket price and jacket discount ratio
            if($product['name'] == "Jacket"){
                $jacketNum = ++$jacketNum;
                $jacketPrice = $product['price'];
                $jacketDiscountRatio = $product['discount'];
            }

            // set shoes discount if he bought a shoes
            if($product['name'] == "Shoes"){
                $shoesDiscount = $shoesDiscount + (($product['price'] * $product['discount']) / 100 );
            }
        }

        // set shipping discount if he bought 2 products or more
        if(count($products) >= 2){
            $shippingDiscount = $discounts['shipping_discount'];
        }

        // check tops product more than 2 and he bought a jacket
        if($topsProduct >= 2 && $jacketNum >= 1){
            // calculate jacket discount
            $jacketDiscount = (($jacketPrice * $jacketDiscountRatio) / 100 );
            // if tops product double jacket number or more then give him discount on all jackets
            // if not then set the jacket discount debend on the ratio between 
            // number of jacket and number of tops product
            if($jacketNum*2 <= $topsProduct){
                $jacketDiscount = $jacketNum * $jacketDiscount;
            }
            // if number of tops product odd subtract one and divided by 2 
            elseif($topsProduct % 2 == 1){
                $jacketDiscount = $jacketDiscount * ($topsProduct - 1) / 2;
            }
            // else if it even just divided by 2 and multiply by jacket discount
            else{
                $jacketDiscount = $jacketDiscount * $topsProduct / 2;
            }
        }

        // calculate value added tax 
        $vat = ($subtotal * $discounts['vat']) / 100;

        // calculate total
        $total = $subtotal + $vat + $shipping - ($shippingDiscount + $jacketDiscount + $shoesDiscount);
        
        // finally, return the invoice 
        $invoice = array(
            'subtotal'          => $subtotal,
            'vat'               => $vat,
            'products_discount' => $productsDiscount,
            'discount_ratio'    => $discounts,
            'shipping'          => $shipping,
            'total'             => $total,
            'discounts_value'   => array(
                'shipping_discount' => $shippingDiscount,
                'jacket_discount'   => $jacketDiscount,
                'shoes_discount'    => $shoesDiscount
            )
        );
        
        return $invoice;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modelInstance = new Product();
        $product = $modelInstance->getProductbyId($id);
        return $product;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
