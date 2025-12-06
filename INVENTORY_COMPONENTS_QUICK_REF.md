# Inventory Components - Quick Reference

## What Are We Creating?

### 1️⃣ REUSABLE COMPONENTS (`resources/views/components/inventory/`)
These are generic, can be used anywhere, like LEGO blocks:

```
Form Components:
  ✓ form-input.blade.php       (text, email, number inputs)
  ✓ form-textarea.blade.php    (multi-line text)
  ✓ form-select.blade.php      (dropdown)
  ✓ form-checkbox.blade.php    (checkbox with label)
  ✓ form-radio.blade.php       (radio buttons)

Button Components:
  ✓ button.blade.php           (primary, secondary, danger, success)
  ✓ button-group.blade.php     (multiple buttons together)
  ✓ icon-button.blade.php      (icon-only buttons)

Card Components:
  ✓ card.blade.php             (basic card container)
  ✓ card-header.blade.php      (card title/header)
  ✓ stat-card.blade.php        (KPI cards: Total, Count, Value)
  ✓ alert-card.blade.php       (colored alert cards)

Table Components:
  ✓ table.blade.php            (table wrapper)
  ✓ table-header.blade.php     (column headers)
  ✓ table-row.blade.php        (table rows with hover)
  ✓ table-cell.blade.php       (table cells)
  ✓ table-empty.blade.php      (no data message)

Badge Components:
  ✓ badge.blade.php            (generic badges)
  ✓ stock-badge.blade.php      (In Stock, Low Stock, Out of Stock)
  ✓ status-indicator.blade.php (animated status dot)

Other Components:
  ✓ modal.blade.php            (popup dialog)
  ✓ confirmation-dialog.blade.php (confirm before action)
  ✓ loading-spinner.blade.php  (loading indicator)
  ✓ empty-state.blade.php      (no results message)
  ✓ pagination.blade.php       (page navigation)
  ✓ breadcrumbs.blade.php      (navigation path)
  ✓ tabs.blade.php             (tab navigation)
  ✓ search-box.blade.php       (search input)
  ✓ toast-notification.blade.php (notifications like alerts)
```

### 2️⃣ LIVEWIRE COMPONENTS (Keep in `resources/views/livewire/inventory/`)
These need live backend interaction:

```
UNIQUE COMPONENTS (Don't make generic):
  ✓ barcode-scanner.blade.php     (ZXing barcode scanning)
  ✓ product-lookup.blade.php      (Smart product search with camera)

PAGES/MANAGEMENT (Already structured):
  ✓ dashboard.blade.php           (Main dashboard - needs Livewire)
  ✓ alerts-list.blade.php         (Alert management - live updates)
  ✓ stock-adjustment/stock-adjustment.blade.php
  ✓ category/category-*.blade.php
  ✓ product/product-*.blade.php
  ✓ supplier/supplier-*.blade.php
  ✓ report/report-*.blade.php

SMALL COMPONENTS (Move to inventory/components/):
  ✓ alerts-counter.blade.php      (Badge showing pending alerts)
  ✓ notification-center.blade.php (Notification popup)
  ✓ toast.blade.php               (Toast notification)
```

---

## Organization Pattern

```
Admin Area (Already Done):
resources/views/
  └── components/admin/
      ├── button.blade.php
      ├── form-input.blade.php
      ├── table.blade.php
      └── ... (10-12 components)

Inventory Area (We're Doing Now):
resources/views/
  └── components/inventory/
      ├── form/
      │   ├── form-input.blade.php
      │   ├── form-textarea.blade.php
      │   └── ...
      ├── button/
      │   ├── button.blade.php
      │   └── ...
      ├── card/
      ├── badge/
      ├── table/
      ├── modal/
      ├── state/
      └── ... (organized by type)
```

---

## Why This Structure?

| Aspect | Reason |
|--------|--------|
| **Generic Components** | Reusable across all pages, DRY principle, easier maintenance |
| **Livewire Components** | Need real-time data, server interaction, state management |
| **Organized Subfolders** | Easy to find components by type (form, card, button, etc.) |
| **Naming Convention** | Consistent, follows Laravel Blade component conventions |
| **Follows Admin Pattern** | Same structure as admin area for consistency |

---

## Example Usage After Implementation

### Before (Without Components):
```blade
<!-- Repetitive code scattered everywhere -->
<div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-gray-600 text-sm font-medium">Total Products</p>
            <p class="text-3xl font-bold text-gray-900">{{ $totalProducts }}</p>
        </div>
        <div class="bg-blue-100 p-3 rounded-lg">
            <svg>...</svg>
        </div>
    </div>
</div>
```

### After (With Components):
```blade
<!-- Clean, reusable, consistent -->
<x-inventory.card.stat-card
    title="Total Products"
    value="{{ $totalProducts }}"
    color="blue"
    icon="box"
/>
```

---

## Component Naming Convention

### Path → Usage
```
resources/views/components/inventory/form/form-input.blade.php
→ <x-inventory.form.form-input />

resources/views/components/inventory/card/stat-card.blade.php
→ <x-inventory.card.stat-card />

resources/views/components/inventory/badge/stock-badge.blade.php
→ <x-inventory.badge.stock-badge />

resources/views/components/inventory/table/table.blade.php
→ <x-inventory.table.table />
```

---

## Benefits

✅ **Code Reusability** - Write once, use everywhere
✅ **Consistency** - Same styling across entire inventory system
✅ **Maintainability** - Change one component, affects all usages
✅ **Scalability** - Easy to extend and add new components
✅ **Team Efficiency** - Others can quickly use existing components
✅ **Testing** - Test components once, trust them everywhere
✅ **Accessibility** - Built-in ARIA labels and semantic HTML

---

## Next: We'll Create

1. **Form Components** - Inputs, selects, checkboxes
2. **Button Components** - Various button styles
3. **Card Components** - Containers for content
4. **Table Components** - Display data efficiently
5. **Badge Components** - Stock status indicators
6. **Other Utilities** - Modals, toasts, loaders
7. **Move Views** - Reorganize existing views
8. **Update References** - Update imports/routes

Ready to start building! 🚀
