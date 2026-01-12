<?php

namespace App\Livewire\Pages\ProcessAndBusinessType;

use Livewire\Component;
use App\Models\{
    MasterSkuProcessClassification as MainModel,
    MasterSkuProcessType,
};
use Illuminate\Support\Facades\{
    Session,
    Validator
};
use Livewire\WithPagination;
use App\Helpers\HelperCustom;

class ProcessClassification extends Component
{
    use WithPagination;

    public array 
        $cached_datas = [],
        $process_types = [];
    
    protected $validator_rules = [
        "manual_id" => "nullable|max:50|min:3",
        "description" => "required|string|max:50|min:3",
        'mst_sku_process_type_id' => 'required|integer|exists:mst_sku_process_type,id',
    ];

    // pagination
    public $allowed_show_entries = [1,10, 25, 50, 100];
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
    
    public  function mount() {
        $this->process_types = MasterSkuProcessType::forSelect()->where("flag_active", "=", "1")->get()->toArray();

        $cache_save_entry = Session::get('table.show_entry');

        $this->show_entry = \in_array($cache_save_entry, $this->allowed_show_entries, true) ? $cache_save_entry : $this->allowed_show_entries[0];

    }
        
    public function render()
    {
        // validasi show_entry
        if (!\in_array((int) $this->show_entry, $this->allowed_show_entries, true)) {
            $this->show_entry = $this->allowed_show_entries[0];
        }

        // simpan ke session
        session()->put('table.show_entry', (int) $this->show_entry);

        $main_datas = MainModel::with('process_type:id,prefix,description')
            ->when($this->keyword, function ($q) {
                $keyword = "%{$this->keyword}%";

                $q->where(function ($q2) use ($keyword) {
                    $q2->where('description', 'like', $keyword)
                    ->orWhere('prefix', 'like', $keyword)
                    ->orWhereHas('process_type', function ($q3) use ($keyword) {
                        $q3->where('description', 'like', $keyword);
                    });
                });
            })
            ->when($this->sort_desc, fn ($q) => $q->orderByDesc('id'))
            ->paginate($this->show_entry)
            ->onEachSide(2)
        ;

        $this->cached_datas = $main_datas->toArray();

        $start_index = ($this->page - 1) * $this->show_entry;

        return view('livewire.pages.process-and-business-type.process-classification', [
            'breadcrumbs' => [
                '#1' => 'Material Detail',
                '#2' => 'Process And Business Type',
                '#3' => 'Process classification',
            ],
            'main_datas' => $main_datas,
            "start_index" => $start_index,
        ]);
    }


    public function add(array $froms) {
        $validated = Validator::make($froms, $this->validator_rules)->validate();

        MainModel::create($validated);

        $this->dispatch("notify", [
            "variant" => "success",
            "title" => "Success",
            "message" => "Data berhasil ditambahkan."
        ]);
    }

    public function edit(array $froms) {
        $validated = Validator::make($froms, $this->validator_rules)->validate();

        MainModel::findOrFail($froms["id"])->update($validated);

        $this->dispatch("notify", [
            "variant" => "success",
            "title" => "Success",
            "message" => "Data berhasil diedit."
        ]);
    }

    public function remove(int $id) {
        MainModel::findOrFail($id)->delete();

        $this->dispatch("notify", [
            "variant" => "success",
            "title" => "Success",
            "message" => "Data berhasil dihapus."
        ]);
    }

    // other method
    public function regeneratePrefix(int $id) {
        $data = MainModel::findOrFail($id);
        $data->prefix = HelperCustom::generateTrxNo(MainModel::PREFIX . '-', $data->id);
        $data->save();

        $this->dispatch("notify", [
            "variant" => "success",
            "title" => "Success",
            "message" => "Code berhasil di regenerate."
        ]);
    }
}
