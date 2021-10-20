# yashry

I used the Laravel framework and MySQL database.
I used Laravel blade to put HTML code.
I used AJAX to call APIs.

First:
I made three tables in the database:
(1)The first one was for countries. 
(2)The second one for products, then I made relation one to many between countries and products.
(3)The third one is for the discount ratio to make the code more dynamic. 

Second:
On the home page, I listed the products in the database.
You can add the product to the cart by ajax then place your order also by ajax.
then you can find your invoice.
For more details in those files below, you will find comments on every line of code. 
"resources/view/products.blade.php"
"public/product.js"
"app/http/controllers/productcontroller"
