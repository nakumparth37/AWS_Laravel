const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/users.js', 'public/js')
   .js('resources/js/products.js', 'public/js')
   .js('resources/js/orders.js', 'public/js')
   .js('resources/js/productDetails.js', 'public/js')
   .sourceMaps(); // Add this line if you want source maps

mix.sass('resources/scss/app.scss', 'public/css')
   .sass('resources/scss/admin.scss','public/css')
   .sass('resources/scss/productDetails.scss','public/css');
