<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Helpers\HelperCustom;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterSkuBusinessType as MainModel;
use Illuminate\Support\Collection;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;



class SkuBusinessTypeComponent extends Component
{

    use WithPagination;

    public $collection_data;
    public $cached_data;
    
    public $edit_id;
    public $prefix = '';
    public $manual_id = '';
    public $description = '';
    public $category = '';

    public $allowed_category = ['AUTOMOTIVE', 'NON-AUTOMOTIVE'];
    public $allowed_category__str = '';

    public $allowed_show_entries = [10, 25, 50, 100];
    public $show_entry;
    public $sort_desc = true;
    public $keyword = "";


    public $page = 1;
    protected $queryString = [
        'page' => ['except' => 1],
        'show_entry' => ['except' => 10], // default
        'keyword' => ['except' => ''],
        'sort_desc' => ['except' => false]
    ];

    public $show_modal = true;

    public function mount()
    {
        $this->allowed_category__str = implode(',', $this->allowed_category);

        $cache_save_entry = Session::get('table.show_entry');

        $this->show_entry = in_array($cache_save_entry, $this->allowed_show_entries, true) ? $cache_save_entry : $this->allowed_show_entries[0];
    }

    public function render()
    {

        $main_data = MainModel::query()
            ->where("flag_active", 1)
            ->when($this->keyword, function ($q) {
                $q->where(function ($q2) {
                    $q2->where('description', 'like', "%{$this->keyword}%")
                    ->orWhere('prefix', 'like', "%{$this->keyword}%")
                    ->orWhere('category', 'like', "%{$this->keyword}%");
                });
            })->when($this->sort_desc, function ($q) {
                $q->orderByDesc('id');
            })->paginate($this->show_entry)->onEachSide(2);
        
        $this->collection_data = $main_data->getCollection();
        $this->cached_data = $this->collection_data->toArray();

        // dd($this->main_data);


        $start_index = ($this->page - 1) * $this->show_entry;
        
        return view('master.sku_business_type.live_index', [
            "start_index" => $start_index,
            "main_data" => $main_data
        ]);
    }

    public function openModal($id = null)
    {
        if ($id ?? false) {
            $row = $this->collection_data->firstWhere('id', $id);
            
            if (!$row) {
                session()->flash('error', 'Data tidak tersedia di page ini!');
                return;
            }
            
            $this->edit_id = $row->id;
            $this->prefix = $row->prefix;
            $this->manual_id = $row->manual_id;
            $this->description = $row->description;
            $this->category = $row->category;
    
            $this->show_modal = true;
        } else {
            $this->reset(["edit_id", "prefix", "manual_id", "description", "category"]);
            $this->show_modal = true;
        }
    }

    public function addData(array $forms)
    {
        $validated = Validator::make($forms, [
            'manual_id' => 'nullable|max:50',
            'description' => 'required|string|max:50',
            'category' => 'required|in:' . $this->allowed_category__str,
        ])->validate();

        // $validated = $this->validate([
        //     'manual_id' => 'nullable|max:50',
        //     'description' => 'required|string|max:50',
        //     'category' => 'required|in:' . $this->allowed_category__str,
        // ]);

        $new = MainModel::create($validated);

        $new->flag_active = 1;
        $new->prefix = HelperCustom::generateTrxNo('SKUT', $new->id);
        $new->save();

        session()->flash('success', 'Data berhasil ditambahkan');
    }

    public function getData()
    {
        // validasi show_entry
        if (!in_array((int) $this->show_entry, $this->allowed_show_entries, true)) {
            $this->show_entry = $this->allowed_show_entries[0];
        }

        // simpan ke session
        session()->put('table.show_entry', (int) $this->show_entry);

        // reset pagination
        $this->resetPage();
    }

    public function editData(array $forms)
    {
        $validated = Validator::make($forms, [
            'manual_id' => 'nullable|max:50',
            'description' => 'required|string|max:50',
            'category' => 'required|in:' . $this->allowed_category__str,
        ])->validate();
        // $validated = $this->validate([
        //     'manual_id' => 'nullable|max:50',
        //     'description' => 'required|string|max:50',
        //     'category' => 'required|in:' . $this->allowed_category__str,
        // ]);

        $data = MainModel::findOrFail(id: $forms['id']);

        $data->update($validated);
        session()->flash('success', 'Data berhasil diubah');
    }

    public function deleteData()
    {
        $data = MainModel::findOrFail($this->editId);
        $data->flag_active = 0;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
        session()->flash('success', 'Data berhasil dihapus');
    }

    
}
