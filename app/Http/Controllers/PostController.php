<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class PostController extends Controller
{

    public function view($id)
    {
        $post = Post::findOrFail($id);

        return view('post.view', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return view('post.edit', compact('post'));
    }

    public function update($id,Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
            'description' => 'required',
            'url' => 'required|unique:posts,url,' . $id,
            'posted_on' => 'required',
            'img_original_url' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        $data = $request->all();
        $image = $request->file('image');
        $post = Post::findOrFail($id);
        if($image){
            $img = time().rand(10000,99999) . '.' .$image->getClientOriginalExtension();
            $image->move('uploads', $img);
            $data['img'] = $img;
            unlink('uploads/' . $post->img);
        }

        $post->update($data);
        
        Session::flash('success','Post updated successfully');
        
        return redirect('post/view/'.$id);
    }

    public function delete($id)
    {
        $post_img = Post::findOrFail($id)->img;
        
        Post::destroy($id);
        unlink('uploads/' . $post_img);
        
        Session::flash('success','Post deleted successfully');

        return redirect('/home');
    }
}
