<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use App\Library\ClassFactory as CF;

use Validator;

class InventoryController extends Controller
{
    public function index(Request $request,$type = null) {

        if($type == 'api'){
            $data = [];
            $search = $request->search['value'];
            $start = $request->start;
            $length = $request->length;
            $columns = array(
                        'item_name',
                        'category_name',
                        'size',
                        'qty',
                        'price',
                        'srp_price',
                    );

            $products = CF::model('Tbl_items')
                        ->select('Tbl_items.*','Tbl_categories.category_name')
                        ->join('Tbl_categories','Tbl_categories.id','Tbl_items.tbl_category_id')
                        ->where('Tbl_categories.category_name','like','%'.$search.'%')
                        ->orWhere('Tbl_items.item_name','like','%'.$search.'%')
                        ->orWhere('Tbl_items.description','like','%'.$search.'%')
                        ->orWhere('Tbl_items.size','like','%'.$search.'%')
                        ->orWhere('Tbl_items.price','like','%'.$search.'%')
                        ->orWhere('Tbl_items.srp_price','like','%'.$search.'%')
                        ->offset($start)
                        ->limit($length)
                        ->orderBy($columns[$request->order[0]['column']],$request->order[0]['dir'])
                        ->get();

            $productsCount = CF::model('Tbl_items')
                        ->select('Tbl_items.*','Tbl_categories.category_name')
                        ->join('Tbl_categories','Tbl_categories.id','Tbl_items.tbl_category_id')
                        ->where('Tbl_categories.category_name','like','%'.$search.'%')
                        ->orWhere('Tbl_items.item_name','like','%'.$search.'%')
                        ->orWhere('Tbl_items.description','like','%'.$search.'%')
                        ->orWhere('Tbl_items.size','like','%'.$search.'%')
                        ->orWhere('Tbl_items.price','like','%'.$search.'%')
                        ->orWhere('Tbl_items.srp_price','like','%'.$search.'%')
                        ->count();

            foreach($products as $k => $each){

                $viewBtn = '<button type="button" class="btn btn-sm btn-mild" onclick="view('.$each['id'].')">View</button>';

                $addToCartBtn = '
                                <button type="button" class="btn btn-sm btn-info" onclick="addToCart(this,'.$each['id'].','.$each['qty'].','.$each['srp_price'].')" data-item="'.$each['item_name'].'">
                                    Add to Cart <i class="fa fa-arrow-right"></i> 
                                </button>
                            ';
                $data[$k][] = $each['item_name'];
                $data[$k][] = $each['category_name'];
                $data[$k][] = $each['size'];
                $data[$k][] = $each['qty'];
                $data[$k][] = number_format($each['srp_price'],2);
                $data[$k][] = $each['qty'] > 0 ? $addToCartBtn : 'Inventory Empty';
            }

            $json_data = array(
                "draw" => intval($request->input('draw')),
                "recordsTotal" => $productsCount,
                "recordsFiltered" => $productsCount,
                "data" => $data
            );
            echo json_encode($json_data);
            exit;
        }

        $userData = CF::model('Tbl_user')->all();
        return view('pages/inventory/index',compact('userData'));
    }

    public function store(Request $request, $type = null) {

        $data = [];
        
        if($type == 'api'){            
            $userData = CF::model('Tbl_user')
                        ->select('id','password')
                        ->get();

            $userId = 0;
            foreach($userData as $each){
                if(Hash::check($request->user_password, $each['password']) == 1){
                    $userId = $each['id'];   
                }
            }
            if($userId == 0){
                $data['type'] = 'error';
                $data['message'] = 'Invalid password!';
            }
            else{
                $data['type'] = 'success';
                $data['message'] = $userId;
            }
                
            return $data;
        }

        $validations = [];

        $lastId = CF::model('Tbl_transaction')->limit(1)->orderBy('id','desc')->get();

        $lastIdNew = !$lastId->isEmpty() ? $lastId[0]['transaction_no'] : 0;
        $transcode = 'TR'.str_pad(str_replace("TR","",$lastIdNew) + 1, 6, '0', STR_PAD_LEFT);

        $validations['customer_name'] = 'required|filled';

        foreach($request->id as $k => $each){
            $validations['id.'.$k] = 'required|filled';
            $validations['qty.'.$k] = 'required|filled';
            $validations['price.'.$k] = 'required|filled';
            $validations['amount.'.$k] = 'required|filled';
        }

        $validator = Validator::make($request->all(),$validations);

        if($validator->fails()){
            $data['type'] = 'error';
            $data['message'] = $validator->errors();

            return $data;
        }

        $customer_id = CF::model('Tbl_customer')->create([
            'customer_name' => $request->customer_name,
            'address' => $request->address,
        ]);

        foreach($request->id as $k => $each){
            
            CF::model('Tbl_transaction')->create([
                'transaction_no' => $transcode,
                'tbl_customer_id' => $customer_id->id,
                'worker_id' => $request->worker_id,
                'tbl_user_id' => $request->user_id,
                'tbl_item_id' => $request->id[$k],
                'qty' => $request->qty[$k],
                'price' => $request->price[$k],
                'type' => 'sell',
                'amount' => $request->amount[$k],
                'date_trans' => date('Y-m-d'),
            ]);

            $itemData[] = CF::model('Tbl_items')->find($request->id[$k]);
            $itemData[$k]['total_item_sell'] += $request->qty[$k];
            $itemData[$k]['qty'] -= $request->qty[$k];
            
            $itemData[$k]->update();
        }
        

        $data['type'] = 'success';
        $data['message'] = 'Checkout Success!';
        $data['code'] = $transcode;

        return $data;
    }

    public function receipt(Request $request, $code = null) {
        $transData = CF::model('Tbl_transaction')
                        ->join('tbl_customers','tbl_customers.id','tbl_transactions.tbl_customer_id')
                        ->join('tbl_items','tbl_items.id','tbl_transactions.tbl_item_id')
                        ->select(
                            'tbl_transactions.date_trans',
                            'tbl_transactions.qty',
                            'tbl_transactions.price',
                            'tbl_transactions.amount',
                            'tbl_items.item_name',
                            'tbl_customers.customer_name',
                            'tbl_customers.address',
                            \DB::raw('(SELECT user_name FROM tbl_users WHERE id = tbl_transactions.worker_id) as worker'),
                            \DB::raw('(SELECT user_name FROM tbl_users WHERE id = tbl_transactions.tbl_user_id) as transacted')
                            )
                        ->where([
                            ['tbl_transactions.transaction_no','=',$code],
                            ['tbl_transactions.type','=','sell'],
                        ])
                        ->get();
        $grandTotal = 0;
        foreach($transData as $each){
            $grandTotal += $each['amount'];
        }

        return view('pages/inventory/receipt',compact('transData','grandTotal'));
    }
}