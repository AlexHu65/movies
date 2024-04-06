<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;

//Requests
use App\Http\Requests\MovieRequest;

//Resources
use App\Http\Resources\MovieResource;

class MovieController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $movies = Movie::paginate(15);

            $pagination = $this->paginated($movies);

            return $this->success('Movies retrieved successfully',  MovieResource::collection($movies), $pagination);

        } catch (\Exception $e) {
            return $this->error('Excepción', ["error" => $e->getMessage()], $e->getMessage(), 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MovieRequest $request)
    {
        try {
            
            $params = $request->all();

            if ($request->hasFile('poster')) {

                $file = $request->file('poster'); 
            
                $folder = 'movies/posters/' . date("Y-m-d");

                $fileName = time() . '_' . $file->getClientOriginalName();
            
                $path = $file->storeAs($folder, $fileName, 'public');

                if ($path) {

                    $params['poster'] = $path;

                    $movie = Movie::create($params);

                    return $this->success('Movie created successfully', new MovieResource($movie));

                } else {
                    return $this->error('File dont uploaded', ['error' => 'File not uploaded']);
                }
            }


        } catch (\Exception $e) {
            return $this->error('Excepción', ["error" => $e->getMessage()], $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
