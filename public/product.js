// initialize cart array
let cart = [];

// get product by id then push it to cart array
function addToCart(id){
    // show cart which give
    document.getElementById("cart").style.display = "";
    $.ajax({
        type: 'GET',
        url: '/product/'+id,
        dataType:'json',
        success:function(data){
            cart.push(data);
            // get element which its id myList 
            var item = document.getElementById("myList");
            // then insert before end of this element the product name which we add it in cart 
            item.insertAdjacentText("beforeend", data.name);
            // and insert break line after product name
            item.insertAdjacentHTML("beforeend", "<br>");
        }
    });
}

function Checkout(cart){
    // hidden the cart to show the invoice after that  
    document.getElementById("cart").style.display = "none";
    // add token to request headers
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // send cart array to request and getting the invoice as return data if success
    $.ajax({
        type: 'POST',
        url: '/checkout',
        data: JSON.stringify(cart),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success:function(data){

            if(data.discounts_value.jacket_discount > 0 || data.discounts_value.shipping_discount > 0 || data.discounts_value.shoes_discount > 0){
                // show discount part if there any discount value
                document.getElementById("discount").style.display = "";
                // if there is value for jacket discount
                if(data.discounts_value.jacket_discount > 0){
                    // show discount value of jacket and discount ratio also
                    document.getElementById("jacket").style.display = "";
                    document.getElementById("jackDiscount").innerHTML = data.products_discount.Jacket;
                    document.getElementById("jacketDiscount").innerHTML = data.discounts_value.jacket_discount.toFixed(4);
                }
                // if there is value for shipping discount
                if(data.discounts_value.shipping_discount > 0){
                    // show discount value of shipping and discount ratio also
                    document.getElementById("shipped").style.display = "";
                    document.getElementById("shippDiscount").innerHTML = data.discount_ratio.shipping_discount;
                    document.getElementById("shippingDiscount").innerHTML = data.discounts_value.shipping_discount.toFixed(4);
                }
                // if there is value for shoes discount
                if(data.discounts_value.shoes_discount > 0){
                    // show discount value of shoes and discount ratio also
                    document.getElementById("shoes").style.display = "";
                    document.getElementById("shoDiscount").innerHTML = data.products_discount.Shoes;
                    document.getElementById("shoesDiscount").innerHTML = data.discounts_value.shoes_discount.toFixed(4);
                }
            }
            // finally, show the rest of the invoice values round to four decimal places
            document.getElementById("checkout").style.display = "";
            document.getElementById("subtotal").innerHTML = data.subtotal.toFixed(4);
            document.getElementById("shipping").innerHTML = data.shipping.toFixed(4);
            document.getElementById("vat").innerHTML = data.vat.toFixed(4);
            document.getElementById("total").innerHTML = data.total.toFixed(4);
        },
        error:function(error){
            // if there is an error show it for debugging
            console.log(error)
        }
    });  
}
