<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\RestockCost;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class RestockCostManager
{
    /**
     * Get all saved cost templates for inventory
     */
    public function getCostTemplates(Inventory $inventory, string $costType = null): Collection
    {
        $query = $inventory->restockCosts()->active();

        if ($costType) {
            $query->where('cost_type', $costType);
        }

        return $query->get();
    }

    /**
     * Get cost templates grouped by type
     */
    public function getCostTemplatesGrouped(Inventory $inventory): array
    {
        $templates = $this->getCostTemplates($inventory);

        $grouped = [
            'tax' => [],
            'shipping' => [],
            'labor' => [],
            'other' => [],
        ];

        foreach ($templates as $template) {
            $type = $template->cost_type;
            if (!isset($grouped[$type])) {
                $grouped[$type] = [];
            }
            $grouped[$type][] = $template;
        }

        return $grouped;
    }

    /**
     * Create new cost template
     */
    public function createTemplate(
        Inventory $inventory,
        User $user,
        string $costType,
        string $label,
        float $amount,
        bool $isPercentage = false
    ): RestockCost {
        return RestockCost::create([
            'inventory_id' => $inventory->id,
            'user_id' => $user->id,
            'cost_type' => $costType,
            'label' => $label,
            'amount' => $amount,
            'is_percentage' => $isPercentage,
            'is_active' => true,
        ]);
    }

    /**
     * Delete all default costs for current user in inventory
     */
    public function deleteUserDefaults(Inventory $inventory): void
    {
        $inventory->restockCosts()
            ->where('user_id', Auth::id())
            ->delete();
    }

    /**
     * Update cost template
     */
    public function updateTemplate(RestockCost $template, array $data): RestockCost
    {
        $template->update($data);
        return $template->fresh();
    }

    /**
     * Delete cost template
     */
    public function deleteTemplate(RestockCost $template): bool
    {
        return $template->delete();
    }

    /**
     * Deactivate cost template (soft delete)
     */
    public function deactivateTemplate(RestockCost $template): RestockCost
    {
        $template->update(['is_active' => false]);
        return $template->fresh();
    }

    /**
     * Get default costs for inventory (for quick form population)
     */
    public function getDefaultCosts(Inventory $inventory): array
    {
        // Get templates for the current user only
        $userId = Auth::id();

        $templates = $inventory->restockCosts()
            ->where('user_id', $userId)
            ->where('is_active', true)
            ->get();

        $defaults = [
            'tax_percentage' => 0,
            'shipping_fee' => 0,
            'labor_fee' => 0,
            'other_fees' => [],
        ];

        foreach ($templates as $template) {
            match ($template->cost_type) {
                'tax' => $defaults['tax_percentage'] = $template->amount,
                'shipping' => $defaults['shipping_fee'] = $template->amount,
                'labor' => $defaults['labor_fee'] = $template->amount,
                'other' => $defaults['other_fees'][] = [
                    'label' => $template->label,
                    'amount' => $template->amount,
                    'id' => $template->id,
                ],
                default => null,
            };
        }

        return $defaults;
    }

    /**
     * Get statistics about costs for an inventory
     */
    public function getCostStatistics(Inventory $inventory): array
    {
        $templates = $this->getCostTemplates($inventory);

        return [
            'total_templates' => $templates->count(),
            'by_type' => [
                'tax' => $templates->where('cost_type', 'tax')->count(),
                'shipping' => $templates->where('cost_type', 'shipping')->count(),
                'labor' => $templates->where('cost_type', 'labor')->count(),
                'other' => $templates->where('cost_type', 'other')->count(),
            ],
            'by_user' => $templates->groupBy('user_id')->count(),
        ];
    }
}
