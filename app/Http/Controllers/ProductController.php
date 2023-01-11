<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = ['code','name', 'description', 'created_at'];
        $length = $request->length;
        $column = $request->column;
        $dir = $request->dir;
        $searchValue = $request->search;
        $query = Product::select('products.*','food_category.category_name')
        ->join('food_category', 'food_category.id', '=', 'products.food_category_id')
        ->orderBy($columns[$column], $dir);
    
        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('code', 'like', '%'.$searchValue.'%')
                ->orWhere('name', 'like', '%'.$searchValue.'%')
                ->orWhere('description', 'like', '%'.$searchValue.'%');
            });
        }
        $projects = $query->paginate($length);
        return ['data'=>$projects, 'draw'=> $request->draw];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'=>'required|string',
            'name'=>'required|string',
            'description'=>'required|string',
            'food_category_id'=>'required',
            'price'=>'required|numeric',
        ]);

        $product = Product::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'food_category_id' => $request->food_category_id,
            'price' => $request->price,
            'deleted' => 0,
        ]);
        return response()->json($product, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'code'=>'required|string',
            'name'=>'required|string',
            'description'=>'required|string',
            'food_category_id'=>'required',
            'price'=>'required|numeric',
        ]);

        $product = Product::find($id);
        $product->code = $request->code;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->food_category_id = $request->food_category_id;
        $product->price = $request->price;
        $product->save();

        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prod = Product::find($id);
        $prod->delete();
        return response()->json($prod, 200);
    }

    public function productUpload(Request $request){
        $id = $request->id;
        $file = $request->file('image');

        $ran = Str::random(5);

        $date = Carbon::now()->toDateString();
        $file_ =  $date.'-'.$ran.'-'.$file->getClientOriginalName();
       
        $file->storeAs('products',$file_, 'public');
        $item = Product::find($id);

        $file_d = storage_path('/app/public/products/').$item->image;
        if(is_file($file_d))
            @unlink($file_d); 
        $item->image =  $file_;
        $item->save();
    }

    public function productFilter(Request $request, $id){
        $searchValue = $request->search;
        
        if($id == 0){
            $product = Product::where('deleted', 0);
            
        }else{
            $product = Product::where('deleted', 0)->where('food_category_id', $id);
        }

        if($searchValue){
            $product->where(function($query) use ($searchValue){
                $query->where('code', 'like', '%'.$searchValue.'%')
                ->orWhere('name', 'like', '%'.$searchValue.'%')
                ->orWhere('description', 'like', '%'.$searchValue.'%');
            });
        }
       
        return response()->json($product->get(), 200);
    }
}
