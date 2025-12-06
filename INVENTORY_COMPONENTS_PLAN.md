# Inventory System Components Planning

## Overview
Following the admin area pattern, we'll organize the inventory system into:
1. **Repeating Views** → Move to `resources/views/livewire/inventory/` folder
2. **Generic Reusable Components** → Create in `resources/views/components/inventory/`
3. **Unique Livewire Components** → Keep in main Livewire folder with other components

---

## Current Repeating Views to Organize

### Files to Move to `livewire/inventory/`
```
alerts-counter.blade.php          → inventory/components/alerts-counter.blade.php
alerts-list.blade.php             → inventory/alerts-list.blade.php (page/template)
barcode-scanner.blade.php         → Keep in inventory/barcode-scanner.blade.php (UNIQUE)
dashboard.blade.php               → inventory/dashboard.blade.php (page/template)
notification-center.blade.php     → inventory/components/notification-center.blade.php
product-lookup.blade.php          → Keep in inventory/product-lookup.blade.php (UNIQUE)
toast.blade.php                   → inventory/components/toast.blade.php
```

### Existing Structured Views (Already in folders)
```
stock/
  └── stock-adjustment.blade.php
category/
  ├── category-create.blade.php
  ├── category-edit.blade.php
  └── category-list.blade.php
product/
  ├── product-create.blade.php
  ├── product-edit.blade.php
  └── product-list.blade.php
report/
  ├── full-inventory-report.blade.php
  ├── low-stock-report.blade.php
  ├── movement-history-report.blade.php
  ├── report-dashboard.blade.php
  └── summary-report.blade.php
supplier/
  ├── supplier-create.blade.php
  ├── supplier-edit.blade.php
  └── supplier-list.blade.php
admin/
  ├── inventory-management.blade.php
  ├── user-inventory-link.blade.php
  └── user-management.blade.php
```

---

## Generic Reusable Components to Create

### `resources/views/components/inventory/`

#### 1. **Form Components** (Inputs, validation, etc.)
- `form-input.blade.php` - Text/email/number input
- `form-textarea.blade.php` - Large text area
- `form-select.blade.php` - Dropdown/select
- `form-checkbox.blade.php` - Checkbox with label
- `form-radio.blade.php` - Radio button group
- `form.blade.php` - Form wrapper with submit button

#### 2. **Table Components** (Display data)
- `table.blade.php` - Main table wrapper
- `table-row.blade.php` - Table row with hover
- `table-cell.blade.php` - Table data cell
- `table-empty.blade.php` - Empty state message
- `table-header.blade.php` - Responsive table headers

#### 3. **Button Components** (Actions)
- `button.blade.php` - Versatile button (primary, secondary, danger, success, etc.)
- `button-group.blade.php` - Group of buttons
- `icon-button.blade.php` - Button with icon

#### 4. **Card Components** (Content containers)
- `card.blade.php` - Basic card wrapper
- `card-header.blade.php` - Card header with title
- `stat-card.blade.php` - KPI/stat display card
- `alert-card.blade.php` - Alert/notification card

#### 5. **Badge/Status Components**
- `badge.blade.php` - Status badge (stock status, alerts, etc.)
- `status-indicator.blade.php` - Live status dot
- `stock-badge.blade.php` - Stock level indicator (In Stock, Low Stock, Out of Stock)

#### 6. **Modal/Dialog Components**
- `modal.blade.php` - Modal wrapper
- `confirmation-dialog.blade.php` - Confirm action dialog
- `modal-header.blade.php` - Modal header
- `modal-footer.blade.php` - Modal footer with actions

#### 7. **List Components**
- `list-item.blade.php` - List item wrapper
- `list-group.blade.php` - List group container
- `checklist.blade.php` - Checkable list items

#### 8. **Filter/Search Components**
- `search-box.blade.php` - Search input
- `filter-group.blade.php` - Filter controls
- `date-range-picker.blade.php` - Date range selection

#### 9. **Loading/State Components**
- `loading-spinner.blade.php` - Loading indicator
- `empty-state.blade.php` - No data message
- `error-message.blade.php` - Error display
- `success-message.blade.php` - Success notification

#### 10. **Pagination/Navigation**
- `pagination.blade.php` - Page navigation
- `breadcrumbs.blade.php` - Breadcrumb navigation
- `tabs.blade.php` - Tab navigation

---

## Unique Livewire Components (Stay in Main Livewire)

These require live interactivity with Livewire backend logic:

### Keep in `livewire/inventory/`:
1. **barcode-scanner.blade.php** - ZXing scanner with JS logic
2. **product-lookup.blade.php** - Modal search with camera
3. **dashboard.blade.php** - Dashboard with live polling & data
4. **alerts-list.blade.php** - Live alert management with Livewire
5. **notification-center.blade.php** - Live notifications with polling

### Generic Components (Move to `components/inventory/`):
1. **alerts-counter.blade.php** → `badge.blade.php` variant (can be generic)
2. **toast.blade.php** → `toast-notification.blade.php` (reusable notification)

---

## Folder Structure After Reorganization

```
resources/views/
├── livewire/
│   ├── inventory/
│   │   ├── components/
│   │   │   ├── alerts-counter.blade.php      (Livewire component)
│   │   │   ├── notification-center.blade.php (Livewire component)
│   │   │   └── toast.blade.php               (Livewire component)
│   │   ├── dashboard.blade.php               (Livewire - main page)
│   │   ├── alerts-list.blade.php             (Livewire - live management)
│   │   ├── barcode-scanner.blade.php         (Livewire - unique)
│   │   ├── product-lookup.blade.php          (Livewire - unique)
│   │   ├── stock/
│   │   │   └── stock-adjustment.blade.php
│   │   ├── category/
│   │   │   ├── category-create.blade.php
│   │   │   ├── category-edit.blade.php
│   │   │   └── category-list.blade.php
│   │   ├── product/
│   │   │   ├── product-create.blade.php
│   │   │   ├── product-edit.blade.php
│   │   │   └── product-list.blade.php
│   │   ├── report/
│   │   │   ├── full-inventory-report.blade.php
│   │   │   ├── low-stock-report.blade.php
│   │   │   ├── movement-history-report.blade.php
│   │   │   ├── report-dashboard.blade.php
│   │   │   └── summary-report.blade.php
│   │   └── supplier/
│   │       ├── supplier-create.blade.php
│   │       ├── supplier-edit.blade.php
│   │       └── supplier-list.blade.php
│   ├── admin/
│   ├── alerts-counter.blade.php    (TO DELETE - moved)
│   ├── alerts-list.blade.php       (TO DELETE - moved)
│   └── ... (other existing Livewire components)
│
└── components/
    ├── admin/
    │   ├── alert.blade.php
    │   ├── badge.blade.php
    │   ├── button.blade.php
    │   ├── form-checkbox.blade.php
    │   ├── form-input.blade.php
    │   ├── form-select.blade.php
    │   ├── form-textarea.blade.php
    │   ├── form.blade.php
    │   ├── table-cell.blade.php
    │   ├── table-empty.blade.php
    │   ├── table-row.blade.php
    │   └── table.blade.php
    │
    └── inventory/
        ├── form/
        │   ├── form.blade.php
        │   ├── form-input.blade.php
        │   ├── form-textarea.blade.php
        │   ├── form-select.blade.php
        │   ├── form-checkbox.blade.php
        │   └── form-radio.blade.php
        │
        ├── table/
        │   ├── table.blade.php
        │   ├── table-row.blade.php
        │   ├── table-header.blade.php
        │   ├── table-cell.blade.php
        │   └── table-empty.blade.php
        │
        ├── button/
        │   ├── button.blade.php
        │   ├── button-group.blade.php
        │   └── icon-button.blade.php
        │
        ├── card/
        │   ├── card.blade.php
        │   ├── card-header.blade.php
        │   ├── stat-card.blade.php
        │   └── alert-card.blade.php
        │
        ├── badge/
        │   ├── badge.blade.php
        │   ├── status-indicator.blade.php
        │   └── stock-badge.blade.php
        │
        ├── modal/
        │   ├── modal.blade.php
        │   ├── confirmation-dialog.blade.php
        │   ├── modal-header.blade.php
        │   └── modal-footer.blade.php
        │
        ├── list/
        │   ├── list-item.blade.php
        │   ├── list-group.blade.php
        │   └── checklist.blade.php
        │
        ├── filter/
        │   ├── search-box.blade.php
        │   ├── filter-group.blade.php
        │   └── date-range-picker.blade.php
        │
        ├── state/
        │   ├── loading-spinner.blade.php
        │   ├── empty-state.blade.php
        │   ├── error-message.blade.php
        │   ├── success-message.blade.php
        │   └── toast-notification.blade.php
        │
        └── navigation/
            ├── pagination.blade.php
            ├── breadcrumbs.blade.php
            └── tabs.blade.php
```

---

## Implementation Priority

### Phase 1: Foundation (Reusable Components)
1. Form components (input, textarea, select, checkbox, radio)
2. Button variants
3. Card and stat-card
4. Badge and stock-badge
5. Table components
6. Empty state and loading indicators

### Phase 2: Complex Components
7. Modal/Dialog components
8. Search and filter components
9. Toast notifications
10. Pagination and navigation

### Phase 3: Reorganize Views
11. Move repeating views to `inventory/` folder
12. Move generic components to `components/inventory/`
13. Update Livewire component references
14. Update route references

### Phase 4: Refactor Existing Views
15. Refactor views to use new components
16. Ensure consistency across all pages
17. Test all functionality

---

## Component Usage Examples

### Form Component
```blade
<x-inventory.form.form-input 
    name="product_name"
    label="Product Name"
    placeholder="Enter product name"
    required
/>
```

### Button Component
```blade
<x-inventory.button.button
    variant="primary"
    size="lg"
    wire:click="save"
>
    Save Product
</x-inventory.button.button>
```

### Stat Card
```blade
<x-inventory.card.stat-card
    title="Total Products"
    value="{{ $totalProducts }}"
    icon="box"
    color="blue"
/>
```

### Stock Badge
```blade
<x-inventory.badge.stock-badge
    status="{{ $product->stock_status }}"
    quantity="{{ $product->current_stock }}"
/>
```

### Table with Components
```blade
<x-inventory.table.table>
    <x-slot name="header">
        <x-inventory.table.table-header columns="['Name', 'SKU', 'Stock', 'Actions']" />
    </x-slot>
    
    @foreach($products as $product)
        <x-inventory.table.table-row>
            <x-inventory.table.table-cell>{{ $product->name }}</x-inventory.table.table-cell>
            <x-inventory.table.table-cell>{{ $product->sku }}</x-inventory.table.table-cell>
            <x-inventory.table.table-cell>
                <x-inventory.badge.stock-badge :product="$product" />
            </x-inventory.table.table-cell>
            <x-inventory.table.table-cell>
                <x-inventory.button.icon-button icon="edit" wire:click="edit({{ $product->id }})" />
            </x-inventory.table.table-cell>
        </x-inventory.table.table-row>
    @endforeach
</x-inventory.table.table>
```

---

## Notes

- **Livewire Components** stay in the main livewire folder structure but are organized logically
- **Blade Components** are reusable and follow the admin pattern
- **Naming Convention**: Use hyphens (kebab-case) for files
- **Props**: Define clear props for flexibility
- **Slots**: Use slots for content injection
- **Consistency**: Follow Tailwind classes and color scheme from admin area
- **Accessibility**: Include ARIA labels and semantic HTML

---

## Next Steps

1. ✅ Create this plan
2. Create folder structure
3. Create generic components
4. Move and update views
5. Refactor views to use components
6. Test and validate
