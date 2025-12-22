<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\MasterPersonCustomer;
use App\Models\MasterCustomerDeliveryDestination;
use Illuminate\Support\Str;
use App\Helpers\NumberGenerator;
use Illuminate\Support\Facades\DB;


class MasterPersonCustomerController
{

    public function index(): Response
    {
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

    public function index_delivery(Request $request, int $customerId): Response
    {
        // get customer info 
        
        $query = DB::table('mst_customer');
        $query->where('id', $customerId);
        $customer_data = $query->get()->first();
        $customer_id = $customer_data->id;
        $customer_name= $customer_data->name;
        $customer_code = $customer_data->prefix;

        // get delivery info
        $query = DB::table('vw_app_list_mst_customer_delivery_hd');
        $query->where('customer_id', $customerId);
        $data = $query->get();

        
        return response()->view('master.person_customer.index_delivery', 
        [
            'data' =>  $data,
            'customer_id' => $customer_id,
            'customer_name' => $customer_name,
            'customer_code' => $customer_code
             ]
    );
    }

    public function add_delivery_destination(Request $request, int $customer_id)
    {
        $doc_num_generated = NumberGenerator::generateNumberV3('mst_customer_delivery_destination', 'DD', 'counter');
        $data['prefix'] = $doc_num_generated['doc_num'];
        $data['counter'] = $doc_num_generated['doc_counter'];
        $data['customer_id'] = $customer_id;
        $data['destination_code'] = $request->destination_code;
        $data['destination_name'] = $request->destination_name;
        $data['destination_address'] = $request->destination_address;
        $data['flag_destination_type'] = $request->flag_destination_type;
        $data['flag_destination_status'] = 1;
        $data['flag_active'] = 1;
        $data['flag_show'] = 1;
        $data['manual_id'] = $request->manual_id;
        $data['generated_id'] = Str::uuid()->toString();
        $data = MasterCustomerDeliveryDestination::create($data);
        $data->save();
        return redirect("/customer/".$customer_id."/delivery");
    }
}
