<?php

namespace App\Http\Controllers;

use App\Mail\NovaTarefaMail;
use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TarefaController extends Controller
{
   public function __construct(){
     $this->middleware('auth');
   }

    public function index()
    {
        if(auth()->check()){
            return 'vc está logado no sistema';
        } else{
            return "Você não está logado";
        }

        
    }

   
    public function create()
    {
        return view('tarefa.create');
    }

    
    public function store(Request $request)
    {
        $tarefa = Tarefa::create($request->all());
        $destinatario = auth()->user()->email;
        Mail::to($destinatario)->send(new NovaTarefaMail($tarefa));
        return redirect()->route('tarefa.show',['tarefa' => $tarefa->id]);
    }

  
    public function show(Tarefa $tarefa)
    {
       return view('tarefa.show',['tarefa' => $tarefa]);
    }

  
    public function edit(Tarefa $tarefa)
    {
        //
    }

  
    public function update(Request $request, Tarefa $tarefa)
    {
        //
    }

 
    public function destroy(Tarefa $tarefa)
    {
        //
    }
}
