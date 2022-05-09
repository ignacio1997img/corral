<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Ready;
use App\Models\Category;
use App\Models\Day;

class ReadyController extends Controller
{
    public function show($id)
    {

        $category = Category::where('status', 1)->where('deleted_at', null)->get();
        $ready = Ready::where('status', '!=', 0)->where('deleted_at', null)
            ->where('day_id', $id)
            ->get();   

        $ready = Ready::with('category')->where('status', '!=', 0)->where('deleted_at', null)->where('day_id', $id)->get();

        $day = day::find($id);

        return view('list.add-ready', compact('id', 'ready', 'category', 'day'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            Ready::create($request->all());
            DB::commit();
            return redirect()->route('ready.show', $request->day_id)->with(['message' => 'Registrado Exitosamente.', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function update(Request $request)
    {
        // return $request->all();
        DB::beginTransaction();
        try {
            $ready = Ready::find($request->ready_id);
            $ready->update($request->all());
            DB::commit();
            return redirect()->route('ready.show', $request->day_id)->with(['message' => 'Actualizado Exitosamente.', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('ready.show', $request->day_id)->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $ready = Ready::find($request->id);
            $ready->update(['status' => 0, 'deleted_at' => Carbon::now()]);
            DB::commit();
            return redirect()->route('ready.show', $request->day_id)->with(['message' => 'Eliminado Exitosamente.', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('ready.show', $request->day_id)->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }



}
