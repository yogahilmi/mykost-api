<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register - MyKost</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container"><br>
        <div class="col-md-4 col-md-offset-4">
            <h2 class="text-center"><b>MyKost</b> | Signup</h3>
            <hr>
            @if(session('error'))
            <div class="alert alert-danger">
                <b>Opps!</b> {{session('error')}}
            </div>
            @elseif (session('success'))
            <div class="alert alert-success">
                {{session('success')}}
            </div>
            @endif
            <form action="{{ route('signup') }}" method="post">
            @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Name" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="form-group">
                <label for="role">Role</label>
                    <select class="form-control" name="role">
                        <option value="0">Owner</option>
                        <option value="1">Premium User</option>
                        <option value="2">Reguler User</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Signup</button>
                <a class="btn btn-secondary btn-block" href="{{ route('index') }}">Already have an account? Login here!</a>
            </form>
        </div>
    </div>
</body>
</html>
