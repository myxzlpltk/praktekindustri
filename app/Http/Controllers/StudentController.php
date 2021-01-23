<?php

namespace App\Http\Controllers;

use App\DataTables\StudentDataTable;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentController extends Controller{

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(StudentDataTable $dataTable){
		return $dataTable->render('students.index');
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
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Student $student){
        return view('students.show', [
        	'student' => $student
		]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\RedirectResponse
	 */
    public function destroy(Student $student){
		$student->delete();

		return redirect()->route('students.index')->with([
			'success' => 'Data mahasiswa berhasil dihapus.'
		]);
    }

	/**
	 * Reset password student.
	 *
	 * @param  \App\Models\Student  $student
	 * @return \Illuminate\Http\RedirectResponse
	 */
    public function resetPassword(Student $student){
    	$newPassword = Str::random(16);
    	$student->user->password = Hash::make($newPassword);
    	$student->user->save();

    	return redirect()->route('students.show', $student)->with([
    		'success' => 'Kata sandi berhasil direset. Kata sandi baru : '.$newPassword
		]);
	}
}
