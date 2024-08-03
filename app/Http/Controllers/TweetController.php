<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;

class TweetController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    // 一覧画面を表示する処理
    $tweets = Tweet::with(['user', 'liked'])->latest()->get();
    // dd($tweets);
    return view('tweets.index', compact('tweets'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    // 入力画面を表示する処理
    return view('tweets.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    // テーブルに保存する処理
    // dd($request->all());
    $request->validate([
      'tweet' => 'required|max:255',
    ]);

    $request->user()->tweets()->create($request->only('tweet'));

    return redirect()->route('tweets.index');
  }

  /**
   * Display the specified resource.
   */
  public function show(Tweet $tweet)
  {
    // 詳細画面を表示する処理
    return view('tweets.show', compact('tweet'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Tweet $tweet)
  {
    // 編集画面を表示する
    return view('tweets.edit', compact('tweet'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Tweet $tweet)
  {
    $request->validate([
      'tweet' => 'required|max:255',
    ]);

    $tweet->update($request->only('tweet'));

    return redirect()->route('tweets.show', $tweet);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Tweet $tweet)
  {
    $tweet->delete();

    return redirect()->route('tweets.index');
  }
}
