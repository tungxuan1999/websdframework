@extends('layouts.layout1')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Profiles</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Profiles</h6>
            <!-- <input type='button' onclick="showDialog(0,0,'','','','','add')" value='Add New'/> -->
        </div>
        <?php
        if($notification = Session::get('notification'))
        {
            echo $notification;
        }
        ?>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <?php
                        echo("<thead>");
                        echo("<tr>");
                        $columns = Schema::getColumnListing('profiles');
                        foreach($columns as $i)
                        {
                            echo("<th>$i</th>");
                        }
                        echo("<th>Edit</th>");
                        echo("</tr>");
                        echo("</thead>");
                        echo("</tbody>");
                        foreach($profiles as $profile)
                        {
                            echo("<tr>");
                            foreach($columns as $i)
                            {
                                if($i == "avatar")
                                {
                                    echo("<td><img height='100' src='{$profile->$i}'></td>");
                                }
                                else
                                echo("<td><a href='/profiles/{$profile->id}'>{$profile->$i}</a></td>");
                            }
                            echo("<td><input type='button' class='btn btn-primary' onclick=".'"'."showDialog($profile->id,$profile->user_id,'$profile->avatar','$profile->full_name','$profile->address','$profile->birthday','update')".'"'." value='Edit'/></td>");
                            echo("</tr>");
                        }
                        echo("</tbody>");
                    ?>
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
                            <div class='alert alert-danger' id="errorProfile">Notification:</div>
                        </div>
                        <div class="form-group" >
                            <input type="text" name="id" class="form-control form-control-user" id="id" placeholder="ID" hidden="true">
                        </div>
                        <div class="form-group" >
                            UID<input type="text" name="user_id" class="form-control form-control-user" id="user_id" placeholder="UID" value="">
                        </div>
                        <div class="form-group" >
                            Name<input type="text" name="full_name" class="form-control form-control-user" id="full_name" placeholder="Full Name" value="">
                        </div>
                        <div class="form-group">
                            Address<input type="text" name="address" class="form-control form-control-user" id="address" placeholder="Address" value="">
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                Birthday<input type="date" class="form-control form-control-user" name="birthday" id="birthday" placeholder="Birthday" value="">
                            </div>
                        </div>
                        <div class="input-group">
                            Avatar<input type="file" class="form-control" id="avatar" name="avatar" accept="image/x-png,image/gif,image/jpeg">
                            <input type="text" name="b64" class="form-control form-control-user" id="b64" hidden="true">
                        </div>
                        <div class="form-group" style="text-align:center">
                            <img id="img" height="100" >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Update" onclick="return checknull()">
                    </div>
			</form>
        </div>
      </div>
    </div>
</div>

  <script type="text/javascript">
    function checknull()
    {
        var user_id = $("input[name=user_id]").val();
        var full_name = $("input[name=full_name]").val();
        var avatar = $("input[name=b64]").val();
        var address = $("input[name=address]").val();
        var birthday = $("input[name=birthday]").val();
        $("#errorProfile").html('Notification:');
        var check = true;
        if(user_id.length == 0)
        {
            $("#errorProfile").append('</br>'+'User ID null');
            check = false;
        }
        if(full_name.length == 0)
        {
            $("#errorProfile").append('</br>'+'Name null');
            check = false;
        }
        if(avatar.length == 0)
        {
            $("#errorProfile").append('</br>'+'Avatar null');
            check = false;
        }
        if(address.length == 0)
        {
            $("#errorProfile").append('</br>'+'Address null');
            check = false;
        }
        if(birthday.length == 0)
        {
            $("#errorProfile").append('</br>'+'Birthday null');
            check = false;
        }
        return check;
    }

    function checkImgProfile()
    {
        if (this.files && this.files[0]) {
    
            var FR= new FileReader();
            
            FR.addEventListener("load", function(e) {
            document.getElementById("img").src       = e.target.result;
            document.getElementById("b64").value = e.target.result;
            }); 
            
            FR.readAsDataURL( this.files[0] );
        }
    }

    document.getElementById("avatar").addEventListener("change", checkImgProfile);

    function showDialog(id,user_id,avatar,name,add,birthday,type)
    {
        $("#errorProfile").html('Notification:');
        var model = document.getElementById('showEdit');
        switch(type)
        {
            case 'update':{
                document.user.action = "{{ route('profiles.update','update') }}";
            }break;
            //   case 'add':{
            //     document.user.action = "{{ route('profiles.update','add') }}";
            //   }break;
        }
        document.getElementById('exampleModalLabel').innerHTML = "Information";
        document.getElementById('id').value = id;
        document.getElementById('user_id').value = user_id;
        document.getElementById('user_id').readOnly = true;
        document.getElementById('img').src = avatar;
        document.getElementById('b64').value = avatar;
        document.getElementById('full_name').value = name;
        document.getElementById('address').value = add;
        document.getElementById('birthday').value = birthday;
        model.style.display = "block";
    }

    function hideDialog()
    {
      var model = document.getElementById('showEdit');
      model.style.display = "none";
    }
</script>
@endsection
