@extends('layouts.layout1')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Products</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- <h6 class="m-0 font-weight-bold text-primary">Profiles</h6> -->
            <?php
            if($notification = Session::get('notification'))
            {
                echo $notification;
            }
            ?>
            <input class='btn btn-primary' type='button' style='width:100px' value='Add New' onclick="showDialog(0,'','','','','','add')"/>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" style="width:100%" cellspacing="0">
                    <?php
                        echo("<thead>");
                        echo("<tr>");
                        $columns = Schema::getColumnListing('products');
                        foreach($columns as $i)
                        {
                            echo("<th>$i</th>");
                        }
                        echo("<th>Edit</th>");
                        echo("</tr>");
                        echo("</thead>");
                        echo("</tbody>");
                        foreach($products as $profile)
                        {
                            echo("<tr>");
                            foreach($columns as $i)
                            {
                                if($i == "image")
                                {
                                    echo("<td><img height='100' src='{$profile->$i}'></td>");
                                }
                                else
                                echo("<td><a>{$profile->$i}</a></td>");
                            }
                            echo("<td>
                                <li class='nav-item'>
                                <a class='nav-link collapsed' href='#' data-toggle='collapse' data-target='#collapseEdit{$profile->id}' aria-expanded='true' aria-controls='collapseEdit{$profile->id}'>
                                    <i class='fas fa-fw fa-cog'></i>
                                    <span>Custom</span>
                                </a>
                                <div id='collapseEdit{$profile->id}' class='collapse' aria-labelledby='headingTwo' data-parent='#accordionSidebar'>
                                    <div class='bg-white py-2 collapse-inner rounded'>
                                    <input class='collapse-item btn btn-primary' type='button' style='width:80px' onclick=".'"'."showDialog($profile->id,'$profile->name','$profile->price','$profile->detail','$profile->image','$profile->sex','update')".'"'." value='Update'/>
                                    <input class='collapse-item btn btn-primary' type='button' style='width:80px' onclick=".'"'."showDialog($profile->id,'$profile->name','$profile->price','$profile->detail','$profile->image','$profile->sex','delete')".'"'." value='Delete'/>
                                    </div>
                                </div>
                                </li>
                            </td>");
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
                            Name<input type="text" name="name" class="form-control form-control-user" id="name" placeholder="Name" value="">
                        </div>
                        <div class="form-group" >
                            Price<input type="number" name="price" class="form-control form-control-user" id="price" placeholder="Price" value="">
                        </div>
                        <div class="form-group">
                            Detail<input type="text" name="detail" class="form-control form-control-user" id="detail" placeholder="Detail" value="">
                        </div>
                        <div class="form-group">
                            Sex 
                            <select name="sex" id="sex">
                                <option value="Male">Male</option>  
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="input-group">
                            Image<input type="file" class="form-control" id="avatar" name="avatar" accept="image/x-png,image/gif,image/jpeg">
                            <input type="text" name="b64" class="form-control form-control-user" id="b64" hidden="true">
                        </div>
                        <div class="form-group" style="text-align:center">
                            <img id="img" height="100" >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input id="btUpdate" type="submit" class="btn btn-primary" value="Update" onclick="return checkNullProduct()">
                    </div>
			</form>
        </div>
      </div>
    </div>
</div>


<script type="text/javascript">
    function checkNullProduct()
    {
        var id = $("input[name=id]").val();
        var name = $("input[name=name]").val();
        var avatar = $("input[name=b64]").val();
        var price = $("input[name=price]").val();
        var detail = $("input[name=detail]").val();
        $("#errorProfile").html('Notification:');
        var check = true;
        if(id.length == 0)
        {
            $("#errorProfile").append('</br>'+'ID null');
            check = false;
        }
        if(name.length == 0)
        {
            $("#errorProfile").append('</br>'+'Name null');
            check = false;
        }
        if(avatar.length == 0)
        {
            $("#errorProfile").append('</br>'+'Image null');
            check = false;
        }
        if(price.length == 0)
        {
            $("#errorProfile").append('</br>'+'Price null');
            check = false;
        }
        if(detail.length == 0)
        {
            $("#errorProfile").append('</br>'+'Detail null');
            check = false;
        }
        if(document.getElementById("sex").value.length == 0)
        {
            $("#errorProfile").append('</br>'+'Sex null');
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

    function showDialog(id,name,price,detail,avatar,sex,type)
    {
        $("#errorProfile").html('Notification:');
        var model = document.getElementById('showEdit');
        switch(type)
        {
            case 'update':{
                document.user.action = "{{ route('products.update','update') }}";
                document.getElementById('btUpdate').value = "Update";
            }break;
            case 'add':{
                document.user.action = "{{ route('products.update','add') }}";
                document.getElementById('btUpdate').value = "Add";
            }break;
            case 'delete':{
                document.user.action = "{{ route('products.update','delete') }}";
                document.getElementById('btUpdate').value = "Delete";
            }break;
        }
        document.getElementById('exampleModalLabel').innerHTML = "Information";
        document.getElementById('id').value = id;
        document.getElementById('img').src = avatar;
        document.getElementById('b64').value = avatar;
        document.getElementById('name').value = name;
        document.getElementById('price').value = price;
        document.getElementById('detail').value = detail;
        document.getElementById('sex').value = sex;
        model.style.display = "block";
    }

    function hideDialog()
    {
      var model = document.getElementById('showEdit');
      model.style.display = "none";
    }
</script>
@endsection
