@extends('layouts.app')
@section('css')
	<!-- Data Table CSS -->
	<link href="{{URL::asset('plugins/datatable/datatables.min.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
<!-- PAGE HEADER -->
<div class="page-header mt-5-7">
	<div class="page-leftheader">
		<h4 class="page-title mb-0">{{ __('Search Results Data') }}</h4>
		<ol class="breadcrumb mb-2">
			<li class="breadcrumb-item"><a href="{{route('user.dashboard')}}"><i class="fa fa-search mr-2 fs-12"></i>{{ __('User') }}</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="{{url('#')}}"> {{ __('Search Results') }}</a></li>
		</ol>
	</div>
</div>
<!-- END PAGE HEADER -->
@endsection
@section('content')	
	<div class="row">
		<div class="col-lg-12 col-md-12 col-xm-12">
			<div class="card border-0">
				<div class="card-header">
					<h3 class="card-title">{{ __('Seach Keyword') }}: <span class="text-info">{{ $searchValue }}</span></h3>
				</div>
				<div class="card-body pt-4">
					<!-- SET DATATABLE -->
					<table id='resultsTable' class='table' width='100%'>
							<thead>
								<tr>
									<th width="15%">{{ __('File Name') }}</th>
									<th width="5%">{{ __('Share Type') }}</th>
									<th width="3%">{{ __('Format') }}</th>		
									<th width="5%">{{ __('Size') }}</th>																																           	   
									<th width="5%">{{ __('Password') }}</th>																																           	   
									<th width="5%">{{ __('Private') }}</th>																																           	   
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
@endsection

@section('js')
<!-- Data Tables JS -->
<script src="{{URL::asset('plugins/datatable/datatables.min.js')}}"></script>
<script type="text/javascript">
	$(function () {
		
		"use strict";


		var data = <?php echo $data; ?>;

		let table = $('#resultsTable').DataTable({
			"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
			responsive: true,
			colReorder: true,
			"order": [[ 6, "desc" ]],
			language: {
				"emptyTable": "<div><img id='no-results-img' src='{{ URL::asset('img/files/no-result.png') }}'><br>{{ __('No search results were found') }}</div>",
			},
			"bFilter": false,
			"paging": false,
			pagingType : 'full_numbers',
			processing: false,
			serverSide: false,
			data: data.original.data,
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
					data: 'private-link',
					name: 'private-link',
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

	});
</script>
@endsection