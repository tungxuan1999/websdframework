<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('includes.head')
</head>
<body>
    <header>
        <div class="siderbar">
            @include('includes.sidebar')
        </div>
    </header>
    @yield('content')
    <script>
    function signup(){
        var newuser = {
            user:document.getElementById("username").value,
            pass: document.getElementById("password").value,
            name: document.getElementById("name").value,
            gender: document.getElementById("gender").value,
            sensor: document.getElementById("sensor").value,
            Status: document.getElementById("status").value,
    };
    axios.post('https://cors-anywhere.herokuapp.com/http://apithcntt03.gear.host/api/CreateAccount', newuser).then((response) => {
        var result = response.data;
        if (result) {
            alert('Create Success');
        } else {
            alert('Create faile');
        }
    });
    }
</script>
</body>
</html>
