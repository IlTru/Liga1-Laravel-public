<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Echipe_22_23_Model;
use App\Models\Jucatori_22_23_Model;
use App\Models\Meciuri_22_23_Model;
use App\Models\Clasament_22_23_Model;
use App\Models\Tari_Model;
use App\Models\Goluri_Assisturi_22_23_Model;
use App\Models\Cartonase_22_23_Model;
use App\Models\Loturi_22_23_Model;
use App\Models\Schimbari_22_23_Model;
use App\Models\Meciuri_Statistici_22_23_Model;
use Illuminate\Pagination\LengthAwarePaginator;

class mainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $pozitii = [
        'atacant',
        'mijlocas',
        'fundas',
        'portar'
    ];

    public function home()
    {
        $echipe = Echipe_22_23_Model::select('id', 'numeEchipa')->orderBy('numeEchipa', 'asc')->get();
        $echipeID = [];
        $echipeNume = [];

        foreach ($echipe as $echipa){
            array_push($echipeID, $echipa['id']);
            array_push($echipeNume, $echipa['numeEchipa']);
        }
        
        $echipeDct = array_combine($echipeID, $echipeNume);

        if(Meciuri_22_23_Model::select('disputat')->where('faza', '=', 'play off')->orWhere('faza', '=', 'play out')->orderBy('disputat', 'desc')->first()){
            $etapa = Meciuri_22_23_Model::select('nrEtapa')->where('faza', '=', 'play off')->where('disputat', '=', '1')->orderBy('nrEtapa', 'desc')->first();
            if($etapa) $etapa = $etapa['nrEtapa'];
            else $etapa = 1;
            $meciuri = Meciuri_22_23_Model::where('faza', '=', 'play off')->orWhere('faza', '=', 'play out')->where('nrEtapa', '=', $etapa)->orderBy('data', 'asc')->get();
            $clasament = Clasament_22_23_Model::where('faza', '=', 'play off')->orWhere('faza', '=', 'play out')->orderBy('faza', 'asc')->orderBy('punctaj', 'desc')->get();
        }
        else{
            $etapa = Meciuri_22_23_Model::select('nrEtapa')->where('faza', '=', 'sezon regulat')->where('disputat', '=', '1')->orderBy('nrEtapa', 'desc')->first();
            if($etapa) $etapa = $etapa['nrEtapa'];
            else $etapa = 1;
            $meciuri = Meciuri_22_23_Model::where('faza', '=', 'sezon regulat')->where('nrEtapa', '=', $etapa)->orderBy('data', 'asc')->get();
            $clasament = Clasament_22_23_Model::where('faza', '=', 'sezon regulat')->orderBy('punctaj', 'desc')->get();
        }

        return view('home', [
                            'cluburi' => $echipe,
                            'meciuri' => $meciuri,
                            'cluburiDct' => $echipeDct,
                            'clasament' => $clasament
        ]);
    }

    public function echipaIndex($numeEchipa){
            return view('club/info', [
                'club' => Echipe_22_23_Model::where('numeEchipa', '=', $numeEchipa)->first(),
                'jucatori' => Jucatori_22_23_Model::where('echipaID', '=', Echipe_22_23_Model::select('id')->where('numeEchipa', '=', $numeEchipa)->first()['id'])->where('echipaActuala', '=', '1')->get()
            ]);
    }

    public function jucatoriIndex(Request $request, $page){
        $clubs = Echipe_22_23_Model::select('id', 'numeEchipa')->orderBy('id', 'asc')->get();
        $clubsID = [];
        $clubsName = [];

        foreach ($clubs as $club){
            array_push($clubsID, $club['id']);
            array_push($clubsName, $club['numeEchipa']);
        }
        $clubsDct = array_combine($clubsID, $clubsName);

        if ($request->isMethod('post')){
            $filters['sortByAttribute'] = $request['sortByAttribute'];
            $filters['order'] = $request['order'];
            $filters['ageMin'] = $request['ageMin'];
            $filters['ageMax'] = $request['ageMax'];
            $filters['heightMin'] = $request['heightMin'];
            $filters['heightMax'] = $request['heightMax'];
            $filters['weightMin'] = $request['weightMin'];
            $filters['weightMax'] = $request['weightMax'];

            if($request['search']) $filters['search'] = $request['search'];
                else $filters['search'] = '';

            $filters['clubsChecked'] = [];
            if(isset($request['clubsChecked'])){
                $filters['clubsChecked'] = array_keys($request['clubsChecked']);
                $filters['allClubs'] = false;
            }
            else{
                $filters['allClubs'] = true;
                foreach(Echipe_22_23_Model::select('id')->get() as $club)
                    array_push($filters['clubsChecked'], $club->id);
            }
            
            $filters['positionsChecked'] = [];
            if(isset($request['positionsChecked'])){
                $filters['positionsChecked'] = array_keys($request['positionsChecked']);
                $filters['allPositions'] = false;
            }
            else{
                $filters['allPositions'] = true;
                foreach($this->pozitii as $pozitie)
                    array_push($filters['positionsChecked'], $pozitie);
            }

            $filters['countriesChecked'] = [];
            if(isset($request['countriesChecked'])){
                $filters['countriesChecked'] = array_keys($request['countriesChecked']);
                $filters['allCountries'] = false;
            }
            else{
                $filters['allCountries'] = true;
                foreach(Tari_Model::select('prescurtare')->get() as $country)
                    array_push($filters['countriesChecked'], $country->prescurtare);
            }

            $players = Jucatori_22_23_Model::
                        where('numeJucator', 'LIKE', '%'.$filters['search'].'%')
                        ->whereIn('echipaID', $filters['clubsChecked'])
                        ->where('echipaActuala', '=', '1')
                        ->whereBetween('varsta', [$filters['ageMin'], $filters['ageMax']])
                        ->whereBetween('inaltime', [$filters['heightMin'], $filters['heightMax']])
                        ->whereBetween('greutate', [$filters['weightMin'], $filters['weightMax']])
                        ->whereIn('pozitie', $filters['positionsChecked'])
                        ->whereIn('nationalitate', $filters['countriesChecked'])
                        ->get();
            
            foreach($players as $player){
                $player['numeEchipa'] = $clubsDct[$player->echipaID];
                $player['goluri'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->where('jucatorID', '=', $player->id)->get());
                $player['assisturi'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '0')->where('jucatorID', '=', $player->id)->get());
                $player['cartonaseGalbene'] = count(Cartonase_22_23_Model::select('id')->where('culoareCartonas', '=', '0')->where('jucatorID', '=', $player->id)->get());
                $player['cartonaseRosii'] = count(Cartonase_22_23_Model::select('id')->where('culoareCartonas', '=', '1')->where('jucatorID', '=', $player->id)->get());
            }

            if($filters['order'] == 'asc') $players = $players->sortBy($filters['sortByAttribute']);
                else $players = collect($players)->sortByDesc($filters['sortByAttribute']);

            $players = array_slice($players->toArray(), ($page - 1) * 20, 20); //ddd($players);
            
            return view('jucatori',
                            ['players' => $players,
                            'clubsDct' => $clubsDct,
                            'countries' => Tari_Model::select('denumire', 'prescurtare')->orderBy('denumire')->get(),
                            'filters' => $filters,
                            'page' => $page
                        ]);
        }

            $filters['search'] = '';
            $filters['ageMin'] = 1;
            $filters['ageMax'] = 100;
            $filters['heightMin'] = 1;
            $filters['heightMax'] = 210;
            $filters['weightMin'] = 1;
            $filters['weightMax'] = 110;
            $filters['sortByAttribute'] = 'numeJucator';
            $filters['order'] = 'asc';
            $filters['clubsChecked'] = [];
            $filters['positionsChecked'] = [];
            $filters['countriesChecked'] = [];
            $filters['allClubs'] = true;
            $filters['allPositions'] = true;
            $filters['allCountries'] = true;

            $players = Jucatori_22_23_Model::where('echipaActuala', '=', '1')->orderBy('numeJucator', 'asc')->skip(($page-1)*20)->take(20)->get();

            foreach($players as $player){
                $player['goluri'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->where('jucatorID', '=', $player->id)->get());
                $player['assisturi'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '0')->where('jucatorID', '=', $player->id)->get());
                $player['cartonaseGalbene'] = count(Cartonase_22_23_Model::select('id')->where('culoareCartonas', '=', '0')->where('jucatorID', '=', $player->id)->get());
                $player['cartonaseRosii'] = count(Cartonase_22_23_Model::select('id')->where('culoareCartonas', '=', '1')->where('jucatorID', '=', $player->id)->get());
            }
            //ddd($players);
            return view('jucatori', [
                'players' => $players,
                'clubsDct' => $clubsDct,
                'countries' => Tari_Model::orderBy('denumire')->get(),
                'filters' => $filters,
                'page' => $page
            ]);
    }

    public function echipaStatistici($numeEchipa, $faza){
        $club = Echipe_22_23_Model::where('numeEchipa', '=', $numeEchipa)->first();
        if($faza == 'generale'){
            $club['goluriCareu'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->where('echipaID', '=', $club->id)->where('tip', '=', 'careu')->get());
            $club['goluriDistanta'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->where('echipaID', '=', $club->id)->where('tip', '=', 'distanta')->get());
            $club['goluriFazaFixa'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->where('echipaID', '=', $club->id)->where('tip', '=', 'faza fixa')->get());
            $club['goluriCap'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->where('echipaID', '=', $club->id)->where('tip', '=', 'cap')->get());
            $club['goluriPenalty'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->where('echipaID', '=', $club->id)->where('tip', '=', 'penalty')->get());
            $club['goluriTotale'] = $club['goluriCareu'] + $club['goluriDistanta'] + $club['goluriFazaFixa'] + $club['goluriCap'] + $club['goluriPenalty'];

            $club['cartonaseGalbene'] = count(Cartonase_22_23_Model::select('id')->where('culoareCartonas', '=', '0')->where('echipaID', '=', $club->id)->get());
            $club['cartonaseRosii'] = count(Cartonase_22_23_Model::select('id')->where('culoareCartonas', '=', '1')->where('echipaID', '=', $club->id)->get());
            
            $statistici['medieGoluri'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->get());
            $statistici['medieGoluri'] = round($statistici['medieGoluri'] / 16, 2);
            
            $nrEtapeJucate = Clasament_22_23_Model::select('meciuriJucate')->where('echipaID', '=', $club->id)->where('faza', '=', 'sezon regulat')->first()['meciuriJucate'];
            if(Clasament_22_23_Model::select('meciuriJucate')->where('echipaID', '=', $club->id)->where(function($query) {$query->where('faza', '=', 'play off')->orWhere('faza', '=','play out');})->first()){
                $nrEtapeJucate = $nrEtapeJucate + Clasament_22_23_Model::select('meciuriJucate')->where('echipaID', '=', $club->id)->where(function($query) {
                    $query->where('faza', '=', 'play off')->orWhere('faza', '=','play out');
                })->first()['meciuriJucate'];
            }

            $listaMeciuriJucateGazdaID = Meciuri_22_23_Model::select('id')->where('echipaGazdaID', '=', $club->id)->where('disputat', '=', '1')->get();
            $listaMeciuriJucateOaspeteID = Meciuri_22_23_Model::select('id')->where('echipaOaspeteID', '=', $club->id)->where('disputat', '=', '1')->get();

            $club['posesieMediePeMeci'] = 0;
            $club['suturiTotale'] = 0;

            $club['posesieMediePeMeci'] = Meciuri_Statistici_22_23_Model::select(Meciuri_Statistici_22_23_Model::raw('sum(posesieEG) as posesieTotala'))->whereIn('meciID', $listaMeciuriJucateGazdaID)->get()[0]['posesieTotala'];
            $club['posesieMediePeMeci'] = $club['posesieMediePeMeci'] + Meciuri_Statistici_22_23_Model::select(Meciuri_Statistici_22_23_Model::raw('sum(posesieEO) as posesieTotala'))->whereIn('meciID', $listaMeciuriJucateOaspeteID)->get()[0]['posesieTotala'];

            $club['suturiTotale'] = Meciuri_Statistici_22_23_Model::select(Meciuri_Statistici_22_23_Model::raw('sum(suturiEG) as suturiTotale'))->whereIn('meciID', $listaMeciuriJucateGazdaID)->get()[0]['suturiTotale'];
            $club['suturiTotale'] = $club['suturiTotale'] + Meciuri_Statistici_22_23_Model::select(Meciuri_Statistici_22_23_Model::raw('sum(suturiEO) as suturiTotale'))->whereIn('meciID', $listaMeciuriJucateOaspeteID)->get()[0]['suturiTotale'];
            $club['suturiPePoartaTotale'] = Meciuri_Statistici_22_23_Model::select(Meciuri_Statistici_22_23_Model::raw('sum(suturiPePoartaEG) as suturiPePoartaTotale'))->whereIn('meciID', $listaMeciuriJucateGazdaID)->get()[0]['suturiPePoartaTotale'];
            $club['suturiPePoartaTotale'] = $club['suturiPePoartaTotale'] + Meciuri_Statistici_22_23_Model::select(Meciuri_Statistici_22_23_Model::raw('sum(suturiPePoartaEO) as suturiPePoartaTotale'))->whereIn('meciID', $listaMeciuriJucateOaspeteID)->get()[0]['suturiPePoartaTotale'];
            if($club['suturiPePoartaTotale'] != 0) $club['medieRealizari'] = round($club['goluriTotale'] / $club['suturiPePoartaTotale'] , 2);
                else $club['medieRealizari'] = 0;
            $club['mediePasePeMeci'] = Meciuri_Statistici_22_23_Model::select(Meciuri_Statistici_22_23_Model::raw('sum(totalPaseEG) as paseTotale'))->whereIn('meciID', $listaMeciuriJucateGazdaID)->get()[0]['paseTotale'];
            $club['mediePasePeMeci'] = $club['mediePasePeMeci'] + Meciuri_Statistici_22_23_Model::select(Meciuri_Statistici_22_23_Model::raw('sum(totalPaseEO) as paseTotale'))->whereIn('meciID', $listaMeciuriJucateOaspeteID)->get()[0]['paseTotale'];
            $club['medieFaulturiPeMeci'] = Meciuri_Statistici_22_23_Model::select(Meciuri_Statistici_22_23_Model::raw('sum(faulturiEG) as faulturiTotale'))->whereIn('meciID', $listaMeciuriJucateGazdaID)->get()[0]['faulturiTotale'];
            $club['medieFaulturiPeMeci'] = $club['medieFaulturiPeMeci'] + Meciuri_Statistici_22_23_Model::select(Meciuri_Statistici_22_23_Model::raw('sum(faulturiEO) as faulturiTotale'))->whereIn('meciID', $listaMeciuriJucateOaspeteID)->get()[0]['faulturiTotale'];
            $club['medieDeposedariPeMeci'] = Meciuri_Statistici_22_23_Model::select(Meciuri_Statistici_22_23_Model::raw('sum(deposedariEG) as deposedariTotale'))->whereIn('meciID', $listaMeciuriJucateGazdaID)->get()[0]['deposedariTotale'];
            $club['medieDeposedariPeMeci'] = $club['medieDeposedariPeMeci'] + Meciuri_Statistici_22_23_Model::select(Meciuri_Statistici_22_23_Model::raw('sum(deposedariEO) as deposedariTotale'))->whereIn('meciID', $listaMeciuriJucateOaspeteID)->get()[0]['deposedariTotale'];
            $club['medieCornerePeMeci'] = Meciuri_Statistici_22_23_Model::select(Meciuri_Statistici_22_23_Model::raw('sum(cornereEG) as cornereTotale'))->whereIn('meciID', $listaMeciuriJucateGazdaID)->get()[0]['cornereTotale'];
            $club['medieCornerePeMeci'] = $club['medieCornerePeMeci'] + Meciuri_Statistici_22_23_Model::select(Meciuri_Statistici_22_23_Model::raw('sum(cornereEO) as cornereTotale'))->whereIn('meciID', $listaMeciuriJucateOaspeteID)->get()[0]['cornereTotale'];

            if($nrEtapeJucate != 0){
                $club['goluriPeMeci'] = round($club['goluriTotale'] / $nrEtapeJucate, 2);
                $club['cartonaseGalbenePeMeci'] = round($club['cartonase galbene'] / $nrEtapeJucate, 2);
                $club['cartonaseRosiiPeMeci'] = round($club['cartonase rosii'] / $nrEtapeJucate, 2);
                $club['posesieMediePeMeci'] = round($club['posesieMediePeMeci'] / $nrEtapeJucate, 2);
                $club['suturiPeMeci'] = round($club['suturiTotale'] / $nrEtapeJucate, 2);
                $club['mediePasePeMeci'] = round($club['mediePasePeMeci'] / $nrEtapeJucate, 2);
                $club['medieFaulturiPeMeci'] = round($club['medieFaulturiPeMeci'] / $nrEtapeJucate, 2);
                $club['medieDeposedariPeMeci'] = round($club['medieDeposedariPeMeci'] / $nrEtapeJucate, 2);
                $club['medieCornerePeMeci'] = round($club['medieCornerePeMeci'] / $nrEtapeJucate, 2);
            }
            else{
                $club['goluriPeMeci'] = 0;
                $club['cartonaseGalbenePeMeci'] = 0;
                $club['cartonaseRosiiPeMeci'] = 0;
                $club['posesieMediePeMeci'] = 0;
                $club['suturiPeMeci'] = 0;
                $club['mediePasePeMeci'] = 0;
                $club['medieFaulturiPeMeci'] = 0;
                $club['medieDeposedariPeMeci'] = 0;
                $club['medieCornerePeMeci'] = 0;
            }
        }
        else if($faza == 'sezon-regulat'){
            $sezonRegulatListaID = Meciuri_22_23_Model::select('id')->where('faza', '=', 'sezon regulat')->get();
            $club['goluriCareu'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->whereIn('meciID', $sezonRegulatListaID)->where('echipaID', '=', $club->id)->where('tip', '=', 'careu')->get());
            $club['goluriDistanta'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->whereIn('meciID', $sezonRegulatListaID)->where('echipaID', '=', $club->id)->where('tip', '=', 'distanta')->get());
            $club['goluriFazaFixa'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->whereIn('meciID', $sezonRegulatListaID)->where('echipaID', '=', $club->id)->where('tip', '=', 'faza fixa')->get());
            $club['goluriCap'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->whereIn('meciID', $sezonRegulatListaID)->where('echipaID', '=', $club->id)->where('tip', '=', 'cap')->get());
            $club['goluriPenalty'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->whereIn('meciID', $sezonRegulatListaID)->where('echipaID', '=', $club->id)->where('tip', '=', 'penalty')->get());
            $club['goluriTotale'] = $club['goluriCareu'] + $club['goluriDistanta'] + $club['goluriFazaFixa'] + $club['goluriCap'] + $club['goluriPenalty'];
            
            $club['cartonaseGalbene'] = count(Cartonase_22_23_Model::select('id')->where('culoareCartonas', '=', '0')->whereIn('meciID', $sezonRegulatListaID)->where('echipaID', '=', $club->id)->get());
            $club['cartonaseRosii'] = count(Cartonase_22_23_Model::select('id')->where('culoareCartonas', '=', '1')->whereIn('meciID', $sezonRegulatListaID)->where('echipaID', '=', $club->id)->get());
        
            $statistici['medieGoluri'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->whereIn('meciID', $sezonRegulatListaID)->get());
            $statistici['medieGoluri'] = round($statistici['medieGoluri'] / 16, 2);
            
            $nrEtapeJucate = Clasament_22_23_Model::select('meciuriJucate')->where('echipaID', '=', $club->id)->where('faza', '=', 'sezon regulat')->first()['meciuriJucate'];
            if($nrEtapeJucate != 0){
                $club['goluriPeMeci'] = round($club['goluriTotale'] / $nrEtapeJucate, 2);
                $club['cartonaseGalbenePeMeci'] = round($club['cartonase galbene'] / $nrEtapeJucate, 2);
                $club['cartonaseRosiiPeMeci'] = round($club['cartonase rosii'] / $nrEtapeJucate, 2);
            }
            else{
                $club['goluriPeMeci'] = 0;
                $club['cartonaseGalbenePeMeci'] = 0;
                $club['cartonaseRosiiPeMeci'] = 0;
            }
        }
        else if($faza == 'play-off-out'){
            $playOffOutListaID = Meciuri_22_23_Model::select('id')->where('faza', '=', 'play off')->orWhere('faza', '=', 'play out')->get();
            $club['goluriCareu'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->whereIn('meciID', $playOffOutListaID)->where('echipaID', '=', $club->id)->where('tip', '=', 'careu')->get());
            $club['goluriDistanta'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->whereIn('meciID', $playOffOutListaID)->where('echipaID', '=', $club->id)->where('tip', '=', 'distanta')->get());
            $club['goluriFazaFixa'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->whereIn('meciID', $playOffOutListaID)->where('echipaID', '=', $club->id)->where('tip', '=', 'faza fixa')->get());
            $club['goluriCap'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->whereIn('meciID', $playOffOutListaID)->where('echipaID', '=', $club->id)->where('tip', '=', 'cap')->get());
            $club['goluriPenalty'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->whereIn('meciID', $playOffOutListaID)->where('echipaID', '=', $club->id)->where('tip', '=', 'penalty')->get());
            $club['goluriTotale'] = $club['goluriCareu'] + $club['goluriDistanta'] + $club['goluriFazaFixa'] + $club['goluriCap'] + $club['goluriPenalty'];

            $club['cartonaseGalbene'] = count(Cartonase_22_23_Model::select('id')->where('culoareCartonas', '=', '0')->whereIn('meciID', $playOffOutListaID)->where('echipaID', '=', $club->id)->get());
            $club['cartonaseRosii'] = count(Cartonase_22_23_Model::select('id')->where('culoareCartonas', '=', '1')->whereIn('meciID', $playOffOutListaID)->where('echipaID', '=', $club->id)->get());
        
            $statistici['medieGoluri'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->whereIn('meciID', $playOffOutListaID)->get());
            $statistici['medieGoluri'] = round($statistici['medieGoluri'] / 16, 2);

            if($nrEtapeJucate = Clasament_22_23_Model::select('meciuriJucate')->where('echipaID', '=', $club->id)->where(function($query) {$query->where('faza', '=', 'play off')->orWhere('faza', '=','play out');})->first()){
                $nrEtapeJucate = $nrEtapeJucate['meciuriJucate'];
            }
            else $nrEtapeJucate = 0;

            if($nrEtapeJucate != 0){
                $club['goluriPeMeci'] = round($club['goluriTotale'] / $nrEtapeJucate, 2);
                $club['cartonaseGalbenePeMeci'] = round($club['cartonase galbene'] / $nrEtapeJucate, 2);
                $club['cartonaseRosiiPeMeci'] = round($club['cartonase rosii'] / $nrEtapeJucate, 2);
            }
            else{
                $club['goluriPeMeci'] = 0;
                $club['cartonaseGalbenePeMeci'] = 0;
                $club['cartonaseRosiiPeMeci'] = 0;
            }
        }

        return view('club/statistici', [
            'club' => $club,
            'jucatori' => Jucatori_22_23_Model::where('echipaID', '=', Echipe_22_23_Model::select('id')->where('numeEchipa', '=', $numeEchipa)->first()['id'])->where('echipaActuala', '=', '1')->get(),
            'faza' => $faza,
            'statistici' => $statistici
        ]);
    }

    public function echipaMeciuri($numeEchipa){
        $echipe = Echipe_22_23_Model::select('id', 'numeEchipa')->orderBy('id', 'asc')->get();
        $echipeID = [];
        $echipeNume = [];

        foreach ($echipe as $echipa){
            array_push($echipeID, $echipa['id']);
            array_push($echipeNume, $echipa['numeEchipa']);
        }
        
        $echipeDct = array_combine($echipeID, $echipeNume);

        $club = Echipe_22_23_Model::where('numeEchipa', '=', $numeEchipa)->first();

        $meciuri = Meciuri_22_23_Model::where('disputat', '=', '0')->where('echipaGazdaID', '=', $club->id)
                                    ->orWhere('disputat', '=', '0')->where('echipaOaspeteID', '=', $club->id)->orderBy('data', 'asc')->get();

        return view('club/meciuri', [
            'club' => $club,
            'cluburiDct' => $echipeDct,
            'meciuri' => $meciuri
        ]);
    }

    public function echipaRezultate($numeEchipa){
        $echipe = Echipe_22_23_Model::select('id', 'numeEchipa')->orderBy('id', 'asc')->get();
        $echipeID = [];
        $echipeNume = [];

        foreach ($echipe as $echipa){
            array_push($echipeID, $echipa['id']);
            array_push($echipeNume, $echipa['numeEchipa']);
        }
        
        $echipeDct = array_combine($echipeID, $echipeNume);

        $club = Echipe_22_23_Model::where('numeEchipa', '=', $numeEchipa)->first();

        $meciuri = Meciuri_22_23_Model::where('disputat', '=', '1')->where('echipaGazdaID', '=', $club->id)
                                    ->orWhere('disputat', '=', '1')->where('echipaOaspeteID', '=', $club->id)->orderBy('data', 'desc')->get();

        return view('club/rezultate', [
            'club' => $club,
            'cluburiDct' => $echipeDct,
            'meciuri' => $meciuri
        ]);
    }

    public function echipaStatisticiJucatori($numeEchipa){
        return view('club-info', [
            'club' => Echipe_22_23_Model::where('numeEchipa', '=', $numeEchipa)->first(),
            'jucatori' => Jucatori_22_23_Model::where('echipaID', '=', Echipe_22_23_Model::select('id')->where('numeEchipa', '=', $numeEchipa)->first()['id'])->where('echipaActuala', '=', '1')->get(),
            'content' => 'statistici-jucatori'
        ]);
    }

    public function jucatorIndex($numeEchipa, $numeJucator, $faza){
        $jucator = Jucatori_22_23_Model::where('numeJucator', '=', $numeJucator)->where('echipaActuala', '=', '1')->first();
        if($jucator){
            $jucator['numeEchipa'] = Echipe_22_23_Model::select('numeEchipa')->where('id', '=', Jucatori_22_23_Model::select('echipaID')->where('id', '=', $jucator->id)->first()['echipaID'])->first()['numeEchipa'];
        }
        else{
            $jucator = Jucatori_22_23_Model::where('numeJucator', '=', $numeJucator)->first();
            $jucator['numeEchipa'] = 'Nu mai joacă în Liga 1';
            return view('jucator-info', [
                'faza' => $faza,
                'jucator' => $jucator,
            ]);
        }

        if($faza == 'statistici-generale'){
            $sezonRegulatListaID = Meciuri_22_23_Model::select('id')->where('faza', '=', 'sezon regulat')->get();
            $PlayOffOutListaID = Meciuri_22_23_Model::select('id')->where('faza', '=', 'play off')->orWhere('faza', '=', 'play out')->get();

            $jucator['goluri careu'] = count(Goluri_Assisturi_22_23_Model::select('id')->whereIn('meciID', $sezonRegulatListaID)->where('golSauAssist', '=', '1')->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'careu')
                                                                                    ->OrWhereIn('meciID', $PlayOffOutListaID)->where('golSauAssist', '=', '1')->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'careu')->get());
            $jucator['goluri distanta'] = count(Goluri_Assisturi_22_23_Model::select('id')->whereIn('meciID', $sezonRegulatListaID)->where('golSauAssist', '=', '1')->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'distanta')
                                                                                        ->OrWhereIn('meciID', $PlayOffOutListaID)->where('golSauAssist', '=', '1')->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'distanta')->get());
            $jucator['goluri faza fixa'] = count(Goluri_Assisturi_22_23_Model::select('id')->whereIn('meciID', $sezonRegulatListaID)->where('golSauAssist', '=', '1')->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'faza fixa')
                                                                                        ->OrWhereIn('meciID', $PlayOffOutListaID)->where('golSauAssist', '=', '1')->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'faza fixa')->get());
            $jucator['goluri cap'] = count(Goluri_Assisturi_22_23_Model::select('id')->whereIn('meciID', $sezonRegulatListaID)->where('golSauAssist', '=', '1')->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'cap')
                                                                                    ->OrWhereIn('meciID', $PlayOffOutListaID)->where('golSauAssist', '=', '1')->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'cap')->get());
            $jucator['goluri penalty'] = count(Goluri_Assisturi_22_23_Model::select('id')->whereIn('meciID', $sezonRegulatListaID)->where('golSauAssist', '=', '1')->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'penalty')
                                                                                        ->OrWhereIn('meciID', $PlayOffOutListaID)->where('golSauAssist', '=', '1')->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'penalty')->get());
            $jucator['goluri totale'] = $jucator['goluri careu'] + $jucator['goluri distanta'] + $jucator['goluri faza fixa'] + $jucator['goluri cap'] + $jucator['goluri penalty'];
            
            $jucator['assisturi pasa'] = count(Goluri_Assisturi_22_23_Model::select('id')->whereIn('meciID', $sezonRegulatListaID)->where('golSauAssist', '=', '0')->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'pasa')
                                                                                        ->OrWhereIn('meciID', $PlayOffOutListaID)->where('golSauAssist', '=', '0')->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'pasa')->get());
            $jucator['assisturi distanta'] = count(Goluri_Assisturi_22_23_Model::select('id')->whereIn('meciID', $sezonRegulatListaID)->where('golSauAssist', '=', '0')->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'distanta')
                                                                                        ->OrWhereIn('meciID', $PlayOffOutListaID)->where('golSauAssist', '=', '0')->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'distanta')->get());
            $jucator['assisturi faza fixa'] = count(Goluri_Assisturi_22_23_Model::select('id')->whereIn('meciID', $sezonRegulatListaID)->where('golSauAssist', '=', '0')->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'faza fixa')
                                                                                            ->OrWhereIn('meciID', $PlayOffOutListaID)->where('golSauAssist', '=', '0')->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'faza fixa')->get());
            $jucator['assisturi corner'] = count(Goluri_Assisturi_22_23_Model::select('id')->whereIn('meciID', $sezonRegulatListaID)->where('golSauAssist', '=', '0')->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'cap')
                                                                                        ->OrWhereIn('meciID', $PlayOffOutListaID)->where('golSauAssist', '=', '0')->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'cap')->get());
            $jucator['assisturi totale'] = $jucator['assisturi pasa'] + $jucator['assisturi distanta'] + $jucator['assisturi faza fixa'] + $jucator['assisturi corner'];

            $jucator['cartonase galbene'] = count(Cartonase_22_23_Model::select('id')->whereIn('meciID', $sezonRegulatListaID)->where('culoareCartonas', '=', '0')->where('jucatorID', '=', $jucator->id)
                                                                                    ->OrWhereIn('meciID', $PlayOffOutListaID)->where('culoareCartonas', '=', '0')->where('jucatorID', '=', $jucator->id)->get());
            $jucator['cartonase rosii'] = count(Cartonase_22_23_Model::select('id')->whereIn('meciID', $sezonRegulatListaID)->where('culoareCartonas', '=', '1')->where('jucatorID', '=', $jucator->id)
                                                                                ->OrWhereIn('meciID', $PlayOffOutListaID)->where('culoareCartonas', '=', '1')->where('jucatorID', '=', $jucator->id)->get());
            
            $meciuriDict = Meciuri_22_23_Model::select('id', 'nrEtapa')->where('faza', '=', 'sezon regulat')->where('echipaGazdaID', '=', $jucator->echipaID)->orWhere('echipaOaspeteID', '=', $jucator->echipaID)->orderBy('id', 'asc')->get();

            $meciuriID = [];
            $meciuriEtape = [];

            foreach ($meciuriDict as $meci){
                array_push($meciuriID, $meci['id']);
                array_push($meciuriEtape, $meci['nrEtapa']);
            }
            $meciuriDict = array_combine($meciuriEtape, $meciuriID);
            
            $minuteJucate = [];
            $nrEtapeDisputate = Meciuri_22_23_Model::select('nrEtapa')->where('echipaGazdaID', '=', $jucator->echipaID)
                                                                      ->where('faza', '=', 'sezon regulat')
                                                                      ->where('disputat', '=', '1')
                                                                      ->orWhere('echipaOaspeteID', '=', $jucator->echipaID)
                                                                      ->where('faza', '=', 'sezon regulat')
                                                                      ->where('disputat', '=', '1')
                                                                      ->orderBy('nrEtapa', 'desc')->first();
            if($nrEtapeDisputate) $nrEtapeDisputate = $nrEtapeDisputate['nrEtapa'];
            else $nrEtapeDisputate = 0;

            for($i = 1; $i<=$nrEtapeDisputate; $i++){
                if(Loturi_22_23_Model::where('meciID', '=', $meciuriDict[$i])->where('jucatorID', '=', $jucator->id)->where('situatie', '=', 'titular')->first()){
                    if($minut = Schimbari_22_23_Model::select('minut')->where('meciID', '=', $meciuriDict[$i])->where('jucatorSchimbatID', '=', $jucator->id)->first())
                        $minuteJucate[$i] = $minut['minut'];
                else{$minuteJucate[$i] = 90;}
                }
                else if(Loturi_22_23_Model::where('meciID', '=', $meciuriDict[$i])->where('jucatorID', '=', $jucator->id)->where('situatie', '=', 'rezerva')->first() && ($minut = Schimbari_22_23_Model::select('minut')->where('meciID', '=', $meciuriDict[$i])->where('jucatorIntratID', '=', $jucator->id)->first())){
                    $minuteJucate[$i] = 90 - $minut['minut'];
                }
                else{$minuteJucate[$i] = 0;}
            }

            $jucator->minuteJucateSezonRegulat = $minuteJucate;
            
            $meciuriDict = Meciuri_22_23_Model::select('id', 'nrEtapa')->where('faza', '=', 'play off')->where('echipaGazdaID', '=', $jucator->echipaID)->orWhere('echipaOaspeteID', '=', $jucator->echipaID)->orderBy('id', 'asc')
                                                                    ->orWhere('faza', '=', 'play out')->where('echipaGazdaID', '=', $jucator->echipaID)->orWhere('echipaOaspeteID', '=', $jucator->echipaID)->orderBy('id', 'asc')->get();

            $meciuriID = [];
            $meciuriEtape = [];

            foreach ($meciuriDict as $meci){
                array_push($meciuriID, $meci['id']);
                array_push($meciuriEtape, $meci['nrEtapa']);
            }
            $meciuriDict = array_combine($meciuriEtape, $meciuriID);
            
            $minuteJucate = [];

            $nrEtapeDisputate = Meciuri_22_23_Model::select('nrEtapa')->where('disputat', '=', '1')->where('echipaGazdaID', '=', $jucator->echipaID)->where('faza', '=', 'play off')
                                                                    ->orWhere('disputat', '=', '1')->where('echipaOaspeteID', '=', $jucator->echipaID)->where('faza', '=', 'play off')
                                                                    ->orWhere('disputat', '=', '1')->where('echipaGazdaID', '=', $jucator->echipaID)->where('faza', '=', 'play out')
                                                                    ->orWhere('disputat', '=', '1')->where('echipaOaspeteID', '=', $jucator->echipaID)->where('faza', '=', 'play out')
                                                                    ->orderBy('nrEtapa', 'desc')->first();
            if($nrEtapeDisputate) $nrEtapeDisputate = $nrEtapeDisputate['nrEtapa'];
            else $nrEtapeDisputate = 0;

            for($i = 1; $i<=$nrEtapeDisputate; $i++){
                if(Loturi_22_23_Model::where('meciID', '=', $meciuriDict[$i])->where('jucatorID', '=', $jucator->id)->where('situatie', '=', 'titular')->first()){
                    if($minut = Schimbari_22_23_Model::select('minut')->where('meciID', '=', $meciuriDict[$i])->where('jucatorSchimbatID', '=', $jucator->id)->first())
                        $minuteJucate[$i] = $minut['minut'];
                else{$minuteJucate[$i] = 90;}
                }
                else if(Loturi_22_23_Model::where('meciID', '=', $meciuriDict[$i])->where('jucatorID', '=', $jucator->id)->where('situatie', '=', 'rezerva')->first() && ($minut = Schimbari_22_23_Model::select('minut')->where('meciID', '=', $meciuriDict[$i])->where('jucatorIntratID', '=', $jucator->id)->first())){
                    $minuteJucate[$i] = 90 - $minut['minut'];
                }
                else{$minuteJucate[$i] = 0;}
            }

            $jucator->minuteJucatePlayOffOut = $minuteJucate;
        }

        if($faza == 'sezon-regulat'){
            $sezonRegulatListaID = Meciuri_22_23_Model::select('id')->where('faza', '=', 'sezon regulat')->get();
            $jucator['goluri careu'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->whereIn('meciID', $sezonRegulatListaID)->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'careu')->get());
            $jucator['goluri distanta'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->whereIn('meciID', $sezonRegulatListaID)->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'distanta')->get());
            $jucator['goluri faza fixa'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->whereIn('meciID', $sezonRegulatListaID)->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'faza fixa')->get());
            $jucator['goluri cap'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->whereIn('meciID', $sezonRegulatListaID)->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'cap')->get());
            $jucator['goluri penalty'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->whereIn('meciID', $sezonRegulatListaID)->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'penalty')->get());
            $jucator['goluriTotale'] = $jucator['goluri careu'] + $jucator['goluri distanta'] + $jucator['goluri faza fixa'] + $jucator['goluri cap'] + $jucator['goluri penalty'];
            
            $jucator['assisturi pasa'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '0')->whereIn('meciID', $sezonRegulatListaID)->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'pasa')->get());
            $jucator['assisturi distanta'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '0')->whereIn('meciID', $sezonRegulatListaID)->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'distanta')->get());
            $jucator['assisturi faza fixa'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '0')->whereIn('meciID', $sezonRegulatListaID)->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'faza fixa')->get());
            $jucator['assisturi corner'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '0')->whereIn('meciID', $sezonRegulatListaID)->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'cap')->get());
            $jucator['assisturi totale'] = $jucator['assisturi pasa'] + $jucator['assisturi distanta'] + $jucator['assisturi faza fixa'] + $jucator['assisturi corner'];

            $jucator['cartonase galbene'] = count(Cartonase_22_23_Model::select('id')->where('culoareCartonas', '=', '0')->whereIn('meciID', $sezonRegulatListaID)->where('jucatorID', '=', $jucator->id)->get());
            $jucator['cartonase rosii'] = count(Cartonase_22_23_Model::select('id')->where('culoareCartonas', '=', '1')->whereIn('meciID', $sezonRegulatListaID)->where('jucatorID', '=', $jucator->id)->get());
            
            $meciuriDict = Meciuri_22_23_Model::select('id', 'nrEtapa')->where('faza', '=', 'sezon regulat')->where('echipaGazdaID', '=', $jucator->echipaID)->orWhere('echipaOaspeteID', '=', $jucator->echipaID)->orderBy('id', 'asc')->get();

            $meciuriID = [];
            $meciuriEtape = [];

            foreach ($meciuriDict as $meci){
                array_push($meciuriID, $meci['id']);
                array_push($meciuriEtape, $meci['nrEtapa']);
            }
            $meciuriDict = array_combine($meciuriEtape, $meciuriID);
            
            $minuteJucate = [];
            $nrEtapeDisputate = Meciuri_22_23_Model::select('nrEtapa')->where('echipaGazdaID', '=', $jucator->echipaID)
                                                                      ->where('faza', '=', 'sezon regulat')
                                                                      ->where('disputat', '=', '1')
                                                                      ->orWhere('echipaOaspeteID', '=', $jucator->echipaID)
                                                                      ->where('faza', '=', 'sezon regulat')
                                                                      ->where('disputat', '=', '1')
                                                                      ->orderBy('nrEtapa', 'desc')->first();
            if($nrEtapeDisputate) $nrEtapeDisputate = $nrEtapeDisputate['nrEtapa'];
            else $nrEtapeDisputate = 0;

            for($i = 1; $i<=$nrEtapeDisputate; $i++){
                if(Loturi_22_23_Model::where('meciID', '=', $meciuriDict[$i])->where('jucatorID', '=', $jucator->id)->where('situatie', '=', 'titular')->first()){
                    if($minut = Schimbari_22_23_Model::select('minut')->where('meciID', '=', $meciuriDict[$i])->where('jucatorSchimbatID', '=', $jucator->id)->first())
                        $minuteJucate[$i] = $minut['minut'];
                else{$minuteJucate[$i] = 90;}
                }
                else if(Loturi_22_23_Model::where('meciID', '=', $meciuriDict[$i])->where('jucatorID', '=', $jucator->id)->where('situatie', '=', 'rezerva')->first() && ($minut = Schimbari_22_23_Model::select('minut')->where('meciID', '=', $meciuriDict[$i])->where('jucatorIntratID', '=', $jucator->id)->first())){
                    $minuteJucate[$i] = 90 - $minut['minut'];
                }
                else{$minuteJucate[$i] = 0;}
            }

            $jucator->minuteJucateSezonRegulat = $minuteJucate;
        }

        if($faza == 'play-off-out'){
            $PlayOffOutListaID = Meciuri_22_23_Model::select('id')->where('faza', '=', 'play off')->orWhere('faza', '=', 'play out')->get();
            $jucator['goluri careu'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->whereIn('meciID', $PlayOffOutListaID)->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'careu')->get());
            $jucator['goluri distanta'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->whereIn('meciID', $PlayOffOutListaID)->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'distanta')->get());
            $jucator['goluri faza fixa'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->whereIn('meciID', $PlayOffOutListaID)->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'faza fixa')->get());
            $jucator['goluri cap'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->whereIn('meciID', $PlayOffOutListaID)->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'cap')->get());
            $jucator['goluri penalty'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '1')->whereIn('meciID', $PlayOffOutListaID)->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'penalty')->get());
            $jucator['goluriTotale'] = $jucator['goluri careu'] + $jucator['goluri distanta'] + $jucator['goluri faza fixa'] + $jucator['goluri cap'] + $jucator['goluri penalty'];
            
            $jucator['assisturi pasa'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '0')->whereIn('meciID', $PlayOffOutListaID)->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'careu')->get());
            $jucator['assisturi distanta'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '0')->whereIn('meciID', $PlayOffOutListaID)->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'distanta')->get());
            $jucator['assisturi faza fixa'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '0')->whereIn('meciID', $PlayOffOutListaID)->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'faza fixa')->get());
            $jucator['assisturi corner'] = count(Goluri_Assisturi_22_23_Model::select('id')->where('golSauAssist', '=', '0')->whereIn('meciID', $PlayOffOutListaID)->where('jucatorID', '=', $jucator->id)->where('tip', '=', 'cap')->get());
            $jucator['assisturi totale'] = $jucator['assisturi pasa'] + $jucator['assisturi distanta'] + $jucator['assisturi faza fixa'] + $jucator['assisturi corner'];

            $jucator['cartonase galbene'] = count(Cartonase_22_23_Model::select('id')->where('culoareCartonas', '=', '0')->whereIn('meciID', $PlayOffOutListaID)->where('jucatorID', '=', $jucator->id)->get());
            $jucator['cartonase rosii'] = count(Cartonase_22_23_Model::select('id')->where('culoareCartonas', '=', '1')->whereIn('meciID', $PlayOffOutListaID)->where('jucatorID', '=', $jucator->id)->get());
            
            $meciuriDict = Meciuri_22_23_Model::select('id', 'nrEtapa')->where('faza', '=', 'play off')->orWhere('faza', '=', 'play out')->where('echipaGazdaID', '=', $jucator->echipaID)->orWhere('echipaOaspeteID', '=', $jucator->echipaID)->orderBy('id', 'asc')->get();

            $meciuriID = [];
            $meciuriEtape = [];

            foreach ($meciuriDict as $meci){
                array_push($meciuriID, $meci['id']);
                array_push($meciuriEtape, $meci['nrEtapa']);
            }
            $meciuriDict = array_combine($meciuriEtape, $meciuriID);
            
            $minuteJucate = [];

            $nrEtapeDisputate = Meciuri_22_23_Model::select('nrEtapa')->where('echipaGazdaID', '=', $jucator->echipaID)
                                                                    ->where('faza', '=', 'play off')
                                                                    ->where('disputat', '=', '1')
                                                                    ->orWhere('echipaOaspeteID', '=', $jucator->echipaID)
                                                                    ->where('faza', '=', 'play off')
                                                                    ->where('disputat', '=', '1')
                                                                    ->orWhere('echipaGazdaID', '=', $jucator->echipaID)
                                                                    ->where('faza', '=', 'play out')
                                                                    ->where('disputat', '=', '1')
                                                                    ->orWhere('echipaOaspeteID', '=', $jucator->echipaID)
                                                                    ->where('faza', '=', 'play out')
                                                                    ->where('disputat', '=', '1')
                                                                    ->orderBy('nrEtapa', 'desc')->first();
            if($nrEtapeDisputate) $nrEtapeDisputate = $nrEtapeDisputate['nrEtapa'];
            else $nrEtapeDisputate = 0;

            for($i = 1; $i<=$nrEtapeDisputate; $i++){
                if(Loturi_22_23_Model::where('meciID', '=', $meciuriDict[$i])->where('jucatorID', '=', $jucator->id)->where('situatie', '=', 'titular')->first()){
                    if($minut = Schimbari_22_23_Model::select('minut')->where('meciID', '=', $meciuriDict[$i])->where('jucatorSchimbatID', '=', $jucator->id)->first())
                        $minuteJucate[$i] = $minut['minut'];
                else{$minuteJucate[$i] = 90;}
                }
                else if(Loturi_22_23_Model::where('meciID', '=', $meciuriDict[$i])->where('jucatorID', '=', $jucator->id)->where('situatie', '=', 'rezerva')->first() && ($minut = Schimbari_22_23_Model::select('minut')->where('meciID', '=', $meciuriDict[$i])->where('jucatorIntratID', '=', $jucator->id)->first())){
                    $minuteJucate[$i] = 90 - $minut['minut'];
                }
                else{$minuteJucate[$i] = 0;}
            }

            $jucator->minuteJucatePlayOffOut = $minuteJucate;
        }

        $jucator->nationalitate = Tari_Model::select('denumire')->where('prescurtare', '=', $jucator->nationalitate)->first()['denumire'];

        return view('jucator-info', [
                                    'faza' => $faza,
                                    'jucator' => $jucator,
        ]);
    }

    public function clasamentIndex($faza){
        $echipe = Echipe_22_23_Model::select('id', 'numeEchipa')->orderBy('id', 'asc')->get();
        
        $echipeID = [];
        $echipeNume = [];

        foreach ($echipe as $echipa){
            array_push($echipeID, $echipa['id']);
            array_push($echipeNume, $echipa['numeEchipa']);
        }
        $echipeDct = array_combine($echipeID, $echipeNume);

        return view('clasament', [
            'clasament' => Clasament_22_23_Model::where('faza', '=', $faza)->orderBy('pozitie')->get(),
            'cluburiDct' => $echipeDct,
            'faza' => $faza
        ]);
    }

    public function meciuriIndex($faza, $etapa = null){
        $echipe = Echipe_22_23_Model::select('id', 'numeEchipa')->orderBy('id', 'asc')->get();
        $echipeID = [];
        $echipeNume = [];

        foreach ($echipe as $echipa){
            array_push($echipeID, $echipa['id']);
            array_push($echipeNume, $echipa['numeEchipa']);
        }
        
        $echipeDct = array_combine($echipeID, $echipeNume);
        if($etapa){
            if($faza == 'sezon regulat'){
                $meciuri = Meciuri_22_23_Model::where('faza', '=', 'sezon regulat')->where('nrEtapa', '=', $etapa)->orderBy('data', 'asc')->get();
            }
            elseif ($faza == 'play off'){
                $meciuri = Meciuri_22_23_Model::where('faza', '=', 'play off')->where('nrEtapa', '=', $etapa)->orderBy('data', 'asc')->get();
            }
            elseif($faza == 'play out'){
                $meciuri = Meciuri_22_23_Model::where('faza', '=', 'play out')->where('nrEtapa', '=', $etapa)->orderBy('data', 'asc')->get();
            }
        }
        else{
            if($faza == 'sezon regulat'){
                $etapa = Meciuri_22_23_Model::select('nrEtapa')->where('faza', '=', 'sezon regulat')->where('disputat', '=', '1')->orderBy('nrEtapa', 'desc')->first();
                if($etapa) $etapa = $etapa['nrEtapa'];
                else $etapa = 1;
                $meciuri = Meciuri_22_23_Model::where('faza', '=', 'sezon regulat')->where('nrEtapa', '=', $etapa)->orderBy('data', 'asc')->get();
            }
            elseif ($faza == 'play off'){
                if($etapa = Meciuri_22_23_Model::select('nrEtapa')->where('faza', '=', 'play off')->where('disputat', '=', '1')->orderBy('nrEtapa', 'desc')->first()){
                    $etapa = $etapa['nrEtapa'];
                    $meciuri = Meciuri_22_23_Model::where('faza', '=', 'play off')->where('nrEtapa', '=', $etapa)->orderBy('data', 'asc')->get();
                }
                else{
                    $meciuri = Meciuri_22_23_Model::where('faza', '=', 'play off')->where('nrEtapa', '=', '1')->orderBy('data', 'asc')->get();
                }
            }
            elseif($faza == 'play out'){
                if($etapa = Meciuri_22_23_Model::select('nrEtapa')->where('faza', '=', 'play out')->where('disputat', '=', '1')->orderBy('nrEtapa', 'desc')->first()){
                    $etapa = $etapa['nrEtapa'];
                    $meciuri = Meciuri_22_23_Model::where('faza', '=', 'play off')->where('nrEtapa', '=', $etapa)->orderBy('data', 'asc')->get();
                }
                else{
                    $meciuri = Meciuri_22_23_Model::where('faza', '=', 'play out')->where('nrEtapa', '=', '1')->orderBy('data', 'asc')->get();
                }
            }
        }

        return view('meciuri', [
            'meciuri' => $meciuri,
            'cluburiDct' => $echipeDct,
            'faza' => $faza
        ]);
    }

    public function meciInfo($meciID){
        $statistici = Meciuri_Statistici_22_23_Model::where('meciID', '=', $meciID)->first();
        $meci = Meciuri_22_23_Model::where('id', '=', $meciID)->first();
        $meci['echipaGazda'] = Echipe_22_23_Model::select('id', 'numeEchipa')->where('id', '=', Meciuri_22_23_Model::select('echipaGazdaID')->where('id', '=', $meciID)->first()['echipaGazdaID'])->first();
        $meci['echipaOaspete'] = Echipe_22_23_Model::select('id', 'numeEchipa')->where('id', '=', Meciuri_22_23_Model::select('echipaOaspeteID')->where('id', '=', $meciID)->first()['echipaOaspeteID'])->first();
        
        return view('Statistici meci/info', [
            'statistici' => $statistici,
            'meci' => $meci
        ]);
    }

    public function meciLoturi($meciID){
        $meci = Meciuri_22_23_Model::where('id', '=', $meciID)->first();
        $meci['echipaGazda'] = Echipe_22_23_Model::select('id', 'numeEchipa')->where('id', '=', Meciuri_22_23_Model::select('echipaGazdaID')->where('id', '=', $meciID)->first()['echipaGazdaID'])->first();
        $meci['echipaOaspete'] = Echipe_22_23_Model::select('id', 'numeEchipa')->where('id', '=', Meciuri_22_23_Model::select('echipaOaspeteID')->where('id', '=', $meciID)->first()['echipaOaspeteID'])->first();
        
        $loturi = [];
        $loturi[$meci['echipaGazda']['numeEchipa']]['titulari'] = Loturi_22_23_Model::where('meciID', '=', $meciID)->where('echipaID', '=', $meci['echipaGazda']['id'])->where('situatie', '=', 'titular')->pluck('jucatorID')->toArray();
        $loturi[$meci['echipaOaspete']['numeEchipa']]['titulari'] = Loturi_22_23_Model::where('meciID', '=', $meciID)->where('echipaID', '=', $meci['echipaOaspete']['id'])->where('situatie', '=', 'titular')->pluck('jucatorID')->toArray();
        $loturi[$meci['echipaGazda']['numeEchipa']]['rezerve'] = Loturi_22_23_Model::where('meciID', '=', $meciID)->where('echipaID', '=', $meci['echipaGazda']['id'])->where('situatie', '=', 'rezerva')->pluck('jucatorID')->toArray();
        $loturi[$meci['echipaOaspete']['numeEchipa']]['rezerve'] = Loturi_22_23_Model::where('meciID', '=', $meciID)->where('echipaID', '=', $meci['echipaOaspete']['id'])->where('situatie', '=', 'rezerva')->pluck('jucatorID')->toArray();

        $jucatori = Jucatori_22_23_Model::select('id', 'numeJucator')->where('echipaID', '=', $meci['echipaGazda']['id'])->orWhere('echipaID', '=', $meci['echipaOaspete']['id'])->get();
        
        $jucatoriID = [];
        $jucatoriNume = [];

        foreach ($jucatori as $jucator){
            array_push($jucatoriID, $jucator['id']);
            array_push($jucatoriNume, $jucator['numeJucator']);
        }
        
        $jucatoriDct = array_combine($jucatoriID, $jucatoriNume);
        
        return view('Statistici meci/loturi', [
            'meci' => $meci,
            'loturi' => $loturi,
            'jucatori' => $jucatoriDct
        ]);
    }

    public function meciEvenimente($meciID){
        $meci = Meciuri_22_23_Model::where('id', '=', $meciID)->first();
        $meci['echipaGazda'] = Echipe_22_23_Model::select('id', 'numeEchipa')->where('id', '=', Meciuri_22_23_Model::select('echipaGazdaID')->where('id', '=', $meciID)->first()['echipaGazdaID'])->first();
        $meci['echipaOaspete'] = Echipe_22_23_Model::select('id', 'numeEchipa')->where('id', '=', Meciuri_22_23_Model::select('echipaOaspeteID')->where('id', '=', $meciID)->first()['echipaOaspeteID'])->first();
        
        $goluri = Goluri_Assisturi_22_23_Model::select('golSauAssist', 'echipaID', 'jucatorID', 'minut')->where('golSauAssist', '=', '1')->where('meciID', '=', $meciID)->get()->toArray();
        $cartonase = Cartonase_22_23_Model::select('culoareCartonas', 'echipaID', 'jucatorID', 'minut')->where('meciID', '=', $meciID)->get()->toArray();
        $schimbari = Schimbari_22_23_Model::select('jucatorSchimbatID', 'jucatorIntratID', 'echipaID', 'minut')->where('meciID', '=', $meciID)->get()->toArray();
        
        $evenimente = [];
        foreach ($goluri as $gol){
            $gol['eveniment'] = 'gol';
            array_push($evenimente, $gol);
        }
        foreach ($cartonase as $cartonas){
            if(!$cartonas['culoareCartonas']) $cartonas['eveniment'] = 'cartonasGalben'; else $cartonas['eveniment'] = 'cartonasRosu';
            array_push($evenimente, $cartonas);
        }
        foreach ($schimbari as $schimbare){
            $schimbare['eveniment'] = 'schimbare';
            array_push($evenimente, $schimbare);
        }
        
        usort($evenimente, function($a, $b) {return $a['minut']-$b['minut'];});

        $jucatori = Jucatori_22_23_Model::select('id', 'numeJucator')->where('echipaID', '=', $meci['echipaGazda']['id'])->orWhere('echipaID', '=', $meci['echipaOaspete']['id'])->get();
        $jucatoriID = [];
        $jucatoriNume = [];
        foreach ($jucatori as $jucator){
            array_push($jucatoriID, $jucator['id']);
            array_push($jucatoriNume, $jucator['numeJucator']);
        }
        $jucatoriDct = array_combine($jucatoriID, $jucatoriNume);

        return view('Statistici meci/evenimente', [
            'meci' => $meci,
            'evenimente' => $evenimente,
            'jucatori' => $jucatoriDct
        ]);
    }

    public function statistici($faza){
        if($faza == 'generale'){

            $statisticiJucatori['marcatori'] = [];
            $statisticiJucatori['assistman'] = [];

            for($i=0;$i<5;$i++){
                $jucator = Goluri_Assisturi_22_23_Model::select('jucatorID', Goluri_Assisturi_22_23_Model::raw('COUNT(*) as nrGoluri'))
                    ->where('golSauAssist', '=', '1')
                    ->groupBy('jucatorID')
                    ->orderByDesc('nrGoluri')
                    ->skip($i)
                    ->first();
    
                if($jucator) array_push($statisticiJucatori['marcatori'], $jucator);
            }

            for($i=0;$i<5;$i++){
                $jucator = Goluri_Assisturi_22_23_Model::select('jucatorID', Goluri_Assisturi_22_23_Model::raw('COUNT(*) as nrAssisturi'))
                    ->where('golSauAssist', '=', '0')
                    ->groupBy('jucatorID')
                    ->orderByDesc('nrAssisturi')
                    ->skip($i)
                    ->first();
    
                if($jucator) array_push($statisticiJucatori['assistman'], $jucator);
            }

            foreach($statisticiJucatori['marcatori'] as $jucator){
                $jucator['numeJucator'] = Jucatori_22_23_Model::select('numeJucator')->where('id', '=', $jucator['jucatorID'])->first()['numeJucator'];
                if(Jucatori_22_23_Model::select('echipaID')->where('id', '=', $jucator['jucatorID'])->where('echipaActuala', '=', 1)->first()){
                    $jucator['numeEchipa'] = Echipe_22_23_Model::select('numeEchipa')->where('id', '=', Jucatori_22_23_Model::select('echipaID')->where('id', '=', $jucator['jucatorID'])->where('echipaActuala', '=', 1)->first()['echipaID'])->first()['numeEchipa'];
                }
            }
            foreach($statisticiJucatori['assistman'] as $jucator){
                $jucator['numeJucator'] = Jucatori_22_23_Model::select('numeJucator')->where('id', '=', $jucator['jucatorID'])->first()['numeJucator'];
                if(Jucatori_22_23_Model::select('echipaID')->where('id', '=', $jucator['jucatorID'])->where('echipaActuala', '=', 1)->first()){
                    $jucator['numeEchipa'] = Echipe_22_23_Model::select('numeEchipa')->where('id', '=', Jucatori_22_23_Model::select('echipaID')->where('id', '=', $jucator['jucatorID'])->where('echipaActuala', '=', 1)->first()['echipaID'])->first()['numeEchipa'];
                }
            }

            $echipe = Echipe_22_23_Model::select('id', 'numeEchipa')->orderBy('id', 'asc')->get();
            
            foreach ($echipe as $echipa){
                $meciuriID = Meciuri_22_23_Model::select('id')->where('echipaGazdaID', '=', $echipa['id'])->orWhere('echipaOaspeteID', '=', $echipa['id'])->get()->toArray();
                foreach($meciuriID as $k=>$v) {
                    $meciuriID[$k] = $v['id'];
                }

                $nrGoluriInscrise = count(Goluri_Assisturi_22_23_Model::select('id')
                    ->where('golSauAssist', '=', '1')
                    ->where('echipaID', '=', $echipa['id'])
                    ->get());

                $echipa['nrGoluriInscrise'] = $nrGoluriInscrise;
                
                $nrGoluriPrimite = count(Goluri_Assisturi_22_23_Model::select('id')
                    ->where('golSauAssist', '=', '1')
                    ->where('echipaID', '!=', $echipa['id'])
                    ->whereIn('meciID', $meciuriID)
                    ->get());
                
                $echipa['nrGoluriPrimite'] = $nrGoluriPrimite;
            }

            foreach ($echipe as $echipa){
                if($echipa['nrGoluriPrimite'] == 0)
                    $echipa['medieGoluri'] = round($echipa['nrGoluriInscrise'], 2);
                else
                    $echipa['medieGoluri'] = round($echipa['nrGoluriInscrise']/$echipa['nrGoluriPrimite'], 2);
            }
            
            $statisticiEchipe = [];
            $statisticiEchipe['goluriInscriseDesc'] = array_slice(collect($echipe)->sortByDesc('nrGoluriInscrise')->toArray(), 0, 5, true);
            $statisticiEchipe['goluriInscriseAsc'] = array_slice(collect($echipe)->sortBy('nrGoluriInscrise')->toArray(), 0, 5, true);
            $statisticiEchipe['goluriPrimiteDesc'] = array_slice(collect($echipe)->sortByDesc('nrGoluriPrimite')->toArray(), 0, 5, true);
            $statisticiEchipe['goluriPrimiteAsc'] = array_slice(collect($echipe)->sortBy('nrGoluriPrimite')->toArray(), 0, 5, true);
            $statisticiEchipe['medieGoluriDesc'] = array_slice(collect($echipe)->sortByDesc('medieGoluri')->toArray(), 0, 5, true);
            $statisticiEchipe['medieGoluriAsc'] = array_slice(collect($echipe)->sortBy('medieGoluri')->toArray(), 0, 5, true);

            return view('sezon-statistici', [
                'faza' => $faza,
                'statisticiJucatori' => $statisticiJucatori,
                'statisticiEchipe' => $statisticiEchipe
            ]);
        }
        else if($faza == 'sezon-regulat'){
            $meciuriSezonRegulatID = Meciuri_22_23_Model::select('id')->where('faza', '=', 'sezon regulat')->get()->toArray();
            $statisticiJucatori['marcatori'] = [];
            $statisticiJucatori['assistman'] = [];

            for($i=0;$i<5;$i++){
                $jucator = Goluri_Assisturi_22_23_Model::select('jucatorID', Goluri_Assisturi_22_23_Model::raw('COUNT(*) as nrGoluri'))
                    ->where('golSauAssist', '=', '1')
                    ->whereIn('meciID', $meciuriSezonRegulatID)
                    ->groupBy('jucatorID')
                    ->orderByDesc('nrGoluri')
                    ->skip($i)
                    ->first();
                
                if($jucator) array_push($statisticiJucatori['marcatori'], $jucator);
            }

            for($i=0;$i<5;$i++){
                $jucator = Goluri_Assisturi_22_23_Model::select('jucatorID', Goluri_Assisturi_22_23_Model::raw('COUNT(*) as nrAssisturi'))
                    ->where('golSauAssist', '=', '0')
                    ->whereIn('meciID', $meciuriSezonRegulatID)
                    ->groupBy('jucatorID')
                    ->orderByDesc('nrAssisturi')
                    ->skip($i)
                    ->first();
    
                    if($jucator) array_push($statisticiJucatori['assistman'], $jucator);
            }

            foreach($statisticiJucatori['marcatori'] as $jucator){
                $jucator['numeJucator'] = Jucatori_22_23_Model::select('numeJucator')->where('id', '=', $jucator['jucatorID'])->first()['numeJucator'];
            }
            foreach($statisticiJucatori['assistman'] as $jucator){
                $jucator['numeJucator'] = Jucatori_22_23_Model::select('numeJucator')->where('id', '=', $jucator['jucatorID'])->first()['numeJucator'];
            }

            $echipe = Echipe_22_23_Model::select('id', 'numeEchipa')->orderBy('id', 'asc')->get();
            
            foreach ($echipe as $echipa){
                $meciuriID = Meciuri_22_23_Model::select('id')->whereIn('id', $meciuriSezonRegulatID)->where('echipaGazdaID', '=', $echipa['id'])->orWhere('echipaOaspeteID', '=', $echipa['id'])->get()->toArray();
                foreach($meciuriID as $k=>$v) {
                    $meciuriID[$k] = $v['id'];
                }

                $nrGoluriInscrise = count(Goluri_Assisturi_22_23_Model::select('id')
                    ->whereIn('meciID', $meciuriSezonRegulatID)
                    ->where('golSauAssist', '=', '1')
                    ->where('echipaID', '=', $echipa['id'])
                    ->get());

                $echipa['nrGoluriInscrise'] = $nrGoluriInscrise;
                
                $nrGoluriPrimite = count(Goluri_Assisturi_22_23_Model::select('id')
                    ->whereIn('meciID', $meciuriSezonRegulatID)
                    ->where('golSauAssist', '=', '1')
                    ->where('echipaID', '!=', $echipa['id'])
                    ->whereIn('meciID', $meciuriID)
                    ->get());
                
                $echipa['nrGoluriPrimite'] = $nrGoluriPrimite;
            }

            foreach ($echipe as $echipa){
                if($echipa['nrGoluriPrimite'] == 0)
                    $echipa['medieGoluri'] = round($echipa['nrGoluriInscrise'], 2);
                else
                    $echipa['medieGoluri'] = round($echipa['nrGoluriInscrise']/$echipa['nrGoluriPrimite'], 2);
            }
            
            $statisticiEchipe = [];
            $statisticiEchipe['goluriInscriseDesc'] = array_slice(collect($echipe)->sortByDesc('nrGoluriInscrise')->toArray(), 0, 5, true);
            $statisticiEchipe['goluriInscriseAsc'] = array_slice(collect($echipe)->sortBy('nrGoluriInscrise')->toArray(), 0, 5, true);
            $statisticiEchipe['goluriPrimiteDesc'] = array_slice(collect($echipe)->sortByDesc('nrGoluriPrimite')->toArray(), 0, 5, true);
            $statisticiEchipe['goluriPrimiteAsc'] = array_slice(collect($echipe)->sortBy('nrGoluriPrimite')->toArray(), 0, 5, true);
            $statisticiEchipe['medieGoluriDesc'] = array_slice(collect($echipe)->sortByDesc('medieGoluri')->toArray(), 0, 5, true);
            $statisticiEchipe['medieGoluriAsc'] = array_slice(collect($echipe)->sortBy('medieGoluri')->toArray(), 0, 5, true);

            return view('sezon-statistici', [
                'faza' => $faza,
                'statisticiJucatori' => $statisticiJucatori,
                'statisticiEchipe' => $statisticiEchipe
            ]);
        }
        else if($faza == 'play-off-out'){
            $meciuriPlayOffOutID = Meciuri_22_23_Model::select('id')->where('faza', '=', 'play off')->orWhere('faza', '=', 'play out')->get()->toArray();
            
            $statisticiJucatori['marcatori'] = [];
            $statisticiJucatori['assistman'] = [];

            for($i=0;$i<5;$i++){
                $jucator = Goluri_Assisturi_22_23_Model::select('jucatorID', Goluri_Assisturi_22_23_Model::raw('COUNT(*) as nrGoluri'))
                    ->where('golSauAssist', '=', '1')
                    ->whereIn('meciID', $meciuriPlayOffOutID)
                    ->groupBy('jucatorID')
                    ->orderByDesc('nrGoluri')
                    ->skip($i)
                    ->first();
                
                if($jucator) array_push($statisticiJucatori['marcatori'], $jucator);
            }

            for($i=0;$i<5;$i++){
                $jucator = Goluri_Assisturi_22_23_Model::select('jucatorID', Goluri_Assisturi_22_23_Model::raw('COUNT(*) as nrAssisturi'))
                    ->where('golSauAssist', '=', '0')
                    ->whereIn('meciID', $meciuriPlayOffOutID)
                    ->groupBy('jucatorID')
                    ->orderByDesc('nrAssisturi')
                    ->skip($i)
                    ->first();
    
                    if($jucator) array_push($statisticiJucatori['assistman'], $jucator);
            }

            foreach($statisticiJucatori['marcatori'] as $jucator){
                $jucator['numeJucator'] = Jucatori_22_23_Model::select('numeJucator')->where('id', '=', $jucator['jucatorID'])->first()['numeJucator'];
            }
            foreach($statisticiJucatori['assistman'] as $jucator){
                $jucator['numeJucator'] = Jucatori_22_23_Model::select('numeJucator')->where('id', '=', $jucator['jucatorID'])->first()['numeJucator'];
            }

            $echipe = Echipe_22_23_Model::select('id', 'numeEchipa')->orderBy('id', 'asc')->get();
            
            foreach ($echipe as $echipa){
                $meciuriID = Meciuri_22_23_Model::select('id')->whereIn('id', $meciuriPlayOffOutID)->where('echipaGazdaID', '=', $echipa['id'])->orWhere('echipaOaspeteID', '=', $echipa['id'])->get()->toArray();
                foreach($meciuriID as $k=>$v) {
                    $meciuriID[$k] = $v['id'];
                }

                $nrGoluriInscrise = count(Goluri_Assisturi_22_23_Model::select('id')
                    ->whereIn('meciID', $meciuriPlayOffOutID)
                    ->where('golSauAssist', '=', '1')
                    ->where('echipaID', '=', $echipa['id'])
                    ->get());

                $echipa['nrGoluriInscrise'] = $nrGoluriInscrise;
                
                $nrGoluriPrimite = count(Goluri_Assisturi_22_23_Model::select('id')
                    ->whereIn('meciID', $meciuriPlayOffOutID)
                    ->where('golSauAssist', '=', '1')
                    ->where('echipaID', '!=', $echipa['id'])
                    ->whereIn('meciID', $meciuriID)
                    ->get());
                
                $echipa['nrGoluriPrimite'] = $nrGoluriPrimite;
            }

            foreach ($echipe as $echipa){
                if($echipa['nrGoluriPrimite'] == 0)
                    $echipa['medieGoluri'] = round($echipa['nrGoluriInscrise'], 2);
                else
                    $echipa['medieGoluri'] = round($echipa['nrGoluriInscrise']/$echipa['nrGoluriPrimite'], 2);
            }
            
            $statisticiEchipe = [];
            $statisticiEchipe['goluriInscriseDesc'] = array_slice(collect($echipe)->sortByDesc('nrGoluriInscrise')->toArray(), 0, 5, true);
            $statisticiEchipe['goluriInscriseAsc'] = array_slice(collect($echipe)->sortBy('nrGoluriInscrise')->toArray(), 0, 5, true);
            $statisticiEchipe['goluriPrimiteDesc'] = array_slice(collect($echipe)->sortByDesc('nrGoluriPrimite')->toArray(), 0, 5, true);
            $statisticiEchipe['goluriPrimiteAsc'] = array_slice(collect($echipe)->sortBy('nrGoluriPrimite')->toArray(), 0, 5, true);
            $statisticiEchipe['medieGoluriDesc'] = array_slice(collect($echipe)->sortByDesc('medieGoluri')->toArray(), 0, 5, true);
            $statisticiEchipe['medieGoluriAsc'] = array_slice(collect($echipe)->sortBy('medieGoluri')->toArray(), 0, 5, true);

            return view('sezon-statistici', [
                'faza' => $faza,
                'statisticiJucatori' => $statisticiJucatori,
                'statisticiEchipe' => $statisticiEchipe
            ]);
        }
    }
}
