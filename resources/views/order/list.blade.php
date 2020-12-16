@extends('layouts.layout1')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Orders</h1>
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
@endsection
