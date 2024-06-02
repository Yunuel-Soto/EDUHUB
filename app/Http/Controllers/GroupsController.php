<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupHasCareer;
use App\Models\TeachersHasGroups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupsController extends Controller
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


        $group = new Group();

        $group->name = $req->nameGroup;
        $group->quota = $req->quota;
        $group->duration = $req->duration;
        $group->career_id = $req->career;
        $group->save();

        return redirect()->route('indexCatalogs')->with('saved_group', 'abc');
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
    public function show(Group $groups)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $groups)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, Group $group)
    {
        $user = Auth::user();

        if(!$user) {
            return redirect()->route('shLogin');
        }

        if(!$user->getRoles('ROLE_SUPERADMIN') or !$user->getRoles('ROLE_ADMIN')) {
            return redirect()->route('home');
        }


        $group->update([
            'name' => $req->nameGroup,
            'quota' => $req->quota,
            'duration' => $req->duration,
            'career_id' => $req->career
        ]);

        return redirect()->route('indexCatalogs')->with('update_group', 'abc');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $user = Auth::user();

        if(!$user) {
            return redirect()->route('shLogin');
        }

        if(!$user->getRoles('ROLE_SUPERADMIN') or !$user->getRoles('ROLE_ADMIN')) {
            return redirect()->route('home');
        }

        $group->delete();

        return redirect()->route('indexCatalogs');
    }
}
