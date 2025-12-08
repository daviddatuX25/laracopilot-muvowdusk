<?php

namespace App\Livewire\Restock;

use App\Models\Product;
use App\Models\Inventory;
use App\Models\Restock;
use App\Services\RestockService;
use App\Services\RestockCostManager;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class RestockBuilder extends Component
{
    use WithPagination;

    public Inventory $inventory;
    public array $defaultCosts = [];
    public array $costTemplates = [];

    // Cart items
    public array $cartItems = [];

    // Budget & Costs
    public float $budgetAmount = 0;
    public float $taxPercentage = 0;
    public float $shippingFee = 0;
    public float $laborFee = 0;
    public array $otherFees = [];

    // Summary calculations
    public float $cartTotal = 0;
    public float $taxAmount = 0;
    public float $totalCost = 0;
    public string $budgetStatus = 'fit';
    public float $budgetDifference = 0;

    // Product search
    public string $searchQuery = '';
    public array $searchResults = [];
    public int $currentPage = 1;

    // Form state
    public string $notes = '';
    public bool $showProductModal = false;
    public ?Product $selectedProduct = null;
    public int $selectedQuantity = 1;
    public float $selectedUnitCost = 0;

    protected $restockService;
    protected $costManager;
    public ?Restock $restock = null;
    public ?Restock $editingRestock = null;

    public function mount()
    {
        // Initialize services
        $this->restockService = app(RestockService::class);
        $this->costManager = app(RestockCostManager::class);

        $inventoryId = session('inventory_id');
        if (!$inventoryId) {
            $this->redirectRoute('inventory.lobby');
            return;
        }

        $this->inventory = Inventory::findOrFail($inventoryId);

        if (!Auth::user()->inventories->contains($this->inventory)) {
            $this->redirectRoute('inventory.lobby');
            return;
        }

        // Initialize with default costs
        $this->defaultCosts = $this->costManager->getDefaultCosts($this->inventory);
        $this->costTemplates = $this->costManager->getCostTemplatesGrouped($this->inventory);

        // If editing existing plan (route param is stored in $restock)
        if ($this->restock) {
            $this->authorize('update', $this->restock);
            $this->editingRestock = $this->restock;

            // Load existing plan data
            $this->budgetAmount = (float) $this->restock->budget_amount;
            $this->taxPercentage = (float) $this->restock->tax_percentage;
            $this->shippingFee = (float) $this->restock->shipping_fee;
            $this->laborFee = (float) $this->restock->labor_fee;

            // Ensure other_fees is always an array
            $otherFeesData = $this->restock->other_fees ?? [];
            $this->otherFees = $this->normalizeOtherFees(is_array($otherFeesData) ? $otherFeesData : []);

            $this->notes = $this->restock->notes ?? '';

            // Load cart items
            $this->cartItems = $this->restock->items->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity_requested,
                    'unit_cost' => (float) $item->unit_cost,
                    'subtotal' => (float) $item->subtotal,
                ];
            })->toArray();

            $this->calculateTotals();
        } else {
            // New plan - use defaults
            $this->taxPercentage = $this->defaultCosts['tax_percentage'] ?? 0;
            $this->shippingFee = $this->defaultCosts['shipping_fee'] ?? 0;
            $this->laborFee = $this->defaultCosts['labor_fee'] ?? 0;

            // Ensure other_fees is always properly formatted
            $otherFeesData = $this->defaultCosts['other_fees'] ?? [];
            $this->otherFees = $this->normalizeOtherFees(is_array($otherFeesData) ? $otherFeesData : []);
        }
    }

    #[On('updated.searchQuery')]
    public function updatedSearchQuery()
    {
        $this->searchProducts();
    }

    /**
     * Normalize other_fees array to ensure consistent structure
     */
    private function normalizeOtherFees(array $fees): array
    {
        if (empty($fees)) {
            return [];
        }

        $normalized = array_filter(
            array_map(function ($fee) {
                if (!is_array($fee)) {
                    return null;
                }
                return [
                    'label' => (string) ($fee['label'] ?? ''),
                    'amount' => (float) ($fee['amount'] ?? 0),
                ];
            }, $fees),
            fn ($fee) => $fee !== null
        );

        return array_values($normalized);
    }

    public function searchProducts()
    {
        if (strlen($this->searchQuery) < 2) {
            $this->searchResults = [];
            return;
        }

        $this->searchResults = Product::where('inventory_id', $this->inventory->id)
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->searchQuery . '%')
                    ->orWhere('sku', 'like', '%' . $this->searchQuery . '%')
                    ->orWhere('barcode', 'like', '%' . $this->searchQuery . '%');
            })
            ->limit(10)
            ->get()
            ->toArray();
    }

    public function selectProduct(int $productId)
    {
        $this->selectedProduct = Product::find($productId);
        $this->selectedUnitCost = $this->selectedProduct->cost_price;
        $this->selectedQuantity = 1;
        // Clear search dropdown after selection
        $this->searchQuery = '';
        $this->searchResults = [];
    }

    public function incrementQuantity()
    {
        $this->selectedQuantity++;
    }

    public function decrementQuantity()
    {
        if ($this->selectedQuantity > 1) {
            $this->selectedQuantity--;
        }
    }

    public function clearSelection()
    {
        $this->selectedProduct = null;
        $this->selectedQuantity = 1;
        $this->selectedUnitCost = 0;
        $this->searchQuery = '';
        $this->searchResults = [];
    }

    public function addToCart()
    {
        if (!$this->selectedProduct) {
            $this->dispatch('toast', type: 'error', message: 'No product selected');
            return;
        }

        if ($this->selectedQuantity < 1) {
            $this->dispatch('toast', type: 'error', message: 'Quantity must be at least 1');
            return;
        }

        if ($this->selectedUnitCost < 0) {
            $this->dispatch('toast', type: 'error', message: 'Unit cost cannot be negative');
            return;
        }

        // Check if product already in cart
        $existingIndex = array_search($this->selectedProduct->id, array_column($this->cartItems, 'product_id'));

        if ($existingIndex !== false) {
            $this->cartItems[$existingIndex]['quantity'] += $this->selectedQuantity;
            $this->cartItems[$existingIndex]['subtotal'] =
                $this->cartItems[$existingIndex]['quantity'] * $this->cartItems[$existingIndex]['unit_cost'];
        } else {
            $this->cartItems[] = [
                'product_id' => $this->selectedProduct->id,
                'product_name' => $this->selectedProduct->name,
                'quantity' => $this->selectedQuantity,
                'unit_cost' => $this->selectedUnitCost,
                'subtotal' => $this->selectedQuantity * $this->selectedUnitCost,
            ];
        }

        $this->calculateTotals();
        $this->searchQuery = '';
        $this->searchResults = [];
        $this->selectedProduct = null;

        $this->dispatch('toast', type: 'success', message: 'Product added to cart');
    }

    public function updateQuantity(int $index, int $quantity)
    {
        if ($quantity < 1) {
            unset($this->cartItems[$index]);
            $this->cartItems = array_values($this->cartItems);
        } else {
            $this->cartItems[$index]['quantity'] = $quantity;
            $this->cartItems[$index]['subtotal'] =
                $quantity * $this->cartItems[$index]['unit_cost'];
        }

        $this->calculateTotals();
    }

    public function updateUnitCost(int $index, float $unitCost)
    {
        if ($unitCost < 0) {
            $unitCost = 0;
        }

        $this->cartItems[$index]['unit_cost'] = $unitCost;
        $this->cartItems[$index]['subtotal'] =
            $this->cartItems[$index]['quantity'] * $unitCost;

        $this->calculateTotals();
    }

    public function removeFromCart(int $index)
    {
        unset($this->cartItems[$index]);
        $this->cartItems = array_values($this->cartItems);
        $this->calculateTotals();
    }

    public function clearCart()
    {
        $this->cartItems = [];
        $this->calculateTotals();
    }

    public function addOtherFee()
    {
        $this->otherFees[] = ['label' => '', 'amount' => 0];
    }

    public function removeOtherFee(int $index)
    {
        unset($this->otherFees[$index]);
        $this->otherFees = array_values($this->otherFees);
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        // Guard against null services (during initial render)
        if (!$this->restockService) {
            $this->restockService = app(RestockService::class);
        }

        if (empty($this->cartItems) || $this->budgetAmount <= 0) {
            $this->cartTotal = 0;
            $this->taxAmount = 0;
            $this->totalCost = 0;
            $this->budgetStatus = 'fit';
            $this->budgetDifference = $this->budgetAmount;
            return;
        }

        // Ensure numeric types for cart items (Livewire may convert to strings)
        $sanitizedCartItems = array_map(function ($item) {
            return [
                'product_id' => (int) $item['product_id'],
                'product_name' => (string) $item['product_name'],
                'quantity' => (int) $item['quantity'],
                'unit_cost' => (float) $item['unit_cost'],
                'subtotal' => (float) $item['subtotal'],
            ];
        }, $this->cartItems);

        $costData = [
            'budget_amount' => (float) $this->budgetAmount,
            'tax_percentage' => (float) $this->taxPercentage,
            'shipping_fee' => (float) $this->shippingFee,
            'labor_fee' => (float) $this->laborFee,
            'other_fees' => array_map(function ($fee) {
                return [
                    'amount' => (float) ($fee['amount'] ?? 0),
                    'label' => (string) ($fee['label'] ?? ''),
                ];
            }, $this->otherFees),
        ];

        $calculations = $this->restockService->calculateTotalCost($sanitizedCartItems, $costData);
        $budgetStatus = $this->restockService->getBudgetStatus($calculations['total_cost'], (float) $this->budgetAmount);

        $this->cartTotal = $calculations['cart_total'];
        $this->taxAmount = $calculations['tax_amount'];
        $this->totalCost = $calculations['total_cost'];
        $this->budgetStatus = $budgetStatus['status'];
        $this->budgetDifference = $budgetStatus['difference'];
    }

    public function updateTaxPercentage()
    {
        $this->calculateTotals();
    }

    public function updateShippingFee()
    {
        $this->calculateTotals();
    }

    public function updateLaborFee()
    {
        $this->calculateTotals();
    }

    public function updateOtherFee()
    {
        $this->calculateTotals();
    }

    public function validateBudgetAmount()
    {
        // Default to 0 if empty
        if ($this->budgetAmount === '' || $this->budgetAmount === null) {
            $this->budgetAmount = 0;
        } else {
            $this->budgetAmount = (float) $this->budgetAmount;
        }
        $this->calculateTotals();
    }

    public function validateTaxPercentage()
    {
        if ($this->taxPercentage === '' || $this->taxPercentage === null) {
            $this->taxPercentage = 0;
        } else {
            $this->taxPercentage = (float) $this->taxPercentage;
        }
        $this->calculateTotals();
    }

    public function validateShippingFee()
    {
        if ($this->shippingFee === '' || $this->shippingFee === null) {
            $this->shippingFee = 0;
        } else {
            $this->shippingFee = (float) $this->shippingFee;
        }
        $this->calculateTotals();
    }

    public function validateLaborFee()
    {
        if ($this->laborFee === '' || $this->laborFee === null) {
            $this->laborFee = 0;
        } else {
            $this->laborFee = (float) $this->laborFee;
        }
        $this->calculateTotals();
    }

    public function saveRestockPlan()
    {
        // Guard against null services
        if (!$this->restockService) {
            $this->restockService = app(RestockService::class);
        }

        if (empty($this->cartItems)) {
            $this->dispatch('toast', type: 'error', message: 'Please add at least one product to the cart');
            return;
        }

        if ($this->budgetAmount <= 0) {
            $this->dispatch('toast', type: 'error', message: 'Budget amount must be greater than 0');
            return;
        }

        try {
            // Clean other_fees: remove empty ones
            $cleanedOtherFees = array_filter(
                $this->otherFees,
                fn ($fee) => !empty($fee['label']) && (float) ($fee['amount'] ?? 0) > 0
            );

            $costData = [
                'budget_amount' => $this->budgetAmount,
                'tax_percentage' => $this->taxPercentage,
                'shipping_fee' => $this->shippingFee,
                'labor_fee' => $this->laborFee,
                'other_fees' => array_values($cleanedOtherFees), // Re-index the array
            ];

            if ($this->editingRestock) {
                // Update existing plan
                $restock = $this->restockService->updateRestockPlan(
                    $this->editingRestock,
                    $this->cartItems,
                    $costData,
                    $this->notes
                );
                $this->dispatch('toast', type: 'success', message: 'Restock plan updated successfully!');
            } else {
                // Create new plan
                $restock = $this->restockService->createRestockPlan(
                    $this->inventory,
                    Auth::user(),
                    $this->cartItems,
                    $costData,
                    $this->notes
                );
                $this->dispatch('toast', type: 'success', message: 'Restock plan saved successfully!');
            }

            $this->redirectRoute('restock.show', $restock);
        } catch (\Exception $e) {
            $this->dispatch('toast', type: 'error', message: 'Error saving plan: ' . $e->getMessage());
        }
    }

    public function saveDefaultCosts()
    {
        try {
            // Guard against null services
            if (!$this->costManager) {
                $this->costManager = app(RestockCostManager::class);
            }

            // Delete existing default costs for this user/inventory
            $this->costManager->deleteUserDefaults($this->inventory);

            // Create new default costs
            if ($this->taxPercentage > 0) {
                $this->costManager->createTemplate(
                    $this->inventory,
                    Auth::user(),
                    'tax',
                    'Tax',
                    $this->taxPercentage,
                    true
                );
            }

            if ($this->shippingFee > 0) {
                $this->costManager->createTemplate(
                    $this->inventory,
                    Auth::user(),
                    'shipping',
                    'Shipping',
                    $this->shippingFee,
                    false
                );
            }

            if ($this->laborFee > 0) {
                $this->costManager->createTemplate(
                    $this->inventory,
                    Auth::user(),
                    'labor',
                    'Labor',
                    $this->laborFee,
                    false
                );
            }

            // Update default costs
            $this->defaultCosts = $this->costManager->getDefaultCosts($this->inventory);
            $this->dispatch('toast', type: 'success', message: 'Default costs saved successfully!');
        } catch (\Exception $e) {
            $this->dispatch('toast', type: 'error', message: 'Error saving defaults: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $header = $this->editingRestock
            ? "Edit Re-stock Plan #" . $this->editingRestock->id
            : "Re-stock Planning";

        view()->share('header', $header);

        return view('livewire.restock.restock-builder', [
            'header' => $header
        ]);
    }
}
