# INF653 Midterm Project - Quotes REST API

**Author:** [Your Name]

## Description
A PHP OOP REST API for managing quotations. Supports full CRUD operations for quotes, authors, and categories.

## Deployed Project
[Live API](https://your-project-url.onrender.com)

## API Endpoints

### Quotes
- `GET /api/quotes/` - Get all quotes
- `GET /api/quotes/?id={id}` - Get a specific quote
- `GET /api/quotes/?author_id={id}` - Get quotes by author
- `GET /api/quotes/?category_id={id}` - Get quotes by category
- `GET /api/quotes/?author_id={id}&category_id={id}` - Get quotes by author and category
- `POST /api/quotes/` - Create a new quote
- `PUT /api/quotes/` - Update a quote
- `DELETE /api/quotes/` - Delete a quote

### Authors
- `GET /api/authors/` - Get all authors
- `GET /api/authors/?id={id}` - Get a specific author
- `POST /api/authors/` - Create a new author
- `PUT /api/authors/` - Update an author
- `DELETE /api/authors/` - Delete an author

### Categories
- `GET /api/categories/` - Get all categories
- `GET /api/categories/?id={id}` - Get a specific category
- `POST /api/categories/` - Create a new category
- `PUT /api/categories/` - Update a category
- `DELETE /api/categories/` - Delete a category

## Technologies
- PHP 8+
- MySQL / PostgreSQL
- PDO
