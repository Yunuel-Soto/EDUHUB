<?php

namespace App\Http\Controllers;

use App\Models\career;
use App\Models\relation_sub_career;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $req)
    {
        $user = Auth::user();

        if(!$user) {
            return redirect()->route('shLogin');
        }

        if(!$user->getRoles('ROLE_SUPERADMIN') or !$user->getRoles('ROLE_ADMIN')) {
            return redirect()->route('home');
        }

        $subject = new Subject();

        $subject->name = $req->nameSubject;
        $subject->save();

        $careers = career::all();

        foreach ($careers as $key => $career) {
            if($req->has($career->id)) {
                $relationSubCareer = new relation_sub_career();

                $relationSubCareer->career_id = $career->id;
                $relationSubCareer->subject_id = $subject->id;
                $relationSubCareer->save();
            }
        }

        return redirect()->route('indexCatalogs')->with('saved_subject', 'abc');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, Subject $subject)
    {
        $user = Auth::user();

        if(!$user) {
            return redirect()->route('shLogin');
        }

        if(!$user->getRoles('ROLE_SUPERADMIN') or !$user->getRoles('ROLE_ADMIN')) {
            return redirect()->route('home');
        }

        $subject->update([
            'name' => $req->nameSubject[$subject->id],
        ]);


        $careers = career::all();

        foreach ($careers as $key => $career) {
            if($req->has('check-' . $career->id . '-' . $subject->id)) {
                $relationSubCareer = relation_sub_career::where('career_id',$career->id)
                    ->where('subject_id', $subject->id)
                    ->get();

                if(count($relationSubCareer) == 0) {
                    $relationSubCareer = new relation_sub_career();

                    $relationSubCareer->career_id = $career->id;
                    $relationSubCareer->subject_id = $subject->id;
                    $relationSubCareer->save();
                }

            } else {
                $list = $subject->relationSubCareer;
                $relartionWCareer = $list->where('career_id', '=', $career->id);

                if(count($relartionWCareer) > 0) {
                    foreach ($relartionWCareer as $key => $relartion) {
                        $relartion->delete();
                    }
                }
            }
        }


        return redirect()->route('indexCatalogs')->with('updateSuccess', 'abc');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $user = Auth::user();

        if(!$user) {
            return redirect()->route('shLogin');
        }

        if(!$user->getRoles('ROLE_SUPERADMIN') or !$user->getRoles('ROLE_ADMIN')) {
            return redirect()->route('home');
        }

        $subject->delete();

        return redirect()->route('indexCatalogs');
    }
}