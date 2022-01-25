<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   <h1>Order Placed Successfully!!</h1>
    <table class="table">
    <tr>
    <th>Name</th>
    <td>{{$product_name}}</td>
    </tr>
    <tr>
    <th>Image</th>
    <td><img src="asset('/images/products/'.$product_image)" ></td>
    </tr>
    <tr>
        <th>Price</th>
        <td>{{$price}}</td>
    </tr>
    
  </tbody>
</table>
</body>
</html>