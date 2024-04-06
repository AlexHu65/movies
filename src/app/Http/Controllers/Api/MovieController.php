<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\Movie;

//Requests
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Requests\MovieRequest;

//Resources
use App\Http\Resources\MovieResource;

class MovieController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $column = $request->column;

            $sort = $request->sort;

            $movies = Movie::orderBy($column, $sort)->paginate(15);

            $pagination = $this->paginated($movies);

            return $this->success('Movies retrieved successfully',  MovieResource::collection($movies), $pagination);

        } catch (\Exception $e) {
            return $this->error('Excepción', ["error" => $e->getMessage()], $e->getMessage(), 500);
        }
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
    public function show(Movie $movie)
    {
        try {
            return $this->success('Movie retrieved successfully',  new MovieResource($movie));
        } catch (\Exception $e) {
            return $this->error('Excepción', ["error" => $e->getMessage()], $e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        try {

            try {
            
                $params = $request->all();
    
                if ($request->hasFile('poster')) {
    
                    $file = $request->file('poster'); 
                
                    $folder = 'movies/posters/' . date("Y-m-d");
    
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    
                    if(!Storage::delete($movie->poster)){
                        return $this->error('File dont deleted', ['error' => 'File not deleted']);
                    }

                    $path = $file->storeAs($folder, $fileName, 'public');
    
                    if ($path) {
    
                        $params['poster'] = $path;
    
                        $movie->update($params);
    
                        return $this->success('Movie created successfully', new MovieResource($movie));
    
                    }else{
                        return $this->error('File dont updloaded', ['error' => 'File not uploaded']);
                    }

                } else {

                    $params['poster'] = $movie->poster;

                    $movie->update($params);
                }
    
                return $this->success('Movie updated successfully', new MovieResource($movie));

    
            } catch (\Exception $e) {
                return $this->error('Excepción', ["error" => $e->getMessage()], $e->getMessage(), 500);
            }
            
        } catch (\Exception $e) {
            return $this->error('Exception', ["error" => $e->getMessage()], $e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function assignPlaces(Request $request, Movie $movie)
    {
        try {
            
            $params = $request->all();
            
            $movie->places()->sync($params['places']);

            return $this->success('Movie updated successfully', new MovieResource($movie));


        } catch (\Exception $e) {
            return $this->error('Exception', ["error" => $e->getMessage()], $e->getMessage(), 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        try {
            
            $movie->places()->detach();
            
            $movie->delete();
            
            return $this->success('Pelicula eliminada correctamente', $movie);

        } catch (\Exception $e) {
            return $this->error('Exception', ["error" => $e->getMessage()], $e->getMessage(), 500);
        }
    }

    /**
     * Disable specific movie.
     */
    public function disable(Movie $movie)
    {
        try {
            
            $movie->active = ($movie->active ? false : true);

            $movie->save();

            return $this->success('Movie disabled successfully', new MovieResource($movie));


        } catch (\Exception $e) {
            return $this->error('Excepción', ["error" => $e->getMessage()], $e->getMessage(), 500);
        }
    }
}
