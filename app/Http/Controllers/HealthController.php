<?php

namespace App\Http\Controllers;

use App\Models\health;
use App\Models\Health as ModelsHealth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HealthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if(!$user){
            return redirect()->route('shLogin');
        }

        $healths = Health::all();

        return view('services/index', [
            'healths' => $healths,
        ]);
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

        if(!($user->getRoles('ROLE_ADMIN') or $user->getRoles('ROLE_SUPERADMIN') or $user->getRoles('ROLE_TEACHER'))) {
            return redirect()->route('home');
        }

        $health = new Health();

        if($req->typeContact == "Otro") {
            $health->typeContact = $req->typeContactOther;
        } else {
            $health->typeContact = $req->typeContact;
        }

        $health->name = $req->name;
        $health->address = $req->address;
        $health->phoneNumber = $req->phoneNumber;
        $health->cost = $req->cost;
        $health->save();

        return redirect()->route('indexHealth')->with('create_success', 'success');
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
    public function show(health $health)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(health $health)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, health $health)
    {
        $user = Auth::user();

        if(!$user) {
            return redirect()->route('shLogin');
        }

        if(!($user->getRoles('ROLE_ADMIN') or $user->getRoles('ROLE_SUPERADMIN'))) {
            return redirect()->route('home');
        }

        if($req->healthType == "Otro") {
            $health->typeContact = $req->typeContactOther;
        } else {
            $health->typeContact = $req->healthType;
        }

        $health->name = $req->name;
        $health->address = $req->address;
        $health->phoneNumber = $req->phoneNumber;
        $health->cost = $req->cost;
        $health->save();

        return redirect()->route('indexHealth')->with('update_success', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(health $health)
    {
        $user = Auth::user();

        if(!$user) {
            return redirect()->route('shLogin');
        }

        if(!($user->getRoles('ROLE_ADMIN') or $user->getRoles('ROLE_SUPERADMIN'))) {
            return redirect()->route('home');
        }

        $health->delete();

        return redirect()->route('indexHealth')->with('delete_success', 'success');
    }
}