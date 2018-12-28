<?php

namespace App\Modules\Product;

use App\Library\ClassFactory as CF;
use App\Http\Controllers\Controller;
use View;
use Route;
use Auth;
use Illuminate\Http\Request;
use App\Models\Tbl_items;
use Validator;
use Intervention\Image\Facades\Image;

class ProductsController extends Controller
{
    public static $view_path = 'Admin.Product';

    public function index() {
        return view($this->render('index'));
    }

    public function show(Request $request) {
        $data = CF::model('Category')->with('Item','Item.Item_detail')->orderBy('type','asc')->get();
        $returnData = array(
            'data' => $data
        );
        return view($this->render('show'),$returnData);
    }

    public function create() {
        return view('/products/create');
    }
    
    public function addForm() {
        $categoriesData = CF::model('Category')->select('id','name')->orderBy('name','asc')->get();
        $category = [];
        if(count($categoriesData)){
            foreach($categoriesData as $k => $v) {
                $category[$v['id']] = $v['name'];
            }
        }
        $returnData = array(
            'categories' => $category
        );
        return view($this->render('create'),$returnData);
    }

    public function createItem(Request $request) {
        $image      = $request->file('file');
        $fileName   = time() . '.' . $image->getClientOriginalExtension();

        $img = Image::make($image->getRealPath());
        $img->resize(120, 120, function ($constraint) {
            $constraint->aspectRatio();                 
        });

        $img->stream(); // <-- Key point

        //dd();
        Storage::disk('local')->put('images/1/smalls'.'/'.$fileName, $img, 'public');
    }
}
