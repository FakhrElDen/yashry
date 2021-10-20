<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Yashry Task</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>

        <link rel="shortcut icon" href="https://cdn11.bigcommerce.com/s-y2uyjca306/product_images/fav-icon.png?t=1607035427">
    </head>
    <body>
        <div class="container pt-5">
            <h2>Products Table</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Item type</th>
                        <th>Item price</th>
                        <th>Shipped from</th>
                        <th>Weight</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price }}$</td>
                            <td>{{ $product->country->name }}</td>
                            <td>{{ $product->weight }}Kg</td>
                            <td><button type="button" onclick="addToCart({{ $product->id }})" class="btn btn-success">Add To Cart</button></td>
                        </tr>
                    @empty
                        <tr>
                            <td><h2>THERE ARE NO PRODUCTS YET .. </h2></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
      
            <div id="cart" style="display:none;">
                <div class="container mt-3">
                    <h2>Cart</h2>
                </div> 
                <div class="container mt-3">
                    <ul class="list-group list-group-flush" id="myList"></ul>
                    <button onclick="Checkout(cart)" type="button" class="btn btn-primary">Checkout</button>
                </div>
            </div>

            <div id="checkout" style="display:none;">
                <div class="container mt-3">
                    <h2>Checkout</h2>
                </div> 
                <div class="container mt-3">
                    <ul class="list-group list-group-flush" id="myList">
                        <li>Subtotal: $<span id="subtotal"></span></li> 
                        <li>Shipping: $<span id="shipping"></span></li>
                        <li>VAT: $<span id="vat"></span></li>
                        <li id="discount" style="display:none;">Discounts: 
                            <ul>
                                <li id="shoes" style="display:none;">
                                    <span id="shoDiscount"></span>% off shoes:  -$<span id="shoesDiscount"></span>
                                </li>
                                <li id="jacket" style="display:none;">
                                    <span id="jackDiscount"></span>% off jacket:  -$<span id="jacketDiscount"></span>
                                </li>
                                <li id="shipped" style="display:none;">
                                    $<span id="shippDiscount"></span> of shipping:  -$<span id="shippingDiscount"></span>
                                </li>
                            </ul>
                        </li>
                        <li>Total: $<span id="total"></span></li>
                    </ul>
                </div>
            </div>
            
        </div>
        
        <script src="product.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    </body>
</html>