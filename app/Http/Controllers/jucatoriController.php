<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Echipe_22_23_Model;
use App\Models\Jucatori_22_23_Model;
use App\Models\Tari_Model;
use App\Models\Goluri_Assisturi_22_23_Model;
use App\Models\Cartonase_22_23_Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Exception;

class jucatoriController extends Controller
{

    public $pozitii = [
        'ATACANT',
        'MIJLOCAS',
        'FUNDAS',
        'PORTAR'
    ];
    
    public function indexAdmin(Request $request, $page){
        $echipe = Echipe_22_23_Model::select('id', 'numeEchipa')->orderBy('id', 'asc')->get();
        $echipeID = [];
        $echipeNume = [];

        foreach ($echipe as $echipa){
            array_push($echipeID, $echipa['id']);
            array_push($echipeNume, $echipa['numeEchipa']);
        }
        $echipeDct = array_combine($echipeID, $echipeNume);

        if ($request->isMethod('post')){
            $filtre['atributulDeSortare'] = $request['atributulDeSortare'];
            $filtre['ordine'] = $request['ordine'];
            $filtre['varstaMin'] = $request['varstaMin'];
            $filtre['varstaMax'] = $request['varstaMax'];
            $filtre['inaltimeMin'] = $request['inaltimeMin'];
            $filtre['inaltimeMax'] = $request['inaltimeMax'];
            $filtre['greutateMin'] = $request['greutateMin'];
            $filtre['greutateMax'] = $request['greutateMax'];

            if($request['cautare']) $filtre['cautare'] = $request['cautare'];
                else $filtre['cautare'] = '';

            $filtre['cluburiSelectate'] = [];
            if(isset($request['cluburiSelectate'])){
                $filtre['cluburiSelectate'] = array_keys($request['cluburiSelectate']);
                $filtre['toateCluburile'] = false;
            }
            else{
                $filtre['toateCluburile'] = true;
                foreach(Echipe_22_23_Model::select('id')->get() as $club)
                    array_push($filtre['cluburiSelectate'], $club->id);
            }
            
            $filtre['pozitiiSelectate'] = [];
            if(isset($request['pozitiiSelectate'])){
                $filtre['pozitiiSelectate'] = array_keys($request['pozitiiSelectate']);
                $filtre['toatePozitiile'] = false;
            }
            else{
                $filtre['toatePozitiile'] = true;
                foreach($this->pozitii as $pozitie)
                    array_push($filtre['pozitiiSelectate'], $pozitie);
            }

            $filtre['tariSelectate'] = [];
            if(isset($request['tariSelectate'])){
                $filtre['tariSelectate'] = array_keys($request['tariSelectate']);
                $filtre['toateTarile'] = false;
            }
            else{
                $filtre['toateTarile'] = true;
                foreach(Tari_Model::select('prescurtare')->get() as $tara)
                    array_push($filtre['tariSelectate'], $tara->prescurtare);
            }

            $jucatori = Jucatori_22_23_Model::
                        where('numeJucator', 'LIKE', '%'.$filtre['cautare'].'%')
                        ->whereIn('echipaID', $filtre['cluburiSelectate'])
                        ->where('echipaActuala', '=', '1')
                        ->whereBetween('varsta', [$filtre['varstaMin'], $filtre['varstaMax']])
                        ->whereBetween('inaltime', [$filtre['inaltimeMin'], $filtre['inaltimeMax']])
                        ->whereBetween('greutate', [$filtre['greutateMin'], $filtre['greutateMax']])
                        ->whereIn('pozitie', $filtre['pozitiiSelectate'])
                        ->whereIn('nationalitate', $filtre['tariSelectate'])
                        ->get();
            
            foreach($jucatori as $jucator){
                $jucator['numeEchipa'] = $echipeDct[$jucator->echipaID];
                $jucator['goluri'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->where('jucatorID', '=', $jucator->id)->get());
                $jucator['assisturi'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '0')->where('jucatorID', '=', $jucator->id)->get());
                $jucator['cartonaseGalbene'] = count(Cartonase_22_23_Model::select('id')->where('culoareCartonas', '=', '0')->where('jucatorID', '=', $jucator->id)->get());
                $jucator['cartonaseRosii'] = count(Cartonase_22_23_Model::select('id')->where('culoareCartonas', '=', '1')->where('jucatorID', '=', $jucator->id)->get());
            }

            if($filtre['ordine'] == 'asc') $jucatori = $jucatori->sortBy($filtre['atributulDeSortare']);
                else $jucatori = collect($jucatori)->sortByDesc($filtre['atributulDeSortare']);

            $jucatori = array_slice($jucatori->toArray(), ($page - 1) * 20, 20);
            
            return view('admin/jucatori/index',
                            ['jucatori' => $jucatori,
                            'echipeDct' => $echipeDct,
                            'tari' => Tari_Model::select('denumire', 'prescurtare')->orderBy('denumire')->get(),
                            'filtre' => $filtre,
                            'page' => $page
                        ]);
        }

            $filtre['cautare'] = '';
            $filtre['varstaMin'] = 1;
            $filtre['varstaMax'] = 100;
            $filtre['inaltimeMin'] = 1;
            $filtre['inaltimeMax'] = 210;
            $filtre['greutateMin'] = 1;
            $filtre['greutateMax'] = 110;
            $filtre['atributulDeSortare'] = 'numeJucator';
            $filtre['ordine'] = 'asc';
            $filtre['cluburiSelectate'] = [];
            $filtre['pozitiiSelectate'] = [];
            $filtre['tariSelectate'] = [];
            $filtre['toateCluburile'] = true;
            $filtre['toatePozitiile'] = true;
            $filtre['toateTarile'] = true;

            $jucatori = Jucatori_22_23_Model::orderBy('numeJucator', 'asc')->skip(($page-1)*20)->take(20)->get();

            foreach($jucatori as $jucator){
                $jucator['goluri'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->where('jucatorID', '=', $jucator->id)->get());
                $jucator['assisturi'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '0')->where('jucatorID', '=', $jucator->id)->get());
                $jucator['cartonaseGalbene'] = count(Cartonase_22_23_Model::select('id')->where('culoareCartonas', '=', '0')->where('jucatorID', '=', $jucator->id)->get());
                $jucator['cartonaseRosii'] = count(Cartonase_22_23_Model::select('id')->where('culoareCartonas', '=', '1')->where('jucatorID', '=', $jucator->id)->get());
            }
            return view('admin/jucatori/index', [
                'jucatori' => $jucatori,
                'echipeDct' => $echipeDct,
                'tari' => Tari_Model::orderBy('denumire')->get(),
                'filtre' => $filtre,
                'page' => $page
            ]);
    }

    public function create()
    {
        $echipeNume = Echipe_22_23_Model::select('id', 'numeEchipa')->orderBy('id', 'asc')->get();

        return view('admin/jucatori/add', ['echipe' => $echipeNume, 'tari' => Tari_Model::select('denumire', 'prescurtare')->orderBy('denumire')->get()]);
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
            'numeJucator' => ['required', 'string', 'max:100'],
            'numar' => ['required', 'integer', 'gte:1', 'lte:99'],
            'varsta' => ['required', 'integer', 'gte:0', 'lte:99'],
            'pozitie' => ['required', Rule::in([
                                                        'ATACANT',
                                                        'MIJLOCAS',
                                                        'FUNDAS',
                                                        'PORTAR'
                                                        ])],
            'inaltime' => ['required', 'integer', 'gte:0', 'lte:220'],
            'greutate' => ['required', 'integer', 'gte:0', 'lte:160'],
        ], $messages = [
            'required' => 'Camp obligatoriu!',
            'max' => 'Ati depasit limita maxima de caractere!',
            'gte' => 'Valoare introdusa este prea mica!',
            'lte' => 'Valoare introdusa este prea mare!',
            'integer' => 'Valoarea introdusa trebuie sa fie un numar intreg!'
            ]
        );

        $jucator = new Jucatori_22_23_Model();
        $jucator->numeJucator = $request->numeJucator;
        $jucator->echipaID = $request->echipaID;
        $jucator->numar = $request->numar;
        $jucator->varsta = $request->varsta;
        $jucator->pozitie = $request->pozitie;
        $jucator->inaltime = $request->inaltime;
        $jucator->greutate = $request->greutate;
        $jucator->nationalitate = $request->nationalitate;
        $jucator->echipaActuala = $request->echipaActuala;
        $jucator->save();

        return redirect('admin-jucatori-index/1');
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
        return view('admin/jucatori/edit', ['jucator' => Jucatori_22_23_Model::where('id', '=', $id)->first(), 'echipe' => Echipe_22_23_Model::select('id', 'numeEchipa')->get(), 'tari' => Tari_Model::select('denumire', 'prescurtare')->orderBy('denumire')->get()]);
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
            'numeJucator' => ['required', 'string', 'max:100'],
            'numar' => ['required', 'integer', 'gte:1', 'lte:99'],
            'varsta' => ['required', 'integer', 'gte:0', 'lte:99'],
            'pozitie' => ['required', Rule::in([
                                                        'ATACANT',
                                                        'MIJLOCAS',
                                                        'FUNDAS',
                                                        'PORTAR'
                                                        ])],
            'inaltime' => ['required', 'integer', 'gte:0', 'lte:220'],
            'greutate' => ['required', 'integer', 'gte:0', 'lte:160']
        ], $messages = [
            'required' => 'Camp obligatoriu!',
            'max' => 'Ati depasit limita maxima de caractere!',
            'gte' => 'Valoare introdusa este prea mica!',
            'lte' => 'Valoare introdusa este prea mare!',
            'integer' => 'Valoarea introdusa trebuie sa fie un numar intreg!'
            ]
        );

        Jucatori_22_23_Model::where('id', '=', $request->id)->update([
            'numeJucator' => $request->numeJucator,
            'echipaID' => $request->echipaID,
            'numar' => $request->numar,
            'varsta' => $request->varsta,
            'pozitie' => $request->pozitie,
            'inaltime' => $request->inaltime,
            'greutate' => $request->greutate,
            'nationalitate' => $request->nationalitate,
            'echipaActuala' => $request->echipaActuala
        ]);

        return redirect('admin-jucatori-index/1');
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
            Jucatori_22_23_Model::where('id', '=', $id)->delete();
        }catch(Exception $e){
            return redirect('admin-eroare');
        }
        return redirect('admin-jucatori-index/1');
    }
}
