<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Product Display</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
</head>
<body>
    <h1>Real-Time Product List</h1>
    <button onclick="fetchProducts()">Fetch Products</button>
    <ul id="product-list"></ul>

    <script>
        function fetchProducts() {
            axios.get('/fetch-products')
                .then(response => console.log(response.data))
                .catch(error => console.error(error));
        }

        function loadProducts() {
            axios.get('/products')
                .then(response => {
                    const products = response.data;
                    const list = document.getElementById('product-list');
                    list.innerHTML = '';
                    products.forEach(product => {
                        let item = document.createElement('li');
                        item.innerHTML = `<strong>${product.name}</strong>: ${product.price} USD`;
                        list.appendChild(item);
                    });
                })
                .catch(error => console.error(error));
        }

        // Load initial products
        loadProducts();

        // Pusher Configuration
        Pusher.logToConsole = true;
        var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
            cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
            forceTLS: true
        });

        var channel = pusher.subscribe('product-channel');
        channel.bind('product-updated', function(data) {
            console.log('New product received:', data);
            loadProducts();
        });
    </script>
</body>
</html>
