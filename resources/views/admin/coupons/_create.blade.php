@extends('layouts.app')


@section('title', 'Coupons')

@section('page', 'Coupons -create')

@section('button')
    <a href="{{ route('coupons.index')}}" class="anchorcss">
        <div class="sidebar-card" >Listings</div>
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => isset($data['enbldEdit']) ? array('coupons.update', $data['coupondata']['id']):'coupons.store', 'files' => true]) !!}
                       @isset($data['enbldEdit'])  @method('PUT')   @endisset
                        <div class="form-group row mlb-4">
                          <label for="inputPassword" class="col-sm-2 col-form-label">Title</label>
                          <div class="col-sm-10">
                            <input type="text" name="title" class="form-control borderform" id="inputPassword" placeholder="Title" value="{{ old('title',$data['coupondata']['title'] ?? null)  }}">
                            @error('title')
                              <span class="invalid-feedback d-block" role="alert">
                                  <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                        </div>



                        <div class="form-group row mlb-4">
                          <label  class="col-sm-2 col-form-label">Equivalent Coins</label>
                          <div class="col-sm-10">
                            <input type="number" name="equivalent_coins" class="form-control borderform" placeholder="Equivalent Coins" value="{{ old('equivalent_coins',$data['coupondata']['equivalent_coins'] ?? null)  }}">
                            @error('equivalent_coins')
                                  <span class="invalid-feedback d-block" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                            </div>
                        </div>

                        <div class="form-group row mlb-4">
                            <label  class="col-sm-2 col-form-label">Date Of Validity</label>
                            <div class="col-sm-10">
                            <input type="date" name="validity" class="form-control borderform" value="{{ isset($data['coupondata']['validity']) ? $data['coupondata']['validity'] : ''  }}">
                            @error('validity')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mlb-4">
                            <label  class="col-sm-2 col-form-label">Offer Code</label>
                            <div class="col-sm-10">
                            <input type="text" name="code" class="form-control borderform" placeholder="Offer Code" value="{{ old('code',$data['coupondata']['code'] ?? null)  }}">
                            @error('code')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mlb-4">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea name="description" placeholder="Description" id="" cols="30" rows="5"  class="form-control borderform">{{ old('description',$data['coupondata']['description'] ?? null) }}</textarea>
                                @error('description')
                              <span class="invalid-feedback d-block" role="alert">
                                  <strong>{{ $message }}</strong>
                                </span>

                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mlb-4">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Thumb Image</label>
                            <div class="col-sm-10">
                              <input type="file" name="thumb_img" class="form-control borderform" accept="image/*" id="staticEmail" value="email@example.com">
                              <span id="bgImgpreview">
                              </span>
                               @isset($data['coupondata']->images) <img src="{{ asset('storage/'.$data['coupondata']->images->thumb_img) }}" width="50" height="50"/>@endisset
                               @error('thumb_img')
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
        $('input[name="thumb_img"]').on('change',function(){
            bgPreview(this);
        });
    });

    function bgPreview(input){
        if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#bgImgpreview + img').remove();
            $('#bgImgpreview').after('<img src="'+e.target.result+'" width="150" height="200"/>');
        };
        reader.readAsDataURL(input.files[0]);
    }
    }
    </script>
@endpush
