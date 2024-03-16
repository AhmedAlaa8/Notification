<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\User;
use App\Notifications\PostNotifi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.post.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.post.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
       $post = Post::create([
            'title'=>$request->title
        ]);
        $users = User::where('id','!=',auth()->user()->id)->get();

        Notification::send($users,new PostNotifi($post->id,$post->title));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $post = Post::findorFail($id);
       $id_noti =  DB::table('notifications')->select('id', 'notifiable_id')->where('data->id',$id)->where('notifiable_id' ,auth()->user()->id)->pluck('id');
        DB::table('notifications')->where('id','=',"$id_noti[0]")->update(['read_at'=>now()]);
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

    }
    public function xx()
    {

        $user = User::find(auth()->user()->id);
        foreach ($user->unreadNotifications as $notification){
            $notification->delete();

        }
        return redirect()->back();

    }
}
