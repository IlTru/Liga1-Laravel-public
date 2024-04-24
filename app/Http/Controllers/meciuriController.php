<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Echipe_22_23_Model;
use App\Models\Meciuri_22_23_Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Exception;
use Carbon\Carbon;

class meciuriController extends Controller
{
    public function indexAdmin(Request $request)
    {
        $echipe = Echipe_22_23_Model::select('id', 'numeEchipa')->orderBy('id', 'asc')->get();
        
        $echipeID = [];
        $echipeNume = [];

        foreach ($echipe as $echipa){
            array_push($echipeID, $echipa['id']);
            array_push($echipeNume, $echipa['numeEchipa']);
        }
        
        $echipe = array_combine($echipeID, $echipeNume);
    
        if(isset($request->faza)){
            $meciuri = Meciuri_22_23_Model::where('faza', '=', $request->faza)->where('nrEtapa', '=', $request->nrEtapa)->get();
            foreach ($meciuri as $meci){
                $meci->data = Carbon::createFromFormat('Y-m-d H:i:s', $meci->data);
                $meci->data = $meci->data->format('y-m-d H:i');
            }
                                                
            return view('admin/meciuri/index', ['meciuri' => $meciuri,'echipe' => $echipe]);
        }
        else{
            $meciuri = Meciuri_22_23_Model::where('faza', '=', 'sezon regulat')->where('nrEtapa', '=', '1')->get();
            foreach ($meciuri as $meci){
                $meci->data = Carbon::createFromFormat('Y-m-d H:i:s', $meci->data);
                $meci->data = $meci->data->format('y-m-d H:i');
            }
                
            return view('admin/meciuri/index', ['meciuri' => $meciuri,'echipe' => $echipe]);
        }
        
    }

    public function create()
    {
        $echipeNume = Echipe_22_23_Model::select('id', 'numeEchipa')->orderBy('id', 'asc')->get();
        return view('admin/meciuri/add', ['echipe' => $echipeNume]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'data' => 'required',
            'echipaGazdaID' => 'different:echipaOaspeteID'
        ], $messages = [
            'required' => 'Data este nesetata!',
            'different' => 'Echipa gazda trebuie sa fie diferita de echipa oaspete'
            ]
        );

        $meci = new Meciuri_22_23_Model();
        $meci->faza = $request->faza;
        $meci->nrEtapa = $request->nrEtapa;
        if ($request->disputat == 'da') $meci->disputat = 1;
        else $meci->disputat = 0;
        $meci->data = $request->data;
        $meci->echipaGazdaID = $request->echipaGazdaID;
        $meci->echipaOaspeteID = $request->echipaOaspeteID;
        $meci->goluriEG = $request->goluriEG;
        $meci->goluriEO = $request->goluriEO;
        $meci->save();

        return redirect('admin-meciuri-index');
    }

    public function edit($id)
    {
        return view('admin/meciuri/edit', ['meci' => Meciuri_22_23_Model::where('id', '=', $id)->first(), 'echipe' => Echipe_22_23_Model::select('id', 'numeEchipa')->get()]);
    }

    public function update(Request $request)
    {

        if ($request->disputat == 'da') $request->disputat = 1;
        else $request->disputat = 0;

        Meciuri_22_23_Model::where('id', '=', $request->id)->update([
            'faza' => $request->faza,
            'nrEtapa' => $request->nrEtapa,
            'disputat' => $request->disputat,
            'data' => $request->data,
            'echipaGazdaID' => $request->echipaGazdaID,
            'echipaOaspeteID' => $request->echipaOaspeteID,
            'goluriEG' => $request->goluriEG,
            'goluriEO' => $request->goluriEO
        ]);

        return redirect('admin-meciuri-index');
    }

    public function destroy($id)
    {
        try{
            Meciuri_22_23_Model::where('id', '=', $id)->delete();
        }catch(Exception $e){
            return redirect('admin-eroare');
        }

        return redirect('admin-meciuri-index');
        
    }
}
