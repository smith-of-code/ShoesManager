<?php

namespace App\Http\Controllers;

use App\Models\Shoes;
use Illuminate\Http\Request;

class ShoesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Shoes[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
        return Shoes::all();
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

        $entity = new Shoes();

        $entity->fill($request->all());
        $status =$entity->save();
        if ($status ){
            if ($request->exists('photo')){

                $photoName = \Storage::disk('photo_shoes')->putFile('/',$request->file('photo'));
                $entity->photo_path = $photoName;
                $entity->save();
            }
            if ($request->exists('weathersIds')){
                Shoes::find($entity->id)->weathers()->syncWithoutDetaching($request->weathersIds);
            }
            if ($request->exists('purposesIds')){
                Shoes::find($entity->id)->purposes()->syncWithoutDetaching($request->purposesIds);
            }
        }
        return response($entity,$status?200:400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entity = Shoes::whereId($id)->first();
        if ($entity){
            return response($entity, 200);
        }else{
            return response('', 404);
        }
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
        $entity = Shoes::whereId($id)->first();
        if ($entity){
            $entity->fill($request->all());
            $status =$entity->save();
            if ($status ){
                if ($request->exists('photo')){

                    $photoName = \Storage::disk('photo_shoes')->putFile('/',$request->file('photo'));
                    $entity->photo_path = $photoName;
                    $entity->save();
                }
                if ($request->exists('weathersIds')){
                    Shoes::find($id)->weathers()->syncWithoutDetaching($request->weathersIds);
                }
                if ($request->exists('purposesIds')){
                    Shoes::find($id)->purposes()->syncWithoutDetaching($request->purposesIds);
                }
            }
            return response($entity,$status?200:400);
        }else{
            return response('', 404);
        }
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
}
