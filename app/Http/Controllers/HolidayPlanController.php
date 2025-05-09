<?php

namespace App\Http\Controllers;

use App\Models\HolidayPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PDF;

class HolidayPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $holidayPlans = HolidayPlan::all();
    
        if ($holidayPlans->isEmpty()) {
            return response()->json([
                'message' => 'Não há nenhum plano cadastrado no momento.'
            ], 200);
        }
        
        return response()->json(['message' => 'Aqui estão seus planos cadastrados até o momento!!', $holidayPlans]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'participants' => 'nullable|array',
        ]);

        $holidayPlan = HolidayPlan::create($request->all());

        return response()->json(['message' => 'Plano criado com sucesso!!', $holidayPlan], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $holidayPlan = HolidayPlan::find($id);
    
        if (!$holidayPlan) {
            return response()->json([
                'message' => 'Não há registros para esse número de Plano de Férias!',
            ], 404);
        }
        
        return response()->json(['message' => 'Aqui está o seu plano ' . $holidayPlan->title . '.', $holidayPlan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'participants' => 'nullable|array',
        ]);

        $holidayPlan = HolidayPlan::findOrFail($id);
        $holidayPlan->update($request->all());

        return response()->json(['message' => 'Plano atualizado com sucesso!!', $holidayPlan]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $holidayPlan = HolidayPlan::findOrFail($id);
        $holidayPlan->delete();

        return response()->json([
            'message' => 'Deletado com sucesso!',
        ], 200);
    }

    public function generatePDF($id)
    {
        $holidayPlan = HolidayPlan::findOrFail($id);

        $pdf = PDF::loadView('holiday_plan_pdf', compact('holidayPlan'));

        // Forçar o download com o cabeçalho correto
        return $pdf->download('holiday_plan_' . $holidayPlan->id . '.pdf');
    }
}
