<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class BugController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        //
        $user = \Auth::user();
        if ($user->may('fix-bug')) {
        } else {
        }

        return view('bug.index');
    }

    public function getNew()
    {
        $users = User::get();

        return view('bug.new', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'url' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);

        $bug = new \App\Bug;
        $bug->url = $request->url;
        $bug->title = $request->title;
        $bug->description = $request->description;
        $bug->creator_user_id = $request->user()->id;
        $bug->fixer_user_id = $request->fixer_user_id;

        if ($request->hasFile('images')) {
            $path = './Uploads/bugs/' . date('Ymd');
            $suffix = $request->file('images')->getClientOriginalExtension();
            $fileName = time() . rand(100000, 999999) . '.' . $suffix;
            $request->file('images')->move($path, $fileName);

            $bug->images = trim($path . '/' . $fileName, '.');
        }

        if ($bug->save()) {
            return redirect('/bug/index')->with('info', '保存成功');
        } else {
            return back()->with('info', '保存失败');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
