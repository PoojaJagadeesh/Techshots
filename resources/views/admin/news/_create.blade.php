@extends('layouts.app')


@section('title', 'News')

@section('page', 'News -create')

@section('button')
    <a href="{{ route('news.index')}}" class="anchorcss">
        <div class="sidebar-card" >Listings</div>
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => isset($data['enbldEdit']) ? array('news.update', $data['newsdata']['id']):'news.store', 'files' => true]) !!}
                        @isset($data['enbldEdit'])  @method('PUT')   @endisset
                        <div class="form-group row mlb-4">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Heading</label>
                            <div class="col-sm-10">
                            <input type="text" name="heading" class="form-control borderform" id="inputPassword" placeholder="Heading" value="{{ old('heading',$data['newsdata']['heading'] ?? null)  }}">
                            @error('heading')
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
                            <label for="inputPassword" class="col-sm-2 col-form-label">Tag</label>
                            <div class="col-sm-10">
                                <input type="text" name="tag" class="form-control borderform" id="inputPassword" placeholder="Tag" value="{{ old('tag',$data['newsdata']['tag'] ?? null)  }}">
                                @error('tag')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            </div>
                        <div class="form-group row mlb-4">
                            <label for="staticEmail" class="col-sm-2 col-form-label">BackGround image</label>
                            <div class="col-sm-10">
                                <input type="file" name="img" class="form-control borderform" accept="image/*" id="staticEmail" value="email@example.com">
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
                                <input type="date" name="display_date" class="form-control borderform" id="staticEmail" value="{{ isset($data['newsdata']['display_date']) ? $data['newsdata']['display_date'] : ''  }}">
                                @error('display_date')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mlb-4">
                            <label  class="col-sm-2 col-form-label">Priority Order</label>
                            <div class="col-sm-10">
                            <input type="number" name="order_num" placeholder="Priority Order" class="form-control borderform" value="{{ old('order_num',$data['newsdata']['order_num'] ?? null)  }}">
                            @error('order_num')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mlb-4">
                        <label  class="col-sm-2 col-form-label">Is Premium ?</label>
                        <div class="col-sm-8">
                            <input type="checkbox" name="is_premium" value="1" {{ (isset($data['newsdata']['is_premium']) && $data['newsdata']['is_premium'] == 1) ? 'checked' : '' }} >
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
            $('#bgImgpreview').after('<img src="'+e.target.result+'" width="250" height="300"/>');
        };
        reader.readAsDataURL(input.files[0]);
    }
    }
    </script>
@endpush
