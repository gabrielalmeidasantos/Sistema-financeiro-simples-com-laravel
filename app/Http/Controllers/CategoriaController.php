<?php

namespace App\Http\Controllers;

use App\Models\categoria;
use App\Models\transacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboardCategorias()
    {
        $categoria = Categoria::all()->where('id_user', auth()->user()->id);
        return view('dashboard.categorias', ['categorias' => $categoria]);
    }

    public function dashboardCategoriasAdicionar(Request $request)
    {
        $credentials = $request->validate([
            'categoria' => ['required'],
        ]);

        $categoria = [
            'id_user' => auth()->user()->id,
            'categoria' => $credentials['categoria'],
        ];

        $cat = Categoria::firstOrNew([
            'id_user' => $categoria['id_user'],
            'categoria' => $credentials['categoria']
        ], [
            'id_user' => $categoria['id_user'],
            'categoria' => $credentials['categoria']
        ]);

        if ($cat->exists === false) {
            $cat->save();
            return redirect()->back()->with('categoriaExiste', false);
        } else {
            return redirect()->back()->with('categoriaExiste', true);
        }
    }

    public function dashboardCategoriasApagar(Request $request)
    {
        $credentials = $request->validate([
            'id' => ['required'],
            'categoria' => ['required'],
        ]);

        Categoria::where([
            'id' => $credentials['id'],
            'id_user' => auth()->user()->id
        ])->delete();

        Transacao::where('categoria', $credentials['categoria'])
            ->where('id_user', auth()->user()->id)
            ->update(['categoria' => 'Sem categoria']);

        return redirect()->back()->with('categoriaApagada', "Categoria removida com sucesso");
    }
}
