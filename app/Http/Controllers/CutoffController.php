<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\cutoff2022;
use Illuminate\Http\Request;
use App\Models\CollegeProgram;

class CutoffController extends Controller
{
    public function doIt(Request $request){
        $cutoff2022 = cutoff2022::all();

        foreach($cutoff2022 as $cutoff){
            $collegeProgram = CollegeProgram::where('college_id', $cutoff->CollegeID)->where('program_id', $cutoff->ProgramID)->first();
            $collegeProgram->year = '2022';
            $collegeProgram->cutoff = $cutoff->EntranceRank;
            $collegeProgram->save();
        }
        return response()->json(CollegeProgram::select('cutoff', 'year')->get());
    }

    public function getCollegePrograms(Request $request){
        $college = $request->college;
        $col = College::where('code', $college)
            ->with(['programs' => function ($query) {
                $query->select('code', 'name');
            }])
            ->first();

        $programs = $col->programs;

        $_programs = [];
        foreach ($programs as $program){
            $prog = [
                'programs' => [
                    "code" => $program->code,
                    "name" => $program->name
                ]
                ];
            $_programs[] = $prog;
        }
        return response()->json($_programs);
    }
}
