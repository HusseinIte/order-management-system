# Orders and Customers Management API

## Overview
This is a training project built using Laravel that manages orders and payments for customers. The system allows CRUD operations for customers and their orders, as well as filtering based on specific criteria. Additionally, it includes a payment management system with various features like fetching the latest, first, highest, and lowest payments for each customer.

## Features

### Customers
- **Add New Customer**: Create a new customer with relevant details.
- **View All Customers**: List all customers in the system.
  
### Orders
- **Add New Order**: Assign a new order to a specific customer.
- **View Customer Orders**: Display all orders placed by a specific customer.
- **Filter Orders by Product**: View all orders containing certain products.
- **Filter Orders by Status**: Display customers with orders having a specific status (e.g., "Completed", "Pending").
- **Filter Customers by Order Date**: List customers who have placed orders within a given date range.

### Payments
- **Add Payment for Customer**: Record a new payment for a specified customer.
- **View Latest Payment**: Retrieve the latest payment made by the customer using `latestOfMany`.
- **View First Payment**: Retrieve the first payment made by the customer using `oldestOfMany`.
- **View Highest Payment**: Fetch the highest payment made by the customer using `ofMany`.
- **View Lowest Payment**: Fetch the lowest payment made by the customer using `ofMany`.


   ### Steps to Run the System


- [Installation](#installation)
 1. **Clone the repository:**
 
     ```bash
     git clone https://github.com/HusseinIte/CoursesManagementSystem.git
     cd CoursesManagementSystem
     ```
 
 2. **Install dependencies:**
 
     ```bash
     composer install
     npm install
     ```
 
 3. **Copy the `.env` file:**
 
     ```bash
     cp .env.example .env
     ```
 
 4. **Generate an application key:**
 
     ```bash
     php artisan key:generate
     ```
 
 5. **Configure the database:**
 
     Update your `.env` file with your database credentials.
 
 6. **Run the migrations:**
 
     ```bash
     php artisan migrate --seed
     ```
 7. **Run the seeders (Optional):**
 
     If you want to populate the database with sample data, use the seeder command:
 
     ```bash
     php artisan db:seed
     ```
 8. **Serve the application:**
 
     ```bash
     php artisan serve
     ```
