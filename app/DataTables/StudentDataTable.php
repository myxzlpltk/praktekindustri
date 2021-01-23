<?php

namespace App\DataTables;

use App\Models\Prodi;
use App\Models\Student;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class StudentDataTable extends DataTable{

	/**
	 * Build DataTable class.
	 *
	 * @param mixed $query Results from query() method.
	 * @return \Yajra\DataTables\DataTableAbstract
	 */
	public function dataTable($query){
		$query->with(['user', 'prodi']);

		return datatables()
			->eloquent($query)
			->with('user')
			->addColumn('action', function (Student $student){
				return '<a href="'.route('students.show', $student).'" class="btn btn-primary btn-sm">Lihat</a>';
			})
			->addColumn('name', function (Student $student){
				return $student->user->name;
			})
			->addColumn('prodi', function (Student $student){
				return $student->prodi->name;
			});
	}

	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\Models\Student $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query(Student $model){
		return $model->newQuery();
	}

	/**
	 * Optional method if you want to use html builder.
	 *
	 * @return \Yajra\DataTables\Html\Builder
	 */
	public function html(){
		return $this->builder()
			->setTableId('student-table')
			->columns($this->getColumns())
			->minifiedAjax()
			->orderBy(0, 'asc')
			->parameters([
				'language' => [
					'url' => asset('vendor/datatables/id.json')
				],
			]);
	}

	/**
	 * Get columns.
	 *
	 * @return array
	 */
	protected function getColumns(){
		return [
			Column::make('nim'),
			Column::make('name', 'user.name'),
			Column::make('prodi', 'prodi.name'),
			Column::make('angkatan'),
			Column::make('action')
		];
	}

	/**
	 * Get filename for export.
	 *
	 * @return string
	 */
	protected function filename(){
		return 'Student_' . date('YmdHis');
	}
}
