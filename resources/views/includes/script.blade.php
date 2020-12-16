  <!-- ajax -->
  <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

  <!-- jquery -->
  <script src="https://code.jquery.com/jquery-3.5.0.js"></script>

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

  <!-- Page level plugins -->
  <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

  <!-- Page level custom scripts -->
  <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
  <script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>

  <!-- table -->
  <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>

  <script>
    $.ajax({
    type:'POST',
    url:"{{ route('kind.getKinds') }}",
    data:{_token: '{{csrf_token()}}'},
    success:function(data){
        if(data.response)
        {
            $("#listkinds").append('<a class="collapse-item" href="/products">All</a>');
            for(var i = 0; i < data.data.length; i++)
            {
                $("#listkinds").append('<a class="collapse-item" href="/profiles">'+data.data[i].id+"."+data.data[i].name+'</a>');
            }
            $("#listkinds").append('<a class="collapse-item" href="/kinds">#CustomKind</a>');
        }
        else {
            alert("Server error");
        }
    },
    error: function (msg) {
        alert("Server error");
    }
    
    });
</script>