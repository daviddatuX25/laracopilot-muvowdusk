# Complete Setup Guide - Step by Step

## Initial Setup After Login

### Step 1: Login as Admin
```
URL: http://127.0.0.1:8000/login
User ID: admin
Password: admin123
```

### Step 2: Create Your First Inventory
1. Click **Inventory Management** in the sidebar (admin section)
2. Click **Add New Inventory**
3. Fill in:
   - **Name:** Main Warehouse (or your warehouse name)
   - **Location:** Headquarters (or location)
   - **Description:** Main storage facility
4. Click **Save**

### Step 3: Assign Inventory to Regular User
1. Click **User-Inventory Links** in the sidebar
2. Click on **user1** from the left panel
3. Check the checkbox for **Main Warehouse**
4. Click **Save Links**

### Step 4: Now user1 Can Create Items
1. Logout (click Logout button in top-right)
2. Login as user1:
   - User ID: user1
   - Password: user123
3. You should now see the dashboard
4. Try creating a product:
   - Click **Products** in sidebar
   - Click **Create Product**
   - Fill in the form
   - Click **Save Product**

---

## Troubleshooting

### ❌ "You must have an assigned inventory" Error
**Solution:** 
- Login as admin
- Go to User-Inventory Links
- Assign an inventory to the user

### ❌ Can't see any categories/suppliers when creating products
**Solution:**
- Create a category first
- Create a supplier first
- Then create a product

### ❌ User doesn't see any products
**Solution:**
- Products are only visible from the inventory they're assigned to
- Make sure you created the product while logged in as that user
- Check that the product was created in your assigned inventory

---

## User Creation Workflow

### Create a New Regular User

1. **Login as admin**

2. **Create the user:**
   - Go to User Management
   - Click Add New User
   - Fill in:
     - User ID: `john_doe`
     - Name: John Doe
     - Email: john@company.com
     - Password: SecurePassword123
     - Admin: **UNCHECKED** (leave unchecked for regular users)
   - Click Save

3. **Create or verify inventory exists:**
   - Go to Inventory Management
   - If no inventory exists, create one
   - You can create multiple inventories

4. **Assign inventory to user:**
   - Go to User-Inventory Links
   - Select `john_doe`
   - Check the inventory/inventories you want to assign
   - Click Save Links

5. **User can now login:**
   - Give John the credentials
   - He logs in and creates products
   - Products automatically assigned to his inventory

---

## Multi-Inventory Setup

### Scenario: Multiple Warehouses

1. **Create Inventories:**
   - Warehouse A (Main)
   - Warehouse B (Secondary)
   - Warehouse C (Distribution)

2. **Assign Users:**
   - user1 → Warehouse A (only)
   - user2 → Warehouse B, Warehouse C
   - user3 → Warehouse C (only)

3. **Data Isolation:**
   - user1 creates products → go to Warehouse A only
   - user2 creates products → go to first assigned (Warehouse B)
   - user3 sees only Warehouse C products

---

## Complete Admin Checklist

- [ ] Login as admin (admin/admin123)
- [ ] Create at least 1 inventory
- [ ] Assign inventory to user1
- [ ] Logout and login as user1
- [ ] Try creating a product
- [ ] Product should be created successfully
- [ ] View products - should see the product you just created
- [ ] Create a category
- [ ] Create a supplier

---

## Full Test Scenario

### Setup
```
Inventories:
- Warehouse A (id: 1)
- Warehouse B (id: 2)

Users:
- admin (assigned to both)
- user1 (assigned to Warehouse A)
- user2 (assigned to Warehouse B)
```

### Test Steps
1. Login as user1
2. Create "Widget A" → Goes to Warehouse A
3. Logout, login as user2
4. Create "Widget B" → Goes to Warehouse B
5. Logout, login as user1
6. View products → See only "Widget A"
7. Cannot see "Widget B" (different warehouse)

---

## Key Points to Remember

✅ **Admin creates and assigns inventories**
✅ **Users see only their assigned inventories' items**
✅ **Items automatically assigned to user's first inventory**
✅ **No inventory selection needed - it's automatic**
✅ **Multiple users can share an inventory**
✅ **One user can have multiple inventories**

---

## Support

### Error Messages Explained

| Error | Cause | Solution |
|-------|-------|----------|
| "You must have an assigned inventory" | User not assigned to any inventory | Admin: assign inventory to user |
| "User doesn't exist" | Wrong userid | Check userid spelling |
| "Can't see products" | Products in different inventory | Check user's assigned inventories |
| Route not found | Not logged in | Login first |
| 403 Forbidden | Trying to access admin as regular user | Only admins can access /admin/* |

---

## Ready to Go!

You now have a complete multi-user, multi-warehouse inventory system with:
- User authentication (userid/password)
- Admin controls
- Automatic data isolation
- Multi-inventory support

Happy inventory managing!
