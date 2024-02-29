<!DOCTYPE html>
<html>
<head>
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
</style>
</head>
<body>

<h1>New Clients</h1>

<table id="customers">
  <tr>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
  </tr>
  @foreach($new_users as $user)
  <tr>
    <td>{{$user->name}}</td>
    <td>{{$user->email}}</td>
    <td>{{$user->phone}}</td>
  </tr>
  @endforeach
</table>

<h1>New Posts</h1>

<table id="customers">
  <tr>
    <th>Client</th>
    <th>Title</th>
    <th>Description</th>
    <th>Contact Number</th>
  </tr>
  @foreach($new_posts as $post)
  <tr>
    <td>{{$post->user->name}}</td>
    <td>{{$post->title}}</td>
    <td>{{$post->description}}</td>
    <td>{{$post->phone}}</td>
  </tr>
  @endforeach
</table>

</body>
</html>


