<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Product Display</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold text-center mb-4">Real-Time Product List</h1>
        <button onclick="fetchProducts()" class="bg-blue-500 text-white px-4 py-2 rounded-lg mb-4">Fetch Products</button>
        <ul id="product-list" class="space-y-4"></ul>
    </div>

    <script>
        // Fetch products from backend
        function fetchProducts() {
            axios.get('/fetch-products')
                .then(response => console.log(response.data))
                .catch(error => console.error(error));
        }

        // Load products and display them
        function loadProducts() {
            axios.get('/products')
                .then(response => {
                    const products = response.data;
                    const list = document.getElementById('product-list');
                    list.innerHTML = '';  // Clear the product list

                    // Loop through each product and display its details
                    products.forEach(product => {
                        let item = document.createElement('li');
                        item.classList.add("bg-gray-200", "p-4", "rounded-lg", "shadow-md");
                        item.innerHTML = `
                            <div class="flex space-x-4">
                                <!-- Product Image -->
                                <img src="${product.image}" alt="${product.name}" class="w-32 h-32 object-cover rounded-lg">

                                <div class="flex-1">
                                    <!-- Product Name -->
                                    <h2 class="font-bold text-lg text-gray-800">${product.name}</h2>

                                    <!-- Product Category -->
                                    <p class="text-sm text-gray-600">${product.category}</p>

                                    <!-- Product Price -->
                                    <p class="mt-2 text-green-600 font-semibold">${product.price} USD</p>

                                    <!-- Product Description -->
                                    <p class="text-sm text-gray-700 mt-2">${product.description}</p>

                                    <!-- Product Rating -->
                                    <div class="flex items-center mt-2">
                                        <span class="text-yellow-500 font-semibold">⭐ ${product.rating_rate}</span>
                                        <span class="ml-2 text-gray-600 text-sm">(${product.rating_count} reviews)</span>
                                    </div>
                                </div>
                            </div>
                        `;
                        list.appendChild(item);  // Add product to the list
                    });
                })
                .catch(error => console.error(error));
        }

        // Load initial products
        loadProducts();

        // Pusher Configuration for real-time updates
        Pusher.logToConsole = true;
        var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
            cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
            forceTLS: true
        });

        var channel = pusher.subscribe('product-channel');
        channel.bind('product-updated', function(data) {
            console.log('New product received:', data);
            loadProducts();  // Reload product list after receiving real-time updates
        });
    </script>
</body>
</html>
