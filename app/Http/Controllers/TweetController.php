<?php

//namespaceは名前空間(クラス、関数、定数の衝突を避けるために)に属するクラスを定義
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Tweet;
use Auth;
use App\Models\User;

//ルーティング表のindex/store/create/show/update/destroy/editの処理を以下に書く
class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // indexの処理を書く
    public function index()
    {
        // tweet.indexというviewファイル(ブレードphp)をレンダリングして結果を返す
        // $tweets = [];
        //ダラーtweetsでツイートをオーダーバイした変数としてreturnとして返す
        //Tweet::はlaravelのモデルクラスでTweetのスタティックメソッドを呼び出している
        //tweetsという名前でデータベースのテーブル名に存在している
        //よって以下はデータベースからデータを取得する処理を行っている
        $tweets = Tweet::getAllOrderByUpdated_at();
        //compactでtweetsという連想配列を作る
        //tweet.indexというviewファイル(indexブレードファイル)にtweetsの結果を返す
        return response()->view('tweet.index',compact('tweets'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        // tweet.createというviewファイル(createブレードファイル)をレンダリングして結果を返す
        return response()->view('tweet.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    //ダラーrequest内にcreateブレードphpから送られてきたデータが入っている
    public function store(Request $request)
    {
        // バリデーション
        //allとする事で全て取得できる
        $validator = Validator::make($request->all(), [
        'tweet' => 'required | max:191',
        'description' => 'required',
        ]);
        // バリデーション:エラー
        if ($validator->fails()) {
            return redirect()
            ->route('tweet.create')
            ->withInput()
            ->withErrors($validator);
        }
        //Auth以下で現在ログインしているユーザーのIDを取得
        //マージで既存のデータに加えてuseridが追加される(前項でuseridカラムを追加したので)
        //データベースを最初に作った段階でuseridカラムを設定していないと入っていなかった箇所はヌルになってしまうs
        $data = $request->merge(['user_id' => Auth::user()->id])->all();
        // create()は最初から用意されている関数
        // 戻り値は挿入されたレコードの情報
        $result = Tweet::create($request->all());
        // ルーティング「tweet.index(indexブレードファイル)」にリダイレクト送信（一覧ページに移動）
        return redirect()->route('tweet.index');    
    }


    /**
     * Display the specified resource.
     */
    // 対応したidの結果を表示する
    public function show($id)
    {
        // データベースのtweetsテーブルから対応したidのデータを見つけてきて
        //tweetという名前でtweet.show(showブレードファイル)に渡している
        $tweet = Tweet::find($id);
        return response()->view('tweet.show', compact('tweet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    //tweet.edit(editブレードファイル)
    public function edit($id)
    {
    // laravel内のTweetモデルというデータ操作を抽象化したモデル
    $tweet = Tweet::find($id);
    return response()->view('tweet.edit', compact('tweet'));
    }


    /**
     * Update the specified resource in storage.
     */
    //tweet.update(updateブレードファイル)
    // RequestはIlluminate\Http\Requestのインスタンスを受け取るための引数。ファイルの上に定義してある
    public function update(Request $request, $id)
    {
    //バリデーション(検証)
    // バリデーションmakeで検証ルールとリクエストデータを引数として受け取る
    // バリデーションするためにallで全てのデータをとってくる
    $validator = Validator::make($request->all(), [
        // tweetは必須であり191文字以下
        'tweet' => 'required | max:191',
        //descriptionも必須
        'description' => 'required',
    ]);
    //バリデーション:エラー
    if ($validator->fails()) {
        return redirect()
        ->route('tweet.edit', $id)
        ->withInput()
        ->withErrors($validator);
    }
    //データ更新処理
    $result = Tweet::find($id)->update($request->all());
    return redirect()->route('tweet.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    //tweet.destroy(destroyブレードファイル)
    //文字宣言した際にstringは書いていないのでダラーidのみ記載
    public function destroy($id)
    {
    // laravel内のTweetモデルというデータ操作を抽象化したモデル
    $result = Tweet::find($id)->delete();
    // tweet.indexというルートのリダイレクトを行う
    return redirect()->route('tweet.index');
    }

    
    public function mydata()
    {
        // Userモデルに定義したリレーションを使用してデータを取得する．
        $tweets = User::query()
        ->find(Auth::user()->id)
        ->userTweets()
        ->orderBy('created_at','desc')
        ->get();
        return response()->view('tweet.index', compact('tweets'));
    }

}
