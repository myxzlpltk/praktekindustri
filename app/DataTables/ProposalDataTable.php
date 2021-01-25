<?php

namespace App\DataTables;

use App\Helpers\Helper;
use App\Models\Proposal;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProposalDataTable extends DataTable{

	/**
	 * Build DataTable class.
	 *
	 * @param mixed $query Results from query() method.
	 * @return \Yajra\DataTables\DataTableAbstract
	 */
	public function dataTable($query){
		return datatables()
			->eloquent($query)
			->addColumn('action', function (Proposal $proposal){
				return '<a class="btn btn-primary btn-sm" href="'.route('proposals.show', $proposal).'">Detail</a>';
			})
			->editColumn('prodi', function (Proposal $proposal){
				return "{$proposal->student->prodi->name} {$proposal->student->angkatan}";
			})
			->editColumn('angkatan', function (Proposal $proposal){
				return $proposal->student->angkatan;
			})
			->editColumn('tgl_sah', function (Proposal $proposal){
				return $proposal->tgl_sah->translatedFormat('d F Y');
			})
			->filterColumn('tgl_sah', function ($query, $keyword) {
				$query->whereRaw("DATE_FORMAT(tgl_sah,'%d %M %Y') like ?", ["%$keyword%"]);
			})
			->editColumn('status_code', function (Proposal $proposal){
				return '<a class="badge '.Helper::proposalStatusClass($proposal->status_code).'">'.$proposal->status.'</a>';
			})
			->filterColumn('status_code', function ($query, $keyword){
				$keys = collect(Proposal::status)->filter(function ($item) use($keyword){
					return false !== stristr($item, $keyword);
				})->keys()->toArray();

				$query->whereIn('status_code', $keys);
			})
			->editColumn('name', function (Proposal $proposal){
				return '<a href="'.route('students.show', $proposal->student).'">'.e($proposal->student->user->name).'</a>';
			})
			->rawColumns(['status_code', 'action', 'name']);
	}

	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\Models\Proposal $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query(Proposal $model){
		return $model->newQuery()
			->with(['student.user', 'student.prodi'])
			->select($model->getTable().".*");
	}

	/**
	 * Optional method if you want to use html builder.
	 *
	 * @return \Yajra\DataTables\Html\Builder
	 */
	public function html(){
		return $this->builder()
			->setTableId('proposal-table')
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
			Column::make('name', 'student.user.name')->title('Nama Mahasiswa'),
			Column::make('prodi', 'student.prodi.name')->title('Program Studi'),
			Column::make('angkatan', 'student.angkatan')->hidden(),
			Column::make('lokasi_prakerin')->title('Nama Industri/Instansi'),
			Column::make('tgl_sah')->title('Tanggal Pengesahan'),
			Column::make('status_code')->title('Status'),
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
		return 'Proposal_' . date('YmdHis');
	}
}
