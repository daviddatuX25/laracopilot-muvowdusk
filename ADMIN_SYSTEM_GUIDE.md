# Admin System & Login Implementation

## Overview
A complete authentication and admin system has been implemented for the Inventory System, including:
- User login (userid/password based)
- Admin account management
- Inventory creation and management
- User-Inventory linking system

---

## Default Login Credentials

### Admin Account
- **User ID:** `admin`
- **Password:** `admin123`
- **Role:** Administrator (has access to all admin features)

### Regular User Account
- **User ID:** `user1`
- **Password:** `user123`
- **Role:** Regular User (no admin features)

---

## How to Login

1. Navigate to `/login` (automatically redirected if not authenticated)
2. Enter your **User ID** (not email)
3. Enter your **Password**
4. Click **Sign in**

---

## Admin Features (For Admin Users Only)

### 1. User Management (`/admin/users`)
Manage all system users:
- **Create New User:** Add new users with userid and password
- **Edit User:** Modify user details and admin status
- **Delete User:** Remove users from the system
- **Promote to Admin:** Toggle admin status for any user

**User Fields:**
- User ID (unique identifier, cannot be changed)
- Name
- Email
- Password (optional when editing - leave blank to keep current)
- Admin Flag (checkbox to grant admin privileges)

### 2. Inventory Management (`/admin/inventories`)
Create and manage inventory locations:
- **Create Inventory:** Add new inventory warehouses/locations
- **Edit Inventory:** Modify inventory details
- **Delete Inventory:** Remove inventories

**Inventory Fields:**
- Name (unique)
- Location (physical location)
- Description

**Important:** When you create an Inventory, it will contain:
- Products (with categories and suppliers)
- Categories
- Suppliers

### 3. User-Inventory Links (`/admin/user-inventory-links`)
Assign inventories to users:
- Select a user from the left panel
- Check/uncheck inventories on the right to assign/remove
- Click **Save Links** to update assignments

**Purpose:** Users can only see and manage products/categories/suppliers from their assigned inventories.

---

## Database Schema

### New Tables Created

#### `inventories`
- `id` (Primary Key)
- `name` (Unique)
- `description` (Nullable)
- `location` (Nullable)
- `timestamps`

#### `user_inventories` (Junction Table)
- `id` (Primary Key)
- `user_id` (Foreign Key → users)
- `inventory_id` (Foreign Key → inventories)
- `timestamps`
- Unique constraint: (user_id, inventory_id)

#### `users` (Modified)
- Added `userid` field (unique, primary way to login)
- Added `is_admin` field (boolean, default false)

#### `products` (Modified)
- Added `inventory_id` (Foreign Key → inventories, nullable)

#### `categories` (Modified)
- Added `inventory_id` (Foreign Key → inventories, nullable)

#### `suppliers` (Modified)
- Added `inventory_id` (Foreign Key → inventories, nullable)

---

## User Workflow

### For Regular Users:
1. Login with userid and password
2. View dashboard
3. Can only see inventories they're assigned to
4. Can manage products/categories/suppliers within assigned inventories

### For Admin Users:
1. Login with admin credentials
2. View dashboard
3. Have access to regular features PLUS admin panel
4. Can:
   - Create/manage user accounts
   - Create/manage inventories
   - Assign inventories to users
5. Access admin features from the sidebar (visible when admin is logged in)

---

## Routes

### Public Routes
- `GET /login` - Login page
- `POST /login` - Process login

### Protected Routes (Authenticated Users)
- `POST /logout` - Logout
- `GET /` - Dashboard
- `GET /products`, `/categories`, `/suppliers` - View management pages
- `GET /reports` - Reports
- `GET /alerts` - Alerts
- And other existing features...

### Admin Routes (Admin Users Only)
- `GET /admin/users` - User Management
- `GET /admin/inventories` - Inventory Management
- `GET /admin/user-inventory-links` - User-Inventory Links

---

## Middleware

### Authentication Middleware
All routes except login are protected by `auth` middleware.

### Admin Middleware (`EnsureUserIsAdmin`)
Admin routes are protected by the `admin` middleware.
- Verifies user is authenticated
- Verifies user has `is_admin = true`
- Returns 403 (Forbidden) if not admin

---

## Navigation

### Sidebar Menu
When authenticated, users see a sidebar with:
- Dashboard
- Categories
- Products
- Suppliers
- Barcode Scanner
- Stock Adjustment
- Reports
- Alerts

### Admin Panel (visible only to admin users)
- User Management
- Inventory Management
- User-Inventory Links

### Top Navigation
- Welcome message with username
- Admin badge (if user is admin)
- Logout button

---

## How to Change Password

Currently, admin can:
1. Go to `/admin/users`
2. Click **Edit** on any user
3. Enter new password in the password field
4. Leave empty to keep current password
5. Click **Save**

---

## Security Notes

- Passwords are hashed using Laravel's bcrypt
- userid is unique per user (different from email)
- is_admin flag controls admin access
- All sensitive routes require authentication
- Admin routes require both authentication AND admin status

---

## Next Steps (Not Implemented Yet)

As mentioned, roles are not implemented yet. Future enhancements could include:
- Role-based access control (Manager, Supervisor, etc.)
- Fine-grained permissions (view-only, edit, delete)
- Department/team assignments
- Audit logging
- Two-factor authentication

---

## Testing

### Quick Test Flow

1. **Test Admin Login:**
   - Go to `/login`
   - Enter: userid=`admin`, password=`admin123`
   - Should see admin menu in sidebar

2. **Test Regular User:**
   - Go to `/login`
   - Enter: userid=`user1`, password=`user123`
   - Should NOT see admin menu in sidebar

3. **Test Unauthorized Access:**
   - Login as `user1`
   - Try to access `/admin/users`
   - Should get 403 error

4. **Test Inventory Assignment:**
   - Create new inventory
   - Assign to user1
   - User1 should only see that inventory

---

## Troubleshooting

### Can't login
- Check userid (not email)
- Verify caps lock is off
- Default credentials: admin/admin123

### Can't see Admin Panel
- Verify you're logged in as admin account
- Check if `is_admin` is true in database

### Routes not working
- Run `php artisan route:list` to verify routes
- Check middleware configuration in `bootstrap/app.php`

---

## Files Added/Modified

### Files Created:
- `app/Http/Controllers/AuthController.php` - Login/logout logic
- `app/Http/Middleware/EnsureUserIsAdmin.php` - Admin middleware
- `app/Models/User.php` - User model with auth
- `app/Models/Inventory.php` - Inventory model
- `app/Models/UserInventory.php` - User-Inventory relationship
- `app/Livewire/Admin/UserManagement.php` - Admin users component
- `app/Livewire/Admin/InventoryManagement.php` - Admin inventories component
- `app/Livewire/Admin/UserInventoryLink.php` - User-Inventory linking component
- `resources/views/auth/login.blade.php` - Login page
- `resources/views/livewire/admin/*.blade.php` - Admin views

### Files Modified:
- `routes/web.php` - Added auth routes and admin routes
- `bootstrap/app.php` - Registered admin middleware
- `app/Models/Product.php` - Added inventory relationship
- `app/Models/Category.php` - Added inventory relationship
- `app/Models/Supplier.php` - Added inventory relationship
- `resources/views/layouts/app.blade.php` - Added logout button and admin menu
- Database migrations for new tables

---

## Support

For issues or questions, check:
1. Laravel logs: `storage/logs/laravel.log`
2. Database migrations status: `php artisan migrate:status`
3. Routes: `php artisan route:list | grep admin`
