<!DOCTYPE html>
<html>
<head>
  <title>Form Example</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    .form-container {
      max-width: 500px;
      margin: 0 auto;
      padding: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="form-container">
      <h2>Form Example</h2>
      <form id="myForm" method="GET">
        @csrf
        <div class="form-group">
          <label for="title">Title:</label>
          <input type="text" class="form-control" id="title" name="title">
        </div>
        <div class="form-group">
          <label for="type">Type:</label>
          <input type="text" class="form-control" id="type" name="type">
        </div>
        <div class="form-group">
            <label for="price">price :</label>
            <input type="number" class="form-control" id="price" name="price">
          </div>
        <div class="form-group">
          <label for="product_code">Product Code:</label>
          <input type="text" class="form-control" id="product_code" name="product_code">
        </div>
        <div class="form-group">
          <label for="description">Description:</label>
          <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <div class="form-group">
          <label for="img">Image URL:</label>
          <input type="text" class="form-control" id="img" name="img">
        </div>
        <button type="submit" class="btn btn-primary" >Submit</button>
      </form>
    </div>
  </div>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
