<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\ClassFactory as CF;

class TransactionController extends Controller
{
    public function index(Request $request,$type = null) {
        if($type == 'api'){
            $data = [];
            $search = $request->search['value'];
            $start = $request->start;
            $length = $request->length;
            $columns = array(
                        'transaction_no',
                        'date_trans',
                        'worker',
                        'transacted',
                        'amount',
                    );

            $transactionData = CF::model('Tbl_transaction')
                ->groupBy(
                    'transaction_no',
                    'date_trans',
                    'worker_id',
                    'tbl_user_id'
                    )
                ->select(
                    'transaction_no',
                    'date_trans',
                    \DB::raw('(SELECT user_name FROM tbl_users WHERE id = tbl_transactions.worker_id) as worker'),
                    \DB::raw('(SELECT user_name FROM tbl_users WHERE id = tbl_transactions.tbl_user_id) as transacted')
                    )
                ->where('transaction_no','like','%'.$search.'%')
                ->orWhere('date_trans','like','%'.$search.'%')
                ->offset($start)
                ->limit($length)
                ->orderBy($columns[$request->order[0]['column']],$request->order[0]['dir'])
                ->get();

            
            $transactionCount = CF::model('Tbl_transaction')
                ->groupBy(
                    'transaction_no',
                    'worker_id',
                    'tbl_user_id'
                    )
                ->select(
                    'transaction_no',
                    \DB::raw('(SELECT user_name FROM tbl_users WHERE id = tbl_transactions.worker_id) as worker'),
                    \DB::raw('(SELECT user_name FROM tbl_users WHERE id = tbl_transactions.tbl_user_id) as transacted')
                    )
                ->where('transaction_no','like','%'.$search.'%')
                ->orWhere('date_trans','like','%'.$search.'%')
                ->count();
            
            foreach($transactionData as $k => $each){

                // $viewBtn = '<button type="button" class="btn btn-sm btn-mild" onclick="view('.$each['id'].')">View</button>';

                // $addToCartBtn = '
                //                 <button type="button" class="btn btn-sm btn-info" onclick="addToCart(this,'.$each['id'].','.$each['qty'].','.$each['srp_price'].')" data-item="'.$each['item_name'].'">
                //                     Add to Cart <i class="fa fa-arrow-right"></i> 
                //                 </button>
                //             ';
                $data[$k][] = $each['transaction_no'];
                $data[$k][] = $each['date_trans'];
                $data[$k][] = $each['worker'];
                $data[$k][] = $each['transacted'];
                $data[$k][] = number_format(0);
                $data[$k][] = '';
            }
            
            $json_data = array(
                "draw" => intval($request->input('draw')),
                "recordsTotal" => $transactionCount,
                "recordsFiltered" => $transactionCount,
                "data" => $data
            );

            echo json_encode($json_data);
            exit;
        }
        return view('pages/transaction/index');
    }
}
