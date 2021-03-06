<?php

namespace App\Http\Controllers\Court;

use App\Court;
use Carbon\Carbon;
use App\SportField;
use Illuminate\Http\Request;
use App\Http\Requests\CourtRequest;
use App\Transformers\CourtTransformer;
use App\Http\Controllers\ApiController;

class CourtController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->middleware('transform.input:' . CourtTransformer::class)->only(['store', 'update']);
    }

    public function index()
    {
        $courts = Court::all();
        return $this->showAll($courts);
    }

  public function store(CourtRequest $request)
    {
        $fields                   = $request->all();
        $fields['name']           = ucwords($request->name);     
        $fields['status']         = $request->status;
        $fields['sportfieldid']   = $request->sport_field_id;
        $fields['avatar']         = $request->avatar;
 

        $today = Carbon::now()->toDateTimeString();
        $change_date = str_replace(" ", "-", $today);
        $name = $change_date."-court-".$request->sport_field_id;
       
        if (Sportfield::findOrFail($request->sport_field_id)) {                  
            if (empty($request->avatar)) {
                //set default image 
                $fields['avatar'] = "courts/court.png"; 
            } else {
                $fields['avatar']  = $request->avatar->storeAs('courts', $name);
            }
            $court = Court::create($fields);
        }

        return $this->showOne($court, 201);
    }
    


    public function show(Court $court)
    {
        return $this->showOne($court);        
    }

    public function update(Request $request, Court $court)
    {
        if ($request->has('name')) {
            $court->name = $request->name;
        }

        if ($request->has('status')) {
            $court->status = $request->status;
        }

        if (!$court->isDirty()) {
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
        }

        $court->save();
        return $this->showOne($court);
    }

    public function destroy(Court $court) //court seria una inyeccion de dependencias, con esto nos ahorramos codear: $court = findOrFail($id);
    {
        $court->delete();
        return $this->showOne($court);
    }
}
