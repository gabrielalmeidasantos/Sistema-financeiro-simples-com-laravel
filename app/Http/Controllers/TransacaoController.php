<?php

namespace App\Http\Controllers;

use App\Models\categoria;
use App\Models\transacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function total($tipo)
    {
        $results = DB::select("SELECT SUM(valor) AS total FROM transacoes WHERE id_user = :id AND tipo_transacao = :tipo", [
            "id" => auth()->user()->id,
            "tipo" => $tipo,
        ]);

        foreach ($results as $valor) {
            foreach ($valor as $v) {
                return $v;
            }
        }
    }

    protected function somarPorCategoriaDeposito(string $categoria)
    {
        $valor = DB::select("SELECT SUM(valor) AS total FROM transacoes WHERE id_user = :id and tipo_transacao = 2 and categoria = :categoria", [
            "id" => auth()->user()->id,
            "categoria" => $categoria
        ]);

        return $valor;
    }

    protected function somarPorCategoriaSaque(string $categoria)
    {
        $valor = DB::select("SELECT SUM(valor) AS total FROM transacoes WHERE id_user = :id and tipo_transacao = 1 and categoria = :categoria", [
            "id" => auth()->user()->id,
            "categoria" => $categoria
        ]);

        return $valor;
    }

    protected function transacoes($tipo)
    {
        $valor = DB::select("SELECT * FROM transacoes WHERE id_user = :id and tipo_transacao = :tipo", [
            "id" => auth()->user()->id,
            "tipo" => $tipo
        ]);

        return $valor;
    }

    public function dashboardIndex()
    {
        $saldo = DB::select('select saldo from users where id = ?', [auth()->user()->id]);

        $totalSaq = $this->total(1);
        $totalDep = $this->total(2);

        $transacoesDeposito = $this->transacoes(2);
        $transacoesSaque = $this->transacoes(1);
        $categoriasUsadasDeposito = [];
        $categoriasUsadasSaque = [];
        $valoresDeposito = [];
        $valoresSaque = [];

        foreach ($transacoesDeposito as $tranDeposito) {
            array_push($categoriasUsadasDeposito, $tranDeposito->categoria);
        }
        $categoriasUsadasDeposito = array_unique($categoriasUsadasDeposito);

        foreach ($categoriasUsadasDeposito as $categoria) {
            $valor = $this->somarPorCategoriaDeposito($categoria);
            array_push($valoresDeposito, [$categoria => $valor]);
        }

        foreach ($transacoesSaque as $tranSaque) {
            array_push($categoriasUsadasSaque, $tranSaque->categoria);
        }
        $categoriasUsadasSaque = array_unique($categoriasUsadasSaque);

        foreach ($categoriasUsadasSaque as $categoria) {
            $valor = $this->somarPorCategoriaSaque($categoria);
            array_push($valoresSaque, [$categoria => $valor]);
        }

        return view('dashboard.index', [
            'totalSaq' => $totalSaq,
            'totalDep' => $totalDep,
            'transacoesDeposito' => $transacoesDeposito,
            'transacoesSaque' => $transacoesSaque,
            'categoriasUsadasDeposito' => $categoriasUsadasDeposito,
            'categoriasUsadasSaque' => $categoriasUsadasSaque,
            'valoresDeposito' => $valoresDeposito,
            'valoresSaque' => $valoresSaque,
            'saldo' => $saldo[0],
        ]);
    }

    public function dashboardDinheiro()
    {
        $saldo = DB::select('select saldo from users where id = ?', [auth()->user()->id]);
        $categorias = Categoria::all()->where('id_user', auth()->user()->id);
        $transacoes = Transacao::all()->where('id_user', auth()->user()->id)->sortByDesc("data");
        return view('dashboard.dinheiro', [
            'categorias' => $categorias,
            "saldo" => $saldo[0],
            "transacoes" => $transacoes
        ]);
    }

    public function dashboardAtividades()
    {
        $transacoes = Transacao::all()->where('id_user', auth()->user()->id)->sortByDesc("data");
        return view('dashboard.atividades', ['transacoes' => $transacoes]);
    }

    public function dashboardtransacaoSaque(Request $request)
    {
        $credentials = $request->validate([
            'valor' => ['required'],
            'categoria' => ['required'],
            'descricao' => ['required'],
        ]);

        $saldo = DB::select('select saldo from users where id = ?', [auth()->user()->id]);

        if ($saldo[0]->saldo >= $credentials['valor']) {
            $transacao = [
                "id_user" => auth()->user()->id,
                'valor' => $credentials['valor'],
                'tipo_transacao' => 1,
                'descricao' => $credentials['descricao'],
                'categoria' => $credentials['categoria']
            ];

            $newSaldo = $saldo[0]->saldo - $transacao['valor'];

            try {
                Transacao::create($transacao);
                DB::update('update users set saldo = :saldo where id = :id', [
                    "saldo" => $newSaldo,
                    "id" => auth()->user()->id
                ]);

                return redirect()->back()->with('saqueRealizado', true);
            } catch (\Throwable $th) {
                dd($th);
            }
        }
        return redirect()->back()->with('saqueRealizado', false);
    }

    public function dashboardtransacaoDeposito(Request $request)
    {
        $credentials = $request->validate([
            'valor' => ['required'],
            'categoria' => ['required'],
            'descricao' => ['required'],
        ]);

        $saldo = DB::select('select saldo from users where id = ?', [auth()->user()->id]);

        $transacao = [
            "id_user" => auth()->user()->id,
            'valor' => $credentials['valor'],
            'tipo_transacao' => 2,
            'descricao' => $credentials['descricao'],
            'categoria' => $credentials['categoria']
        ];

        $newSaldo = $saldo[0]->saldo + $transacao['valor'];

        try {
            Transacao::create($transacao);
            DB::update('update users set saldo = :saldo where id = :id', [
                "saldo" => $newSaldo,
                "id" => auth()->user()->id
            ]);

            return redirect()->back()->with('depositoRealizado', true);
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
