# Car Rental Reservation System - Setup & Implementation Guide

## Overview
This is a complete car rental reservation system built with PHP and MySQL. The system allows customers to reserve cars, and admins to approve/reject reservations. Once approved, customers can return the car and make payments.

## Complete Workflow

```
1. CUSTOMER REGISTRATION
   ↓
2. CUSTOMER LOGIN
   ↓
3. BROWSE AVAILABLE CARS
   ↓
4. CREATE RESERVATION (Select car, rental date, return date)
   Status: Pending
   ↓
5. ADMIN REVIEW (Admin sees pending reservations)
   ↓
6. ADMIN APPROVE/REJECT
   - If Approved → Notification sent to customer
   - If Rejected → Notification sent to customer
   ↓
7. CUSTOMER VIEWS BOOKINGS
   - Shows all reservations with status
   - If Approved: Shows "Return Car" button
   ↓
8. CUSTOMER CLICKS "RETURN CAR"
   - Payment modal appears
   - Shows total amount due
   ↓
9. CUSTOMER CONFIRMS PAYMENT
   - Payment recorded
   - Reservation status → Completed
   - Success notification shown
```

## Database Setup

### 1. Create Database
```sql
CREATE DATABASE `car-rental`;
```

### 2. Import SQL Schema
Run the SQL file to create all tables:
```
databaseSQL/car_rental.sql
```

This creates:
- `customers` - User accounts (customer/admin)
- `cars` - Vehicle inventory
- `reservations` - Booking records
- `payments` - Payment tracking
- `notifications` - User notifications

## Configuration

### Database Connection
Edit `database.php`:
```php
$host = 'localhost';
$db   = 'car-rental';
$user = 'root';
$pass = '';
```

## File Structure

```
CarRental/
├── admin-dashboard.php      # Admin main dashboard
├── admin-car.php           # Admin car management
├── Booking-pending.php     # Admin approve/reject bookings
├── bookings.php            # Customer view bookings & return
├── index.php               # Home page with car listing
├── login.php               # Login/registration
├── Reservation.php         # Booking form
├── AuthController.php      # Authentication logic
├── CarController.php       # Car CRUD operations
├── database.php            # DB connection
├── logout.php              # Logout handler
├── components/
│   ├── navigator.php       # Navigation bar
│   ├── admin-nav.php       # Admin navigation
│   └── footer.php          # Footer
├── js/
│   ├── index.js           # Car modal functions
│   ├── bookings.js        # Booking management
│   ├── reservation.js     # Reservation form
│   └── signout.js         # Logout function
├── modals/
│   ├── booking-details-modal.php
│   └── car-details-modal.php
├── uploads/
│   └── cars/              # Car image uploads
└── databaseSQL/
    └── car_rental.sql     # Database schema
```

## Key Features Fixed

### 1. Session Management
- Properly sets `$_SESSION['user_id']` and `$_SESSION['is_admin']`
- Works for both customer and admin roles
- Auto-login after registration

### 2. Booking Workflow
- Customer can reserve a car with rental and return dates
- Real-time calculation of total cost based on days and daily rate
- Status tracking: Pending → Approved/Rejected → Completed

### 3. Admin Approval System
- Admin views all pending reservations
- Can approve or reject with one click
- Notifications sent to customer automatically

### 4. Payment System
- Return Car button only shows when reservation is Approved
- Payment modal displays total amount due
- Payment status updates reservation to Completed
- Payment records stored in `payments` table

### 5. Notification System
- Notifications stored in database
- Displayed in notification bell (top right)
- Auto-marked as read when viewed
- Different notifications for approval/rejection

### 6. Dashboard Statistics
- Total bookings count
- Active users count
- Pending bookings count
- All statistics fetched from database in real-time

## User Roles

### Customer
- Register account
- Browse and reserve cars
- View all bookings with status
- Return car and make payment
- Receive notifications

### Admin
- Login to dashboard
- View all pending reservations
- Approve or reject reservations
- Manage car inventory (add/edit/delete)
- View statistics

## Default Admin Account

To create an admin account, run this SQL:
```sql
INSERT INTO customers (full_name, email, contact_number, password, role) 
VALUES (
  'Admin User', 
  'admin@test.com', 
  '09123456789', 
  '$2y$10$...', -- password hash (use password_hash('password', PASSWORD_DEFAULT))
  'admin'
);
```

Or use the registration form and manually update the role:
```sql
UPDATE customers SET role = 'admin' WHERE email = 'admin@test.com';
```

## Common Database Queries

### View all pending reservations
```sql
SELECT r.*, c.car_model, cu.full_name 
FROM reservations r 
JOIN cars c ON r.car_id = c.car_id 
JOIN customers cu ON r.id = cu.id 
WHERE r.status = 'Pending';
```

### View customer bookings
```sql
SELECT r.*, c.car_model, c.car_image 
FROM reservations r 
JOIN cars c ON r.car_id = c.car_id 
WHERE r.id = ? 
ORDER BY r.rental_date DESC;
```

### Calculate booking statistics
```sql
SELECT 
  COUNT(*) as total_bookings,
  SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending,
  SUM(CASE WHEN status = 'Approved' THEN 1 ELSE 0 END) as approved,
  SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) as completed
FROM reservations;
```

## Testing the Complete Workflow

### 1. Customer Registration
- Go to login.php
- Click "Sign Up" tab
- Fill in all details and register
- Should auto-login and redirect to index.php

### 2. Browse and Reserve
- Click "Book Now" on any car
- Select rental and return dates
- Total price calculates automatically
- Click "Confirm Booking"
- Reservation created with Pending status

### 3. Admin Approval
- Login as admin (admin@test.com)
- Go to "Bookings" tab
- Review pending reservation
- Click "Approve" or "Reject"
- Success message shown

### 4. Customer Receives Notification
- Customer sees notification in bell icon
- Message shows reservation was approved

### 5. Customer Returns Car
- Go to "My Bookings"
- Find approved booking
- Click "Return Car" button
- Payment modal appears with total amount
- Click "Confirm Payment"
- Page redirects with success message

### 6. Verify Completion
- Booking status changed to "Completed"
- Payment recorded in payments table
- Notification sent to customer

## Troubleshooting

### Session Not Working
- Check `database.php` connection
- Verify session is started: `session_start();`
- Clear browser cookies and try again

### Booking Not Appearing
- Check customer_id matches in reservations table
- Verify reservation query in bookings.php
- Check `$_SESSION['user']['id']` is set

### Admin Can't Approve
- Verify admin has `role = 'admin'` in database
- Check session has `$_SESSION['is_admin'] = 1`
- Ensure reservation exists in database

### Payment Not Working
- Check payments table exists
- Verify amount is calculated correctly
- Check reservation_id matches

### Notifications Not Showing
- Check notifications table exists
- Verify `customer_id` field is populated
- Check notification query in navigator.php

## API Endpoints (POST Methods)

### Reservation
- `POST /Reservation.php` - Create reservation

### Payment
- `POST /bookings.php` - Process payment

### Admin Approval
- `POST /Booking-pending.php` - Approve/reject reservation

### Car Management
- `POST /admin-dashboard.php` - Add/delete cars

## Security Notes

1. **Always validate input** - Use htmlspecialchars() and PDO prepared statements
2. **Hash passwords** - Use password_hash() and password_verify()
3. **Check roles** - Verify admin before showing admin pages
4. **Sanitize output** - Use htmlspecialchars() for display
5. **Use HTTPS** - In production, always use HTTPS

## Future Improvements

1. Add email notifications
2. Implement cancellation with refunds
3. Add car availability calendar
4. Implement multiple payment methods
5. Add customer reviews/ratings
6. Add SMS notifications
7. Implement advanced search/filters
8. Add report generation for admins
9. Implement loyalty points system
10. Add vehicle insurance options

## Support

For issues or questions:
1. Check database connection in database.php
2. Verify all tables exist using `SHOW TABLES;`
3. Check table structure using `DESCRIBE table_name;`
4. Review error logs in PHP error_log
5. Check browser console for JavaScript errors
