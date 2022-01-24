<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Orders List</title>
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
              <li class="breadcrumb-item active">Orders</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <h2>All Orders</h2>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <table id="users" class="table table-bordered table-hover w-100">
                    <thead>
                    <tr>
                      <th>Id</th>
                      <th>Customer</th>
                      <th>Address</th>
                      <th>Products</th>
                      <th>Amount</th>
                      <th>Discount</th>
                      <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $cnt=1;?>
                      @foreach($orders as $order)
                    <tr>
                      <td>{{$cnt}}</td>
                      <td>{{$order[0]->fullName}}</td>
                      <td>{{$order[0]->address}}<br>State:{{$order[0]->state}},City:{{$order[0]->city}}<br>Pin code:{{$order[0]->pincode}}<br>Mobile:{{$order[0]->mobile_no}}</td>
                      <td> 
                        <ul style="list-style-type:none">
                          @foreach($order[1] as $orderP)
                           <li><img src="{{asset('/images/products/').'/'.$orderP->image}}" width="100" height="100">
                            Name:{{$orderP->product_name}}<br>
                            Price:{{$orderP->price}}<br>
                           </li>
                          @endforeach
                        </ul>                        
                      </td>
                      <td>{{$order[0]->amount}}</td>
                      <td>{{$order[2]}}</td>
                      <td>
                          <form action="{{url('status/update')}}" method="post">
                              @csrf
                              <input type="hidden" value="{{$order['0']->oid}}" name="id">
                              <input type="radio" name="status" value="processing" {{$order[0]->status=="processing"?'checked':''}}> Processing<br>
                              <input type="radio" name="status" value="packed" {{$order[0]->status=="packed"?'checked':''}}> Packed<br>
                              <input type="radio" name="status" value="shipped" {{$order[0]->status=="shipped"?'checked':''}}> Shipped<br>
                              <input type="radio" name="status" value="delivered" {{$order[0]->status=="delivered"?'checked':''}}> Delivered<br>
                              <input type="submit" value="update" class="btn btn-outline-success">
                          </form>
                      </td>
                    </tr>
                    <?php $cnt++?>
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