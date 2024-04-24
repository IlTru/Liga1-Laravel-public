<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jucatori_22_23_Model;
use App\Models\Meciuri_22_23_Model;
use App\Models\Meciuri_Statistici_22_23_Model;
use App\Models\Loturi_22_23_Model;
use App\Models\Goluri_Assisturi_22_23_Model;
use App\Models\Cartonase_22_23_Model;
use App\Models\Schimbari_22_23_Model;
use App\Models\Echipe_22_23_Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Exception;

class statisticiSiEvenimenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexAdminMS($meciID)
    {
        // dd($meciID);
        $jucatoriEG = Jucatori_22_23_Model::select('id', 'numeJucator')->orderBy('id', 'asc')->where('echipaID', '=', Meciuri_22_23_Model::select('echipaGazdaID')->where('id', '=', $meciID)->first()['echipaGazdaID'])->get();
        $jucatoriEGID = [];
        $jucatoriEGNume = [];
        foreach ($jucatoriEG as $jucator){
            array_push($jucatoriEGID, $jucator['id']);
            array_push($jucatoriEGNume, $jucator['numeJucator']);
        }
        $jucatoriEG = array_combine($jucatoriEGID, $jucatoriEGNume);

        $jucatoriEO = Jucatori_22_23_Model::select('id', 'numeJucator')->orderBy('id', 'asc')->where('echipaID', '=', Meciuri_22_23_Model::select('echipaOaspeteID')->where('id', '=', $meciID)->first()['echipaOaspeteID'])->get();
        $jucatoriEOID = [];
        $jucatoriEONume = [];
        foreach ($jucatoriEO as $jucator){
            array_push($jucatoriEOID, $jucator['id']);
            array_push($jucatoriEONume, $jucator['numeJucator']);
        }
        $jucatoriEO = array_combine($jucatoriEOID, $jucatoriEONume);
        
        $jucatori = $jucatoriEG + $jucatoriEO;

        return view('admin\statistici\statisticiMeci\index',
                                                    ['meciID' => $meciID,
                                                    'meciStatistici' => Meciuri_Statistici_22_23_Model::where('meciID', '=', $meciID)->first(),
                                                    'goluriAssisturi' => Goluri_Assisturi_22_23_Model::where('meciID', '=', $meciID)->orderBy('golSauAssist', 'DESC')->orderBy('minut')->get(),
                                                    'cartonase' => Cartonase_22_23_Model::where('meciID', '=', $meciID)->orderBy('minut')->get(),
                                                    'schimbari' => Schimbari_22_23_Model::where('meciID', '=', $meciID)->orderBy('minut')->get(),
                                                    'loturi' => Loturi_22_23_Model::where('meciID', '=', $meciID)->orderBy('echipaID')->orderBy('situatie', 'DESC')->get(),
                                                    'echipaGazda' => Echipe_22_23_Model::select('id', 'numeEchipa')->where('id', '=', Meciuri_22_23_Model::select('echipaGazdaID')->where('id', '=', $meciID)->first()['echipaGazdaID'])->first(),
                                                    'echipaOaspete' => Echipe_22_23_Model::select('id', 'numeEchipa')->where('id', '=', Meciuri_22_23_Model::select('echipaOaspeteID')->where('id', '=', $meciID)->first()['echipaOaspeteID'])->first(),
                                                    'jucatori' => $jucatori
                                                ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createMS($meciID)
    {
        $echipaGazda = Echipe_22_23_Model::select('numeEchipa')->where('id', '=', Meciuri_22_23_Model::select('echipaGazdaID')->where('id', '=', $meciID)->first()['echipaGazdaID'])->first()['numeEchipa'];
        $echipaOaspete = Echipe_22_23_Model::select('numeEchipa')->where('id', '=', Meciuri_22_23_Model::select('echipaOaspeteID')->where('id', '=', $meciID)->first()['echipaOaspeteID'])->first()['numeEchipa'];
        return view('admin/statistici/statisticimeci/add', ['meciID' => $meciID, 'echipaGazda' => $echipaGazda, 'echipaOaspete' => $echipaOaspete]);
    }

    public function createGA($meciID, $echipaID)
    {
        return view('admin/statistici/goluriassisturi/add', ['meciID' => $meciID, 'echipaID' => $echipaID, 'jucatori' => Jucatori_22_23_Model::select('id', 'numeJucator')->where('echipaID', '=', $echipaID)->orderBy('numeJucator')->get()]);
    }

    public function createCrt($meciID, $echipaID)
    {
        return view('admin/statistici/cartonase/add', ['meciID' => $meciID, 'echipaID' => $echipaID, 'jucatori' => Jucatori_22_23_Model::select('id', 'numeJucator')->where('echipaID', '=', $echipaID)->orderBy('numeJucator')->get()]);
    }

    public function createScb($meciID, $echipaID)
    {
        return view('admin/statistici/schimbari/add', ['meciID' => $meciID, 'echipaID' => $echipaID, 'jucatori' => Jucatori_22_23_Model::select('id', 'numeJucator')->where('echipaID', '=', $echipaID)->orderBy('numeJucator')->get()]);
    }

    public function createLot($meciID, $echipaID)
    {
        return view('admin/statistici/loturi/add', ['meciID' => $meciID, 'echipaID' => $echipaID, 'jucatori' => Jucatori_22_23_Model::select('id', 'numeJucator', 'numar')->where('echipaID', '=', $echipaID)->orderBy('numar')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeMS(Request $request)
    {
        $request->validate([
            'suturiEG' => ['required', 'integer', 'gte:0', 'lte:100'],
            'suturiEO' => ['required', 'integer', 'gte:0', 'lte:100'],
            'suturiPePoartaEG' => ['required', 'integer', 'gte:0', 'lte:100'],
            'suturiPePoartaEO' => ['required', 'integer', 'gte:0', 'lte:100'],
            'posesieEG' => ['required', 'integer', 'gte:0', 'lte:100'],
            'posesieEO' => ['required', 'integer', 'gte:0', 'lte:100'],
            'cartonaseGalbeneEG' => ['required', 'integer', 'gte:0', 'lte:16'],
            'cartonaseGalbeneEO' => ['required', 'integer', 'gte:0', 'lte:16'],
            'cartonaseRosiiEG' => ['required', 'integer', 'gte:0', 'lte:5'],
            'cartonaseRosiiEO' => ['required', 'integer', 'gte:0', 'lte:5'],
            'totalPaseEG' => ['required', 'integer', 'gte:0', 'lte:2000'],
            'totalPaseEO' => ['required', 'integer', 'gte:0', 'lte:2000'],
            'faulturiEG' => ['required', 'integer', 'gte:0', 'lte:100'],
            'faulturiEO' => ['required', 'integer', 'gte:0', 'lte:100'],
            'deposedariEG' => ['required', 'integer', 'gte:0', 'lte:200'],
            'deposedariEO' => ['required', 'integer', 'gte:0', 'lte:200'],
            'cornereEG' => ['required', 'integer', 'gte:0', 'lte:100'],
            'cornereEO' => ['required', 'integer', 'gte:0', 'lte:100']
        ], $messages = [
            'required' => 'Camp obligatoriu!',
            'gte' => 'Valoare introdusa este prea mica!',
            'lte' => 'Valoare introdusa este prea mare!',
            'integer' => 'Valoarea introdusa trebuie sa fie un numar intreg!'
            ]
        );

        $statistici = new Meciuri_Statistici_22_23_Model();
        $statistici->meciID = $request->meciID;
        $statistici->suturiEG = $request->suturiEG;
        $statistici->suturiEO = $request->suturiEO;
        $statistici->suturiPePoartaEG = $request->suturiPePoartaEG;
        $statistici->suturiPePoartaEO = $request->suturiPePoartaEO;
        $statistici->posesieEG = $request->posesieEG;
        $statistici->posesieEO = $request->posesieEO;
        $statistici->cartonaseGalbeneEG = $request->cartonaseGalbeneEG;
        $statistici->cartonaseGalbeneEO = $request->cartonaseGalbeneEO;
        $statistici->cartonaseRosiiEG = $request->cartonaseRosiiEG;
        $statistici->cartonaseRosiiEO = $request->cartonaseRosiiEO;
        $statistici->totalPaseEG = $request->totalPaseEG;
        $statistici->totalPaseEO = $request->totalPaseEO;
        $statistici->faulturiEG = $request->faulturiEG;
        $statistici->faulturiEO = $request->faulturiEO;
        $statistici->deposedariEG = $request->deposedariEG;
        $statistici->deposedariEO = $request->deposedariEO;
        $statistici->cornereEG = $request->cornereEG;
        $statistici->cornereEO = $request->cornereEO;
        $statistici->save();

        return redirect('admin-meciuri-index');
    }

    public function storeGA(Request $request)
    {
        if ($request->golSauAssist){
            $request->validate([
                'minut' => ['required', 'integer', 'gte:0', 'lte:90'],
                'tipGol' => 'required'
            ], $messages = [
                'required' => 'Camp obligatoriu!',
                'gte' => 'Valoare introdusa este prea mica!',
                'lte' => 'Valoare introdusa este prea mare!',
                'integer' => 'Valoarea introdusa trebuie sa fie un numar intreg!'
                ]
            );

        $golAssist = new Goluri_Assisturi_22_23_Model();
        $golAssist->golSauAssist = $request->golSauAssist;
        $golAssist->meciID = $request->meciID;
        $golAssist->echipaID = $request->echipaID;
        $golAssist->jucatorID = $request->jucatorID;
        $golAssist->minut = $request->minut;
        $golAssist->tip = $request->tipGol;
        $golAssist->save();

        return redirect('admin-meciuri-index');
    }
        else {
            $request->validate([
                'minut' => ['required', 'integer', 'gte:0', 'lte:90'],
                'tipAssist' => 'required'
            ], $messages = [
                'required' => 'Camp obligatoriu!',
                'gte' => 'Valoare introdusa este prea mica!',
                'lte' => 'Valoare introdusa este prea mare!',
                'integer' => 'Valoarea introdusa trebuie sa fie un numar intreg!'
                ]
            );

            $golAssist = new Goluri_Assisturi_22_23_Model();
            $golAssist->golSauAssist = $request->golSauAssist;
            $golAssist->meciID = $request->meciID;
            $golAssist->echipaID = $request->echipaID;
            $golAssist->jucatorID = $request->jucatorID;
            $golAssist->minut = $request->minut;
            $golAssist->tip = $request->tipAssist;
            $golAssist->save();

            return redirect('admin-meciuri-index');
        }
    }

    public function storeCrt(Request $request)
    {
        $request->validate([
            'minut' => ['required', 'integer', 'gte:0', 'lte:90']
        ], $messages = [
            'required' => 'Camp obligatoriu!',
            'gte' => 'Valoare introdusa este prea mica!',
            'lte' => 'Valoare introdusa este prea mare!',
            'integer' => 'Valoarea introdusa trebuie sa fie un numar intreg!'
            ]
        );

        $cartonas = new Cartonase_22_23_Model();
        $cartonas->culoareCartonas = $request->culoareCartonas;
        $cartonas->meciID = $request->meciID;
        $cartonas->echipaID = $request->echipaID;
        $cartonas->jucatorID = $request->jucatorID;
        $cartonas->minut = $request->minut;
        $cartonas->save();

        return redirect('admin-meciuri-index');
    }

    public function storeScb(Request $request)
    {
        $request->validate([
            'minut' => ['required', 'integer', 'gte:0', 'lte:90'],
            'jucatorSchimbatID' => 'different:jucatorIntratID'
        ], $messages = [
            'required' => 'Camp obligatoriu!',
            'gte' => 'Valoare introdusa este prea mica!',
            'lte' => 'Valoare introdusa este prea mare!',
            'integer' => 'Valoarea introdusa trebuie sa fie un numar intreg!',
            'different' => 'Jucatorul schimbat trebuie sa fie diferit de jucatorul intrat!'
            ]
        );

        $schimbare = new Schimbari_22_23_Model();
        $schimbare->meciID = $request->meciID;
        $schimbare->jucatorSchimbatID = $request->jucatorSchimbatID;
        $schimbare->jucatorIntratID = $request->jucatorIntratID;
        $schimbare->echipaID = $request->echipaID;
        $schimbare->minut = $request->minut;
        $schimbare->save();

        return redirect('admin-meciuri-index');
    }

    public function storeLot(Request $request)
    {
        $jucatori = Jucatori_22_23_Model::select('id')->where('echipaID', '=', $request->echipaID)->get();
        foreach ($jucatori as $jucator) {
            if(isset($request[$jucator->id])){
                $intrare = new Loturi_22_23_Model();
                $intrare->meciID = $request->meciID;
                $intrare->echipaID = $request->echipaID;
                $intrare->jucatorID = $jucator->id;
                $intrare->situatie = $request[$jucator->id];
                $intrare->save();
            }
        }

        return redirect('admin-meciuri-index');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyMS($id)
    {
        Meciuri_Statistici_22_23_Model::where('id', '=', $id)->delete();
        return redirect("admin-meciuri-index");
    }
    public function destroyLot($meciID)
    {
        Loturi_22_23_Model::where('meciID', '=', $meciID)->delete();
        return redirect("admin-meciuri-index");
    }
    public function destroyGA($id)
    {
        Goluri_Assisturi_22_23_Model::where('id', '=', $id)->delete();
        return redirect("admin-meciuri-index");
    }
    public function destroyCrt($id)
    {
        Cartonase_22_23_Model::where('id', '=', $id)->delete();
        return redirect("admin-meciuri-index");
    }
    public function destroyScb($id)
    {
        Schimbari_22_23_Model::where('id', '=', $id)->delete();
        return redirect("admin-meciuri-index");
    }
}
