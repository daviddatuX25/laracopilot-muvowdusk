# Re-stock Feature - Comprehensive Plan

## Overview
The Re-stock feature enables inventory managers to:
1. Build re-stocking carts by selecting products with quantities
2. Configure costs (taxes, shipping, labor, etc.)
3. Set budget thresholds and track if purchases fit within budget
4. Save re-stocking plans for later execution
5. Fulfill saved plans by bulk replenishing products
6. Maintain audit logs through stock movements

---

## Database Design

### 1. New Table: `restocks` (Main Re-stock Plan)
```sql
CREATE TABLE restocks (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    inventory_id BIGINT NOT NULL FOREIGN KEY,
    user_id BIGINT NOT NULL FOREIGN KEY,
    status ENUM('draft', 'pending', 'fulfilled', 'cancelled') DEFAULT 'draft',
    budget_amount DECIMAL(15, 2) NOT NULL,
    cart_total DECIMAL(15, 2) NOT NULL,
    tax_percentage DECIMAL(5, 2) DEFAULT 0,
    tax_amount DECIMAL(15, 2) DEFAULT 0,
    shipping_fee DECIMAL(15, 2) DEFAULT 0,
    labor_fee DECIMAL(15, 2) DEFAULT 0,
    other_fees JSON DEFAULT '[]',  -- Array of {label, amount}
    total_cost DECIMAL(15, 2) NOT NULL,
    budget_status ENUM('under', 'fit', 'over') DEFAULT 'fit',
    budget_difference DECIMAL(15, 2),  -- Positive if under, negative if over
    notes TEXT NULLABLE,
    fulfilled_at TIMESTAMP NULLABLE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (inventory_id) REFERENCES inventories(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX (inventory_id),
    INDEX (user_id),
    INDEX (status)
);
```

### 2. New Table: `restock_items` (Cart Items in Re-stock Plan)
```sql
CREATE TABLE restock_items (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    restock_id BIGINT NOT NULL FOREIGN KEY,
    product_id BIGINT NOT NULL FOREIGN KEY,
    quantity_requested INT NOT NULL,
    unit_cost DECIMAL(15, 2) NOT NULL,
    subtotal DECIMAL(15, 2) NOT NULL,  -- quantity * unit_cost
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (restock_id) REFERENCES restocks(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id),
    UNIQUE (restock_id, product_id),
    INDEX (product_id)
);
```

### 3. Modified: `stock_movements` Table (Track Fulfillment)
Add optional restock_id field to link fulfillments to restock plan:
```sql
ALTER TABLE stock_movements ADD COLUMN (
    restock_id BIGINT NULLABLE,
    FOREIGN KEY (restock_id) REFERENCES restocks(id),
    INDEX (restock_id)
);
```

### 4. New Table: `restock_costs` (Persistent Cost Templates)
Store default/template costs that can be reused across restocks:
```sql
CREATE TABLE restock_costs (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    inventory_id BIGINT NOT NULL FOREIGN KEY,
    user_id BIGINT NOT NULL FOREIGN KEY,
    cost_type ENUM('tax', 'shipping', 'labor', 'other') NOT NULL,
    label VARCHAR(100) NOT NULL,  -- e.g., "VAT", "Gas", "Handling"
    amount DECIMAL(15, 2) NOT NULL,
    is_percentage BOOLEAN DEFAULT FALSE,  -- For tax: 15% vs 200 pesos
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (inventory_id) REFERENCES inventories(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX (inventory_id, cost_type)
);
-- Examples:
-- VAT: cost_type='tax', label='VAT', amount=15, is_percentage=TRUE
-- Gas: cost_type='shipping', label='Gas', amount=200, is_percentage=FALSE
-- Handling: cost_type='other', label='Handling', amount=50, is_percentage=FALSE
```

---

## Models

### 1. `Restock` Model
```php
namespace App\Models;

class Restock extends Model {
    protected $fillable = [
        'inventory_id', 'user_id', 'status', 'budget_amount',
        'cart_total', 'tax_percentage', 'tax_amount',
        'shipping_fee', 'labor_fee', 'other_fees', 'total_cost',
        'budget_status', 'budget_difference', 'notes', 'fulfilled_at'
    ];
    
    protected $casts = [
        'other_fees' => 'array',
        'budget_amount' => 'decimal:2',
        'cart_total' => 'decimal:2',
        'tax_percentage' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'budget_difference' => 'decimal:2',
        'fulfilled_at' => 'datetime',
    ];
    
    public function inventory() { return $this->belongsTo(Inventory::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function items() { return $this->hasMany(RestockItem::class); }
    public function stockMovements() { return $this->hasMany(StockMovement::class); }
}
```

### 2. `RestockItem` Model
```php
namespace App\Models;

class RestockItem extends Model {
    protected $fillable = ['restock_id', 'product_id', 'quantity_requested', 'unit_cost', 'subtotal'];
    
    protected $casts = [
        'unit_cost' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];
    
    public function restock() { return $this->belongsTo(Restock::class); }
    public function product() { return $this->belongsTo(Product::class); }
}
```

---

## UI/UX Flow

### Page 1: Re-stock Builder (`/restock`)
**Component: `Livewire\Restock\RestockBuilder`**

#### Layout:
```
┌─────────────────────────────────────────────────────────────┐
│  RE-STOCK PLANNING INTERFACE                                │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  LEFT PANEL (70%)          │  RIGHT PANEL (30%)              │
│  ──────────────────────────┼──────────────────────────       │
│  1. PRODUCT CART BUILDER   │  CART SUMMARY                   │
│     - Search/Filter Products│  ├─ Cart Total: $XXX.XX       │
│     - Quantity Dial        │  ├─ Tax (XX%): $XXX.XX         │
│     - Add to Cart Button   │  ├─ Shipping: $XXX.XX          │
│     - Current Cart Preview │  ├─ Labor: $XXX.XX             │
│                            │  ├─ Other Fees: +              │
│                            │  ├─ ─────────────────          │
│                            │  ├─ TOTAL COST: $XXX.XX        │
│  2. COST CONFIGURATION     │  │                              │
│     - Budget Input         │  BUDGET STATUS                  │
│     - Tax % Input          │  ┌──────────────────┐          │
│     - Cost Classifications:│  │ Budget: $5000    │          │
│       • Shipping Fee       │  │ ─────────────────│          │
│       • Labor Fee          │  │ Total Cost: $4200│          │
│       • Other (Add more)   │  │ Status: ✓ UNDER │          │
│                            │  │ Diff: +$800      │          │
│                            │  └──────────────────┘          │
│  3. NOTES                  │                                 │
│     - Text Area            │  ACTIONS                        │
│                            │  [Save Plan] [Clear] [Help]    │
│                            │                                 │
└─────────────────────────────────────────────────────────────┘
```

#### Interactions:
1. **Product Selection**
   - Search by name/SKU/barcode
   - Filter by category or supplier (optional)
   - Show current stock levels
   - Click to add to cart

2. **Quantity Management**
   - Dial/number input (increment/decrement buttons)
   - Quick buttons (+1, +5, +10, -1, -5, -10)
   - Real-time subtotal calculation

3. **Cost Configuration**
   - Budget input (required)
   - Tax percentage (optional, persisted as default)
   - Predefined fee types (Shipping, Labor)
   - Custom fees (dynamic "Add Fee" button)
   
4. **Budget Status Indicator**
   - Red: Over budget (cost > budget)
   - Yellow: Close to budget (cost within 10% margin)
   - Green: Under budget (cost < budget)
   - Shows: difference amount, percentage

5. **Cart Preview**
   - Live-updating summary
   - Remove/edit items inline
   - Clear entire cart
   - Duplicate restock plan (if viewing saved)

#### Key Features:
- **Real-time Calculation**: Cart total, taxes, total cost updated as inputs change
- **Persistent Defaults**: Tax % saved to user preferences, restored on next visit
- **Undo/Redo**: Action history for cart modifications
- **Auto-save Draft**: Save work in progress without submitting

---

### Page 2: Saved Re-stock Plans (`/restock/plans`)
**Component: `Livewire\Restock\RestockPlansList`**

#### Layout:
```
┌─────────────────────────────────────────────────────────────┐
│  RE-STOCK PLANS HISTORY                                      │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  [Search] [Filter: Status] [Sort] [New Plan]                │
│                                                              │
│  ┌────────────────────────────────────────────────────────┐ │
│  │ Plan #1 | "Monthly Restock Q4"                 Draft    │ │
│  │ Created: 2024-12-01 | Items: 15 | Total: $5,234.50    │ │
│  │ Budget: $6,000 | Status: ✓ UNDER ($765.50)             │ │
│  │ [Edit] [Duplicate] [Fulfill] [Delete]                  │ │
│  └────────────────────────────────────────────────────────┘ │
│                                                              │
│  ┌────────────────────────────────────────────────────────┐ │
│  │ Plan #2 | "Emergency Restock"           Fulfilled      │ │
│  │ Created: 2024-11-20 | Items: 8 | Total: $3,100.00     │ │
│  │ Budget: $3,500 | Status: ✓ UNDER ($400.00)             │ │
│  │ Fulfilled: 2024-11-21 [View Details] [Delete]          │ │
│  └────────────────────────────────────────────────────────┘ │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

#### Statuses:
- **Draft**: Unsaved plan in progress
- **Pending**: Saved plan ready to fulfill
- **Fulfilled**: Completed, stock updated
- **Cancelled**: Discarded plan

#### Actions:
- **Edit**: Modify quantities and costs
- **Duplicate**: Clone plan for similar future restocking
- **Fulfill**: Execute the plan (bulk update stock)
- **View Details**: See breakdown and stock movements created

---

### Page 3: Re-stock View & Print (`/restock/plans/{id}`)
**Component: `Livewire\Restock\RestockDetails`**

#### Layout (Print-Friendly View):
```
┌─────────────────────────────────────────────────────────────┐
│  RE-STOCK PLAN DETAILS                                      │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  Plan: "Monthly Restock Q4" (#1)                             │
│  Status: PENDING                                             │
│  Created: 2024-12-01                                         │
│                                                              │
│  PLAN SUMMARY                                                │
│  ─────────────────                                           │
│  Cart Total: $4,000.00                                       │
│  Tax (15%): $600.00                                          │
│  Shipping: $200.00                                           │
│  Labor: $150.00                                              │
│  TOTAL: $4,950.00                                            │
│                                                              │
│  BUDGET ANALYSIS                                             │
│  Budget: $5,500.00                                           │
│  Difference: +$550.00 (✓ UNDER)                              │
│                                                              │
│  ITEMS (15 products)                                         │
│  ┌─────────────────────────────────────────────────────┐    │
│  │ Product Name      │ Qty │ Unit Cost │ Subtotal │    │    │
│  ├─────────────────────────────────────────────────────┤    │
│  │ Widget A          │ 50  │ $10.00    │ $500.00  │    │    │
│  │ Widget B          │ 30  │ $15.00    │ $450.00  │    │    │
│  │ ...               │ ... │ ...       │ ...      │    │    │
│  └─────────────────────────────────────────────────────┘    │
│                                                              │
│  ACTIONS                                                     │
│  [Print Plan] [Print Receipt] [Fulfill & Update Stock]      │
│  [Edit Plan] [Duplicate] [Cancel]                            │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

#### Processes:

**Pre-Purchase (Print Guidance):**
1. View full plan details (read-only)
2. Print plan document - formatted as guidance sheet for buyer
   - Shows all products, quantities, and expected unit costs
   - Includes budget allocation and total expected cost
   - Can be used while shopping to ensure correct items/quantities

**Post-Purchase (Print Receipt):**
1. Same layout as print plan but marked as "RECEIPT"
2. Can be printed after confirming fulfillment
3. Documents what was actually purchased

**Fulfillment:**
1. Review plan one final time
2. Confirm "Fulfill & Update Stock" button
3. On confirm:
   - Update product stock (add quantity for each item)
   - Create `StockMovement` records for each product
   - Link movements to plan via `restock_id` for audit
   - Change plan status to "fulfilled"
   - Record `fulfilled_at` timestamp
   - Option to print receipt after fulfillment

---

## Livewire Components Structure

```
app/Livewire/Restock/
├── RestockBuilder.php          # Main cart builder component
├── RestockItemRow.php          # Individual cart item (reusable)
├── CostConfiguration.php       # Tax & fees section
├── CartSummary.php             # Right panel summary
├── BudgetStatusIndicator.php   # Budget status visual
├── RestockPlansList.php        # List of saved plans
├── RestockFulfill.php          # Fulfillment flow
└── RestockDetails.php          # View saved plan details

resources/views/livewire/restock/
├── restock-builder.blade.php
├── restock-item-row.blade.php
├── cost-configuration.blade.php
├── cart-summary.blade.php
├── budget-status-indicator.blade.php
├── restock-plans-list.blade.php
├── restock-fulfill.blade.php
└── restock-details.blade.php
```

---

## Services & Helpers

### 1. `RestockService` (app/Services/RestockService.php)
```php
class RestockService {
    // Calculate total cost based on cart, taxes, and fees
    public function calculateTotalCost($cartItems, $taxes, $fees) {}
    
    // Determine budget status (under/fit/over)
    public function getBudgetStatus($totalCost, $budget) {}
    
    // Create restock plan from cart data
    public function createRestockPlan($inventory, $user, $cartData, $costData) {}
    
    // Update existing plan
    public function updateRestockPlan($restock, $cartData, $costData) {}
    
    // Fulfill plan: update all product stocks and create movements
    public function fulfillRestockPlan($restock, $user) {}
}
```

### 2. `RestockCostManager` (app/Services/RestockCostManager.php)
```php
class RestockCostManager {
    // Get all saved cost templates for inventory
    public function getCostTemplates($inventory, $costType = null) {}
    
    // Create new cost template
    public function createTemplate($inventory, $type, $label, $amount, $isPercentage) {}
    
    // Update cost template
    public function updateTemplate($costTemplate, $data) {}
    
    // Delete cost template
    public function deleteTemplate($costTemplate) {}
    
    // Load templates for quick reuse in form
    public function getDefaultCosts($inventory, $user) {}
    
    // Add custom fee to restock (one-time, not template)
    public function addCustomFee($restock, $label, $amount) {}
}
```

### 3. `RestockPrintService` (app/Services/RestockPrintService.php)
```php
class RestockPrintService {
    // Generate printable plan document (pre-purchase guidance)
    public function generatePlanSheet($restock) {}
    
    // Generate printable receipt (post-fulfillment)
    public function generateReceipt($restock) {}
    
    // Export to PDF
    public function exportToPDF($restock, $type = 'plan') {}
}
```

---

## Validation Rules

### RestockBuilder:
```php
[
    'budget_amount' => 'required|numeric|min:0',
    'tax_percentage' => 'nullable|numeric|min:0|max:100',
    'shipping_fee' => 'nullable|numeric|min:0',
    'labor_fee' => 'nullable|numeric|min:0',
    'other_fees' => 'nullable|array',
    'other_fees.*.label' => 'required|string|max:50',
    'other_fees.*.amount' => 'required|numeric|min:0',
    'notes' => 'nullable|string|max:500',
    'items' => 'required|array|min:1',
    'items.*.product_id' => 'required|exists:products,id',
    'items.*.quantity_requested' => 'required|integer|min:1',
    'items.*.unit_cost' => 'required|numeric|min:0',
]
```

---

## Routes

```php
// web.php
Route::middleware('auth')->group(function () {
    // Re-stock Planning
    Route::get('/restock', [RestockController::class, 'builder'])
        ->name('restock.builder');
    
    // Save/Update plan
    Route::post('/restock', [RestockController::class, 'store'])
        ->name('restock.store');
    Route::put('/restock/{restock}', [RestockController::class, 'update'])
        ->name('restock.update');
    
    // View saved plans
    Route::get('/restock/plans', [RestockController::class, 'plans'])
        ->name('restock.plans');
    
    // View single plan
    Route::get('/restock/plans/{restock}', [RestockController::class, 'show'])
        ->name('restock.show');
    
    // Fulfill plan
    Route::get('/restock/plans/{restock}/fulfill', [RestockController::class, 'fulfill'])
        ->name('restock.fulfill');
    Route::post('/restock/plans/{restock}/fulfill', [RestockController::class, 'confirmFulfill'])
        ->name('restock.confirmFulfill');
    
    // Delete plan
    Route::delete('/restock/plans/{restock}', [RestockController::class, 'destroy'])
        ->name('restock.destroy');
});
```

---

## Data Persistence Strategy

### 1. Session-based Cart (Temporary)
- Store current cart in session while building plan
- Clear on save or discard
- Session key: `restock_cart_{inventory_id}`

### 2. Database-based Plans (Permanent)
- Save complete plan to `restocks` and `restock_items` tables
- Status field tracks: draft → pending → fulfilled
- `fulfilled_at` timestamp only set when fulfilled

### 3. User Preferences (Cost Templates)
- Load restock costs from `restock_costs` table by inventory & user
- User can create/edit templates for quick reuse
- Templates are suggestions, can be overridden per plan

### 4. Stock Movements (Audit Log)
- Each fulfillment creates `StockMovement` records
- `restock_id` references the plan for audit trail
- Cost breakdown already stored in `restocks` and `restock_items` tables

---

## Key Calculations

### Total Cost Formula:
```
Cart Total = SUM(product.quantity * product.unit_cost)
Tax Amount = Cart Total × (Tax % / 100)
Total Fees = Shipping + Labor + SUM(Other Fees)
TOTAL COST = Cart Total + Tax Amount + Total Fees

Budget Status:
- If TOTAL COST <= Budget: "under" (green)
- If TOTAL COST > Budget: "over" (red)
- Difference = Budget - TOTAL COST (can be negative)
```

### Real-time UI Updates:
- All calculations trigger on: quantity change, tax update, fee change
- Use Livewire's reactive properties to cascade updates
- Debounce tax input (300ms) to reduce API calls

---

## Feature Phases

### Phase 1: Core Re-stock Builder (MVP)
- [x] Database tables creation
- [ ] `RestockBuilder` Livewire component
- [ ] Product search & selection
- [ ] Quantity management with dial
- [ ] Cost configuration (budget, tax, shipping, labor)
- [ ] Cart summary with real-time calculations
- [ ] Budget status indicator
- [ ] Save plan functionality

### Phase 2: Plan Management
- [ ] `RestockPlansList` component
- [ ] View saved plans
- [ ] Edit existing plans
- [ ] Delete plans
- [ ] Filter/search plans

### Phase 3: Fulfillment
- [ ] `RestockFulfill` component
- [ ] Fulfillment flow with confirmation
- [ ] Bulk stock updates
- [ ] Stock movement creation with restock metadata
- [ ] Print receipt

### Phase 4: Enhancements (Future)
- [ ] Plan history/versioning
- [ ] Email notifications on fulfillment
- [ ] Restock schedule/recurring plans
- [ ] Comparison analysis (planned vs actual costs)
- [ ] Budget forecasting

---

## Testing Strategy

### Unit Tests:
- `RestockService` calculations
- `RestockFeeManager` fee operations
- Budget status logic
- Validation rules

### Feature Tests:
- Create restock plan flow
- Update existing plan
- Fulfill plan workflow
- Stock movement creation
- Session management

### Livewire Component Tests:
- Product search interaction
- Quantity updates
- Cost configuration changes
- Form submission
- Budget status UI updates

---

## Integration with Existing System

### StockMovement Enhancement:
- Add `restock_id` foreign key to link fulfillments
- Add `restock_metadata` JSON field for audit purposes
- Existing `stock_adjustment` logic remains unchanged
- Type field already supports 'adjustment' - restock is a type of adjustment

### User Model Enhancement:
- No changes needed (restock costs now in separate `restock_costs` table)

### Inventory Model:
- Add `hasMany('restocks')` relationship
- Used to filter plans by inventory context

### Product Model:
- Add `restockItems()` relationship to `RestockItem`
- Used for restock history per product

### RestockCost Model:
```php
class RestockCost extends Model {
    protected $fillable = ['inventory_id', 'user_id', 'cost_type', 'label', 'amount', 'is_percentage', 'is_active'];
    
    protected $casts = [
        'amount' => 'decimal:2',
        'is_percentage' => 'boolean',
        'is_active' => 'boolean',
    ];
    
    public function inventory() { return $this->belongsTo(Inventory::class); }
    public function user() { return $this->belongsTo(User::class); }
}
```

---

## API Responses (for AJAX/Livewire)

### GET /api/products/search
```json
{
    "data": [
        {
            "id": 1,
            "name": "Widget A",
            "sku": "WID-001",
            "barcode": "123456789",
            "current_stock": 50,
            "cost_price": 10.00,
            "reorder_level": 20,
            "category": "Electronics"
        }
    ]
}
```

### POST /api/restock/calculate
```json
{
    "cart_total": 4000.00,
    "tax_percentage": 15,
    "tax_amount": 600.00,
    "shipping_fee": 200.00,
    "labor_fee": 150.00,
    "other_fees": [
        {"label": "Handling", "amount": 50.00}
    ],
    "total_cost": 4950.00,
    "budget_amount": 5500.00,
    "budget_status": "under",
    "budget_difference": 550.00
}
```

---

## Error Handling

### Validation Errors:
- Display inline validation messages
- Highlight invalid fields with red borders
- Show summary of all errors at form top

### Business Logic Errors:
- Product no longer available (deleted)
- Insufficient product stock for plan quantity
- Budget amount less than zero
- Negative quantities/fees

### Fulfillment Errors:
- Plan already fulfilled (prevent duplicate)
- Plan deleted by another user
- Stock movement creation fails

---

## Performance Considerations

1. **Product Search**: Implement full-text search with indexes on name, SKU, barcode
2. **Plan Listing**: Paginate results, lazy-load plan details
3. **Calculations**: Memoize total cost calculation, update only on relevant changes
4. **Database**: Index on `restocks(inventory_id, status)` for faster queries
5. **Livewire**: Use wire:lazy for list components, debounce search input

---

## Security

1. **Authorization**:
   - User can only view/edit plans for their inventory
   - Middleware: `CheckInventoryAccess`

2. **Data Validation**:
   - All inputs validated server-side
   - Decimal precision limited to 2 places
   - Quantities must be positive integers

3. **Audit Trail**:
   - Track who created/fulfilled plans
   - Stock movements link back to restock plan
   - `fulfilled_by_user_id` optional field in `restocks`

---

## UI/UX Enhancements

1. **Keyboard Shortcuts**: 
   - Cmd+S to save plan
   - Cmd+K to search products

2. **Undo/Redo**: 
   - Stack-based action history

3. **Tooltips**:
   - Budget status indicator
   - Tax percentage field
   - Fee classification

4. **Dark Mode**: 
   - Already supported in existing system
   - Use existing Tailwind classes

5. **Mobile Responsiveness**:
   - Stack panels vertically on small screens
   - Swipeable cart items
   - Touch-friendly dial controls

---

## Implementation Checklist

- [ ] Create migrations for `restocks`, `restock_items`, and `restock_costs` tables
- [ ] Add `restock_id` column to `stock_movements` table
- [ ] Create `Restock`, `RestockItem`, and `RestockCost` models
- [ ] Create `RestockService`, `RestockCostManager`, and `RestockPrintService` services
- [ ] Create `RestockController`
- [ ] Build `RestockBuilder` Livewire component
- [ ] Build `RestockDetails` component with print options
- [ ] Build `RestockFulfill` component
- [ ] Build `RestockPlansList` and other supporting components
- [ ] Create Blade views for each component
- [ ] Implement print templates (Plan sheet, Receipt)
- [ ] Implement routes
- [ ] Add validation rules
- [ ] Implement tests (unit + feature)
- [ ] Create cost template management UI
- [ ] Update navigation menu
- [ ] Add database seeding for testing
- [ ] Documentation & user guide
- [ ] Demo/walkthrough video

---

## Success Metrics

1. Users can build restock plan in < 2 minutes
2. Budget calculation accurate to the cent
3. Fulfillment completes in < 1 second per 50 items
4. Stock movements correctly logged with restock reference
5. No data loss on page refresh/navigation
6. Mobile-friendly experience
7. Print functionality works pre-purchase and post-fulfillment

---

## Notes

- This plan avoids redundant logging by leveraging existing `StockMovement` system
- `restock_id` in stock movements links fulfillments back to plan for audit trail
- Cost breakdown stored in `restocks` and `restock_items` tables for historical accuracy
- `restock_costs` table stores reusable templates (not per-restock, per-inventory)
- Print functionality available pre-purchase (guidance) and post-fulfillment (receipt)
- All calculations are deterministic (same inputs = same outputs) for auditability
- Plan can be easily extended for recurring restocks, approval workflows, or cost forecasting

