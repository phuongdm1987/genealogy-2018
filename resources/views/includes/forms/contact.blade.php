<form action="{{ route('contacts.update', ['id' => $person->contact->id]) }}" method="POST">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    {{-- Email --}}
    <div class="form-group row">
        <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

        <div class="col-md">
            <input type="email" id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email', $person->contact->email) }}">

            @if ($errors->has('email'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- Mobile --}}
    <div class="form-group row">
        <label for="mobile" class="col-md-4 col-form-label text-md-right">Mobile</label>

        <div class="col-md">
            <input type="text" id="mobile" class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" value="{{ old('mobile', $person->contact->mobile) }}">

            @if ($errors->has('mobile'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('mobile') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- Skype --}}
    <div class="form-group row">
        <label for="skype" class="col-md-4 col-form-label text-md-right">Skype</label>

        <div class="col-md">
            <input type="text" id="skype" class="form-control{{ $errors->has('skype') ? ' is-invalid' : '' }}" name="skype" value="{{ old('skype', $person->contact->skype) }}">

            @if ($errors->has('skype'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('skype') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- Facebook url --}}
    <div class="form-group row">
        <label for="facebook_url" class="col-md-4 col-form-label text-md-right">Facebook url</label>

        <div class="col-md">
            <input type="text" id="facebook_url" class="form-control{{ $errors->has('facebook_url') ? ' is-invalid' : '' }}" name="facebook_url" value="{{ old('facebook_url', $person->contact->facebook_url) }}">

            @if ($errors->has('facebook_url'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('facebook_url') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- Address --}}
    <div class="form-group row">
        <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>

        <div class="col-md">
            <textarea id="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address">{{ old('address', $person->contact->address) }}</textarea>

            @if ($errors->has('address'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <small class="form-text text-muted text-center">
        You can also add or change details later.
    </small>

    <div class="text-center mt-md-3">
        <button type="submit" class="btn btn-primary">Ok</button>
        <button type="reset" class="btn btn-default">Cancel</button>
    </div>
</form>