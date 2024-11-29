# 🍽️ WeRestaurant  

**WeRestaurant** is a comprehensive restaurant management system designed to streamline restaurant operations, including menu management, order processing, billing, and reporting. This project offers an easy-to-use interface for staff to manage day-to-day tasks efficiently.  

---

## 📋 Features  

### **Admin Module**  
- **Menu Management**  
  - Add, update, and delete menu items with categories and pricing.  
  - Upload images for menu items to enhance customer experience.  

- **Order Management**  
  - Process customer orders efficiently with a real-time interface.  
  - Modify orders as needed before generating a bill.  

- **Billing and Receipt Generation**  
  - Generate bills with detailed breakdowns, including taxes and service charges.  
  - Print and save invoices for customer and business records.  

- **User Authentication**  
  - Secure login system for staff to manage restaurant operations.  
  - Logout functionality ensures data privacy.  

- **Reports and Analytics**  
  - View daily, monthly, and custom-period sales reports.  
  - Analyze performance metrics and improve decision-making.  

### **Additional Features**  
- **Tax Management**  
  - Configure and apply tax rates for orders.  
- **Profile Management**  
  - Update admin profile details securely.  
- **Error Handling**  
  - Logs errors for troubleshooting and smooth operation.  

---

## ⚙️ Technology Stack  

### **Frontend**  
- HTML, CSS, JavaScript  
- Responsive design for seamless user experience.  

### **Backend**  
- PHP for server-side functionality.  
- MySQL for database management.  

### **Dependencies**  
- **Font Awesome**: For icons.  
- **jQuery**: For dynamic content updates.  
- **Bootstrap**: For responsive UI design.  

---

## 🔧 Setup Instructions  

### **1. Set Up the Database**  
1. Create a database named `werestaurant`.  
2. Import the provided `werestaurant.sql` file into the database.  

### **2. Configure the Database Connection**  
Update the `db.php` file with your database credentials:  
```php
$host = 'localhost';  
$db_name = 'werestaurant';  
$username = 'root';  
$password = '';
```
### **3. Install Dependencies** 
 Ensure your server supports:  
  - PHP 7.4 or later.
  - PHP extensions: mysqli, curl, mbstring.

### **4. Run the Application**
   - **For a local server:**  
     - Place the project folder in the server’s root directory (e.g., htdocs for XAMPP).
     - Access the project at http://localhost/WeRestaurant/.
   - **For a web server:** 
     - Upload the project files to the web server.
     - Configure config.php for production credentials.

## 🚀 How It Works
   - **admin Flow**
     - Login to the system.
     - Add or modify menu items.
     - Process customer orders and generate bills.
     - View and analyze sales reports.

## 📈 Project Highlights
  - Real-time Order Processing: Quickly modify and finalize orders for smooth service.
  - Interactive Reports: Easily accessible insights into sales performance.
  - Dynamic Menu Management: Make updates to the menu instantly.
  
