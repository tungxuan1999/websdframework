@extends('layouts.layout1')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Kinds</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- <h6 class="m-0 font-weight-bold text-primary">Profiles</h6> -->
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
                <table class="table table-bordered" id="dataTable" style="width:100%" cellspacing="0">
                    <?php
                        echo("<thead>");
                        echo("<tr>");
                        $columns = Schema::getColumnListing('kinds');
                        foreach($columns as $i)
                        {
                            echo("<th>$i</th>");
                        }
                        echo("<th>Edit</th>");
                        echo("</tr>");
                        echo("</thead>");
                        echo("</tbody>");
                        foreach($kinds as $profile)
                        {
                            echo("<tr>");
                            foreach($columns as $i)
                            {
                                echo("<td><a>{$profile->$i}</a></td>");
                            }
                            echo("<td><input type='button' class='btn btn-primary' value='Edit'/></td>");
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
