<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quotes REST API - Nathan Birkes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
            background: #f9f9f9;
            color: #333;
        }
        h1 { color: #4a90d9; }
        h3 { color: #555; }
        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 14px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 10px 0 25px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            text-align: left;
        }
        th { background: #4a90d9; color: white; }
        tr:nth-child(even) { background: #f2f2f2; }
    </style>
</head>
<body>
    <h1>📚 Quotes REST API</h1>
    <p>Built by <strong>Nathan Birkes</strong> | INF653 Back End Web Development</p>
    <p>Base URL: <code>/api</code></p>

    <h3>Quotes Endpoints</h3>
    <table>
        <tr><th>Method</th><th>Endpoint</th><th>Description</th></tr>
        <tr><td>GET</td><td>/api/quotes/</td><td>Get all quotes</td></tr>
        <tr><td>GET</td><td>/api/quotes/?id=1</td><td>Get quote by ID</td></tr>
        <tr><td>GET</td><td>/api/quotes/?author_id=1</td><td>Get quotes by author</td></tr>
        <tr><td>GET</td><td>/api/quotes/?category_id=1</td><td>Get quotes by category</td></tr>
        <tr><td>GET</td><td>/api/quotes/?author_id=1&category_id=1</td><td>Get quotes by author and category</td></tr>
        <tr><td>POST</td><td>/api/quotes/</td><td>Create a new quote</td></tr>
        <tr><td>PUT</td><td>/api/quotes/</td><td>Update a quote</td></tr>
        <tr><td>DELETE</td><td>/api/quotes/</td><td>Delete a quote</td></tr>
    </table>

    <h3>Authors Endpoints</h3>
    <table>
        <tr><th>Method</th><th>Endpoint</th><th>Description</th></tr>
        <tr><td>GET</td><td>/api/authors/</td><td>Get all authors</td></tr>
        <tr><td>GET</td><td>/api/authors/?id=1</td><td>Get author by ID</td></tr>
        <tr><td>POST</td><td>/api/authors/</td><td>Create a new author</td></tr>
        <tr><td>PUT</td><td>/api/authors/</td><td>Update an author</td></tr>
        <tr><td>DELETE</td><td>/api/authors/</td><td>Delete an author</td></tr>
    </table>

    <h3>Categories Endpoints</h3>
    <table>
        <tr><th>Method</th><th>Endpoint</th><th>Description</th></tr>
        <tr><td>GET</td><td>/api/categories/</td><td>Get all categories</td></tr>
        <tr><td>GET</td><td>/api/categories/?id=1</td><td>Get category by ID</td></tr>
        <tr><td>POST</td><td>/api/categories/</td><td>Create a new category</td></tr>
        <tr><td>PUT</td><td>/api/categories/</td><td>Update a category</td></tr>
        <tr><td>DELETE</td><td>/api/categories/</td><td>Delete a category</td></tr>
    </table>
</body>
</html>