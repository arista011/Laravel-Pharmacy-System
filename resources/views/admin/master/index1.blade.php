@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')

@endpush

@push('page-header')
<div class="col-sm-7 col-auto">
	<h3 class="page-title">Supplier</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item active">Supplier</li>
	</ul>
</div>
<div class="col-sm-5 col">
	<a href="{{route('suppliers.index')}}" class="btn btn-primary float-right mt-2">Add New</a>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-md-12">

		<!-- Suppliers -->
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table id="supplier-table" class="datatable table table-hover table-center mb-0">
						<thead>
							<tr>
								<th>Product</th>
								<th>Name</th>
								<th>Phone</th>
								<th>Email</th>
								<th>Address</th>
								<th>Company</th>
								<th class="action-btn">Action</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Add Modal -->
<div class="modal fade" id="add_suppliers" aria-hidden="true" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Supplier</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" action="{{route('supplier.index')}}">
					@csrf
					<div class="row form-row">
						<div class="col-12">
							<div class="form-group">
								<label>Category</label>
								<input type="text" name="name" class="form-control">
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-primary btn-block">Save Changes</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- /ADD Modal -->

<!-- Edit Details Modal -->
<div class="modal fade" id="edit_supplier" aria-hidden="true" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Category</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{route('supplier.index')}}">
					@csrf
					@method("PUT")
					<div class="row form-row">
						<div class="col-12">
							<input type="hidden" name="id" id="edit_id">
							<div class="form-group">
								<label>Category</label>
								<input type="text" class="form-control edit_name" name="name">
							</div>
						</div>

					</div>
					<button type="submit" class="btn btn-primary btn-block">Save Changes</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- /Edit Details Modal -->

@endsection

@push('page-js')
<script>
	$(document).ready(function() {
		var table = $('#supplier-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{route('suppliers.index')}}",
			columns: [{
					data: 'product',
					name: 'product'
				},
				{
					data: 'name',
					name: 'name'
				},
				{
					data: 'email',
					name: 'email'
				},
				{
					data: 'phone',
					name: 'phone'
				},
				{
					data: 'address',
					name: 'address'
				},
				{
					data: 'company',
					name: 'company'
				},
				{
					data: 'action',
					name: 'action',
					orderable: false,
					searchable: false
				},
			]
		});
		$('#supplier-table').on('click', '.editbtn', function() {
			$('#edit_supplier').modal('show');
			var id = $(this).data('id');
			var name = $(this).data('name');
			var email = $(this).data('email');
			var phone = $(this).data('phone');
			var address = $(this).data('address');
			var company = $(this).data('company');
			var product = $(this).data('product');
			$('#edit_id').val(id);
			$('.edit_name').val(name);
			$('.edit_email').val(email);
			$('.edit_phone').val(phone);
			$('.edit_address').val(address);
			$('.edit_company').val(company);
			$('.edit_product').val(product);
		});

	});
</script>
@endpush