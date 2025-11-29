<?php

namespace App\Livewire\Report;

trait BaseReportTrait
{
    public $search = '';
    public $filterCategory = '';
    public $filterSupplier = '';
    public $perPage = 15;

    protected function applySearchFilter($query, $searchFields = ['name', 'sku'])
    {
        if (!empty($this->search)) {
            $query->where(function ($q) use ($searchFields) {
                foreach ($searchFields as $field) {
                    $q->orWhere($field, 'like', '%' . $this->search . '%');
                }
            });
        }
        return $query;
    }

    protected function applyCategoryFilter($query)
    {
        if (!empty($this->filterCategory)) {
            $query->where('category_id', $this->filterCategory);
        }
        return $query;
    }

    protected function applySupplierFilter($query)
    {
        if (!empty($this->filterSupplier)) {
            $query->where('supplier_id', $this->filterSupplier);
        }
        return $query;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterCategory()
    {
        $this->resetPage();
    }

    public function updatedFilterSupplier()
    {
        $this->resetPage();
    }
}
