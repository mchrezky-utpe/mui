<?php

namespace App\Services\Transaction;
use App\Helpers\NumberGenerator;

use App\Helpers\HelperCustom;
use App\Models\Transaction\PurchaseOrder;
use App\Models\Transaction\VwPoDroplist;
use App\Models\Transaction\VwPoItemList;
use App\Models\Transaction\PurchaseOrderDetail;
use App\Models\Transaction\PurchaseOrderDeduction;
use App\Models\Transaction\PurchaseOrderOtherCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Helpers\CalcHelper;
use App\Models\Transaction\PurchaseOrdePrintDtVw;
use App\Models\Transaction\PurchaseOrdePrintHdVw;
use Illuminate\Support\Facades\DB;


class PurchaseOrderService
{
    public function list(){
          return PurchaseOrder::where('flag_active', 1)->get();
    }

    public function get_droplist($request){
        return VwPoDroplist::where('prs_supplier_id', $request->input('supplier_id'))->get();
     }

     public function get_item_by(Request $request){
         return VwPoItemList::where('trans_po_id', $request->input('id'))->get();
      }

    public function get_all(Request $request){
        $start = $request->input('start'); // Start index untuk pagination
        $length = $request->input('length'); // Jumlah data per halaman
        $search = $request->input('search.value'); // Pencarian global
        $orderColumnIndex = $request->input('order.0.column'); // Indeks kolom yang diurutkan
        $orderDirection = $request->input('order.0.dir'); // Arah pengurutan (asc/desc)
        $columns = $request->input('columns'); // Semua kolom

        //$orderColumn = $columns[$orderColumnIndex]['data'];


        // $query = DB::table('trans_purchase_order')
        //     ->select(
        //         'trans_purchase_order.id',
        //         'trans_purchase_order.trans_date',
        //         'trans_purchase_order.manual_id',
        //         'trans_purchase_order.doc_num',
        //         'trans_purchase_order.flag_type',
        //         'trans_purchase_order.prs_supplier_id',
        //         'trans_purchase_order.description',
        //         'mst_person_supplier.description as supplier_name'
        //     )
        //     ->leftJoin('mst_person_supplier', 'trans_purchase_order.prs_supplier_id', '=', 'mst_person_supplier.id');

        $query = DB::table('vw_app_list_trans_po_hd');

        //$query->where('trans_purchase_order.flag_active', [1]);

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('trans_purchase_order.trans_date', [$request->start_date, $request->end_date]);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('trans_purchase_order.manual_id', 'like', '%' . $search . '%')
                    ->orWhere('trans_purchase_order.doc_num', 'like', '%' . $search . '%')
                    ->orWhere('mst_person_supplier.description', 'like', '%' . $search . '%')
                    ->orWhere('trans_purchase_order.description', 'like', '%' . $search . '%');
            });
        }

        $recordsTotal = $query->count();

        $recordsFiltered = $query->count();

        /*
        if($orderColumn){
            $query->orderBy($orderColumn, $orderDirection);
        }
        */

        //$data = $query->offset($start)->limit($length)->get();
        $data = $query->get();
        return [
            'data' => $data,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' =>  $recordsFiltered
        ];
    }

    public function upload(Request $request){
        DB::beginTransaction();

        try {

        // Ambil file dari request
        $file = $request->file('file');
        // $fileName = $file->getClientOriginalName();
        // $mimeType = $file->getMimeType();
        $fileData = file_get_contents($file->getRealPath()); // Baca file sebagai binary data

            
        $purchaseOrder = PurchaseOrder::where('id', $request->id)->firstOrFail();
        $purchaseOrder->file = $fileData;
        $purchaseOrder->save();

        DB::commit();
        }catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollBack();
            dd($e);
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function add(Request $request)
    {
        // Mulai transaksi
        DB::beginTransaction();

        try {
            // Generate nomor dokumen
            $doc_num_generated = NumberGenerator::generateNumber('trans_purchase_order', 'MUI/P0');

            // PO Header Data
            $data = [
                'manual_id' => $request->manual_id,
                'trans_date' => $request->trans_date,
                'valid_from_date' => $request->valid_from_date,
                'valid_to_date' => $request->valid_to_date,
                'flag_type' => $request->flag_type,
                'gen_terms_detail_id' => $request->gen_terms_detail_id,
                'gen_department_id' => $request->gen_department_id,
                'prs_supplier_id' => $request->prs_supplier_id,
                'gen_currency_id' => $request->gen_currency_id,
                'description' => $request->description,
                'val_exchangerates' => $request->val_exchangerates ?? 1,
                'doc_num' => $doc_num_generated['doc_num'],
                'doc_counter' => $doc_num_generated['doc_counter'],
                'flag_status' => 1,
                'revision' => 0,
                'generated_id' => Str::uuid()->toString(),
                'flag_active' => 1,
            ];

            // Simpan data PO Header
            $poHeader = PurchaseOrder::create($data);
            $items;

            // PO Detail Data
            foreach ($request->sku_id as $index => $sku_id) {
                $price = $request->price[$index];
                $qty = $request->qty[$index];
                $discount_percentage = $request->discount_percentage[$index] ?? 0;
                $vat_percentage = $request->vat_percentage[$index] ?? 0;

                $subtotal = CalcHelper::calcSubtotal($data['val_exchangerates'], $qty, $price);
                $discount = CalcHelper::calcDiscount($subtotal['sub_total_f'], $subtotal['sub_total_d'], $discount_percentage);
                $vat = CalcHelper::calcVat($discount['after_discount_f'], $discount['after_discount_d'], $vat_percentage);

                $items[] = [
                    'sku_description' => $request->sku_description[$index],
                    'sku_prefix' => $request->sku_prefix[$index],
                    'description' => $request->description_item[$index] ?? null,
                    'sku_id' => $sku_id,
                    'price_f' => $price,
                    'price_d' => $price * $qty * $data['val_exchangerates'],
                    'qty' => $qty,
                    'subtotal_f' => $subtotal['sub_total_f'],
                    'subtotal_d' => $subtotal['sub_total_d'],
                    'discount_percentage' => $discount_percentage,
                    'discount_flag' => null, // TODO
                    'discount_f' => $discount['discount_f'],
                    'discount_d' => $discount['discount_d'],
                    'afterdiscount_f' => $discount['after_discount_f'],
                    'afterdiscount_d' => $discount['after_discount_d'],
                    'vat_percentage' => $vat_percentage,
                    'vat_flag' => null, // TODO
                    'vat_f' => $vat['vat_f'],
                    'vat_d' => $vat['vat_d'],
                    'total_f' => $vat['total_f'],
                    'total_d' => $vat['total_d'],
                    'generated_id' => Str::uuid()->toString(),
                    'trans_po_id' => $poHeader->id,
                    'manual_id' => '',
                ];
            }

            // Simpan data PO Detail
            PurchaseOrderDetail::insert($items);

            // Commit transaksi jika semua berhasil
            DB::commit();
        } catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollBack();
            dd($e);
            return response()->json([
                'message' => 'Terjadi kesalahan saat membuat Purchase Order.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $purchaseOrder = PurchaseOrder::where('id', $id)->firstOrFail();

            $purchaseOrder->flag_active = 0;
            $purchaseOrder->deleted_at = Carbon::now();
            $purchaseOrder->deleted_by = Auth::id();
            $purchaseOrder->save();

            DB::commit();

        } catch (\Exception $e) {
            // Rollback jika ada error
            DB::rollBack();
            dd($e);
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus Purchase Order.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function get(int $id)
    {
        return PurchaseOrder::where('id', $id)->firstOrFail();
    }
    public function print(int $id)
    {
        $header = PurchaseOrdePrintHdVw::where('id', $id)->first();
        $detail = PurchaseOrdePrintDtVw::where('trans_po_id', $id)->get();

        return [
            'header' => $header,
            'detail' => $detail,
        ];
    }

    function edit(Request $request)
    {
        $data = PurchaseOrder::where('id', $request->id)->firstOrFail();
        $data->description = $request->description;
        $data->manual_id= $request->manual_id;
        $data->save();
    }
}
