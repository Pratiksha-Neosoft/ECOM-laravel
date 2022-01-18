<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Product list</title>
    @include('admin.includes.head')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
@include('admin.includes.nav')
@include('admin.includes.sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Products</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <a class="btn btn-info" href="{{url('admin/add-product')}}">Add Product</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="users" class="table table-bordered table-hover w-100">
                    <thead>
                        <tr>
                          <th>Product ID</th>
                          <th>Category Name</th>
                          <th>Product Name</th>
                          <th>Product Color</th>
                          <th>Description</th>
                          <th>Price</th>
                          <th>Image</th>
                          <th>Feature Item</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $cnt=1?>
                          @foreach($products as $product)
                        <tr>
                          <td>{{ $cnt }}</td>
                          <td>{{ $product->category_name }}</td>
                          <td>{{ $product->product_name }}</td>
                          <td>{{ $product->product_color }}</td>
                          <td>{{ $product->description }}</td>
                          <td>INR {{ $product->price }}</td>
                          <td>
                            @if(!empty($product->image))
                            <img src="{{ asset('/images/products/'.$product->image) }}" style="width:50px;">
                            @endif
                          </td>
                          <td>@if($product->feature_item == 1) Yes @else No @endif</td>
                          <td>
                            <a href="{{ url('/admin/edit-product/'.$product->id) }}" class="btn btn-primary btn-mini">Edit</a> 
                            <a href="{{ url('/admin/add-attributes/'.$product->id) }}" class="btn btn-success btn-mini">Attributes</a>
                            <a href="{{ url('/admin/add-images/'.$product->id) }}" class="btn btn-info btn-mini">Images</a>
                            <a href="{{ url('/admin/delete-product/'.$product->id) }}" class="btn btn-danger " onclick="return deleteConfirm()">Delete</a>        
                          </td>
                        </tr>
                        <?php $cnt++;?>
                        @endforeach
                      </tbody>    
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.1.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('Admin_assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('Admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- DataTables  & Plugins -->
<script src="{{asset('Admin_assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Admin_assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('Admin_assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('Admin_assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('Admin_assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('Admin_assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('Admin_assets/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('Admin_assets/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('Admin_assets/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('Admin_assets/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('Admin_assets/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('Admin_assets/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script src="{{asset('Admin_assets/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script>
  function deleteConfirm(){
    return confirm("Do you really want to delete this record.");
  }
  $(function () {
    $('#users').DataTable({
      "pageLength": 5,
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
    });
  });
</script>
</body>
</html>