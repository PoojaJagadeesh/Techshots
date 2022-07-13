@extends('layouts.app')


@section('title', 'Product')

@section('page', 'Product -create')

@section('button')
    <a href="{{ route('products.index')}}" class="anchorcss">
        <div class="sidebar-card" >Listings</div>
    </a>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => isset($data['enbldEdit']) ? array('products.update', $data['newsdata']['id']):'products.store', 'files' => true]) !!}
                       @isset($data['enbldEdit'])  @method('PUT')   @endisset
                        <div class="form-group row mlb-4">
                          <label for="heading" class="col-sm-2 col-form-label">Heading</label>
                          <div class="col-sm-10">
                            <input type="text" name="heading" class="form-control borderform" id="heading" placeholder="Heading" value="{{ old('heading',$data['newsdata']['heading'] ?? null)  }}">
                            @error('heading')
                              <span class="invalid-feedback d-block" role="alert">
                                  <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                        </div>
                        <div class="form-group row mlb-4">
                            <label for="product_link" class="col-sm-2 col-form-label">Link</label>
                            <div class="col-sm-10">
                                 <input type="text" name="product_link" class="form-control borderform" id="product_link" placeholder="Link" value="{{ old('product_link',$data['newsdata']['product_link'] ?? null)  }}">
                                @error('product_link')
                              <span class="invalid-feedback d-block" role="alert">
                                  <strong>{{ $message }}</strong>
                                </span>

                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mlb-4">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea name="description" placeholder="description" id="" cols="30" rows="5"  class="form-control borderform">{{ old('description',$data['newsdata']['description'] ?? null) }}</textarea>
                                @error('description')
                              <span class="invalid-feedback d-block" role="alert">
                                  <strong>{{ $message }}</strong>
                                </span>

                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mlb-4">
                            <label for="staticEmail" class="col-sm-2 col-form-label">BackGround image</label>
                            <div class="col-sm-10">
                              <input type="file" name="img" class="form-control borderform" accept="image/*" id="image" value="email@example.com">
                              <span id="bgImgpreview">
                              </span>
                               @isset($data['newsdata']->images) <img src="{{ asset('storage/'.$data['newsdata']->images->img) }}" width="450" height="300"/>@endisset
                               @error('img')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mlb-4">
                            <label  class="col-sm-2 col-form-label">Display date</label>
                            <div class="col-sm-10">
                              <input type="date" name="display_date" class="form-control borderform" id="date" value="{{ isset($data['newsdata']['display_date']) ? $data['newsdata']['display_date'] : ''  }}">
                              @error('display_date')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mlb-4">
                          <label  class="col-sm-2 col-form-label">Price</label>
                          <div class="col-sm-10">
                            <input type="number" name="actual_price" placeholder="Price" class="form-control borderform" value="{{ old('actual_price',$data['newsdata']['actual_price'] ?? null)  }}">
                            @error('actual_price')
                                  <span class="invalid-feedback d-block" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>
                        <div class="form-group row mlb-4">
                          <label  class="col-sm-2 col-form-label">Discount Price</label>
                          <div class="col-sm-10">
                            <input type="number" name="discount_price" placeholder="Discount Price" class="form-control borderform" value="{{ old('discount_price',$data['newsdata']['discount_price'] ?? null)  }}">
                            @error('discount_price')
                                  <span class="invalid-feedback d-block" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>
                       <div class="form-group row mlb-4">
                          <label  class="col-sm-2 col-form-label">Button Label</label>
                          <div class="col-sm-10">
                            <input type="text" name="button_label" placeholder="Button Label" class="form-control borderform" value="{{ old('button_label',$data['newsdata']['button_label'] ?? null)  }}">
                            @error('button_label')
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
