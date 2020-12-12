@extends('layouts.layout1')
@section('content')
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Users</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
      <?php
        if($notification = Session::get('notification'))
        {
            echo $notification;
        }
        ?>
    <input class='btn btn-primary' type='button' style='width:100px' onclick="showDialog(0,'','','','','add')" value='Add New'/>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <?php
            echo("<thead>");
            echo("<tr>");
            $columns = Schema::getColumnListing('users');
               foreach($columns as $i)
               {
                echo("<th>$i</th>");
               }
            echo("<th>Edit</th>");
            echo("</tr>");
            echo("</thead>");
            echo("</tbody>");
            foreach($users as $user)
            {
                echo("<tr>");
                foreach($columns as $i)
               {
                    echo("<td><a href='/profiles/{$user->id}'>{$user->$i}</a></td>");
               }
               echo("<td>
                  <li class='nav-item'>
                    <a class='nav-link collapsed' href='#' data-toggle='collapse' data-target='#collapseEdit{$user->id}' aria-expanded='true' aria-controls='collapseEdit{$user->id}'>
                        <i class='fas fa-fw fa-cog'></i>
                        <span>Edit</span>
                    </a>
                    <div id='collapseEdit{$user->id}' class='collapse' aria-labelledby='headingTwo' data-parent='#accordionSidebar'>
                        <div class='bg-white py-2 collapse-inner rounded'>
                        <input class='collapse-item btn btn-primary' type='button' style='width:80px' onclick=".'"'."showDialog($user->id,'$user->name','$user->email','$user->password','$user->remember_token','update')".'"'." value='Update'/>
                        <input class='collapse-item btn btn-primary' type='button' style='width:80px' onclick=".'"'."showDialog($user->id,'$user->name','$user->email','$user->password','$user->remember_token','delete')".'"'." value='Delete'/>
                        </div>
                    </div>
                  </li>
               </td>");
               echo("</tr>");
            }
            echo("</tbody>");
        ?>
      <!-- <thead>
          <tr>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Email Verified</th>
            <th>Password</th>
            <th>Remember Token</th>
            <th>Create At</th>
            <th>Update At</th>
            <th>Edit</th>
          </tr>
        </tfoot>
        <tbody>
          @foreach($users as $user)
                <tr>
                    <td><a href="/profiles/{{$user->id}}">{{$user->id}}</a></td>
                    <td><a href="/profiles/{{$user->id}}">{{$user->name}}</a></td>
                    <th><a href="/profiles/{{$user->id}}">{{$user->email}}</a></th>
                    <th><a href="/profiles/{{$user->id}}">{{$user->email_verified_at}}</a></th>
                    <th><a href="/profiles/{{$user->id}}">{{$user->password}}</a></th>
                    <th><a href="/profiles/{{$user->id}}">{{$user->remember_token}}</a></th>
                    <th><a href="/profiles/{{$user->id}}">{{$user->created_at}}</a></th>
                    <th><a href="/profiles/{{$user->id}}">{{$user->updated_at}}</a></th>
                    <td><a href="/profiles/{{$user->id}}/edit" class="btn btn-primary" role="button"></a></td>
                </tr>
            @endforeach
        </tbody> -->
      </table>
    </div>
  </div>
</div>
</div>

<div class='modal' id='showEdit' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
    <div class='modal-dialog' role='document'>
      <div class='modal-content'>
        <div class='modal-header'>
          <h5 class='modal-title' id='exampleModalLabel'></h5>
          <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
            <span aria-hidden='true' onclick='hideDialog()'>×</span>
          </button>
        </div>
            <form class="user" name="user" method="POST">
                    @csrf
                    @method('PUT')<!-- khai báo này dùng để thiết lập phương thức PUT
                                        nếu không khai báo thì khi submit không thiết lập HttpPUT -->
                    <div class="modal-body">
                        <div class="form-group">
                            <div class='alert alert-danger' id="error">Notification:</div>
                        </div>
                        <div class="form-group" >
                            <input type="text" name="id" class="form-control form-control-user" id="id" placeholder="ID" hidden="true">
                        </div>
                        <div class="form-group" >
                            Email<input type="email" name="email" class="form-control form-control-user" id="email" placeholder="EMAIL">
                        </div>
                        <div class="form-group" >
                            <input type="button" class="btn btn-primary" onclick="getMessage()" value="Check Email">
                        </div>
                        <div class="form-group" >
                            Name<input type="text" name="name" class="form-control form-control-user" id="name" placeholder="NAME">
                        </div>
                        <div class="form-group" >
                            Password<input type="password" name="password" class="form-control form-control-user" id="password" placeholder="PASSWORD">
                        </div>
                        <div class="form-group" >
                            Token<input type="text" name="remember_token" class="form-control form-control-user" id="remember_token" placeholder="REMEMBER TOKEN" readonly>
                        </div>
                        <div class="form-group" >
                          <input type="button" class="btn btn-primary" onclick="randomToken()" value="Random Token">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input id="btUpdate" type="submit" class="btn btn-primary" value="Update" onclick="return checkNull()">
                    </div>
			</form>
        </div>
      </div>
    </div>
</div>

  <script type="text/javascript">
    function checkNull()
    {
      if(document.getElementById('btUpdate').value != "Delete")
      {
        $("#error").html('Notification:');
        var check = true;
        if(document.getElementById('email').value.length == 0)
        {
          $("#error").append('</br>'+'Email null');
          check = false;
        }
        if(document.getElementById('name').value.length == 0)
        {
          $("#error").append('</br>'+'Name null');
          check = false;
        }
        if(document.getElementById('password').value.length == 0)
        {
          $("#error").append('</br>'+'Password null');
          check = false;
        }
        return check;
      }
      else return true;
    }
    function randomToken()
    {
      var result           = '';
      var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
      for ( var i = 0; i < 10; i++ ) {
          result += characters.charAt(Math.floor(Math.random() * characters.length));
      }
      document.getElementById('remember_token').value = result;
    }
    function showDialog(id,name,email,password,remember_token,type)
    {
      $("#error").html('Notification:');
      var model = document.getElementById('showEdit');
      switch(type)
      {
          case 'update':{
            document.user.action = "{{ route('users.update','update') }}";
            document.getElementById('btUpdate').value = 'Update';
            document.getElementById('email').readOnly = true;
          }break;
          case 'add':{
            document.user.action = "{{ route('users.update','add') }}";
            document.getElementById('btUpdate').value = 'Add';
            document.getElementById('email').readOnly = false;
          }break;
          case 'delete':{
            document.user.action = "{{ route('users.update','delete') }}";
            document.getElementById('btUpdate').value = 'Delete';
            document.getElementById('email').readOnly = true;
          }
      }
      document.getElementById('exampleModalLabel').innerHTML = "Information";
      document.getElementById('id').value = id;
      document.getElementById('name').value = name;
      document.getElementById('email').value = email;
      document.getElementById('password').value = '';
      if(remember_token.length != 0)
        document.getElementById('remember_token').value = remember_token;
      else
        randomToken();
      model.style.display = "block";
    }

    function hideDialog()
    {
      var model = document.getElementById('showEdit');
      model.style.display = "none";
    }

    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      } 
    });

    function getMessage() {
      $("#error").html('Notification:');
      var email = $("input[name=email]").val();
      $.ajax({
        type:'POST',
        url:"{{ route('user.checkEmail') }}",
        data:{email:email, _token: '{{csrf_token()}}'},
        success:function(data){
          $("#error").append('</br>'+data.msg);
        },
        error: function (msg) {
          $("#error").append('</br>'+msg.responseJSON.message);
        }
        
      });
    }
</script>
@endsection
