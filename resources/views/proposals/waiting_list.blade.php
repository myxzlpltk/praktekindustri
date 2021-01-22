@extends('layouts.app')

@section('title', "Daftar Tunggu Proposal")

@push('stylesheets')
@endpush

@section('content')
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-clipboard-list fa-fw"></i>Daftar Tunggu Proposal</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
					 <div class="row">
							<div class="col-sm-12">
								 <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
										<thead>
											 <tr role="row">
													<th rowspan="1" colspan="1" style="width: 38px;">Nama Mahasiswa</th>
													<th rowspan="1" colspan="1" style="width: 61px;">Nama Industri/Instansi</th>
													<th rowspan="1" colspan="1" style="width: 50px;">Tanggal Pengesahan</th>
													<th rowspan="1" colspan="1" style="width: 50px;">Status</th>
													<th rowspan="1" colspan="1" style="width: 50px;">Detail</th>
											 </tr>
										</thead>
										<tbody>
											@forelse ($proposals as $p)
											 <tr role="row">
													<td>{{$p->user->name}}</td>
													<td>{{$p->lokasi_prakerin}}</td>
													<td>{{$p->tgl_sah_view()}}</td>
													<td><a class=
														@if ($p->status == "Tunggu_TTD")
														"badge badge-warning"
														@elseif ($p->status == "Disahkan")
														"badge badge-success"
														@elseif ($p->status == "Ditolak")
														"badge badge-danger"
														@endif
														>{{$p->status}}</a></td>
													<td><a class="btn btn-primary" href="{{ route('proposals.edit', $p->id) }}">Detail</a></td>
												</tr>
											@empty
												<div class="alert alert-danger">
													Data proposal tidak ditemukan.
												</div>
											@endforelse

										</tbody>
										<tfoot>

										</tfoot>
								 </table>
							</div>
					 </div>
				</div>
		 </div>
		 <div class="d-flex justify-content-center">
			{{ $proposals->links() }}
		 </div>

		</div>
	</div>
@endsection

@push('scripts')

@endpush
