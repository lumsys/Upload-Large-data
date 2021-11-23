<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CSV Upload Tasks</title>
  </head>
  <body>
  <h1 class="text-center">Upload file</h1>
<hr>
<form method="post" action="{{ url('import') }}"  enctype="multipart/form-data">
    @csrf

  <div class=""form-group{{$errors->has('file') ? 'has-error': '' }}">  
<input type="file" name="file" id="file"> 
@if ($errors->has('file'))
    <span class="help-block">
        <strong>{{$errors->first('file')}}</strong>
</span>
@endif

</div>

<button type="submit">Submit</button>

</form>
  </div>
</nav>


              </div>
          </div>
      </div>


  </div>

   </body>
</html>