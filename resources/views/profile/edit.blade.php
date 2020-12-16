@extends('layouts.layout1')
    @section('content')
        <div class="container-fluid">
            <!-- Page Heading -->
            <!-- <h1 class="h3 mb-2 text-gray-800">Orders</h1> -->
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profile</h6>
                </div>
				<?php
					if($notification = Session::get('notification'))
					{
						echo $notification;
					}
				?>
                <div class="card-body">
					<div class="form-group">
						<div class='alert alert-danger' id="errorProfile">Notification:</div>
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
					<input type="button" class="btn btn-primary" value="Update" onclick="return checknull()">
                </div>
            </div>
        </div>
		<script type="text/javascript">
			function checknull()
			{
				var full_name = $("input[name=full_name]").val();
				var avatar = $("input[name=b64]").val();
				var address = $("input[name=address]").val();
				var birthday = $("input[name=birthday]").val();
				$("#errorProfile").html('Notification:');
				var check = true;
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
				if(check)
				{
					// $("#error").html('Notification:');
					$.ajax({
					type:'POST',
					url:"{{ route('profile.postMyProfile') }}",
					data:{
						full_name:full_name,
						b64:avatar,
						address:address,
						birthday:birthday,
						_token: '{{csrf_token()}}'
					},
					success:function(data){
						alert(data.msg);
						location.reload();
					},
					error: function (msg) {
						alert("Error server");
					}
					
					});
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
			<?php
			if($profile)
			{
				echo("
					document.getElementById('img').src = '$profile->avatar';
					document.getElementById('b64').value = '$profile->avatar';
					document.getElementById('full_name').value = '$profile->full_name';
					document.getElementById('address').value = '$profile->address';
					document.getElementById('birthday').value = '$profile->birthday';
				");
			}
			?>
		</script>
    @endsection
