<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Echipe_22_23_Model;
use App\Models\Jucatori_22_23_Model;
use Illuminate\Support\Facades\Validator;
use Exception;

class echipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAdmin()
    {
        return view('admin/echipe/index', ['echipe' => Echipe_22_23_Model::all()]);
    }

    public function index()
    {
        return view('cluburi', ['echipe' => Echipe_22_23_Model::all()]);
    }

    public static function show($id)
    {
        return view('echipa', ['echipa' => Echipe_22_23_Model::where('id', '=', $id)->first(), 'jucatori' => Jucatori_22_23_Model::select('id', 'numeJucator')->where('echipaID', '=', $id)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/echipe/add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'numeEchipa' => ['required', 'string', 'max:50']
        ], $messages = [
            'required' => 'Camp obligatoriu!',
            'max' => 'Ati depasit limita maxima de caractere!'
            ]
        );

        $echipa = new Echipe_22_23_Model();
        $echipa->numeEchipa = $request->numeEchipa;
        $echipa->save();

        return redirect('admin-echipe-index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $echipa = Echipe_22_23_Model::where('id', '=', $id)->first();
        return view('admin/echipe/edit', compact('echipa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'numeEchipa' => ['required', 'string', 'max:30']
        ], $messages = [
            'required' => 'Camp obligatoriu!',
            'max' => 'Ati depasit limita maxima!'
            ]
        );

        Echipe_22_23_Model::where('id', '=', $request->id)->update([
        'numeEchipa' => $request->numeEchipa
        ]);

        return redirect('admin-echipe-index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            Echipe_22_23_Model::where('id', '=', $id)->delete();
        }catch(Exception $e){
            // return redirect('admin-eroare');
            return back()->withErrors(['Ati incercat sa stergeti o intrare ce face referinta la o alta intrare din baza de date!']);
        }
        return redirect('admin-echipe-index');
    }
}
