<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Echipe_22_23_Model;
use App\Models\Clasament_22_23_Model;

class ClasamentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function indexAdminSR()
    {
        $echipe = Echipe_22_23_Model::select('id', 'numeEchipa')->orderBy('id', 'asc')->get();
        
        $echipeID = [];
        $echipeNume = [];

        foreach ($echipe as $echipa){
            array_push($echipeID, $echipa['id']);
            array_push($echipeNume, $echipa['numeEchipa']);
        }
        $echipe = array_combine($echipeID, $echipeNume);

        return view('admin/clasament/index', [
            'clasament' => Clasament_22_23_Model::where('faza', '=', 'sezon regulat')->orderBy('pozitie')->get(),
            'echipe' => $echipe,
            'faza' => 'sezon regulat'
        ]);
    }

    public function indexAdminPOF()
    {
        $echipe = Echipe_22_23_Model::select('id', 'numeEchipa')->orderBy('id', 'asc')->get();
        
        $echipeID = [];
        $echipeNume = [];

        foreach ($echipe as $echipa){
            array_push($echipeID, $echipa['id']);
            array_push($echipeNume, $echipa['numeEchipa']);
        }
        $echipe = array_combine($echipeID, $echipeNume);

        return view('admin/clasament/index', [
            'clasament' => Clasament_22_23_Model::where('faza', '=', 'play off')->orderBy('pozitie')->get(),
            'echipe' => $echipe,
            'faza' => 'play off'
        ]);
    }

    public function indexAdminPOU()
    {
        $echipe = Echipe_22_23_Model::select('id', 'numeEchipa')->orderBy('id', 'asc')->get();
        
        $echipeID = [];
        $echipeNume = [];

        foreach ($echipe as $echipa){
            array_push($echipeID, $echipa['id']);
            array_push($echipeNume, $echipa['numeEchipa']);
        }
        $echipe = array_combine($echipeID, $echipeNume);

        return view('admin/clasament/index', [
            'clasament' => Clasament_22_23_Model::where('faza', '=', 'play out')->orderBy('pozitie')->get(),
            'echipe' => $echipe,
            'faza' => 'play out'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSR()
    {
        $echipeID = Echipe_22_23_Model::select('id')->orderBy('numeEchipa')->get();
        $pozitie = 1;
        foreach ($echipeID as $echipaID){
            $intrare = new Clasament_22_23_Model;
            $intrare->faza = 'sezon regulat';
            $intrare->echipaID = $echipaID->id;
            $intrare->pozitie = $pozitie;
            $intrare->meciuriJucate = 0;
            $intrare->victorii = 0;
            $intrare->egaluri = 0;
            $intrare->infrangeri = 0;
            $intrare->save();
            $pozitie++;
        }

        return redirect('admin');
    }

    public function storePO()
    {
        $intrare = new Clasament_22_23_Model;
        $intrare->faza = 'play out';
        $intrare->echipaID = 1;
        $intrare->pozitie = 1;
        $intrare->meciuriJucate = 0;
        $intrare->victorii = 0;
        $intrare->egaluri = 0;
        $intrare->infrangeri = 0;
        $intrare->punctaj = 0;
        $intrare->save();

        return redirect('admin');
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
    public function update($faza, $echipaID, $coloana, $update)
    {
        if(Clasament_22_23_Model::where('faza', '=', $faza)->where('echipaID', '=', $echipaID)->first()[$coloana] == 0 && $update == 'minus'){
            if($faza == 'sezon regulat') return redirect('admin-clasament-sezon-regulat');
                else if($faza == 'play off') return redirect('admin-clasament-play-off');
                    else return redirect('admin-clasament-play-out');
        }

        if($update == 'plus'){
            Clasament_22_23_Model::where('faza', '=', $faza)->where('echipaID', '=', $echipaID)->increment($coloana, 1);
        }
        else{
            Clasament_22_23_Model::where('faza', '=', $faza)->where('echipaID', '=', $echipaID)->decrement($coloana, 1);
        }

        if($faza == 'sezon regulat') return redirect('admin-clasament-sezon-regulat');
            else if($faza == 'play off') return redirect('admin-clasament-play-off');
                else return redirect('admin-clasament-play-out');
    }

    public function refresh($faza) {
        $echipe = Clasament_22_23_Model::select('echipaID', Clasament_22_23_Model::raw('victorii*3+egaluri as pct, victorii+egaluri+infrangeri as mj'))->where('faza', '=', $faza)->orderBy('punctaj', 'DESC')->get();

        foreach ($echipe as $echipa){
            Clasament_22_23_Model::where('echipaID', '=', $echipa->echipaID)->update([
                'meciuriJucate' => $echipa->mj,
                'punctaj' => $echipa->pct
            ]);
        }

        Clasament_22_23_Model::where('faza', '=', $faza)->where('echipaID', '=', 14)->decrement('punctaj', 9); //exceptie

        $echipe = Clasament_22_23_Model::select('echipaID')->where('faza', '=', $faza)->orderBy('punctaj', 'DESC')->get();
        $i = 1;
        foreach ($echipe as $echipa){
            Clasament_22_23_Model::where('echipaID', '=', $echipa->echipaID)->where('faza', '=', $faza)->update([
                'pozitie' => $i
            ]);
            $i++;
        }

        if($faza == 'sezon regulat') return redirect('admin-clasament-sezon-regulat');
            else if($faza == 'play off') return redirect('admin-clasament-play-off');
                else return redirect('admin-clasament-play-out');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
