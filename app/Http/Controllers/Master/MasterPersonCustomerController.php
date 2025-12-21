<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\MasterPersonCustomer;
use Illuminate\Support\Str;
use App\Helpers\NumberGenerator;
use Illuminate\Support\Facades\DB;


class MasterPersonCustomerController
{

    public function index(): Response
    {
        $data = MasterPersonCustomer::where('flag_active', 1)->get();
        return response()->view('master.person_customer.index', ['data' =>  null ]);
    }

    public function get_all(Request $request){
        
        $start = $request->input('start');
        $length = $request->input('length'); 
        $search = $request->input('search.value');
        $query = DB::table('mst_customer');

        $recordsTotal = $query->count();
        $recordsFiltered = $query->count();
        
        if($length > 0){        
            $data = $query->limit($length)->offset($start)->orderBy('prefix','DESC')->get();
        }else{
            $data = $query->sortBy('prefix')->get();
        }

        $data = [
            'data' =>  $data,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ];

        return response()->json([
            'draw' => intval($request->input('draw')), // Parameter dari DataTables
            'recordsTotal' => $data['recordsTotal'], // Total record tanpa filter
            'recordsFiltered' => $data['recordsFiltered'], // Total record setelah filter
            'data' => $data['data'], // Data untuk ditampilkan
        ]);
    }

    public function add(Request $request)
    {
        $doc_num_generated = NumberGenerator::generateNumberV3('mst_customer', 'CTC', 'counter');
        $data['prefix'] = $doc_num_generated['doc_num'];
        $data['counter'] = $doc_num_generated['doc_counter'];
        $data['name'] = $request->name;
        $data['initials'] = $request->initials;
        $data['npwp'] = $request->npwp;
        $data['office_address'] = $request->office_address;
        $data['phone_number'] = $request->phone_number;
        $data['fax_number'] = $request->fax_number;
        $data['email'] = $request->email;
        $data['contact_person_name'] = $request->contact_person_name;
        $data['contact_person_phone'] = $request->contact_person_phone;
        $data['contact_person_email'] = $request->contact_person_email;
        $data['flag_active'] = 1;
        $data['flag_show'] = 1;
        $data['manual_id'] = $request->manual_id;
        $data['generated_id'] = Str::uuid()->toString();
        $data = MasterPersonCustomer::create($data);
        $data->save();
        return redirect("/customer");
    }

    public function delete(Request $request, int $id)
    {
        $data = MasterPersonCustomer::where('id', $id)->firstOrFail();
        $data->flag_active = 0;
        $data->save();
        return redirect("/customer");
    }
  
    public function get(Request $request, int $id)
    {
       $data = MasterPersonCustomer::where('id', $id)->firstOrFail();
        return response()->json([
            'data' => $data
        ]);
    }

    public function edit(Request $request)
    {
        $data = MasterPersonCustomer::where('id', $request->id)->firstOrFail();
        $data->name = $request->name;
        $data->initials = $request->initials;
        $data->office_address = $request->office_address;
        $data->phone_number = $request->phone_number;
        $data->email = $request->email;
        $data->contact_person_name = $request->contact_person_name;
        $data->contact_person_phone= $request->contact_person_phone;
        $data->contact_person_email= $request->contact_person_email;
        $data->save();
        return redirect("/customer");
    }
}
