@extends('layouts.app')

	@section('content')
		<div class="container">
			<form action="{{ route('test.store')}}" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <textarea 
                	name="body" 
                    class="form-control" 
                    rows="8" cols="8" 
                    maxlength="130"
                    placeholder="Tweet something...." 
                    required>
                    {{ old('body')}}
                </textarea>
                @if($errors->first('body'))
                    {{$errors->first('body')}}
                @endif
            </div>
            <div class="form-group">
                <input class="form-control" type="file" name="images[]" multiple accept="image/*"></input>
                @if($errors->first('images'))
                    {{$errors->first('images')}}
                @endif
            </div>
            <div class="form-group">
                <button class="btn btn-primary">
                    <i class="fa fa-bullhorn "></i>Tweet
                </button>
            </div>
        </form>

        @if($a = Session::get('body'))
        	{{ $a}}
        @endif
		</div>
	@endsection