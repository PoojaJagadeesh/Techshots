@extends('layouts.app')


@section('title', 'Scoreboard')

@section('page', 'Scoreboard -create')

@section('button')
    <a href="{{ route('scoreBoard.index')}}" class="anchorcss">
        <div class="sidebar-card" >Listings</div>
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => isset($data['enbldEdit']) ? array('scoreBoard.update', $data['scoredata']['id']):'scoreBoard.store', 'files' => true]) !!}
                        @isset($data['enbldEdit'])  @method('PUT')   @endisset
                        <div class="form-group row mlb-4">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Alt Text</label>
                            <div class="col-sm-10">
                            <input type="text" name="alt_text" class="form-control borderform" value="{{ old('alt_text',$data['scoredata']['alt_text'] ?? null)  }}" id="inputPassword" placeholder="Alt text">
                            @error('alt_text')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        </div>

                        <div class="form-group row mlb-4">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-10">
                                <input type="file" name="img" class="form-control borderform" accept="image/*" id="staticEmail" value="email@example.com">
                                <span id="bgImgpreview">
                            </span>
                                @isset($data['scoredata']->images) <img src="{{ asset('storage/'.$data['scoredata']->images->img) }}" width="450" height="300"/>@endisset
                                @error('img')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mlb-4 float-right">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection


@push('page-scripts')
    <script>
    $(function(){
        $('input[name="img"]').on('change',function(){
            bgPreview(this);
        });
    });

    function bgPreview(input){
        if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#bgImgpreview + img').remove();
            $('#bgImgpreview').after('<img src="'+e.target.result+'" width="450" height="300"/>');
        };
        reader.readAsDataURL(input.files[0]);
    }
    }
    </script>
@endpush
