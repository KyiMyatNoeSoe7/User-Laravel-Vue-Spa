<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
class PostController extends Controller
{   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        Log::info("index");
        Log::info(Carbon::now());
        Log::info(Carbon::now()->format("Y-m-d H:i:s"));

        return Post::get();
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
            'name' => 'required|unique:posts,name',
            'description' => 'required',
        ]); 
        
        $post = new Post;
        $post->name = $request->name;
        $post->description = $request->description;

        $post->save();
        return $post;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) 
    {
        $post = Post::findOrFail($id);
        return $post;

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
        $post = Post::findOrFail($id);
        $post->name = $request->name;
        $post->description = $request->description;
    
        $post->update();
        return $post;
    }
     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) 
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return $post;
    }
     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showPost(Request $request)
    {   
        $posts = Post::query();
        if($request->keyword) {
            return $posts->where('name', 'like', "%" . $request->keyword . "%")
           ->paginate(5);
        } else {
            return $posts->all()->get()->paginate(5);
        }

    }

    public function uploadCSVFile(Request $request){
        if (($handle = fopen($request->file('file'), 'r' )) !== FALSE) {
            $importData_arr = array();
            $i = 1;
            while ( ($data = fgetcsv( $handle, 1000, ',' )) !== FALSE ) {
                      $num = count($data);
                      for ($c=0; $c < $num; $c++) {
                          $importData_arr[$i][] = $data [$c];
                      }
                      $i++;
                  }
         
               foreach ($importData_arr as $key=>$importData) {
                    if ($key == 1) {     
                        continue;
                    }
                    $postExist = Post::where('name', $importData[1])->exists();

                    if(! $postExist) {
                        $insertData = array(
                            "name"=>$importData[1],
                            "description"=>$importData[2]);
                        DB::table('posts')->insert($insertData);
                    }
                  }
            }
            fclose ( $handle );
    }
}
