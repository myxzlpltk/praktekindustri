<?php

namespace App\DataTables;

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
		return datatables()
			->eloquent($query)
			->addColumn('action', function (Student $student){
				return '<a href="'.route('students.show', $student).'" class="btn btn-primary btn-sm">Lihat</a>';
			})
			->editColumn('name', function (Student $student){
				return $student->user->name;
			})
			->editColumn('prodi', function (Student $student){
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
		return $model->newQuery()
			->with(['user', 'prodi'])
			->select($model->getTable().".*");;
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
			Column::make('nim')->title('NIM'),
			Column::make('name', 'user.name')->title('Nama Mahasiswa'),
			Column::make('prodi', 'prodi.name')->title('Program Studi'),
			Column::make('angkatan')->title('Tahun Angkatan'),
			Column::make('action')->title('Aksi')
				->orderable(false)
				->searchable(false),
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
