# Diabetes Management System - XAMPP Ready

## Quick Setup Instructions for XAMPP

### Step 1: Extract Files
1. Extract the `diabetes_management_system_xampp.zip` file
2. Copy the entire `diabetes_management_system` folder to your XAMPP `htdocs` directory
   - Usually located at: `C:\xampp\htdocs\` (Windows) or `/Applications/XAMPP/htdocs/` (Mac)

### Step 2: Start XAMPP Services
1. Open XAMPP Control Panel
2. Start **Apache** and **MySQL** services
3. Wait for both services to show "Running" status

### Step 3: Create Database
1. Open your web browser
2. Go to: `http://localhost/phpmyadmin`
3. Click "Import" tab
4. Click "Choose File" and select the `database.sql` file from the project folder
5. Click "Go" to import the database

### Step 4: Access the Website
1. Open your web browser
2. Go to: `http://localhost/diabetes_management_system`
3. You will be redirected to the login page

### Step 5: Login
Use these credentials to login:
- **Username:** `shaikha`
- **Password:** `123456`

Or use any of these demo accounts:
- **Username:** `ahmed123` | **Password:** `password`
- **Username:** `sara_ali` | **Password:** `password`

## Features Included

✅ **Complete User Authentication System**
- Login and registration pages
- Session management
- User profile display

✅ **Dashboard with Personal Greeting**
- Displays user's name (شيخة will appear as "شيخة")
- Time-based greetings (Good morning/afternoon/evening)
- Quick access to all features

✅ **Medical Management Features**
- Doctor Consultations
- Hospital Appointments
- Test Results Tracking
- Emergency Contacts
- Recommended Meals for Diabetes

✅ **Professional Design**
- Responsive layout
- Modern UI with gradients
- Professional medical imagery
- Mobile-friendly design

✅ **XAMPP Optimized**
- Default MySQL settings (root user, no password)
- Plain text passwords for easy testing
- Pre-configured database connection
- Ready-to-use demo data

## File Structure
```
diabetes_management_system/
├── css/style.css              # All styling
├── js/script.js               # JavaScript functionality
├── images/                    # All images and icons
├── includes/config.php        # Database configuration
├── database.sql               # Database structure and data
├── index.php                  # Redirects to login
├── login.php                  # Login page
├── register.php               # Registration page
├── dashboard.php              # Main dashboard
├── consultations.php          # Doctor consultations
├── appointments.php           # Hospital appointments
├── test_results.php           # Test results
├── emergency.php              # Emergency services
├── recommended_meals.php      # Meal recommendations
├── logout.php                 # Logout handler
└── README.md                  # This file
```

## Troubleshooting

**If you can't access the website:**
1. Make sure Apache and MySQL are running in XAMPP
2. Check that the folder is in the correct htdocs directory
3. Try accessing: `http://localhost/diabetes_management_system/login.php`

**If login doesn't work:**
1. Make sure you imported the database.sql file
2. Check that MySQL is running
3. Use the exact credentials: `shaikha` / `123456`

**If database connection fails:**
1. Open `includes/config.php`
2. Verify the database settings match your XAMPP configuration
3. Default settings should work: host=localhost, username=root, password=(empty)

## Demo User Information

**Primary User (شيخة):**
- Username: `shaikha`
- Password: `123456`
- Full Name: شيخة
- This user has sample medical data for testing

**Additional Demo Users:**
- `ahmed123` / `password` (Ahmed Al-Rashid)
- `sara_ali` / `password` (Sara Ali Johnson)
- `john_doe` / `password` (John Michael Doe)
- `mary_smith` / `password` (Mary Elizabeth Smith)

## Security Note

This version uses plain text passwords for easy testing and setup. In a production environment, passwords should be properly hashed for security.

## Support

If you encounter any issues:
1. Check that XAMPP services are running
2. Verify the database was imported correctly
3. Ensure the files are in the correct htdocs directory
4. Try accessing the website using the direct URL

---

**Ready to use!** Just copy to htdocs, start XAMPP, import database, and login with `shaikha` / `123456`

