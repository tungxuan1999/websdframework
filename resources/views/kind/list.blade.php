@extends('layouts.layout1')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Kinds</h1>
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
            <input class='btn btn-primary' type='button' style='width:100px' value='Add New'/>
        </div>
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
                            echo("<td>
                                <li class='nav-item'>
                                <a class='nav-link collapsed' href='#' data-toggle='collapse' data-target='#collapseEdit{$profile->id}' aria-expanded='true' aria-controls='collapseEdit{$profile->id}'>
                                    <i class='fas fa-fw fa-cog'></i>
                                    <span>Custom</span>
                                </a>
                                <div id='collapseEdit{$profile->id}' class='collapse' aria-labelledby='headingTwo' data-parent='#accordionSidebar'>
                                    <div class='bg-white py-2 collapse-inner rounded'>
                                    <input class='collapse-item btn btn-primary' type='button' style='width:80px' value='Update'/>
                                    <input class='collapse-item btn btn-primary' type='button' style='width:80px' value='Delete'/>
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
@endsection
