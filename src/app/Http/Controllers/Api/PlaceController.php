<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\Place;

//Requests
use App\Http\Requests\PlaceRequest;

//Resources
use App\Http\Resources\SinglePlaceResource;
use App\Http\Resources\PlaceResource;

class PlaceController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $column = $request->column;

            $sort = $request->sort;

            $places = Place::orderBy($column, $sort)->paginate(15);

            $pagination = $this->paginated($places);

            return $this->success('Movies retrieved successfully',  PlaceResource::collection($places), $pagination);

        } catch (\Exception $e) {
            return $this->error('Excepción', ["error" => $e->getMessage()], $e->getMessage(), 500);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function all(Request $request)
    {
        try {

            $places = Place::where('active', 1)->get();

            return $this->success('Places retrieved successfully',  SinglePlaceResource::collection($places), []);

        } catch (\Exception $e) {
            return $this->error('Excepción', ["error" => $e->getMessage()], $e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlaceRequest $request)
    {
        try {
            
            $params = $request->all();

            $active = ($params['active'] ? 1 : 0);

            $params['active'] = $active;

            $place = Place::create($params);

            return $this->success('Place created successfully', new PlaceResource($place));

        } catch (\Exception $e) {
            return $this->error('Excepción', ["error" => $e->getMessage()], $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Place $id)
    {
        try {
            return $this->success('Place retrieved successfully',  new PlaceResource($place));
        } catch (\Exception $e) {
            return $this->error('Excepción', ["error" => $e->getMessage()], $e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Place $place)
    {
        try {
            
            $place->movies()->detach();
            
            $place->delete();
            
            return $this->success('Turno eliminado correctamente', $place);

        } catch (\Exception $e) {
            return $this->error('Exception', ["error" => $e->getMessage()], $e->getMessage(), 500);
        }
        
    }

    /**
     * Disable specific movie.
     */
    public function disable(Place $place)
    {
        try {
            
            $place->active = ($place->active ? false : true);
            
            if($place->active){
                $place->movies()->detach();
            }

            $place->movies()->detach();

            $place->save();

            return $this->success('Place disabled successfully', new PlaceResource($place));


        } catch (\Exception $e) {
            return $this->error('Excepción', ["error" => $e->getMessage()], $e->getMessage(), 500);
        }
    }
}
