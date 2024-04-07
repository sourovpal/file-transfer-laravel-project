@extends('layouts.app')
@section('css')
	<!-- Data Table CSS -->
	<link href="{{URL::asset('plugins/datatable/datatables.min.css')}}" rel="stylesheet" />
	<!-- Sweet Alert CSS -->
	<link href="{{URL::asset('plugins/sweetalert/sweetalert2.min.css')}}" rel="stylesheet" />
	<!-- FilePond CSS -->
	<link href="{{URL::asset('plugins/filepond/filepond-plugin-image-preview.css')}}" rel="stylesheet" />
	<link href="{{URL::asset('plugins/filepond/filepond.css')}}" rel="stylesheet" />
	<link href="{{URL::asset('plugins/awselect/awselect.min.css')}}" rel="stylesheet" />
	<link href="{{URL::asset('plugins/photoviewer/photoviewer.min.css')}}" rel="stylesheet" />
	<link href="{{URL::asset('plugins/plyr/plyr.css')}}" rel="stylesheet" />
	<link href="{{URL::asset('plugins/datetimepicker/jquery.datetimepicker.min.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
<!-- PAGE HEADER -->
<div class="page-header mt-5-7">
	<div class="page-leftheader">
		<h4 class="page-title mb-0">{{ __('Transfer File') }}</h4>
		<ol class="breadcrumb mb-2">
			<li class="breadcrumb-item"><a href="{{route('user.dashboard')}}"><i class="fa-solid fa-shuffle mr-2 fs-12"></i>{{ __('User') }}</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="{{url('#')}}"> {{ __('Transfer File') }}</a></li>
		</ol>
	</div>
</div>
<!-- END PAGE HEADER -->
@endsection
@section('content')	
	<div class="row">

	
		<div class="col-lg-3 col-md-12 col-sm-12">
			<form id="multipartupload" action="" method="post" enctype="multipart/form-data">		
				@csrf

				<div class="card border-0">
					<div class="card-body">						
						<!-- DRAG & DROP FILES -->
						<div class="select-file">
							<input type="file" name="filepond" id="filepond" class="filepond" multiple data-allow-reorder="true" required  />	
						</div>						
					</div>
				</div>

				<div class="card border-0">
					<div class="card-body p-5 pb-0">

						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">	
									<h6 class="fs-11 mb-2 font-weight-bold">{{ __('Transfer Type') }}</h6>								
									<select id="type" name="type" data-placeholder="{{ __('Select file share option') }}" data-callback="typeChanged">		
										<option value="link" @if (config('settings.default_share_method') == 'link') selected @endif>{{ __('Link') }}</option>
										<option value="email" @if (config('settings.default_share_method') == 'email') selected @endif>{{ __('Email') }}</option>									
									</select>
									@error('type')
										<p class="text-danger">{{ $errors->first('type') }}</p>
									@enderror	
								</div>
							</div>

							<div class="col-sm-12">								
								<div class="input-box email-box">								
									<h6 class="fs-11 mb-2 font-weight-bold">{{ __('Send To') }}  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<div class="form-group">							    
										<input type="text" class="form-control @error('email-to') is-danger @enderror" id="email-to" name="email_to" autocomplete="off">
										@error('email-to')
											<p class="text-danger">{{ $errors->first('email-to') }}</p>
										@enderror
									</div> 
								</div> 
							</div>

							<div class="col-sm-12">								
								<div class="input-box email-box">								
									<h6 class="fs-11 mb-2 font-weight-bold">{{ __('Send From') }}  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<div class="form-group">							    
										<input type="text" class="form-control @error('email-from') is-danger @enderror" id="email-from" name="email_from" autocomplete="off">
										@error('email-from')
											<p class="text-danger">{{ $errors->first('email-from') }}</p>
										@enderror
									</div> 
								</div> 
							</div>

							<div class="col-sm-12">								
								<div class="input-box email-box">								
									<h6 class="fs-11 mb-2 font-weight-bold">{{ __('Message') }}</h6>
									<div class="form-group">							    
										<textarea class="form-control" id="message" rows="6" name="message" placeholder="Include your email message (Optional)"></textarea>
									</div> 
								</div> 
							</div>

							@if ((auth()->user()->group == 'user' && config('settings.link_expiration__feature_user') == 'enable') || auth()->user()->group == 'subscriber')
								<div class="col-sm-12">
									<div id="form-group">
										<h6 class="fs-11 mb-2 font-weight-bold">{{ __('Link Expiration') }} <i class="ml-1 text-dark fs-12 fa-solid fa-circle-info" data-tippy-content="{{ __('Set a custom date to expire the download link') }}"></i></h6>
										<select id="link-expiration" name="link-expiration" data-placeholder="{{ __('Enable/Disable Link Expiration') }}" data-callback="signedLinkChanged">
											<option value=1 @if (config('settings.link_expiration_default_state') == 'enable') selected @endif>{{ __('Enable') }}</option>
											<option value=0 @if (config('settings.link_expiration_default_state') == 'disable') selected @endif> {{ __('Disable') }}</option>																															
										</select>
									</div>
								</div>

								<div class="col-sm-12">
									<div id="form-group" class="expiration-time-box">
										<h6 class="fs-11 mb-2 font-weight-bold">{{ __('Set Expiration Date') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
										<input type="text" id="datetime" name="link-duration">
									</div>
								</div>
							@elseif (auth()->user()->group == 'admin')
								<div class="col-sm-12">
									<div id="form-group">
										<h6 class="fs-11 mb-2 font-weight-bold">{{ __('Link Expiration') }} <i class="ml-1 text-dark fs-12 fa-solid fa-circle-info" data-tippy-content="{{ __('Set a custom date to expire the download link') }}"></i></h6>
										<select id="link-expiration" name="link-expiration" data-placeholder="{{ __('Enable/Disable Link Expiration') }}" data-callback="signedLinkChanged">
											<option value=1 @if (config('settings.link_expiration_default_state') == 'enable') selected @endif>{{ __('Enable') }}</option>
											<option value=0 @if (config('settings.link_expiration_default_state') == 'disable') selected @endif> {{ __('Disable') }}</option>																															
										</select>
									</div>
								</div>

								<div class="col-sm-12">
									<div id="form-group" class="expiration-time-box">
										<h6 class="fs-11 mb-2 font-weight-bold">{{ __('Set Expiration Date') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
										<input type="text" id="datetime" name="link-duration">
									</div>
								</div>
							@endif

							
							@if ((auth()->user()->group == 'user' && config('settings.password_protection_feature_user') == 'enable') || auth()->user()->group == 'subscriber')
								<div class="col-sm-12">
									<div id="form-group">
										<h6 class="fs-11 mb-2 font-weight-bold">{{ __('Password Protection') }}</h6>
										<select id="password-protection" name="password-protection" data-placeholder="{{ __('Enable/Disable Password Protection') }}" data-callback="passwordChanged">
											<option value=1 @if (config('settings.password_protection_default_state') == 'enable') selected @endif>{{ __('Enable') }}</option>
											<option value=0 @if (config('settings.password_protection_default_state') == 'disable') selected @endif> {{ __('Disable') }}</option>																															
										</select>
									</div>
								</div>

								<div class="col-sm-12">								
									<div class="input-box password-box">								
										<h6 class="fs-11 mb-2 font-weight-bold">{{ __('Password') }}  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
										<div class="form-group">							    
											<input type="text" class="form-control @error('password') is-danger @enderror" id="password-input" name="password" autocomplete="off">
											@error('password')
												<p class="text-danger">{{ $errors->first('password') }}</p>
											@enderror
										</div> 
									</div> 
								</div>
							@elseif (auth()->user()->group == 'admin')
								<div class="col-sm-12">
									<div id="form-group">
										<h6 class="fs-11 mb-2 font-weight-bold">{{ __('Password Protection') }}</h6>
										<select id="password-protection" name="password-protection" data-placeholder="{{ __('Enable/Disable Password Protection') }}" data-callback="passwordChanged">
											<option value=1 @if (config('settings.password_protection_default_state') == 'enable') selected @endif>{{ __('Enable') }}</option>
											<option value=0 @if (config('settings.password_protection_default_state') == 'disable') selected @endif> {{ __('Disable') }}</option>																															
										</select>
									</div>
								</div>

								<div class="col-sm-12">								
									<div class="input-box password-box">								
										<h6 class="fs-11 mb-2 font-weight-bold">{{ __('Password') }}  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
										<div class="form-group">							    
											<input type="text" class="form-control @error('password') is-danger @enderror" id="password-input" name="password" autocomplete="off">
											@error('password')
												<p class="text-danger">{{ $errors->first('password') }}</p>
											@enderror
										</div> 
									</div> 
								</div>
							@endif
						</div>						

						<div class="card-footer border-0 text-center p-0">
							<div class="w-100 pt-2 pb-2">
								<div class="text-center">
									<span id="processing" class="processing-image"><img src="{{ URL::asset('/img/svgs/upgrade.svg') }}" alt=""></span>
									<button type="submit" name="submit" class="btn btn-primary pl-6 pr-6" id="transfer">{{ __('Transfer') }}</button>
								</div>
							</div>							
						</div>							
				
					</div>
				</div>
			</form>
		</div>

		<div class="col-lg-9 col-md-12 col-sm-12">
			<div class="card border-0">
				<div class="card-body">
					<a id="refresh-button" class="refresh-button" href="#" data-tippy-content="Refresh Table"><i class="fa-solid fa-arrows-rotate table-action-buttons view-action-button"></i></a>
					<div class="d-inline border-0">
						<div>
							<h3 class="card-title fs-16 mt-3 mb-4"><i class="fa-solid fa-shuffle mr-4 text-info"></i>{{ __("Today's Transfers") }}</h3>							
						</div>						
					</div>
					<!-- SET DATATABLE -->
					<table id='resultsTable' class='table' width='100%'>
							<thead>
								<tr>
									<th width="12%">{{ __('File Name') }}</th>
									<th width="3%">{{ __('Type') }}</th>	
									<th width="3%">{{ __('Size') }}</th>	
									<th width="1%">{{ __('Password') }}</th>																																           	   
									<th width="1%">{{ __('Downloads') }}</th>																																           	   
									<th width="3%">{{ __('Transfered On') }}</th>  						           							           	
									<th width="3%">{{ __('Expires On') }}</th>  						           							           	
									<th width="5%">{{ __('Actions') }}</th>
								</tr>
							</thead>
					</table> <!-- END SET DATATABLE -->
				</div>
			</div>
		</div>
	</div>

	<!-- DOWNLOAD LINK MODAL -->
	<div class="modal fade" id="linkResultModal" tabindex="-1" role="dialog" aria-labelledby="projectModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
		<div class="modal-dialog modal-dialog-centered modal-md" role="document">
			<div class="modal-content">                                
				<div class="modal-body pb-0 pl-6 pr-6 pt-6">        
					<div class="input-box no-gutters">	    
						<div class="col-sm-12 text-center">			
							<span><i class='fa-solid fa-cloud-check fs-40 mb-4 text-primary'></i></span>
							<h4 class="font-weight-bold fs-22"> {{ __('Download Links Created') }}</h4>
							<p class="mb-4">{{ __('File are successfully uploaded and download links are listed below') }}</p>					
							<div id="files-data">
							</div>
						</div>
					</div>
				</div>
				<div class="text-center pb-3">
					<button type="button" class="btn btn-cancel mb-4" data-bs-dismiss="modal" onclick="resetData()">{{ __('Transfer New File') }}</button>
				</div>                                                    
			</div>
		</div>
	</div>
	<!-- END DOWNLOAD LINK MODAL -->

	<!-- EMAIL DOWNLOAD LINK MODAL -->
	<div class="modal fade" id="emailResultModal" tabindex="-1" role="dialog" aria-labelledby="projectModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
		<div class="modal-dialog modal-dialog-centered modal-md" role="document">
			<div class="modal-content">                                
				<div class="modal-body pb-0 pl-6 pr-6 pt-6">        
					<div class="input-box no-gutters">	    
						<div class="col-sm-12 text-center">			
							<span><i class='fa-solid fa-envelope-circle-check fs-40 mb-4 text-primary'></i></span>
							<h4 class="font-weight-bold fs-22"> {{ __('Email Sent Successfully') }}</h4>
							<p class="mb-4">{{ __('File are successfully uploaded and email has been sent with download links listed below') }}</p>					
							<div id="email-files-data">
							</div>
						</div>
					</div>
				</div>
				<div class="text-center pb-3">
					<button type="button" class="btn btn-cancel mb-4" data-bs-dismiss="modal" onclick="resetData()">{{ __('Transfer New File') }}</button>
				</div>                                                    
			</div>
		</div>
	</div>
	<!-- END EMAIL DOWNLOAD LINK MODAL -->

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
<script src="{{URL::asset('plugins/datatable/datatables.min.js')}}"></script>
<script src="{{URL::asset('plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
<script src="{{URL::asset('plugins/datetimepicker/jquery.datetimepicker.full.min.js')}}"></script>
<!-- FilePond JS -->
<script src={{ URL::asset('plugins/filepond/filepond-plugin-file-validate-size.min.js') }}></script>
<script src={{ URL::asset('plugins/filepond/filepond-plugin-file-validate-type.min.js') }}></script>
<script src={{ URL::asset('plugins/filepond/filepond-plugin-image-preview.js') }}></script>
<script src={{ URL::asset('plugins/filepond/filepond-plugin-image-exif-orientation.js') }}></script>
<script src={{ URL::asset('plugins/filepond/filepond.min.js') }}></script>
<script src="{{URL::asset('js/upload.js')}}"></script>
<!-- Awselect JS -->
<script src="{{URL::asset('plugins/awselect/awselect-custom.js')}}"></script>
<script src="{{URL::asset('js/awselect.js')}}"></script>
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
			"order": [[ 5, "desc" ]],
			language: {
				"emptyTable": "<div><img id='no-results-img' src='{{ URL::asset('img/files/no-result.png') }}'><br>No files were transfered yet</div>",
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
			ajax: "{{ route('user.transfer.upload') }}",
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


		// DELETE TRANSFER
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


		$('#datetime').datetimepicker({
			format:'d M Y H:i:s',
		});



		FilePond.registerPlugin(
			FilePondPluginImagePreview,
			FilePondPluginImageExifOrientation,
			FilePondPluginFileValidateSize,
   			FilePondPluginFileValidateType
		);


		$.ajax({
			headers: {
				'X-CSRF-TOKEN': '{{ csrf_token() }}',
			},
			type: "GET",
			url: 'settings',

		}).done(function(data) {

			$('#files-data').html('');
			$('#email-files-data').html('');
			$('.file-data').html('');

			// SET DEFATUL FILEPOND OPTIONS
			FilePond.setOptions({
				maxFileSize: data['max_file_size'] + 'MB',
				maxFiles: data['max_file_quantity'],
				labelIdle: "{{ __('Drag & Drop files to transfer or') }} <span class=\"filepond--label-action\">{{ __('Browse') }}</span><br><span class='restrictions'><span class='restrictions-highlight'>{{ __('Max Size') }}: " + data['max_file_size'] + "MB, {{ __('Max Files') }}: " + data['max_file_quantity'] + "</span></span>",
				required: true,
				server: {
					process: "tmp-upload",
					revert: "tmp-delete",
					headers: {
						'X-CSRF-TOKEN': '{{ csrf_token() }}',
					},
				},
				labelFileProcessingError: (error) => {
				console.log(error);
			}
			});
		});


		// CREATE FILEPOND INSTANCE
		let pond = FilePond.create(document.querySelector('.filepond'));


		// SUBMIT FORM
		$('#multipartupload').on('submit', function(e) {

			e.preventDefault();

			let form = $(this);

			$.ajax({
				headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
				method: 'POST',
				url: 'upload',
				data: form.serialize(),
				beforeSend: function() {
					$('#transfer').html('');
					$('#transfer').prop('disabled', true);
					$('#processing').show().clone().appendTo('#transfer'); 
					$('#processing').hide();          
				},
				complete: function() {
					$('#transfer').prop('disabled', false);
					$('#processing', '#transfer').empty().remove();
					$('#processing').hide();
					$('#transfer').html('Transfer');            
				},
				success: function (data) {
					
					if (data['status'] == 'success') {
						
						pond.removeFiles({ revert: true });
						$("#resultsTable").DataTable().ajax.reload();

						processLinks(data['links'], data['type']);

						if (data['type'] == 'link') {
                        	setTimeout(() => {  $('#linkResultModal').modal('show'); }, 1000);
						} else {
							setTimeout(() => {  $('#emailResultModal').modal('show'); }, 1000);
						}

					} else {
						Swal.fire('{{ __('File Transfer Error') }}', data['message'], 'warning');
					}
				},
				error: function(data) {
					$('#transfer').prop('disabled', false);
            		$('#transfer').html('Transfer'); 
					console.log(data)
				}
			});
		});
	});

	function processLinks(links, type) {

		let inputLink;

		Object.keys(links).forEach(key => {

  			if (type == 'link') {
				$("<div class='fs-12' />").html("<div class='file-name text-left'><span class='font-weight-bold'>{{ __('File Name') }}</span>: " + key + "</div>").appendTo("#files-data");

				inputLink = '<div class="input-group download-links"> \
									<input type="text" class="form-control link" value="{{ config('app.url') }}/download/' + links[key] + '" readonly> \
									<label class="input-group-btn mb-0"> \
										<button class="btn btn-primary copy-link" type="button" onclick="copy(this)"><i class="fas fa-copy fs-15"></i></button> \
									</label> \
								</div>';

				$("<div class='file-data mb-4' />").html(inputLink).appendTo("#files-data");
			
			} else {
				$("<div class='fs-12' />").html("<div class='file-name text-left'><span class='font-weight-bold'>{{ __('File Name') }}</span>: " + key + "</div>").appendTo("#email-files-data");

				inputLink = '<div class="input-group download-links"> \
									<input type="text" class="form-control link" value="{{ config('app.url') }}/download/' + links[key] + '" readonly> \
									<label class="input-group-btn mb-0"> \
										<button class="btn btn-primary copy-link" type="button" onclick="copy(this)"><i class="fas fa-copy fs-15"></i></button> \
									</label> \
								</div>';

				$("<div class='file-data mb-4' />").html(inputLink).appendTo("#email-files-data");
			}
		});
	}

	function resetData() {

		$('#files-data').html('');
		$('#email-files-data').html('');
		$('.file-data').html('');

		document.getElementById('email-to').value = '';
		document.getElementById('email-from').value = '';
		document.getElementById('message').value = '';
		document.getElementById('password-input').value = '';
	}
</script>
@endsection