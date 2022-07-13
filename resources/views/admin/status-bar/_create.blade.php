@extends('layouts.app')


@section('title', 'History')

@section('page', 'Status Bar -Create/Edit')
@section('button')
    <a href="{{ route('statusBar.index')}}" class="anchorcss">
        <div class="sidebar-card" >Listings</div>
    </a>
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => isset($data['enbldEdit']) ? array('statusBar.update', $data['statdata']['id']):'statusBar.store', 'files' => true]) !!}
                        @isset($data['enbldEdit'])  @method('PUT')   @endisset
                        <div class="form-group row mlb-4">
                            <label for="inputFirstName" class="col-sm-2 col-form-label">Heading</label>
                            <div class="col-sm-10">
                            <input type="text" name="heading" class="form-control borderform" id="inputFirstName" value="{{ old('heading',$data['statdata']['heading'] ?? null)  }}" placeholder="Heading">
                            @error('heading')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                            </div>
                        </div>
                        <div class="form-group row mlb-4">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Content</label>
                            <div class="col-sm-10">
                                <textarea name="content" placeholder="content" id="" cols="30" rows="3"  class="form-control borderform">{{ old('content',$data['statdata']['content'] ?? null) }}</textarea>
                                @error('content')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mlb-4">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Full image</label>
                            <div class="col-sm-10">
                                <input type="file" name="bg_img" class="form-control borderform" accept="image/*" id="staticEmail" value="email@example.com">
                                <span id="bgImgpreview">
                                </span>
                                @isset($data['statdata']->images) <img src="{{ asset('storage/'.$data['statdata']->images->bg_img) }}" width="450" height="300"/>@endisset
                                @error('bg_img')

                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mlb-4">
                            <label  class="col-sm-2 col-form-label">Year</label>
                            <div class="col-sm-10">
                                <input type="date" name="year" class="form-control borderform datepicker" value="{{ isset($data['statdata']['year']) ? \Carbon\Carbon::createFromFormat('Y-m-d',$data['statdata']['year'].'-01-01')->toDateString() : '' }}" id="staticEmail">
                                @error('year')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mlb-4">
                            <label  class="col-sm-2 col-form-label">Display date</label>
                            <div class="col-sm-10">
                                <input type="date" name="display_date" value="{{ isset($data['statdata']['display_date']) ? $data['statdata']['display_date'] : ''  }}" class="form-control borderform datepicker" id="staticEmail">
                                @error('display_date')
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
        $('input[name="bg_img"]').on('change',function(){
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

