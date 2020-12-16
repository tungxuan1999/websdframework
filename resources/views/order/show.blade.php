@extends('layouts.layout1')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-2 text-gray-800">Orders</h1> -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Orders</h6>
        </div>
        <div class="card-body">
            <?php
                $columns = Schema::getColumnListing('orders');
                foreach($columns as $i)
                {
                    switch($i)
                    {
                        case 'title':
                        {
                            echo("Title: <input id='titles' class='form-control' type='text' value='{$orders->$i}' readonly>");
                        }
                        break;
                        case 'body':
                        {
                            echo("Body
                            </br>
                                <textarea id='bodys' rows='4' style='width:100%' readonly>{$orders->$i}</textarea>
                            </br>");
                        }break;
                        case 'user_id':
                        {
                            echo("User ID: <input id='userids' class='form-control' type='number' value='{$orders->$i}' readonly>");
                            echo("<center><label id='useridshows' name='useridshows'>".json_encode($user)."</label></center>");
                            echo("<input id='btCheckuser' type='button' class='collapse-item btn btn-primary' value='Check user' onclick='postUser()' hidden='true'></br>");
                            echo("<input id='btOnclickInfo' onclick='onclickshowprofile()' value='Show Information' class='collapse-item btn btn-primary'></br>");
                        }break;
                        case 'status':
                        {
                            echo("Status:</br>
                            <select name='statuss' id='statuss' disabled>
                                <option value='0'>Pending</option>  
                                <option value='1'>Success</option>
                                <option value='2'>Fail</option>
                            </select></br>");
                        }break;
                        default:{
                            echo("{$i}: <input class='form-control' type='text' value='{$orders->$i}' readonly>");
                        }
                    }
                }
                echo("
                <script>
                    document.getElementById('statuss').value = {$orders->status};
                </script>
                ");
            ?>
            </br>
            <center><input id="editorderss" class='collapse-item btn btn-primary' type='button' style='width:80px' value='Edit' onclick='onclickeditorderss()'/></center>
        </div>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Items</h6>
        </div>
        <div class="card-body">
            <input class='btn btn-primary' type='button' style='width:100px' onclick="showDialog(0,'','','','','',0,'add')" value='Add New'/>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" style="width:100%" cellspacing="0">
                    <?php
                        echo("<thead>");
                        echo("<tr>");
                        echo("<th>ID</th>");
                        echo("<th>Name</th>");
                        echo("<th>Price</th>");
                        echo("<th>Detail</th>");
                        echo("<th>Image</th>");
                        echo("<th>Sex</th>");
                        echo("<th>Edit</th>");
                        echo("</tr>");
                        echo("</thead>");
                        echo("</tbody>");
                        $total = 0;
                        foreach($orders_products as $item)
                        {
                            $stt = $item->product_id - 1;
                            $total += $products[$stt]->price;
                            echo("<tr id='item_{$products[$stt]->id}'>");
                            echo("<td>{$products[$stt]->id}</td>");
                            echo("<td>{$products[$stt]->name}</td>");
                            echo("<td>{$products[$stt]->price}</td>");
                            echo("<td>{$products[$stt]->detail}</td>");
                            echo("<td><img height='100' src='{$products[$stt]->image}'></td>");
                            echo("<td>{$products[$stt]->sex}</td>");
                            echo("<td>
                                <li class='nav-item'>
                                <a class='nav-link collapsed' href='#' data-toggle='collapse' data-target='#collapseEdit{$item->id}' aria-expanded='true' aria-controls='collapseEdit{$item->id}'>
                                    <i class='fas fa-fw fa-cog'></i>
                                    <span>Custom</span>
                                </a>
                                <div id='collapseEdit{$item->id}' class='collapse' aria-labelledby='headingTwo' data-parent='#accordionSidebar'>
                                    <div class='bg-white py-2 collapse-inner rounded'>
                                    <input class='collapse-item btn btn-primary' type='button' style='width:80px' onclick=".'"'."showDialog({$products[$stt]->id},'{$products[$stt]->name}','{$products[$stt]->price}','{$products[$stt]->detail}','{$products[$stt]->image}','{$products[$stt]->sex}','{$item->id}','update')".'"'." value='Update'/>
                                    <input class='collapse-item btn btn-primary' type='button' style='width:80px' onclick=".'"'."showDialog({$products[$stt]->id},'{$products[$stt]->name}','{$products[$stt]->price}','{$products[$stt]->detail}','{$products[$stt]->image}','{$products[$stt]->sex}','{$item->id}','delete')".'"'." value='Delete'/>
                                    </div>
                                </div>
                                </li>
                            </td>");
                            echo("</tr>");
                        }
                        echo("</tbody>");
                        echo("<tfoot>
                            <tr>
                                <th>Total</th>
                                <th></th>
                                <th>$total</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>");
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
                <div class="modal-body">
                    <div class="form-group">
                        <div class='alert alert-danger' id="errorProfile">Notification:</div>
                    </div>
                    <div class="form-group" >
                            <input type="text" name="order_product_id" class="form-control form-control-user" id="order_product_id" hidden="true">
                        </div>
                    <div class="form-group" >
                            <?php
                                echo("<select name='id' id='id' onchange='checkID(value)'>");
                                foreach($products as $item)
                                {
                                    echo("<option value='$item->id'>$item->id</option>");
                                }
                                echo("</select>");
                            ?>
                            <script>
                                function checkID(value)
                                {
                                    if(value != 0)
                                    {
                                        var passedArray =  <?php echo json_encode($products); ?>;
                                        document.getElementById('img').src = passedArray[value-1]['image'];
                                        document.getElementById('name').value = passedArray[value-1]['name'];
                                        document.getElementById('price').value = passedArray[value-1]['price'];
                                        document.getElementById('detail').value = passedArray[value-1]['detail'];
                                        document.getElementById('sex').value = passedArray[value-1]['sex'];
                                    }
                                }
                                </script>
                    </div>
                    <div class="form-group" >
                        Name<input type="text" name="name" class="form-control form-control-user" id="name" placeholder="Name" value="" readonly>
                    </div>
                    <div class="form-group" >
                        Price<input type="number" name="price" class="form-control form-control-user" id="price" placeholder="Price" value="" readonly>
                    </div>
                    <div class="form-group">
                        Detail<input type="text" name="detail" class="form-control form-control-user" id="detail" placeholder="Detail" value="" readonly>
                    </div>
                    <div class="form-group">
                        Sex 
                        <select name="sex" id="sex" disabled>
                            <option value="Male">Male</option>  
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group" style="text-align:center">
                        <img id="img" height="100" >
                    </div>
                </div>
                <div class="modal-footer">
                    <input id="btUpdate" type="button" class="btn btn-primary" value="Update" onclick="return checkNullProduct()">
                </div>
        </div>
      </div>
    </div>
</div>


<script type="text/javascript">
    function checkNullProduct()
    {
        $("#errorProfile").html('Notification:');
        var check = true;
        if(document.getElementById('id').value.length == 0)
        {
            $("#errorProfile").append('</br>'+'ID null');
            check = false;
        }
        if(check)
        {
            postBuyItem(document.getElementById('order_product_id').value, document.getElementById('id').value,document.getElementById('btUpdate').value);
        }
        return check;
    }

    function showDialog(id,name,price,detail,avatar,sex,order_product_id,type)
    {
        $("#errorProfile").html('Notification:');
        var model = document.getElementById('showEdit');
        switch(type)
        {
            case 'update':{
                document.getElementById('btUpdate').value = "Update";
                document.getElementById('id').disabled = false;
            }break;
            case 'add':{
                document.getElementById('btUpdate').value = "Add";
                document.getElementById('id').disabled = false;
            }break;
            case 'delete':{
                document.getElementById('btUpdate').value = "Delete";
                document.getElementById('id').disabled = true;
            }break;
        }
        document.getElementById('exampleModalLabel').innerHTML = "Information";
        document.getElementById('order_product_id').value = order_product_id;
        document.getElementById('id').value = id;
        document.getElementById('img').src = avatar;
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

    function postBuyItem(id, product_id,type)
    {
        var order_id = <?php echo("{$orders->id}")?>;
        $("#errorProfile").html('Notification:');
        var check = true;
        if(id.length == 0)
        {
            $("#errorProfile").append('</br>'+'ID null');
            check = false;
        }
        if(product_id.length == 0)
        {
            $("#errorProfile").append('</br>'+'Product ID null');
            check = false;
        }
        if(order_id.length == 0)
        {
            $("#errorProfile").append('</br>'+'Order ID null');
            check = false;
        }
        if(type.length == 0)
        {
            $("#errorProfile").append('</br>'+'Type null');
            check = false;
        }
        if(check)
        {
            // $("#error").html('Notification:');
            $.ajax({
            type:'POST',
            url:"{{ route('order.postBuyItem') }}",
            data:{
                id:id,
                order_id:order_id,
                product_id:product_id,
                type:type,
                _token: '{{csrf_token()}}'
            },
            success:function(data){
                alert(data.msg);
                location.reload();
            },
            error: function (msg) {
                alert("Error server, not send");
            }
            
            });
        }
        return check;
    }
    function onclickeditorderss()
    {
        if(document.getElementById('editorderss').value == 'Edit')
        {
            document.getElementById('editorderss').value = 'Update';
            document.getElementById('titles').readOnly = false;
            document.getElementById('bodys').readOnly = false;
            document.getElementById('statuss').disabled = false;
            document.getElementById('userids').readOnly = false;
            document.getElementById('btCheckuser').hidden = false;
            
        }
        else{
            if(document.getElementById('useridshows').innerText  != 'null')
            {
                document.getElementById('editorderss').value = 'Edit'
                document.getElementById('titles').readOnly = true;
                document.getElementById('bodys').readOnly = true;
                document.getElementById('statuss').disabled = true;
                document.getElementById('userids').readOnly = true;
                document.getElementById('btCheckuser').hidden = true;
                postOrder();
            }
            else{
                alert('User ID fail');
            }
        }
    }
    function postUser()
    {
        var check = true;
        var id = document.getElementById('userids').value;
        if(id.length == 0)
        {
            alert("ID null");
            check = false;
        }
        if(check)
        {
            $.ajax({
            type:'POST',
            url:"{{ route('user.getUser') }}",
            data:{
                id:id,
                _token: '{{csrf_token()}}'
            },
            success:function(data){
                if(data.msg == 'User is exist')
                {
                    $("#useridshows").html(data.user);
                    document.getElementById('userids').readOnly = true;
                            
                    document.getElementById('btCheckuser').hidden = true;
                }
                else
                    $("#useridshows").html('null');
            },
            error: function (msg) {
                alert("Error server, not send");
            }
            
            });
        }
        return check;
    }
    function postOrder()
    {
        var order_id = <?php echo("{$orders->id}")?>;
        var check = true;
        var user_id = document.getElementById('userids').value;
        if(user_id.length == 0)
        {
            alert("ID null");
            check = false;
        }
        if(check)
        {
            $.ajax({
            type:'POST',
            url:"{{ route('order.postOrder') }}",
            data:{
                id:order_id,
                user_id:user_id,
                title:document.getElementById('titles').value,
                body:document.getElementById('bodys').value,
                status:document.getElementById('statuss').value,
                type:'update',
                _token: '{{csrf_token()}}'
            },
            success:function(data){
                if(data.msg == 'Update success')
                {
                    alert(data.msg);
                    location.reload();
                }
                else {
                    alert(data.msg);
                }
            },
            error: function (msg) {
                alert("Error server, not send");
            }
            
            });
        }
        return check;
    }
    function onclickshowprofile()
    {
        var user_id = document.getElementById('userids').value;
        window.open("/users/show/"+user_id);
    }
</script>
@endsection
