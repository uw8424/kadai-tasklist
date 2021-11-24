<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     //getでtasks/にアクセスされた場合の「一覧表示処理」
    public function index()
    {
        $tasks = Task::all();
        
        return view("tasks.index",[
            "tasks" => $tasks,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     //getでtasks/createにアクセスされた場合の「タスク作成画面」
    public function create()
    {
        $task = new Task;
        
        return view("tasks.create", [
            "task" => $task,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     //postでtasks/にアクセスされた場合の「タスク作成処理」
    public function store(Request $request)
    {
        $request->validate([
            "content" => "required",
            "status" => "required|max:10",
            ]);
        
        $task = new Task;
        $task->user_id = \Auth::user()->id;
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        
        return redirect("/");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     
     //getでtasks/に（任意のidにアクセスされた場合の「取得表示処理」）
    public function show($id)
    {
        $task = Task::findOrFail($id);
        
        return view("tasks.show", [
            "task" =>$task,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     //getでtasks/に/（任意のid）/にアクセスされた場合の「編集取得処理」
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        
        return view("tasks.edit",[
            "task" => $task,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     //putまたはpatchでtasks/（任意id）/editにアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {   
        $request->validate([
            "status" => "required|max:10",
            "content" => "required",
            ]);
        
        $task = Task::findOrFail($id);
        
        $task->user_id = \Auth::user()->id;
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        
        return redirect("/");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     //deleteでmessages/（任意のid）にアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
       if(\Auth::id() === $task->user_id) {
        $task->delete();
       }
        return redirect("/");
    }
}
