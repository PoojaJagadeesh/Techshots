@extends('layouts.app')


@section('title', 'Infographics')

@section('page', 'Infographics -create')
@section('button')
    <a href="{{ route('infoGraphics.index')}}" class="anchorcss">
        <div class="sidebar-card" >Listings</div>
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => isset($data['enbldEdit']) ? array('infoGraphics.update', $data['infodata']['id']):'infoGraphics.store', 'files' => true]) !!}
                         @isset($data['enbldEdit'])  @method('PUT')   @endisset
                        <div class="form-group row">
                          <label for="inputPassword" class="col-sm-2 col-form-label">Alt Text</label>
                          <div class="col-sm-10">
                            <input type="text" name="alt_text" class="form-control borderform" id="inputPassword" placeholder="Alt text" value="{{ old('alt_text',$data['infodata']['alt_text'] ?? null)  }}">
                            @error('alt_text')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                          </div>
                        </div>

                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-10">
                                <span id="bgImgpreview">
                                </span>
                                 @isset($data['infodata']->images) <img src="{{ asset('storage/'.$data['infodata']->images->img) }}" width="450" height="300"/>@endisset
                              <input type="file" name="img" class="form-control borderform" accept="image/*" id="staticEmail" value="email@example.com">
                              @error('img')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <span id="specsize" @if(!$errors->has('width') && !$errors->has('height')) style="display: none;" @endif >
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Dimensions</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                  <input type="text" name="width" class="form-control borderform col-sm-6" placeholder="Width" value="{{ old('width') }}">
                                  <input type="text" name="height" class="form-control borderform col-sm-6" placeholder="Height" value="{{ old('height') }}" >
                                  @error('width')
                                        <span class="invalid-feedback d-block col-sm-6" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                  @enderror
                                  @error('height')
                                        <span class="invalid-feedback d-block col-sm-6" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                </div>
                            </div>
                        </span>

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
            if(this.files.length != 0)
            $('span#specsize').show();
            else
            $('span#specsize').hide(); $('span#specsize input[type="text"]').val('');
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
