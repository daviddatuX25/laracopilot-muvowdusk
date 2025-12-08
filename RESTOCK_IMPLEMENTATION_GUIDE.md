# Re-stock Feature Implementation Guide

## Status: ✅ COMPLETE - Phase 1 Core Implementation

Implementation date: December 7, 2025

---

## What Has Been Implemented

### 1. Database Layer ✅
- **Migrations Created:**
  - `restocks` - Main restock plan table
  - `restock_items` - Individual items in restock plans
  - `restock_costs` - Cost template library
  - `stock_movements` - Enhanced with `restock_id` foreign key for audit trail

- **All migrations have been run successfully**

### 2. Models ✅
- **`Restock` Model** - Main plan with relationships
- **`RestockItem` Model** - Individual cart items
- **`RestockCost` Model** - Cost templates for reuse
- **Enhanced Models:**
  - `Inventory` - added `restocks()` and `restockCosts()` relationships
  - `Product` - added `restockItems()` relationship

### 3. Services ✅
- **`RestockService`** - Core business logic
  - Calculate total costs with taxes and fees
  - Determine budget status (under/over)
  - Create new restock plans
  - Update existing plans
  - Fulfill plans with stock updates
  - Cancel plans
  - Generate summaries

- **`RestockCostManager`** - Cost template management
  - Get/create/update/delete cost templates
  - Get templates grouped by type
  - Get default costs for form population
  - Cost statistics

- **`RestockPrintService`** - Printing and PDF export
  - Generate plan sheets (pre-purchase)
  - Generate receipts (post-fulfillment)
  - Export to PDF
  - Format summaries for printing

### 4. Controller ✅
- **`RestockController`** - All CRUD operations
  - `builder()` - Show restock builder page
  - `store()` - Save new plan
  - `update()` - Update existing plan
  - `plans()` - List all plans with filtering
  - `show()` - View plan details
  - `fulfill()` - Show fulfillment confirmation
  - `confirmFulfill()` - Execute fulfillment
  - `destroy()` - Delete plan
  - `printPlan()` - Export plan to PDF
  - `printReceipt()` - Export receipt to PDF

### 5. Routes ✅
All routes registered in `routes/web.php`:
```
GET    /restock                          → builder
POST   /restock                          → store
GET    /restock/plans                    → plans
GET    /restock/plans/{restock}          → show
PUT    /restock/plans/{restock}          → update
GET    /restock/plans/{restock}/fulfill  → fulfill
POST   /restock/plans/{restock}/fulfill  → confirmFulfill
DELETE /restock/plans/{restock}          → destroy
GET    /restock/plans/{restock}/print    → printPlan
GET    /restock/plans/{restock}/receipt  → printReceipt
```

### 6. Livewire Components ✅
- **`RestockBuilder`** - Interactive cart builder with:
  - Product search (by name, SKU, barcode)
  - Dynamic quantity and unit cost adjustment
  - Real-time cost calculations
  - Budget status tracking
  - Add/remove products from cart
  - Tax, shipping, labor, and other fees configuration
  - Save plan functionality

### 7. Blade Views ✅
- **`restock-builder.blade.php`** - Main builder interface
- **`details.blade.php`** - View plan details
- **`plans-list.blade.php`** - List all plans
- **`fulfill.blade.php`** - Fulfillment confirmation
- **`print/plan-sheet.blade.php`** - Pre-purchase printable guide
- **`print/receipt.blade.php`** - Post-fulfillment receipt

### 8. Authorization ✅
- **`RestockPolicy`** - Authorization gates
  - View: User must have inventory access
  - Create: All authenticated users
  - Update: Creator or admin
  - Delete: Creator only (non-fulfilled)
  - Fulfill: Inventory member (non-fulfilled)

### 9. Database Seeder ✅
- **`RestockSeeder`** - Sample data for testing
  - Creates cost templates (VAT, Shipping, Labor)
  - Creates sample draft and fulfilled restock plans
  - Automatically creates items based on inventory products

---

## Getting Started

### 1. Access the Feature

**After logging in, navigate to:**
- **Build Plan**: `/restock`
- **View Plans**: `/restock/plans`

### 2. Create Your First Restock Plan

1. Go to `/restock`
2. Enter a **Budget Amount** (required)
3. **Search and add products** to cart:
   - Search by name, SKU, or barcode
   - Select quantity and unit cost
   - Click "Add to Cart"
4. **Configure costs** (optional):
   - Tax percentage
   - Shipping fee
   - Labor fee
   - Additional custom fees
5. **Monitor budget status** in the right panel (green = under, red = over)
6. **Save the plan** - Status becomes "pending"

### 3. Manage Saved Plans

From `/restock/plans`:
- **View** plan details
- **Edit** quantities and costs
- **Fulfill** to update stock
- **Print** as guidance or receipt
- **Delete** (only draft/pending plans)

### 4. Fulfill a Plan

1. Click **Fulfill** on a pending plan
2. Review all items and new stock levels
3. **Confirm** - Stock levels are updated automatically
4. Plan status changes to **"fulfilled"**
5. Stock movements are created with restock reference for audit

### 5. Print Plans

**Pre-Purchase:**
- Use "Print Plan" to get a guidance sheet before buying

**Post-Fulfillment:**
- Use "Print Receipt" to get verification after stock update

---

## Key Features

### ✅ Real-time Calculations
- Cart total updates instantly as quantities/costs change
- Tax calculated based on cart total
- Total cost = cart + tax + shipping + labor + fees
- Budget difference displayed prominently

### ✅ Budget Tracking
- **Green**: Under budget (safe)
- **Red**: Over budget (warning)
- **Yellow**: Close to budget (caution)
- Shows exact difference amount

### ✅ Cost Templates
- Save common costs (VAT, shipping, labor)
- Reuse across plans
- Per-inventory, per-user templates
- Can be percentage or fixed amount

### ✅ Audit Trail
- All restock plans linked to user
- Fulfillment tracked with date and user
- Stock movements reference restock plan
- Complete cost breakdown preserved

### ✅ Multi-Format Export
- **PDF Plan Sheets** - For buyer/vendor
- **PDF Receipts** - For records/verification
- Professional formatting
- All details included

---

## Database Schema

### `restocks` Table
```
id, inventory_id, user_id, status, budget_amount, cart_total,
tax_percentage, tax_amount, shipping_fee, labor_fee, other_fees,
total_cost, budget_status, budget_difference, notes,
fulfilled_at, fulfilled_by, created_at, updated_at
```

### `restock_items` Table
```
id, restock_id, product_id, quantity_requested,
unit_cost, subtotal, created_at, updated_at
```

### `restock_costs` Table
```
id, inventory_id, user_id, cost_type, label,
amount, is_percentage, is_active, created_at, updated_at
```

### Enhanced `stock_movements` Table
```
... (existing columns) ...
restock_id (NEW), created_at, updated_at
```

---

## Testing

### Run Seeds
```bash
php artisan db:seed --class=RestockSeeder
```

This will create:
- Sample cost templates for each user/inventory
- 2 sample plans per user/inventory (draft + fulfilled)
- Automatically populated with existing products

### Manual Testing Flow

1. **Create Plan**
   - Navigate to `/restock`
   - Budget: 5000
   - Add 3+ products
   - Set tax to 15%
   - Verify calculations
   - Save

2. **View Plans**
   - Go to `/restock/plans`
   - See new plan listed
   - Click "View" to see details
   - Verify all info is correct

3. **Fulfill Plan**
   - Click "Fulfill" button
   - Review items and new stock levels
   - Confirm fulfillment
   - Check that stock levels updated
   - Verify plan status is "fulfilled"

4. **Print & Export**
   - Click "Print Plan" to download PDF
   - Verify formatting
   - Click "Receipt" to download fulfillment receipt
   - Open PDF and verify all data

---

## API Endpoints (Built-in)

### Create Plan
```
POST /restock
Content-Type: application/json

{
  "budget_amount": 5000,
  "tax_percentage": 15,
  "shipping_fee": 100,
  "labor_fee": 0,
  "other_fees": [{"label": "Handling", "amount": 50}],
  "notes": "Monthly restock",
  "items": [
    {"product_id": 1, "quantity": 10, "unit_cost": 100},
    {"product_id": 2, "quantity": 5, "unit_cost": 200}
  ]
}
```

### Update Plan
```
PUT /restock/{restock}
Content-Type: application/json

(Same JSON structure as above)
```

### Fulfill Plan
```
POST /restock/{restock}/fulfill
```

---

## Validation Rules

### Plan Creation/Update
```
budget_amount: required|numeric|min:0
tax_percentage: nullable|numeric|min:0|max:100
shipping_fee: nullable|numeric|min:0
labor_fee: nullable|numeric|min:0
other_fees: nullable|array
other_fees.*.label: required|string|max:50
other_fees.*.amount: required|numeric|min:0
notes: nullable|string|max:500
items: required|array|min:1
items.*.product_id: required|exists:products,id
items.*.quantity: required|integer|min:1
items.*.unit_cost: required|numeric|min:0
```

---

## Common Tasks

### Change Default Tax Rate
1. Go to `/restock`
2. Set tax % once
3. It's automatically saved and used next time
4. Stored in `restock_costs` table

### Create Cost Template
1. Use the RestockCostManager service:
```php
$costManager->createTemplate(
    $inventory,
    $user,
    'tax',           // 'tax', 'shipping', 'labor', 'other'
    'VAT',           // Label
    15,              // Amount
    true             // Is percentage
);
```

### Check Stock Movements
1. Each fulfillment creates entries in `stock_movements`
2. `restock_id` field links back to the plan
3. Can query: `StockMovement::where('restock_id', $id)->get()`

---

## Troubleshooting

### Problem: Products not appearing in search
**Solution:**
- Ensure products belong to current inventory
- Check product name/SKU/barcode contains search term
- Try searching with exact SKU or barcode

### Problem: Budget status shows wrong
**Solution:**
- Verify tax_percentage is correct
- Check all fees are entered
- Ensure quantities are positive
- Unit costs must be ≥ 0

### Problem: Can't fulfill plan
**Solution:**
- Plan must not already be fulfilled
- You must have access to the inventory
- Check policy authorization

### Problem: PDF export fails
**Solution:**
- Verify `dompdf` package is installed
- Check `config/dompdf.php` exists
- Ensure storage directory is writable

---

## Performance Notes

- Product search is limited to 10 results (configurable)
- Plans list is paginated (15 per page)
- Calculations are memoized during request
- Database queries use indexes on `(inventory_id, status)`
- Stock updates in single transaction (atomic)

---

## Security Notes

- All routes require authentication
- Authorization policies prevent unauthorized access
- All inputs validated server-side
- Decimal precision limited to 2 places
- Fulfilled plans cannot be edited/deleted
- Prices stored as DECIMAL(15,2) for accuracy

---

## Next Steps (Phase 2+)

- Cost template UI for managing templates
- Plan editing and duplicating
- Recurring/scheduled restocks
- Budget forecasting and analysis
- Email notifications on fulfillment
- Restock history and comparison
- Integration with supplier orders
- Mobile app support

---

## Files Created/Modified

### New Files
```
Database:
- database/migrations/2024_12_07_000001_create_restocks_table.php
- database/migrations/2024_12_07_000002_create_restock_items_table.php
- database/migrations/2024_12_07_000003_create_restock_costs_table.php
- database/migrations/2024_12_07_000004_add_restock_id_to_stock_movements.php
- database/seeders/RestockSeeder.php

Models:
- app/Models/Restock.php
- app/Models/RestockItem.php
- app/Models/RestockCost.php

Services:
- app/Services/RestockService.php
- app/Services/RestockCostManager.php
- app/Services/RestockPrintService.php

Controllers:
- app/Http/Controllers/RestockController.php

Livewire:
- app/Livewire/Restock/RestockBuilder.php

Policies:
- app/Policies/RestockPolicy.php

Views:
- resources/views/livewire/restock/restock-builder.blade.php
- resources/views/restock/details.blade.php
- resources/views/restock/fulfill.blade.php
- resources/views/restock/plans-list.blade.php
- resources/views/restock/print/plan-sheet.blade.php
- resources/views/restock/print/receipt.blade.php
```

### Modified Files
```
- routes/web.php (added 10 restock routes)
- app/Models/Inventory.php (added 2 relationships)
- app/Models/Product.php (added 1 relationship)
```

---

## Support & Documentation

All calculations follow the formula:
```
TOTAL_COST = CART_TOTAL + TAX + SHIPPING + LABOR + OTHER_FEES
BUDGET_DIFFERENCE = BUDGET - TOTAL_COST
BUDGET_STATUS = (TOTAL_COST > BUDGET) ? 'over' : 'under'
```

For questions, refer to the RESTOCK_FEATURE_PLAN.md for detailed specifications.

---

**Ready to use! 🚀**
