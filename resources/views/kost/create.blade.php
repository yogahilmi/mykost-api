<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MyKost</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container"><br>
        <div class="col-md-4 col-md-offset-4">
            <h2 class="text-center"><b>MyKost</b> | Create Data</h3>
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
            <form action="{{ route('store') }}" method="post">
            @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Name" required>
                </div>
                <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="location" class="form-control" placeholder="Location" required>
                </div>
                <div class="form-group">
                    <label>Pirce</label>
                    <input type="number" name="price" class="form-control" placeholder="Price" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea type="text" name="description" class="form-control" placeholder="Description" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>
