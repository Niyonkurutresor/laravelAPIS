<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

use function PHPUnit\Framework\returnSelf;

class PostController extends Controller
{
    //
public function getAllPosts(){
    $posts = Post::all();
    return response()->json(['Message'=>'Posts found successfylly','posts'=>$posts]);
}

public function createPost(Request $request){

 $validate =  $request->validate([
    'title'=>'string|required|',
    'description'=>'string|required'
   ]);

   /**
    * but this have to be changed.
    * because the post must be created by the user
    * and each post must contain the user id 
    * From this the function will never know the creater.
    */
$post = Post::created($request);
   return response()->json(
    [
        'Message'=>'Post Created successfully',
        'Post'=>$post
    ]
    );

}

/**
 * Update The post.
 * Each student must be allowed to delete the post that he/she created
 * other ways you must have to get an erro
 * ErrorMessage: ' You can update only your own posts
 * 
 */
public function updatePost(Request $request,$id,$name){
 $request->validate(
        [
            'title'=>'string|required',
            'description'=>'string|required'
        ]
    );

    $post = Post::updated($request);
    if(empty($post)){
        return response()->json(
            [
                'Message'=>'Update Failed Please try again'
            ]
            );
    }

    return response()->json(
        [
            'Message'=>'Post updated successfylly!',
            'Post'=>$post,
        ]
        );
}

public function deletePost(Request $request, $id){
    
    $post = Post::where('id',$id)->get();
    if(empty($post)){
        return response()->json(
            [
                'Message'=>'Failed to find Post',
                'Error'=>''
            ]
            );
    }
    return response()->json(
        [
            'message'=>'Post Deleted successfully!',
            'Response'=>$post
        ]
        );
    
}

}
