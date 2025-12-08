# Re-stock Feature - Quick Reference Card

## 🚀 Quick Start

### Access Points
- **Builder**: Visit `/restock` to build a new plan
- **Plans List**: Visit `/restock/plans` to view all plans
- **Details**: Click on any plan to view its details

### The 3-Step Process

#### Step 1: Add Products to Cart
```
1. Search for product (name/SKU/barcode)
2. Set quantity and unit cost
3. Click "Add to Cart"
4. Repeat for more products
```

#### Step 2: Configure Costs
```
1. Set Budget Amount (required)
2. Set Tax % (optional, stored as default)
3. Add Shipping Fee (optional)
4. Add Labor Fee (optional)
5. Add Other Fees (optional, repeatable)
```

#### Step 3: Save & Fulfill
```
1. Save plan (status = "pending")
2. View saved plans from /restock/plans
3. Click "Fulfill" to update stock
4. Confirm (stock updates automatically)
```

---

## 🧮 Key Calculations

### Total Cost Formula
```
Cart Total = SUM(quantity × unit_cost for each item)
Tax Amount = Cart Total × (Tax % / 100)
Total Cost = Cart Total + Tax + Shipping + Labor + Other Fees
```

### Budget Status
```
✅ UNDER  = Total Cost < Budget (green)
❌ OVER   = Total Cost > Budget (red)
⚠️  FIT   = Total Cost ≈ Budget (yellow)
```

---

## 📊 Status Flow

```
Draft
  ↓
Pending (saved, ready to fulfill)
  ↓
Fulfilled (stock updated, complete)
  or
Cancelled (discarded)
```

---

## 🎯 Common Use Cases

### Build Monthly Restock
1. Go to `/restock`
2. Set budget to monthly allocation
3. Add all products needed
4. System calculates costs with taxes
5. Save as "pending"
6. Execute when stock arrives

### Quick Restock (Emergency)
1. Quick search (SKU fastest)
2. Add quantities
3. Skip fees if not needed
4. Save immediately
5. Fulfill when ready

### Budget Planning
1. Enter planned budget
2. Add desired quantities
3. Watch budget status change color
4. Adjust quantities or remove items
5. Stay within budget

### Print for Verification
1. Create plan and save
2. Click "Print Plan" to get buyer sheet
3. Give to receiving department
4. After fulfillment, click "Print Receipt"
5. Attach to order records

---

## 🔑 Key Fields

### Budget Section
| Field | Required | Notes |
|-------|----------|-------|
| Budget Amount | YES | Total spending limit |

### Cart
| Field | Required | Notes |
|-------|----------|-------|
| Product | YES | Search required |
| Quantity | YES | Must be ≥ 1 |
| Unit Cost | YES | Can be updated per plan |

### Costs
| Field | Required | Notes |
|-------|----------|-------|
| Tax % | NO | Saved as default |
| Shipping | NO | Fixed amount |
| Labor | NO | Fixed amount |
| Other Fees | NO | Repeatable, label + amount |

### Metadata
| Field | Required | Notes |
|-------|----------|-------|
| Notes | NO | Up to 500 chars |

---

## 💾 What Gets Saved

### In `restocks` Table
- All budget and cost info
- Cart and total calculations
- Budget status and difference
- Fulfillment date/user
- Notes

### In `restock_items` Table
- Every product in plan
- Quantities and unit costs
- Subtotals for each item

### In `restock_costs` Table
- Cost templates (VAT, shipping, etc)
- Per-user, per-inventory
- Can be reused

### In `stock_movements` Table
- One entry per product fulfillment
- Links back to restock plan
- Complete audit trail

---

## 🔍 Search Tips

### Product Search
```
SKU (fastest)    : Type "WID-001"
Barcode (fast)   : Type "123456789"
Name (flexible)  : Type partial name "widget"
```

### Plan Filtering
```
From /restock/plans
- Select status filter
- Draft = Not yet ready
- Pending = Ready to fulfill
- Fulfilled = Complete
- Cancelled = Discarded
```

---

## 📋 Best Practices

✅ **DO:**
- Set tax % once, it becomes default
- Review budget status before saving
- Use cost templates for consistency
- Print plan before giving to vendor
- Print receipt for record keeping

❌ **DON'T:**
- Create plan without budget
- Add products with $0 unit cost
- Try to edit fulfilled plans
- Delete fulfilled plans
- Mix different tax rates (adjust once)

---

## 🛠️ Troubleshooting

| Problem | Solution |
|---------|----------|
| Products not showing | Search must be 2+ chars, exact SKU/barcode works |
| Budget shows red | Total cost > budget, reduce qty or remove items |
| Can't fulfill | Plan must not be fulfilled, check permissions |
| PDF won't open | Verify dompdf installed, check file permissions |
| Calculations wrong | Verify tax %, check all quantities positive |

---

## 📞 Support

**Feature Documentation**: See `RESTOCK_IMPLEMENTATION_GUIDE.md`
**Database Schema**: See `RESTOCK_FEATURE_PLAN.md` Section "Database Design"
**API Details**: See `RestockController.php` for request/response formats

---

## ⚡ Quick Commands

### Seed Test Data
```bash
php artisan db:seed --class=RestockSeeder
```

### Reset and Reseed
```bash
php artisan migrate:refresh --seed --class=RestockSeeder
```

### View Routes
```bash
php artisan route:list | grep restock
```

---

## 🎨 UI Elements

### Color Coding
- **Green**: Under budget ✅
- **Red**: Over budget ❌
- **Yellow**: Close to budget ⚠️
- **Blue**: Status badge

### Buttons
- **Save**: Creates/updates plan
- **Fulfill**: Executes stock update
- **Print**: Download as PDF
- **Delete**: Remove plan (pending only)

---

## 📱 Mobile Friendly
- Responsive design ✅
- Touch-friendly controls ✅
- Mobile optimized quantities ✅
- Swipeable cart items ✅
- Dark mode supported ✅

---

**v1.0 - Phase 1 Complete** 🎉
