@extends('layouts.app')


@section('title', 'Scratch Cards')

@section('page', 'Scratch Cards -create')
@section('button')
    <a href="{{ route('scratchCard.index')}}" class="anchorcss">
        <div class="sidebar-card" >Listings</div>
    </a>
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => isset($data['enbldEdit']) ? array('scratchCard.update', $data['scratchdata']['id']):'scratchCard.store', 'files' => true]) !!}
                       @isset($data['enbldEdit'])  @method('PUT')   @endisset
                       <div class="form-group row mlb-4">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Scratch Card Title</label>
                        <div class="col-sm-10">
                            <input type="text" name="scratch_title" class="form-control borderform" placeholder="Scratch card title" value="{{ old('scratch_title',$data['scratchdata']['scratch_title'] ?? null)  }}">
                          @error('scratch_title')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>

                        <div class="form-group row mlb-4">
                          <label for="inputPassword" class="col-sm-2 col-form-label">Scratch Card Type</label>
                          <div class="col-sm-10">
                              <select name="scratch_type" class="form-control borderform">
                               <option value="">Select</option>
                               <option value="0" @if(old('scratch_type', $data['scratchdata']['scratch_type'] ?? null) == "0") selected @endif>Offer</option>
                               <option value="1" @if(old('scratch_type', $data['scratchdata']['scratch_type'] ?? null) == "1") selected @endif>Coin</option>
                              </select>
                            @error('scratch_type')
                              <span class="invalid-feedback d-block" role="alert">
                                  <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                        </div>
                        <div class="form-group row mlb-4">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea name="description" placeholder="Description" id="" cols="30" rows="5"  class="form-control borderform">{{ old('description',$data['scratchdata']['description'] ?? null) }}</textarea>
                                @error('description')
                              <span class="invalid-feedback d-block" role="alert">
                                  <strong>{{ $message }}</strong>
                                </span>

                                @enderror
                            </div>
                        </div>

                     <div class="show_offer_div" @if(!$errors->has('offer_title') && !$errors->has('thumb_img') && !$errors->has('offer_code')) style="display: none;" @endif>
                        <div class="form-group row mlb-4">
                            <label  class="col-sm-2 col-form-label">Offer Title</label>
                            <div class="col-sm-8">
                              <input type="text" name="offer_title" class="form-control borderform" placeholder="Offer Title" value="{{ old('offer_title',$data['scratchdata']['scratchable']['title'] ?? null)  }}">
                              @error('offer_title')
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
                               @isset($data['scratchdata']['scratch_offer_image']) <img src="{{ asset('storage/'.$data['scratchdata']['scratch_offer_image']) }}" width="50" height="50"/>@endisset
                               @error('thumb_img')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mlb-4">
                            <label  class="col-sm-2 col-form-label">Date Of Validity</label>
                            <div class="col-sm-10">
                              <input type="date" name="validity" class="form-control borderform" value="{{ old('validity',$data['scratchdata']['scratchable']['validity'] ?? null)  }}">
                              @error('validity')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                         </div>

                        <div class="form-group row mlb-4">
                            <label  class="col-sm-2 col-form-label">Offer Code</label>
                            <div class="col-sm-8">
                              <input type="text" name="offer_code" class="form-control borderform" placeholder="Offer Code" value="{{ old('offer_code',$data['scratchdata']['scratchable']['code'] ?? null)  }}">
                              @error('offer_code')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                      </div>

                        <div class="show_coins_div" @if(!$errors->has('equivalent_coins')) style="display: none;" @endif>
                        <div class="form-group row mlb-4">
                          <label  class="col-sm-2 col-form-label">Equivalent Coins</label>
                          <div class="col-sm-8">
                            <input type="text" name="equivalent_coins" class="form-control borderform" placeholder="Equivalent Coins" value="{{ old('equivalent_coins',$data['scratchdata']['scratchable']['equivalent_coins'] ?? null)  }}">
                            @error('equivalent_coins')
                                  <span class="invalid-feedback d-block" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
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

        $('select[name="scratch_type"]').on('change',function(){
           if($(this).val() === "0"){ // offer
            $('div.show_offer_div').show(); $('div.show_coins_div').hide();
           }
           else if($(this).val() === "1"){ // coin
            $('div.show_coins_div').show(); $('div.show_offer_div').hide();
           }
           else{
            $('div.show_coins_div').hide(); $('div.show_offer_div').hide();
           }
        });

        performDivTransparency();
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

    function performDivTransparency(){
        var offerDiv = "{{ old('scratch_type', $data['scratchdata']['scratch_type'] ?? null) }}";
        if(offerDiv == "0"){ //offer
         $('div.show_offer_div').show();
        }
        else if(offerDiv == "1"){ //coin
        $('div.show_coins_div').show();
        }

    }
    </script>
@endpush
