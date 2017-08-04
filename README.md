# wc-add-cutom-price-to-url
Allow selected WooCommerce products to have a price set in the URL

# Installation
Upload `woocommerce-add-price-to-url.php` to `wp-plugins` directory and activate it.

# Usage
To use a custom price in the URL:
1) Check the `Allow URL Price` checkbox. This is located in `Product Data` > `General` tab of the selected product.
2) To add a product to the cart with a custom price use the products id and a url param. For example:
If I want to sell 1 product with the product id of `609` and the custom price of `150.99` then the url would be:
`http://mywebsite.com/?add-to-cart=679&quantity=1&price=69.69`


