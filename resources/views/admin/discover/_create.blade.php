@extends('layouts.app')


@section('title', 'Discover')

@section('page', 'Discover -create')
@section('button')
    <a href="{{ route('discover.index')}}" class="anchorcss">
        <div class="sidebar-card" >Listings</div>
    </a>
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => isset($data['enbldEdit']) ? array('discover.update', $data['discoverdata']['id']):'discover.store', 'files' => true]) !!}
                    @isset($data['enbldEdit'])  @method('PUT')   @endisset
                    <div class="form-group row mlb-4">
                          <label for="inputPassword" class="col-sm-2 col-form-label">Heading</label>
                          <div class="col-sm-10">
                            <input type="text" name="heading" class="form-control borderform @error('heading') is-invalid @enderror" id="inputPassword" placeholder="Heading" value="{{ old('heading',$data['discoverdata']['heading'] ?? null)  }}">
                            @error('heading')
                                <span class="invalid-feedback d-block" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        </div>
                        <div class="form-group row mlb-4">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Link</label>
                            <div class="col-sm-10">
                                <input type="text" name="link" class="form-control borderform @error('link') is-invalid @enderror" id="inputPassword" placeholder="Link" value="{{ old('link',$data['discoverdata']['link'] ?? null)  }}">
                                @error('link')
                                    <span class="invalid-feedback d-block">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mlb-4">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Tag</label>
                            <div class="col-sm-10">
                                <input type="text" name="tag" class="form-control borderform @error('tag') is-invalid @enderror" id="inputPassword" placeholder="Tag" value="{{ old('tag',$data['discoverdata']['tag'] ?? null)  }}">
                                @error('tag')
                                    <span class="invalid-feedback d-block">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mlb-4">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-10">
                                <input type="file" name="img" accept="image/*" class="form-control borderform" id="staticEmail">
                                <span id="bgImgpreview">
                                </span>
                                 @isset($data['discoverdata']->images) <img src="{{ asset('storage/'.$data['discoverdata']->images->img) }}" width="450" height="300"/>@endisset
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
