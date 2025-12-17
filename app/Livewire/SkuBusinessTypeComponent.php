<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Helpers\HelperCustom;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterSkuBusinessType;

class SkuBusinessTypeComponent extends Component
{
    public $editId;
    public $code = '';
    public $name = '';
    public $category = '';

    public $allowed_category = ['AUTOMOTIVE', 'NON-AUTOMOTIVE'];
    public $allowed_category__str = '';

    public function mount()
    {
        $this->allowed_category__str = implode(',', $this->allowed_category);
    }

    public function render()
    {
        return view('master.sku_business_type.live_index');
    }

    public function addData()
    {
        $validated = $this->validate([
            'name' => 'required|min:3|max:50',
            'category' => 'required|in:' . $this->allowed_category__str,
        ]);

        $new = MasterSkuBusinessType::create($validated);

        $new->prefix = HelperCustom::generateTrxNo('SKUT', $new->id);
        $new->save();

        session()->flash('success', 'Data berhasil ditambahkan');
    }

    public function editData()
    {
        $validated = $this->validate([
            'name' => 'required|min:3|max:50',
            'category' => 'required|in:' . $this->allowed_category__str,
        ]);

        $data = MasterSkuBusinessType::findOrFail($this->editId);

        $data->update($validated);
        session()->flash('success', 'Data berhasil diubah');
    }

    public function deleteData()
    {
        $data = MasterSkuBusinessType::findOrFail($this->editId);
        $data->flag_active = 0;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
        session()->flash('success', 'Data berhasil dihapus');
    }
}
