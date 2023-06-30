<form action="{{route('upload-file')}}" method="post" enctype='multipart/form-data'>
@csrf

<input type="file" name="file">


<input type="submit">

<img src="https://upload-again.s3.amazonaws.com/{{$lastImage->image}}" width="100px" alt="">

<a href="{{route('download',$lastImage->id)}}">download</a>
</form>
