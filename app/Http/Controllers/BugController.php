<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

use App\User;
use App\Bug;
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
        /*$user = \Auth::user();
        if ($user->may('fix-bug')) {
        } else {
        }*/

        $bugs = Bug::orderBy('id', 'desc')->get();
        foreach($bugs as $bug){
        }

        return view('bug.index', ['bugs' => $bugs]);
    }

    public function getNew()
    {
        $role = Role::where('name', 'RD')->first();
        $users = $role->users()->get();

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
            return redirect('/bug/index')->with('info', '创建成功');
        } else {
            return back()->with('info', '创建失败');
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
    public function getShow($id)
    {
        $users = User::get();
        $bug = Bug::find($id);

        return view('bug.show', ['users' => $users, 'bug' => $bug]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getEdit($id)
    {
        $role = Role::where('name', 'RD')->first();
        $users = $role->users()->get();
        $bug = Bug::find($id);

        return view('bug.edit', ['users' => $users, 'bug' => $bug]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function postUpdate(Request $request)
    {
        $id = $request->id;
        $bug = Bug::find($id);

        $bug->url = $request->url;
        $bug->title = $request->title;
//        $bug->description = $request->description;
        $bug->status = $request->status;
        $bug->fixer_user_id = $request->fixer_user_id;

        $desctiption = trim($request->description);
        $desc = trim(rtrim($desctiption, "--------------------------------我是分割线，不用管我，新内容继续往下添加即可-----------------------------------"));
        if ($desc != $bug->description) {
            $bug->description = $desctiption;
        }

        if ($request->hasFile('images')) {
            $path = './Uploads/bugs/' . date('Ymd');
            $suffix = $request->file('images')->getClientOriginalExtension();
            $fileName = time() . rand(100000, 999999) . '.' . $suffix;
            $request->file('images')->move($path, $fileName);

            $bug->images = trim($path . '/' . $fileName, '.');
        }

        if ($bug->save()) {
            return redirect('/bug/index')->with('info', '修改成功');
        } else {
            return back()->with('info', '修改失败');
        }
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
