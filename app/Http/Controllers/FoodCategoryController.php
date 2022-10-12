<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FoodCategory;

class FoodCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = ['category_name', 'description', 'created_at'];
        $length = $request->length;
        $column = $request->column;
        $dir = $request->dir;
        $searchValue = $request->search;
        $query = FoodCategory::orderBy($columns[$column], $dir);
    
        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('category_name', 'like', '%'.$searchValue.'%')
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
            'category_name'=>'required|string',
            'description'=>'required|string',

        ]);

        $fc = FoodCategory::create([
            'category_name'=>$request->category_name,
            'description'=>$request->description,
        ]);

        return response()->json($fc, 200);
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
            'category_name'=>'required|string',
            'description'=>'required|string',

        ]);

        $fc = FoodCategory::find($id);
        $fc->category_name = $request->category_name;
        $fc->description = $request->description;
        $fc->save();

        return response()->json($fc, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function listCategory(){
        $lst = FoodCategory::all();
        return response()->json($lst, 200);
    }
}
