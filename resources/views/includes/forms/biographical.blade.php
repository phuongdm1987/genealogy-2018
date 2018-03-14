<form action="{{ route('biographical.update', ['id' => $person->biographical->id]) }}" method="POST">
    {{ csrf_field() }}
    {{ method_field('PUT') }}{{-- Birth place --}}
    <div class="form-group row">
        <label for="birth_place" class="col-md-4 col-form-label text-md-right">Birth place</label>

        <div class="col-md">
            <input type="text" id="birth_place" class="form-control{{ $errors->has('birth_place') ? ' is-invalid' : '' }}" name="birth_place" value="{{ old('birth_place', $person->biographical->birth_place) }}">

            @if ($errors->has('birth_place'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('birth_place') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- Company --}}
    <div class="form-group row">
        <label for="company" class="col-md-4 col-form-label text-md-right">Company</label>

        <div class="col-md">
            <input type="text" id="company" class="form-control{{ $errors->has('company') ? ' is-invalid' : '' }}" name="company" value="{{ old('company', $person->biographical->company) }}">

            @if ($errors->has('company'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('company') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- Career --}}
    <div class="form-group row">
        <label for="career" class="col-md-4 col-form-label text-md-right">Career</label>

        <div class="col-md">
            <input type="text" id="career" class="form-control{{ $errors->has('career') ? ' is-invalid' : '' }}" name="career" value="{{ old('career', $person->biographical->career) }}">

            @if ($errors->has('career'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('career') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- School --}}
    <div class="form-group row">
        <label for="school" class="col-md-4 col-form-label text-md-right">School</label>

        <div class="col-md">
            <input type="text" id="school" class="form-control{{ $errors->has('school') ? ' is-invalid' : '' }}" name="school" value="{{ old('school', $person->biographical->school) }}">

            @if ($errors->has('school'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('school') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- Subject --}}
    <div class="form-group row">
        <label for="subject" class="col-md-4 col-form-label text-md-right">Subject</label>

        <div class="col-md">
            <input type="text" id="subject" class="form-control{{ $errors->has('subject') ? ' is-invalid' : '' }}" name="subject" value="{{ old('subject', $person->biographical->subject) }}">

            @if ($errors->has('subject'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('subject') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- Degree --}}
    <div class="form-group row">
        <label for="degree" class="col-md-4 col-form-label text-md-right">Degree</label>

        <div class="col-md">
            <input type="text" id="degree" class="form-control{{ $errors->has('degree') ? ' is-invalid' : '' }}" name="degree" value="{{ old('degree', $person->biographical->degree) }}">

            @if ($errors->has('degree'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('degree') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- Hobbies --}}
    <div class="form-group row">
        <label for="hobbies" class="col-md-4 col-form-label text-md-right">Hobbies</label>

        <div class="col-md">
            <textarea id="hobbies" class="form-control{{ $errors->has('hobbies') ? ' is-invalid' : '' }}" name="hobbies">{{ old('hobbies', $person->biographical->hobbies) }}</textarea>

            @if ($errors->has('hobbies'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('hobbies') }}</strong>
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