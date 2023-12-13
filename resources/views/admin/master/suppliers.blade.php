@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')

@endpush

@push('page-header')
<div class="col-sm-7 col-auto">
    <h3 class="page-title">Categories</h3>
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">Categories</li>
    </ul>
</div>
<div class="col-sm-5 col">
    <a href="#add_supplier" data-toggle="modal" class="btn btn-primary float-right mt-2">Add Category</a>
</div>
@endpush

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="suppliers-table" class="datatable table table-striped table-bordered table-hover table-center mb-0">
                        <thead>
                            <tr style="boder:1px solid black;">
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Product</th>
                                <th>Company</th>
                                <th class="text-center action-btn">Actions</th>
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
<div class="modal fade" id="add_supplier" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('suppliers.store')}}">
                    @csrf
                    <div class="row form-row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Name</label><input type="text" name="name" class="form-control">
                                <label>Phone</label><input type="text" name="phone" class="form-control">
                                <label>Email</label><input type="text" name="email" class="form-control">
                                <label>Address</label><input type="text" name="address" class="form-control">
                                <label>Product</label><input type="text" name="product" class="form-control">
                                <label>Company</label><input type="text" name="company" class="form-control">
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
<div class="modal fade" id="edit-supplier" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('suppliers.update')}}">
                    @csrf
                    @method("PUT")
                    <div class="row form-row">
                        <div class="col-12">
                            <input type="hidden" name="id" id="edit_id">
                            <div class="form-group">
                                <label>Name</label><input type="text" name="name" class="form-control edit_name">
                                <label>Phone</label><input type="text" name="phone" class="form-control edit_phone">
                                <label>Email</label><input type="text" name="email" class="form-control edit_email">
                                <label>Address</label><input type="text" name="address" class="form-control edit_address">
                                <label>Product</label><input type="text" name="product" class="form-control edit_product">
                                <label>Company</label><input type="text" name="company" class="form-control edit_company">
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
        var table = $('#suppliers-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('suppliers.index')}}",
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'product',
                    name: 'product'
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
        $('#suppliers-table').on('click', '.editbtn', function() {
            $('#edit-supplier').modal('show');
            var id = $(this).data('id');
            var product = $(this).data('product');
            var name = $(this).data('name');
            var email = $(this).data('email');
            var phone = $(this).data('phone');
            var address = $(this).data('address');
            var company = $(this).data('company');
            $('#edit_id').val(id);
            $('.edit_product').val(product);
            $('.edit_name').val(name);
            $('.edit_email').val(email);
            $('.edit_phone').val(phone);
            $('.edit_address').val(address);
            $('.edit_product').val(product);
            $('.edit_company').val(company);
        });
    });
</script>
@endpush