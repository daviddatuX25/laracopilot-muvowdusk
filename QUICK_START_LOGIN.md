# Quick Start - Login & Admin System

## 🚀 Get Started in 30 Seconds

### 1. Login Page
Go to: **http://localhost:8000/login**

### 2. Test Admin Account
```
User ID: admin
Password: admin123
```

### 3. You're In!
You should see the dashboard with admin menu in the sidebar.

---

## 📖 What You Can Do

### As Admin (`admin` / `admin123`)
1. **Manage Users** - `/admin/users`
   - Create new users
   - Change passwords
   - Make users admins

2. **Create Inventories** - `/admin/inventories`
   - Create warehouses
   - Each warehouse is independent

3. **Link Users to Inventories** - `/admin/user-inventory-links`
   - Assign warehouses to users
   - Users only see their assigned warehouses

### As Regular User (`user1` / `user123`)
1. View dashboard
2. Manage products/categories/suppliers
3. NO admin access (no sidebar menu)

---

## 🔑 Key Features

| Feature | Admin | User | Guest |
|---------|-------|------|-------|
| Login | ✅ | ✅ | ❌ |
| Dashboard | ✅ | ✅ | ❌ |
| Products | ✅ | ✅ | ❌ |
| Categories | ✅ | ✅ | ❌ |
| Suppliers | ✅ | ✅ | ❌ |
| User Management | ✅ | ❌ | ❌ |
| Inventory Management | ✅ | ❌ | ❌ |
| User-Inventory Links | ✅ | ❌ | ❌ |

---

## 🎯 Common Tasks

### Create a New User
1. Login as admin
2. Click **User Management** in sidebar
3. Click **Add New User**
4. Fill form:
   - User ID: (unique identifier)
   - Name: (full name)
   - Email: (optional)
   - Password: (min 6 chars)
   - Admin: (checkbox if admin)
5. Click **Save**

### Create a New Inventory
1. Login as admin
2. Click **Inventory Management** in sidebar
3. Click **Add New Inventory**
4. Fill form:
   - Name: (e.g., "Main Warehouse")
   - Location: (e.g., "Building A")
   - Description: (optional)
5. Click **Save**

### Assign Inventory to User
1. Login as admin
2. Click **User-Inventory Links** in sidebar
3. Select user from left panel
4. Check/uncheck inventories on right
5. Click **Save Links**

### Change User Password
1. Login as admin
2. Click **User Management**
3. Click **Edit** on user
4. Enter new password in password field
5. Click **Save**
6. Leave password blank to keep current

---

## 🔗 Important URLs

| Page | URL |
|------|-----|
| Login | `/login` |
| Dashboard | `/` |
| User Management | `/admin/users` |
| Inventory Mgmt | `/admin/inventories` |
| User-Inv Links | `/admin/user-inventory-links` |
| Products | `/products` |
| Categories | `/categories` |
| Suppliers | `/suppliers` |

---

## ✅ Testing Checklist

- [ ] Can login with `admin`/`admin123`
- [ ] Can see admin menu in sidebar
- [ ] Can access User Management
- [ ] Can create new user
- [ ] Can create new inventory
- [ ] Can assign inventory to user
- [ ] Can logout
- [ ] Can login with `user1`/`user123`
- [ ] Cannot see admin menu as regular user
- [ ] Cannot access `/admin/users` as regular user

---

## 🆘 Troubleshooting

**Q: Can't login**
- A: Check userid (not email) and password. Default: `admin`/`admin123`

**Q: Don't see admin menu**
- A: Login as `admin`, not `user1`

**Q: Getting 403 error**
- A: Only admins can access `/admin/*` routes

**Q: Can't see inventory as user**
- A: Admin needs to assign inventory to user in "User-Inventory Links"

---

## 📚 More Info

See `ADMIN_SYSTEM_GUIDE.md` for detailed documentation.

---

## 🎉 You're Ready!

Start exploring the system. Happy inventory managing!
