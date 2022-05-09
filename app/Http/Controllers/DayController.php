<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Day;
use App\Models\Next;
use App\Models\Board;
use App\Models\Ready;
use App\Models\Category;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DayController extends Controller
{
    public function index()
    {
        // $category = Category::where('status', 1)->where('deleted_at', null)->get();

        $day = Day::where('status', '!=', 0)->where('deleted_at', null)->get();
        $count = Day::where('status', 2)->where('deleted_at', null)->count();

        return view('list.browse', compact('day', 'count'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            Day::create($request->all());            
            DB::commit();
            // return redirect()->route('day.index')->with('success', 'Registrado Exitosamente');
            return redirect()->route('day.index')->with(['message' => 'Registrado Exitosamente.', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
           DB::rollBack();
            return redirect()->route('day.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);         
        }
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $day = Day::find($request->id);
            $day->update($request->all());
            DB::commit();
            return redirect()->route('day.index')->with(['message' => 'Actualizado Exitosamente.', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('day.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $day = Day::find($request->id);
            $day->update(['status' => 0, 'deleted_at' => Carbon::now()]);
            DB::commit();
            return redirect()->route('day.index')->with(['message' => 'Eliminado Exitosamente.', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('day.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
        
    }
    public function finalize(Request $request)
    {
        $day = Day::find($request->id);
        $day->update(['status' => 1]);
        return redirect()->route('day.index')->with(['message' => 'Finalizado Exitosamente.', 'alert-type' => 'success']);
    }

    public function show($id)
    {
        DB::table('nexts')->delete();

        $ready = Ready::with('category')->where('status',1)->where('deleted_at', null)->where('day_id', $id)->first();
        
        $readys = Ready::with('category')->where('status',1)->where('deleted_at', null)->where('day_id', $id)->get();

        $next = Next::create(['ready_id' => $ready->id, 'total' => count($readys)-1, 'lote' => $ready->lote, 'quantity' => $ready->quantity, 'price' => $ready->price, 'category' => $ready->category->name]);


        // if($ready)
        // {
        //     Board::create(['ready_id' => $ready->id, 'price' => $ready->price, 'quantity' => $ready->quantity, 'lote' => $ready->lote, 'category' => $ready->category->name]);
        // }

        return view('board.board-user', compact('id', 'ready', 'readys', 'next'));
    }


    public function boardUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            $ready = Ready::find($request->id);
            $ready->update($request->all());
            $next = Next::where('ready_id', $ready->id)->first();
            $next->update(['price' => $request->price]);

            $readys = Ready::with('category')->where('status',1)->where('deleted_at', null)->where('day_id', $request->day_id)->get();

            $id = $request->day_id;            
            DB::commit();
            return view('board.board-user', compact('id','readys', 'next'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('day.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }

    public function boardNext(Request $request)
    {
        DB::beginTransaction();
        try {
            $next = Next::where('ready_id', $request->id)->first();            

            $readys = Ready::with('category')->where('status',1)->where('deleted_at', null)->where('day_id', $request->day_id)->get();
           
            if($next->position < $next->total)
            {
                $next->update(['position' => $next->position + 1, 'price' => $readys[$next->position+1]->price, 'lote' => $readys[$next->position+1]->lote,
                'quantity' => $readys[$next->position+1]->quantity, 'category' => $readys[$next->position+1]->category->name,
                'ready_id' => $readys[$next->position+1]->id]);
      
            }
            else
            {
                $next->update(['position' => 0, 'price' => $readys[0]->price, 'lote' => $readys[0]->lote,
                'quantity' => $readys[0]->quantity, 'category' => $readys[0]->category->name,
                'ready_id' => $readys[0]->id]);
                
                
            }
            $id = $request->day_id;   



            DB::commit();
            return view('board.board-user', compact('id','readys', 'next'));
        } catch (\Throwable $th) {
            DB::rollBack();
            // return 1;
            return redirect()->route('day.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
        
    }


    public function boardManual($id, $i, $day)
    {
        DB::beginTransaction();
        try {

            DB::table('nexts')->delete();
            $ready = Ready::with('category')->where('status',1)->where('deleted_at', null)->where('id', $id)->first();
        
            $readys = Ready::with('category')->where('status',1)->where('deleted_at', null)->where('day_id', $day)->get();

            $next = Next::create(['position' => $i, 'ready_id' => $id, 'total' => count($readys)-1, 'lote' => $ready->lote, 'quantity' => $ready->quantity, 'price' => $ready->price, 'category' => $ready->category->name]);
        

            $id = $day;   



            DB::commit();
            return view('board.board-user', compact('id','readys', 'next'));
        } catch (\Throwable $th) {
            DB::rollBack();
            // return 1;
            return redirect()->route('day.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }


    public function prinf($id)
    {
        $day = Day::find($id);
        $readys = Ready::with('category')->where('status',1)->where('deleted_at', null)->where('day_id', $id)->get();
        // return $ready;
        return view('list.prinf', compact('id', 'day', 'readys'));
    }




    public function tv($id)
    {
        return view('board.board');
    }

    public function getBoard()
    {
        return Next::all();
    }

}
