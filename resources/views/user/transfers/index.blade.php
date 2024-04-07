@extends('layouts.app')
@section('css')
	<!-- Data Table CSS -->
	<link href="{{URL::asset('plugins/datatable/datatables.min.css')}}" rel="stylesheet" />
	<!-- Sweet Alert CSS -->
	<link href="{{URL::asset('plugins/sweetalert/sweetalert2.min.css')}}" rel="stylesheet" />
	<link href="{{URL::asset('plugins/photoviewer/photoviewer.min.css')}}" rel="stylesheet" />
	<link href="{{URL::asset('plugins/plyr/plyr.css')}}" rel="stylesheet" />
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="Stylesheet" type="text/css" />
@endsection
@section('page-header')
<!-- PAGE HEADER -->
<div class="page-header mt-5-7">
	<div class="page-leftheader">
		<h4 class="page-title mb-0">{{ __('My Transfer List') }}</h4>
		<ol class="breadcrumb mb-2">
			<li class="breadcrumb-item"><a href="{{route('user.dashboard')}}"><i class="fa-solid fa-box-circle-check mr-2 fs-12"></i>{{ __('User') }}</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="{{url('#')}}"> {{ __('My Transfer List') }}</a></li>
		</ol>
	</div>
</div>
<!-- END PAGE HEADER -->
@endsection
@section('content')	
	<div class="row">

		<div class="row pr-0">
			<div class="col-lg-4 col-md-12 col-sm-12">
				<div class="card mb-5 border-0">
					<div class="card-body d-flex">
						<div class="usage-info w-100">
							<p class=" mb-0 fs-12 font-weight-bold">{{ __('Total Transfered Files') }}</p>
							<h2 class="mb-1 mt-2 number-font-light font-weight-800">{{ number_format($storage['total']) }}</h2>
						</div>
						<div class="usage-icon text-right">
							<i class="fa-solid fa-cloud-arrow-up"></i>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12">
				<div class="card mb-5 border-0">
					<div class="card-body d-flex">
						<div class="usage-info w-100">
							<p class=" mb-0 fs-12 font-weight-bold">{{ __('Total Shared via Link') }}</p>
							<h2 class="mb-1 mt-2 number-font-light font-weight-800">{{ number_format($storage['links']) }}</h2>
						</div>
						<div class="usage-icon text-right">
							<i class="fa-solid fa-link"></i>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12">
				<div class="card mb-5 border-0">
					<div class="card-body d-flex">
						<div class="usage-info w-100">
							<p class=" mb-0 fs-12 font-weight-bold">{{ __('Total Shared via Emails') }}</p>
							<h2 class="mb-1 mt-2 number-font-light font-weight-800">{{ number_format($storage['email']) }}</h2>
						</div>
						<div class="usage-icon text-right">
							<i class="fa-solid fa-envelope-circle-check"></i>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-12 col-md-12 col-xm-12">
			<div class="card border-0">
				<div class="card-body">
					<a id="refresh-button" class="refresh-button special-refresh" href="#" data-tippy-content="Refresh Table"><i class="fa-solid fa-arrows-rotate table-action-buttons view-action-button"></i></a>
					<!-- SET DATATABLE -->
					<table id='resultsTable' class='table' width='100%'>
							<thead>
								<tr>
									<th width="15%">{{ __('File Name') }}</th>
									<th width="5%">{{ __('Share Type') }}</th>
									<th width="3%">{{ __('Format') }}</th>		
									<th width="5%">{{ __('Size') }}</th>																																           	   
									<th width="5%">{{ __('Password') }}</th>																																           	   
									<th width="5%">{{ __('Downloads') }}</th>																																           	   
									<th width="5%">{{ __('Transfered On') }}</th>  					           							           	
									<th width="5%">{{ __('Expires On') }}</th>  					           							           	
									<th width="5%">{{ __('Actions') }}</th>
								</tr>
							</thead>
					</table> <!-- END SET DATATABLE -->
				</div>
			</div>
		</div>
	</div>

	<!-- AUDIO PLAYER MODAL -->
	<div class="modal fade" id="audio-player-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-keyboard="false">
		<div class="modal-dialog modal-dialog-centered modal-md" role="document">
			<div class="modal-content p-4">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel"><i class="fas fa-music"></i> Audio Player</h4>
						<button type="button" class="btn-close fs-12" data-bs-dismiss="modal" aria-label="Close"></button>		        	
					</div>

					<!-- AUDIO PLAYER -->
					<div id="audio-player-box">
						<audio id="audio-player"></audio>	
					</div>

			</div>
		</div>
	</div> <!-- END AUDIO PLAYER MODAL -->

	<!-- VIDEO PLAYER MODAL -->
	<div class="modal fade" id="video-player-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-keyboard="false">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		  	<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel"><i class="fas fa-film"></i> Video Player</h4>
					<button type="button" class="btn-close fs-12" data-bs-dismiss="modal" aria-label="Close"></button>		        	
				</div>

				<!-- AUDIO PLAYER -->
				<div id="video-player-box">
					<audio id="video-player"></audio>	
				</div>

		  	</div>
		</div>
  	</div> <!-- END VIDEO PLAYER MODAL -->
@endsection

@section('js')
<!-- Data Tables JS -->
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
<script src="{{URL::asset('plugins/datatable/datatables.min.js')}}"></script>
<script src="{{URL::asset('plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
<script src="{{URL::asset('plugins/tippy/popper.min.js')}}"></script>
<script src="{{URL::asset('plugins/tippy/tippy-bundle.umd.min.js')}}"></script>
<script src="{{URL::asset('plugins/tippy/tippy-bundle.umd.min.js')}}"></script>
<script src="{{URL::asset('plugins/photoviewer/photoviewer.min.js')}}"></script>
<script src="{{URL::asset('plugins/plyr/plyr.min.js')}}"></script>
<script src="{{URL::asset('js/process.js')}}"></script>
<script type="text/javascript">
	$(function () {

		"use strict";
		

		let table = $('#resultsTable').DataTable({
			"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
			responsive: true,
			colReorder: true,
			"order": [ 6, "desc" ],
			language: {
				"emptyTable": "<div><img id='no-results-img' src='{{ URL::asset('img/files/no-result.png') }}'><br>{{ __('No files transfered yet') }}</div>",
				search: "<i class='fa fa-search search-icon'></i>",
				lengthMenu: '_MENU_ ',
				paginate : {
					first    : '<i class="fa fa-angle-double-left"></i>',
					last     : '<i class="fa fa-angle-double-right"></i>',
					previous : '<i class="fa fa-angle-left"></i>',
					next     : '<i class="fa fa-angle-right"></i>'
				}
			},
			pagingType : 'full_numbers',
			processing: true,
			serverSide: true,
			ajax: "{{ route('user.transfer.list') }}",
			columns: [
				{
					data: 'custom-name',
					name: 'custom-name',
					orderable: true,
					searchable: true
				},					
				{
					data: 'custom-type',
					name: 'custom-type',
					orderable: true,
					searchable: true
				},
				{
					data: 'custom-format',
					name: 'custom-format',
					orderable: true,
					searchable: true
				},			
				{
					data: 'custom-size',
					name: 'custom-size',
					orderable: true,
					searchable: true
				},
				{
					data: 'custom-protected',
					name: 'custom-protected',
					orderable: true,
					searchable: true
				},
				{
					data: 'downloads',
					name: 'downloads',
					orderable: true,
					searchable: true
				},
				{
					data: 'created-on',
					name: 'created-on',
					orderable: true,
					searchable: true
				},		
				{
					data: 'expires-on',
					name: 'expires-on',
					orderable: true,
					searchable: true
				},			
				{
					data: 'actions',
					name: 'actions',
					orderable: false,
					searchable: false
				},
			]
		});


		// DELETE FILE
		$(document).on('click', '.deleteTransferButton', function(e) {

			e.preventDefault();

			Swal.fire({
				title: '{{ __('Confirm File Deletion') }}',
				text: '{{ __('It will permanently delete this file') }}',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: '{{ __('Delete') }}',
				reverseButtons: true,
			}).then((result) => {
				if (result.isConfirmed) {
					let formData = new FormData();
					formData.append("id", $(this).attr('id'));
					$.ajax({
						headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
						method: 'post',
						url: 'delete',
						data: formData,
						processData: false,
						contentType: false,
						success: function (data) {
							if (data['status'] == 'success') {
								Swal.fire('{{ __('File Deleted') }}', '{{ __('File has been successfully deleted') }}', 'success');	
								$("#resultsTable").DataTable().ajax.reload();								
							} else {
								Swal.fire('{{ __('Delete Failed') }}', data['message'], 'error');
							}      
						},
						error: function(data) {
							Swal.fire('Oops...','Something went wrong!', 'error')
						}
					})
				} 
			})
		});


		$('#refresh-button').on('click', function(e){
			e.preventDefault();
			$("#resultsTable").DataTable().ajax.reload();
		});


	});
</script>
@endsection