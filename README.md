# PHP Web Application - Order Management System

## Project Description

This project is a PHP-based web application that manages customer orders. The application allows users to browse and order products, manage their shopping cart, provide customer information, and confirm orders. It includes user authentication, error handling, and session management for tracking customer and cart data. The application is built using a model-view-controller (MVC) pattern.

### Features
- **Customer Account**: Users can log in or create a new account during checkout.
- **Product Selection**: Users can browse products, add them to a shopping cart, and update quantities.
- **Order Process**: A multi-step order process that includes adding items to the cart, providing customer information, and confirming orders.
- **Authentication**: Customers can log in to speed up the checkout process.
- **Order Confirmation**: After placing an order, customers receive an order summary.
- **Session Management**: Keeps track of cart items and customer information using PHP sessions.

## Controllers

- **MainController.php**: Handles the main routing and application logic. It directs the user to different pages such as the product ordering page, customer information page, login, and order confirmation.
  
### Actions

1. **`index`**: 
   - Renders the homepage of the application.
   
2. **`bestel`**:
   - Manages product selection and shopping cart updates. Allows users to add products to the cart and adjust item quantities.

3. **`klantgegevens`**:
   - Handles customer information submission and login functionality. Validates customer details before proceeding to the order overview.

4. **`login`**:
   - Authenticates customers using email and password. If successful, it redirects them to the order overview page.

5. **`verwerkKlantgegevens`**:
   - Processes the customer data submitted during checkout, including adding or updating customer details in the database.

6. **`besteloverzicht`**:
   - Shows the overview of the order, including products in the cart and customer details, before the user confirms the order.

7. **`bevestiging`**:
   - Finalizes the order by saving it to the database and displaying an order confirmation page.

8. **`toonBevestiging`**:
   - Displays the order confirmation page after an order has been successfully placed.

9. **`logout`**:
   - Logs the user out by clearing the session and redirects them to the homepage.

10. **`error`**:
   - Displays an error page when an exception is caught.

## Project Structure

- **`Business/`**: Contains the business logic classes for handling customers, products, orders, etc.
- **`Presentation/`**: Contains the view files for rendering HTML output (e.g., order pages, forms).
- **`vendor/`**: Includes third-party libraries installed via Composer.
- **`MainController.php`**: The main controller that routes user requests to the appropriate handlers.
  
## Error Handling

Errors encountered during the order process (e.g., login issues, missing customer data) are caught and displayed on an error page. The error message is stored in the session and cleared after display to prevent repetition.

## Future Enhancements

- **Admin Panel**: Add a section for managing products, customers, and orders.
- **Order History**: Allow customers to view their past orders.
- **Product Recommendations**: Implement a recommendation system based on customer behavior.
- **Improved Security**: Enhance authentication and session management for better security.

## License

This project is licensed under the MIT License - see the LICENSE file for details.

--- 

This README gives a clear overview of the system, how to run it, and the major functionalities. Feel free to customize it based on your project specifics!
