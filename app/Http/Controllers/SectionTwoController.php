<?php

namespace App\Http\Controllers;

use App\Models\Section_two;
use Illuminate\Http\Request;

class SectionTwoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('section_twos.index');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section_two  $section_two
     * @return \Illuminate\Http\Response
     */
    public function show(Section_two $section_two)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section_two  $section_two
     * @return \Illuminate\Http\Response
     */
    public function edit(Section_two $section_two)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section_two  $section_two
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section_two $section_two)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section_two  $section_two
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section_two $section_two)
    {
        //
    }
}
