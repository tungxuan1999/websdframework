@extends('layouts.layout1')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Orders</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- <h6 class="m-0 font-weight-bold text-primary">Profiles</h6> -->
            <tr>
                <th>Status: </th>
                <th>
                    <select name="searchstatus" id="searchstatus">
                        <option value="All">All</option>  
                        <option value="Pending">Pending</option>  
                        <option value="Success">Success</option>
                        <option value="Fail">Fail</option>
                    </select>
                </th>
                <th> From day: </th>
                <th>
                    <input type="date" name="firstdaycreate" id="firstdaycreate" value="">
                </th>
                <th> To day: </th>
                <th>
                    <input type="date" name="enddaycreate" id="enddaycreate" value="">
                </th>
                <th>
                    <input type="button" class="collapse-item btn btn-primary" value="Search" onclick="onSearch()">
                </th>
            </tr>
            <?php
            if($notification = Session::get('notification'))
            {
                echo $notification;
            }
            ?>
            <!-- <input class='btn btn-primary' type='button' style='width:100px' value='Add New'/> -->
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" style="width:100%" cellspacing="0">
                    <?php
                        echo("<thead>");
                        echo("<tr>");
                        $columns = Schema::getColumnListing('orders');
                        foreach($columns as $i)
                        {
                            echo("<th>$i</th>");
                        }
                        echo("<th>Edit</th>");
                        echo("</tr>");
                        echo("</thead>");
                        echo("</tbody>");
                        foreach($orders as $profile)
                        {
                            echo("<tr>");
                            foreach($columns as $i)
                            {
                                if($i == "status")
                                {
                                    switch($profile->$i)
                                    {
                                        case 0:{
                                            echo("<td><a>Pending</a></td>");
                                        }break;
                                        case 1:{
                                            echo("<td><a>Success</a></td>");
                                        }break;
                                        case 2:{
                                            echo("<td><a>Fail</a></td>");
                                        }break;
                                    }
                                }
                                else
                                echo("<td><a>{$profile->$i}</a></td>");
                            }
                            echo("<td>
                            <input class='collapse-item btn btn-primary' type='button' style='width:80px' onclick='"."window.open(".'"'."/orders/show/{$profile->id}".'")'.";' value='Show'/>
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
<script>
    function onSearch() {
        var table, tr, td, i, txtValue, searchstatus, firstdaycreate, enddaycreate;
        document.getElementsByName('dataTable_length')[0].value = 100;
        $( 'select[name ="dataTable_length"]' ).change();

        searchstatus = document.getElementById("searchstatus").value;
        firstdaycreate = document.getElementById("firstdaycreate").value;
        enddaycreate = document.getElementById("enddaycreate").value;
        table = document.getElementById("dataTable");
        tr = table.getElementsByTagName("tr");
        if(firstdaycreate!= "" && enddaycreate!="" && firstdaycreate>enddaycreate)
        {
            alert("Form day must < To day");
        }
        else
        {
            if(enddaycreate != "")
            {
                enddaycreate = new Date(enddaycreate);
                enddaycreate.setDate(enddaycreate.getDate() + 1);
            }
            for (i = 0; i < tr.length; i++) {
                tr[i].style.display = "";
                if (tr[i].getElementsByTagName("td")[4]) {
                    txtValue = tr[i].getElementsByTagName("td")[4].textContent || tr[i].getElementsByTagName("td")[4].innerText;
                    if(searchstatus != "All")
                    {
                        if (txtValue != searchstatus) {
                            tr[i].style.display = "none";
                        }
                    }
                }
                if(tr[i].getElementsByTagName("td")[5])
                {
                    txtValue = tr[i].getElementsByTagName("td")[5].textContent || tr[i].getElementsByTagName("td")[5].innerText;
                    
                    if(firstdaycreate == "" || enddaycreate == "")
                    {
                        if(firstdaycreate == "" && enddaycreate != "")
                        {
                            if(txtValue > enddaycreate)
                            {
                                tr[i].style.display = "none";
                            }
                        }
                        if(enddaycreate == "" && firstdaycreate != "")
                        {
                            if(txtValue < firstdaycreate)
                            {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                    else{
                        if(txtValue < firstdaycreate || txtValue > enddaycreate)
                        {
                                tr[i].style.display = "none";
                        }
                    }
                }       
            }
        }
    }
</script>
@endsection
