<?php

namespace App\Http\Controllers;

use App\Models\career;
use App\Models\Group;
use App\Models\relation_sub_career;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Undefined;

class CareerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('shLogin');
        }

        if(!$user->getRoles('ROLE_SUPERADMIN') or !$user->getRoles('ROLE_ADMIN')) {
            return redirect()->route('home');
        }

        $careers = career::all();
        $subjects = Subject::all();
        $groups = Group::all();

        return view('catalogos/career/index', array(
            'careers' => $careers,
            'subjects' => $subjects,
            'groups' => $groups
        ));
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

        $count = $req->count;

        $career = new Career();

        $career->name = $req->nameCareer;
        $career->save();

        for($i = 1; $i <= $count; $i++) {
            $subjects = Subject::where('name','=', $req->nameSubject[$i])->get();
            if(count($subjects) == 0) {
                $subject = new Subject();
            } else {
                $subject = $subjects[0];
            }

            $subject->name = $req->nameSubject[$i];
            $subject->save();
            $relationSubCareer = new relation_sub_career();
            $relationSubCareer->career_id = $career->id;
            $relationSubCareer->subject_id = $subject->id;
            $relationSubCareer->save();
        }

        return redirect()->route('indexCatalogs')->with('saved_career', 'abc');
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
    public function show(career $career)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(career $career)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, career $career)
    {
        $user  = Auth::user();

        if(!$user) {
            return redirect()->route('shLogin');
        }

        if(!$user->getRoles('ROLE_SUPERADMIN') or !$user->getRoles('ROLE_ADMIN')) {
            return redirect()->route('home');
        }

        $career->update([
            'name' => $req->nameCareer[$career->id],
        ]);

        $count = $req->count;
        $lastNumber = 1;

        foreach ($career->relationSubCareer as $key => $list) {
            if(isset($req->nameSubject[$career->id][$list->subject->id])){
                $list->subject->update([
                    'name' => $req->nameSubject[$career->id][$list->subject->id],
                ]);
            } else {
                $list->delete();
            }
            $lastNumber = $list->subject->id;
        }

        // $count = 0;

        if($lastNumber != $count) {
            for ($i = $lastNumber + 1; $i <= $count; $i++) {
                if(isset($req->nameSubject[$career->id][$i])) {
                    $subjects = Subject::where('name','=', $req->nameSubject[$career->id][$i])->get();
                    if(count($subjects) == 0) {
                        $subject = new Subject();
                    } else {
                        $subject = $subjects[0];
                    }

                    $subject->name = $req->nameSubject[$career->id][$i];
                    $subject->save();
                    $relationSubCareer = new relation_sub_career();
                    $relationSubCareer->career_id = $career->id;
                    $relationSubCareer->subject_id = $subject->id;
                    $relationSubCareer->save();
                }

            }
        }


        return redirect()->route('indexCatalogs')->with('saved', 'abc');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(career $career)
    {
        $user = Auth::user();

        if(!$user) {
            return redirect()->route('shLogin');
        }

        if(!$user->getRoles('ROLE_SUPERADMIN') or !$user->getRoles('ROLE_ADMIN')) {
            return redirect()->route('home');
        }

        $career->delete();

        return redirect()->route('indexCatalogs');
    }
}