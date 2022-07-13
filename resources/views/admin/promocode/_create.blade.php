@extends('layouts.app')


@section('title', 'Promo Code')

@section('page', 'Promo Code-Create')

@section('button')
    <a href="{{ route('promocode.index')}}" class="anchorcss">
        <div class="sidebar-card" >Listings</div>
    </a>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => isset($data['enbldEdit']) ? array('promocode.update', $data['promo']['id']):'promocode.store',  'files' => true]) !!}
                    @isset($data['enbldEdit'])  @method('PUT')   @endisset
                        <div class="form-group row mlb-4">
                          <label for="inputPassword" class="col-sm-2 col-form-label">Title</label>
                          <div class="col-sm-10">
                            <input type="text" name="code_name" class="form-control" id="code_name" placeholder="title" value="{{ old('code_name',$data['promo']['code_name'] ?? null)  }}">
                               @error('code_name')
                                <small class="invalid-feedback d-block">
                                    {{ $message }}
                                </small>
                            @enderror
                          </div>
                        </div>
                        <div class="form-group row mlb-4">
                          <label for="inputPassword" class="col-sm-2 col-form-label">Percentage of discount</label>
                          <div class="col-sm-10">
                            <input type="number" name="discount_percentage" class="form-control" id="percentage" placeholder="Percentage of discount" maxlength="3" value="{{ isset($data['promo']['discount_percentage']) ? $data['promo']['discount_percentage'] : ''  }}">
                               @error('discount_percentage')
                                <small class="invalid-feedback d-block">
                                    {{ $message }}
                                </small>
                            @enderror
                          </div>
                        </div>
                        <div class="form-group row mlb-4">
                          <label for="inputPassword" class="col-sm-2 col-form-label">Prefix</label>
                          <div class="col-sm-10">
                            <select name="prefix" class="form-control borderform" id="prefix">
                               <option value="">Select</option>
                               <option value="CAN" @if(old('prefix', $data['promo']['prefix'] ?? null) == "CAN") selected @endif>Cansa</option>
                               <option value="CCO" @if(old('prefix', $data['promo']['prefix'] ?? null) == "CCO") selected @endif>Can&Co</option>
                               <option value="ANX" @if(old('prefix', $data['promo']['prefix'] ?? null) == "ANX") selected @endif>AnxialPay</option>
                              </select>
                               @error('prefix')
                                <small class="invalid-feedback d-block">
                                    {{ $message }}
                                </small>
                            @enderror
                          </div>
                        </div>
                        <div class="form-group row mlb-4">
                          <label for="inputPassword" class="col-sm-2 col-form-label">Code</label>
                          <div class="col-sm-10">
                              <input type="text" name="code" class="form-control-plaintext" id="code" value="{{ isset($data['promo']['code']) ? $data['promo']['code'] : ''  }}" readonly><i class="fa fa-sync-alt" onclick="regenerateCode()"></i>
                               @error('prefix')
                                <small class="invalid-feedback d-block">
                                    {{ $message }}
                                </small>
                            @enderror
                          </div>
                        </div>
                        <div class="form-group row mlb-4">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Plan</label>
                            <div class="col-sm-10">
                              <select name="plan_id" class="form-control borderform">
                               <option value="">Select</option>
                              @foreach($data['plan'] as $plan)
                               <option value="{{ $plan->id }}" @if(old('plan_id', $data['promo']['plan_id'] ?? null) == $plan->id) selected @endif>{{ $plan->title }}</option>
                              @endforeach
                              </select>
                               @error('plan_id')
                                <small class="invalid-feedback d-block">
                                    {{ $message }}
                                </small>
                            @enderror
                            </div>
                        </div>
                           <div class="form-group row mlb-4">
                        <label  class="col-sm-2 col-form-label">Is there validity ?</label>
                        <div class="col-sm-8">
                          <input type="checkbox" id="validity" name="validity" value="1" {{ (isset($data['promo']['validity']) && $data['promo']['validity'] == 1) ? 'checked' : '' }} >
                        </div>
                    </div>
                    <div class="form-group row validity_div mlb-4" style="display:none;">
                            <label  class="col-sm-2 col-form-label">From</label>
                            <div class="col-sm-10">
                              <input type="date" name="from" class="form-control borderform" id="staticEmail" value="{{ isset($data['promo']['from']) ? $data['promo']['from'] : ''  }}">
                              @error('from')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                          <div class="form-group row validity_div mlb-4" style="display:none;">
                            <label  class="col-sm-2 col-form-label">To</label>
                            <div class="col-sm-10">
                              <input type="date" name="to" class="form-control borderform" id="staticEmail" value="{{ isset($data['promo']['to']) ? $data['promo']['to'] : ''  }}">
                              @error('to')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                         <div class="form-group row mlb-4">
                        <label  class="col-sm-2 col-form-label">Is reusable?</label>
                        <div class="col-sm-8">
                          <input type="checkbox" id="reusable" name="reusable" value="1" {{ (isset($data['promo']['reusable']) && $data['promo']['reusable'] == 1) ? 'checked' : '' }} >
                        </div>
                    </div>
                        <div class="form-group row reuse_div mlb-4" style="display:none;">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Count of Usage</label>
                            <div class="col-sm-10">
                              <input type="text" name="count_usage" class="form-control-plaintext" id="staticEmail" value="{{ isset($data['promo']['count_usage']) ? $data['promo']['count_usage'] : ''  }}">
                            </div>
                             @error('count_usage')
                                <small class="invalid-feedback d-block">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>


                        <div class="form-group row mlb-4 float-right">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
@push('page-scripts')
<script>
$('#reusable').on('change', function(e) {

		if($(this).is(':checked')) {
	  	$('.reuse_div').show();
	  } else {
	  		$('.reuse_div').hide();
	  }
	});
  $('#validity').on('change', function(e) {

		if($(this).is(':checked')) {
	  	$('.validity_div').show();
	  } else {
	  		$('.validity_div').hide();
	  }
	});
  $('#prefix').on('change', function() {
    var pref=$(this).val();
  var text = "";
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  for (var i = 0; i < 10; i++)
    text += possible.charAt(Math.floor(Math.random() * possible.length));

 $('#code').val(pref+'-'+text);
});
function regenerateCode(){

      var pref=$('#prefix').val();
  var text = "";
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  for (var i = 0; i < 10; i++)
    text += possible.charAt(Math.floor(Math.random() * possible.length));

 $('#code').val(pref+'-'+text);
}
</script>
@endpush
