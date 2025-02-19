# Mini Blog & Shopping Cart

A simple web application that combines a **blogging platform** with a **shopping cart system** using PHP and MySQL. Users can **create, edit, and delete blog posts** while also managing a shopping cart.

## Features

### Blog System
- User authentication (Login/Register/Logout)
- Create, edit, and delete blog posts
- Upload and display images for blog posts
- Display all posts with author details

### Shopping Cart
- Browse products
- Add products to the cart
- Update or remove items from the cart
- Checkout functionality

## Technologies Used
- **Frontend:** HTML, CSS (Bootstrap)
- **Backend:** PHP, MySQL
- **Database:** MySQL
- **Session Handling:** PHP Sessions

## Installation

### 1. Clone the Repository
```sh
git clone https://github.com/yourusername/mini-blog-cart.git
cd mini-blog-cart
```

### 2. Setup Database
1. Create a new database in MySQL (e.g., `mini_blog_cart`).
2. Import the `database.sql` file:
   ```sql
   SOURCE path/to/database.sql;
   ```
3. Update `config.php` with your database credentials:
   ```php
   $conn = new mysqli('localhost', 'root', '', 'mini_blog_cart');
   ```

### 3. Start XAMPP (or any PHP server)
Ensure **Apache** and **MySQL** are running.

### 4. Run the Project
Place the project in `htdocs` and access it via:
```
http://localhost/mini-blog-cart/
```

## Folder Structure
```
mini-blog-cart/
├── includes/
│   ├── header.php
│   ├── footer.php
│
├── uploads/         # Stores uploaded images
├── config.php       # Database connection
├── index.php        # Homepage
├── blog.php         # Blog listing & post creation
├── cart.php         # Shopping cart system
├── login.php        # User login
├── register.php     # User registration
├── logout.php       # Logout function
```

## Features Breakdown

### User Authentication
- Users can register and log in.
- Session handling ensures secure authentication.
- Users must be logged in to create/edit posts.

### Blog System
- Users can create blog posts with images.
- Posts are stored in the database and displayed.
- Users can edit or delete their own posts.

### Shopping Cart
- Users can browse available products.
- Items can be added, removed, or updated in the cart.
- Checkout functionality processes the cart.

## Future Improvements
- Add admin panel for managing users/posts.
- Implement product categories and filters.
- Improve security with prepared statements.
- Integrate payment gateway for shopping cart.

## License
This project is open-source and available under the [MIT License](LICENSE).

---
Developed by **[Your Name]** 🚀

