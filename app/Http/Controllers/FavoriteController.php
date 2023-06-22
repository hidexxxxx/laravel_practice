<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//以下を追加する必要がある
use App\Models\Tweet;
use Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Tweet $tweet)
    {
        //attachで中間テーブルへデータの追加
        $tweet->users()->attach(Auth::id());
        return redirect()->route('tweet.index');
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
     * Display the specified resource.
     */
    public function destroy(Tweet $tweet)
    {
        //中間テーブルのデータを削除するためにデタッチする
        $tweet->users()->detach(Auth::id());
        return redirect()->route('tweet.index');
    }


}
