<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use App\Library\ClassFactory as CF;

use Validator;

class ExpenseController extends Controller
{
    public function index(Request $request, $type = null) {
        if($type == 'api'){
            $data = [];
            $search = $request->search['value'];
            $start = $request->start;
            $length = $request->length;
            $columns = array(
                        'date_from',
                        'amount',
                        'description',
                        'user_name',
                    );

            $expense = CF::model('Tbl_expense')
                            ->join('Tbl_users','Tbl_users.id','Tbl_expenses.tbl_user_id')
                            ->select('Tbl_expenses.*','Tbl_users.user_name')
                            ->where('user_name','like','%'.$search.'%')
                            ->orWhere('amount','like','%'.$search.'%')
                            ->orWhere('description','like','%'.$search.'%')
                            ->offset($start)
                            ->limit($length)
                            ->orderBy($columns[$request->order[0]['column']],$request->order[0]['dir'])
                            ->get();
            
            $expenseCount = CF::model('Tbl_expense')
                            ->join('Tbl_users','Tbl_users.id','Tbl_expenses.tbl_user_id')
                            ->select('Tbl_expenses.*','Tbl_users.user_name')
                            ->where('user_name','like','%'.$search.'%')
                            ->orWhere('amount','like','%'.$search.'%')
                            ->orWhere('description','like','%'.$search.'%')
                            ->get();

            foreach($expense as $k => $each){
                $data[$k][] = date('F d, Y', strtotime($each['date_from']));
                $data[$k][] = number_format($each['amount'],2);
                $data[$k][] = $each['description'];
                $data[$k][] = $each['user_name'];
                $data[$k][] = '';
            }
            $json_data = array(
                "draw" => intval($request->input('draw')),
                "recordsTotal" => count($expenseCount),
                "recordsFiltered" => count($expenseCount),
                "data" => $data
            );
            echo json_encode($json_data);
            exit;
        }
        return view('pages/expense/index');
    }
    
    public function store(Request $request, $api = null) {
        $data = [];

        if($api == 'api'){            
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
        $validator = Validator::make($request->all(),[
            'date_from' => 'filled',
            'amount' => 'integer|filled',
        ]);

        if($validator->fails()){
            $data['message'] = $validator->errors();
            $data['type'] = 'error';

            return $data;
        }

        CF::model('Tbl_expense')::create([
            'tbl_user_id' => $request->user_id,
            'amount' => $request->amount,
            'date_from' => $request->date_from,
            'description' => $request->description,
        ]);
        $data['message'] = 'Creating of category successful!';
        $data['type'] = 'success';



        return $data;
    }
}
