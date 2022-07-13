@extends('layouts.app')


@section('title', 'Plans')

@section('page', 'Plans -create')

@section('button')
    <a href="{{ route('plans.index')}}" class="anchorcss">
        <div class="sidebar-card" >Listings</div>
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => isset($data['enbldEdit']) ? array('plans.update', $data['plandata']['id']):'plans.store', 'files' => true]) !!}
                        @isset($data['enbldEdit'])  @method('PUT')   @endisset
                        <div class="form-group row mlb-4">
                          <label for="inputPassword" class="col-sm-2 col-form-label">Title</label>
                          <div class="col-sm-10">
                            <input type="text" name="title" class="form-control borderform @error('title') is-invalid @enderror" id="inputPassword" placeholder="Title" value="{{ old('title',$data['plandata']['title'] ?? null)  }}">
                            @error('title')
                                <small class="invalid-feedback d-block">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        </div>
                        <div class="form-group row mlb-4">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Number of days</label>
                            <div class="col-sm-10">
                                <input type="text" name="allowable_days" class="form-control borderform @error('allowable_days') is-invalid @enderror"  placeholder="Number of days." value="{{ old('allowable_days',$data['plandata']['allowable_days'] ?? null)  }}">
                                @error('allowable_days')
                                    <small class="invalid-feedback d-block">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mlb-4">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Price(₹)</label>
                            <div class="col-sm-10">
                                <input type="text" name="price" class="form-control borderform @error('price') is-invalid @enderror"  placeholder="Price" value="{{ old('price',$data['plandata']['price'] ?? null)  }}">
                                @error('price')
                                    <small class="invalid-feedback d-block">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mlb-4">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-10">
                                <input type="file" name="img" accept="image/*" class="form-control borderform" id="staticEmail">
                                <span id="bgImgpreview">
                                </span>
                                 @isset($data['plandata']->images) <img src="{{ asset('storage/'.$data['plandata']->images->thumb_img) }}" width="50" height="50"/>@endisset
                                 @error('img')
                                      <span class="invalid-feedback d-block" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                            </div>
                        </div>

                        <div class="form-group row mlb-4">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea name="description" placeholder="Use comma seperated sentences to describe the plan description" id="" cols="30" rows="5"  class="form-control borderform">{{ old('description',$data['plandata']['description'] ?? null) }}</textarea>
                                @error('description')
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
            $('#bgImgpreview').after('<img src="'+e.target.result+'" width="50" height="50"/>');
        };
        reader.readAsDataURL(input.files[0]);
    }
    }
    </script>
@endpush
