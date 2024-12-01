

# **Event Management System**

## **Overview**

The Event Management System is designed to simplify the management of university events, clubs, and registrations. It allows administrators, advisors, and users to manage events, income, expenses, sponsorships, and registrations efficiently.  

---

## **Prerequisites**

1. **XAMPP** (or any local server with PHP and MySQL):
   - Download and install XAMPP from [here](https://www.apachefriends.org/index.html).
2. **Web Browser** (Google Chrome, Firefox, etc.).
3. **Code Editor** (Optional but recommended: VS Code, Sublime Text, etc.).

---

## **Installation Steps**

### **1. Clone or Download the Project**

1. Clone the repository or download the project as a ZIP file.
   ```bash
   git clone https://github.com/sumonstr12/Event_manageMent_System.git
   ```
2. Extract the ZIP file (if downloaded).

### **2. Set Up XAMPP**

1. Start **Apache** and **MySQL** from the XAMPP Control Panel.  
2. Navigate to the XAMPP installation folder (default: `C:\xampp\htdocs`).  
3. Place the project folder in the `htdocs` directory.

---

### **3. Import the Database**

1. Open your browser and go to:  
   ```
   http://localhost/phpmyadmin
   ```
2. Create a new database:
   - Name the database (e.g., `event_management`).
3. Import the database file:
   - Click **Import** and choose the SQL file (`event_management.sql`) from the project folder.
   - Click **Go** to upload the database.

---

### **4. Configure the Database Connection**

1. Open the project folder in your code editor.  
2. Locate the database configuration file (e.g., `dbconnect.php`):  
   ```php
   <?php
   $host = "localhost";
   $user = "root";
   $password = "";
   $database = "event_management";

   $conn = mysqli_connect($host, $user, $password, $database);

   if (!$conn) {
       die("Connection failed: " . mysqli_connect_error());
   }
   ?>
   ```
3. Ensure the database credentials match your local setup:
   - **Host**: `localhost`
   - **Username**: `root`
   - **Password**: (leave blank if no password is set)
   - **Database Name**: Use the name of the imported database.

---

### **5. Run the Project**

1. Open your browser and navigate to:
   ```
   http://localhost/<project-folder-name>/
   ```
2. You should see the homepage of the Event Management System.

---

## **Usage Instructions**

### **Admin Access**
1. Use the admin credentials to log in:
   - **Username**: `admin@example.com` (default email in the database)
   - **Password**: `password123` (default password in the database)

2. Manage events, clubs, and announcements via the admin dashboard.

---

### **User Registration**
1. Navigate to the registration page.
2. Fill in the user details to register for events and segments.

---

## **Support**

If you encounter any issues:
- Check your database connection settings.
- Ensure that XAMPP services (Apache, MySQL) are running.
- Verify that the database is properly imported.

For further assistance, please contact **[Your Name]** at **[Your Email]**.

---

## **License**

This project is open-source and free to use. You can modify it as needed.

--- 

This **README.md** file provides clear steps and ensures that your project is easy to set up and run. Let me know if you’d like any changes!