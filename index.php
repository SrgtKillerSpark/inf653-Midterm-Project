<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INF653 Midterm Project - Quotes REST API</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #1a1a2e;
            color: #eee;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px;
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: #e94560;
        }
        .subtitle {
            font-size: 1.1rem;
            color: #aaa;
            margin-bottom: 40px;
        }
        .card {
            background: #16213e;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 20px;
            width: 100%;
            max-width: 700px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        .card h2 {
            color: #e94560;
            margin-bottom: 15px;
            font-size: 1.4rem;
        }
        .endpoint {
            background: #0f3460;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 10px;
            font-family: 'Courier New', monospace;
            font-size: 0.95rem;
        }
        .method {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 0.8rem;
            margin-right: 10px;
        }
        .get { background: #27ae60; color: #fff; }
        .post { background: #f39c12; color: #fff; }
        .put { background: #3498db; color: #fff; }
        .delete { background: #e74c3c; color: #fff; }
        footer {
            margin-top: 40px;
            color: #666;
            font-size: 0.9rem;
        }
        a { color: #e94560; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>Quotes REST API</h1>
    <p class="subtitle">INF653 Back End Web Development - Midterm Project</p>

    <div class="card">
        <h2>GET Endpoints</h2>
        <div class="endpoint"><span class="method get">GET</span>/api/quotes/ - All quotes</div>
        <div class="endpoint"><span class="method get">GET</span>/api/quotes/?id={id} - Single quote</div>
        <div class="endpoint"><span class="method get">GET</span>/api/quotes/?author_id={id} - Quotes by author</div>
        <div class="endpoint"><span class="method get">GET</span>/api/quotes/?category_id={id} - Quotes by category</div>
        <div class="endpoint"><span class="method get">GET</span>/api/quotes/?author_id={id}&amp;category_id={id}</div>
        <div class="endpoint"><span class="method get">GET</span>/api/authors/ - All authors</div>
        <div class="endpoint"><span class="method get">GET</span>/api/authors/?id={id} - Single author</div>
        <div class="endpoint"><span class="method get">GET</span>/api/categories/ - All categories</div>
        <div class="endpoint"><span class="method get">GET</span>/api/categories/?id={id} - Single category</div>
    </div>

    <div class="card">
        <h2>POST Endpoints</h2>
        <div class="endpoint"><span class="method post">POST</span>/api/quotes/ - Create a quote</div>
        <div class="endpoint"><span class="method post">POST</span>/api/authors/ - Create an author</div>
        <div class="endpoint"><span class="method post">POST</span>/api/categories/ - Create a category</div>
    </div>

    <div class="card">
        <h2>PUT Endpoints</h2>
        <div class="endpoint"><span class="method put">PUT</span>/api/quotes/ - Update a quote</div>
        <div class="endpoint"><span class="method put">PUT</span>/api/authors/ - Update an author</div>
        <div class="endpoint"><span class="method put">PUT</span>/api/categories/ - Update a category</div>
    </div>

    <div class="card">
        <h2>DELETE Endpoints</h2>
        <div class="endpoint"><span class="method delete">DELETE</span>/api/quotes/ - Delete a quote</div>
        <div class="endpoint"><span class="method delete">DELETE</span>/api/authors/ - Delete an author</div>
        <div class="endpoint"><span class="method delete">DELETE</span>/api/categories/ - Delete a category</div>
    </div>

    <footer>
        <p>&copy; 2024 INF653 Midterm Project</p>
    </footer>
</body>
</html>
