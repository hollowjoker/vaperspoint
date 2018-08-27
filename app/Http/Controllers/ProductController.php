<?php

namespace App\Http\Controllers;

use App\Library\ClassFactory as CF;
use Illuminate\Http\Request;
use App\Models\Tbl_items;
use Validator;

class ProductController extends Controller
{
    public function index(Request $request, $type = null ) {
        
        if($type == 'api'){
            $data = [];
            $search = $request->search['value'];
            $start = $request->start;
            $length = $request->length;
            $columns = array(
                        'category_name',
                        'item_name',
                        'description',
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
                $data[$k][] = $each['category_name'];
                $data[$k][] = $each['item_name'];
                $data[$k][] = $each['description'];
                $data[$k][] = $each['size'];
                $data[$k][] = $each['qty'];
                $data[$k][] = number_format($each['price'],2);
                $data[$k][] = number_format($each['srp_price'],2);
                $data[$k][] = '
                                <button class="btn-sm btn-info" data-toggle="modal" data-target="#importModal" onclick="getProduct('.$each['id'].')">Import</button>
                                <a href="/product/edit/'.$each['id'].'">
                                    <button class="btn-sm btn-mild">
                                        Edit
                                    </button>
                                </a>            
                            ';
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

        return view('pages/product/index');
    }

    public function create($type = null) {
        $category = CF::model('Tbl_category')->select('id','category_name')->get();

        if($type == 'add'){
            $options = '';
            foreach($category as $each){
                $options .= '<option value="'.$each['id'].'">'.$each['category_name'].'</option>';
            }

            $forAppend = '
                <tr>
                    <td> <button type="button" class="btn btn-danger btn-sm delLine"><i class="fa fa-minus" aria-hidden="true"></i></button> </td>
                    <td>
                        <div class="form-group">
                            <select class="form-control form-control-sm" name="tbl_category_id[]" required>
                                <option selected disabled value="">&dash;</option>
                                '.$options.'
                            </select>
                        </div>
                    </td>
                    <td> <input class="form-control form-control-sm" type="text" name="item_name[]" placeholder="Item Name" required> </td>
                    <td> <textarea class="form-control form-control-sm" type="text" name="description[]" placeholder="Description"></textarea> </td>
                    <td> <input class="form-control form-control-sm" type="text" name="size[]" placeholder="Size"> </td>
                    <td> <input class="form-control form-control-sm compute" type="text" name="qty[]" placeholder="Qty" required> </td>
                    <td> <input class="form-control form-control-sm compute" type="text" name="price[]" placeholder="Price" required> </td>
                    <td> <input class="form-control form-control-sm" type="text" name="srp_price[]" placeholder="Srp" required> </td>
                    <td> <input class="form-control form-control-sm compute" type="text" name="amount[]" readonly placeholder="Amount"> </td>
                    <td> <button type="button" class="btn btn-info btn-sm addLine"><i class="fa fa-plus" aria-hidden="true"></i></button> </td>
                </tr>
            ';
            echo $forAppend;
            exit;
        }

        return view('pages/product/create', compact('category'));
    }

    public function store(Request $request){

        $data = [];
        $validations = [];

        $lastId = CF::model('Tbl_item_imported_transaction')->limit(1)->orderBy('id','desc')->get();
        $lastIdNew = empty($lastId) ? $lastId[0]['trans_code'] : 0;
        $transcode = 'PC'.str_pad(str_replace("PC","",$lastIdNew) + 1, 6, '0', STR_PAD_LEFT);

        foreach($request->item_name as $k => $each){
            $validations['tbl_category_id.'.$k] = 'required|filled';
            $validations['item_name.'.$k] = 'required|filled';
            $validations['qty.'.$k] = 'required|filled';
            $validations['price.'.$k] = 'required|filled';
            $validations['srp_price.'.$k] = 'required|filled';
            $validations['amount.'.$k] = 'required|filled';
        }
        $validator = Validator::make($request->all(),$validations);

        if($validator->fails()){
            $data['type'] = 'failed';
            $data['message'] = $validator->errors();

            return $data;
        }

        
        
        foreach($request->tbl_category_id as $k => $each){
            $tbl_item_id = CF::model('Tbl_items')->create([
                'tbl_category_id' => $each,
                'item_name' => $request->item_name[$k],
                'description' => $request->description[$k],
                'qty' => $request->qty[$k],
                'size' => $request->size[$k],
                'srp_price' => $request->srp_price[$k],
                'price' => $request->price[$k],
                'total_item_buy' => $request->qty[$k],
            ]);
            
            CF::model('Tbl_item_imported_transaction')->create([
                'trans_code' => $transcode,
                'tbl_item_id' => $tbl_item_id->id,
                'qty' => $request->qty[$k],
                'srp_price' => $request->srp_price[$k],
                'price' => $request->price[$k],
                'amount' => $request->amount[$k],
            ]);
        }
        $data['type'] = 'success';
        $data['message'] = 'Creation of category successful!';

        return $data;
    }

    public function edit($id) {
        $product = CF::model('Tbl_items')->find($id);
        $category = CF::model('Tbl_category')->select('id','category_name')->get();
        return view('pages/product/edit', compact('product','category'));
    }

    public function getProduct($id) {
        $product = CF::model('Tbl_items')->where('id',$id)->get();
        return $product;
    }

    public function update(Request $request) {
        
        $data = [];
        $itemData = CF::model('Tbl_items')->find($request->id);
        
        $validator = Validator::make($request->all(),[
            'id' => 'integer|filled|required',
            'qty' => 'integer|filled|required',
            'price' => 'numeric|filled|required',
            'srp_price' => 'numeric|filled|required',
            'amount' => 'numeric|filled|required',
        ]);

        if($validator->fails()){
            $data['type'] = 'error';
            $data['message'] = $validator->errors();
        }
        else{
            $itemData['total_item_buy'] += $request->qty;
            $itemData['qty'] += $request->qty;

            $itemData->update([
                'qty' => $itemData['qty']
            ]);

            $lastTrans = CF::model('Tbl_item_imported_transaction')->max('trans_code');
            $transcode = 'PC'.str_pad(str_replace("PC","",$lastTrans) + 1, 6, '0', STR_PAD_LEFT);

            CF::model('Tbl_item_imported_transaction')->create([
                'trans_code' => $transcode,
                'tbl_item_id' => $itemData['id'],
                'qty' => $request->qty,
                'srp_price' => $request->srp_price,
                'price' => $request->price,
                'amount' => $request->amount,
            ]);

            
            $data['type'] = 'success';
            $data['message'] = 'Importing of product successful!';;
        }
        return $data;
    }

    public function updateAll(Request $request) {

        $data = [];

        $validator = Validator::make($request->all(),[
            'tbl_category_id' => 'integer|required|filled',
            'item_name' => 'required|filled',
            'qty' => 'integer|required|filled',
            'price' => 'numeric|required|filled',
            'srp_price' => 'numeric|required|filled',
            'amount' => 'numeric|required|filled',
        ]);

        if($validator->fails()){
            $data['type'] = 'error';
            $data['message'] = $validator->errors();
        }
        else{
            $productData = CF::model('Tbl_items')->find($request->id);

            $productData->update([
                'category_id' => $request->category_id,
                'item_name' => $request->item_name,
                'description' => $request->description,
                'size' => $request->size,
                'price' => $request->price,
                'srp_price' => $request->srp_price,
            ]);
            
            $data['type'] = 'success';
            $data['message'] = 'Editing of product Success!';

        }

        return $data;
    }
}
