<form action="{{ route('persons.update', ['id' => $person->id]) }}" method="POST">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    {{-- First name --}}
    <div class="form-group row">
        <label for="first_name" class="col-md-4 col-form-label text-md-right">First name</label>

        <div class="col-md">
            <input type="text" id="first_name" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name', $person->first_name) }}" autofocus>

            @if ($errors->has('first_name'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('first_name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- Middle name --}}
    <div class="form-group row">
        <label for="middle_name" class="col-md-4 col-form-label text-md-right">Middle name</label>

        <div class="col-md">
            <input type="text" id="middle_name" class="form-control{{ $errors->has('middle_name') ? ' is-invalid' : '' }}" name="middle_name" value="{{ old('middle_name', $person->middle_name) }}">

            @if ($errors->has('middle_name'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('middle_name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- Last name --}}
    <div class="form-group row">
        <label for="last_name" class="col-md-4 col-form-label text-md-right">Last name</label>

        <div class="col-md">
            <input type="text" id="last_name" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name', $person->last_name) }}">

            @if ($errors->has('last_name'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('last_name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- Sex --}}
    <div class="form-group row">
        <label for="sex" class="col-md-4 col-form-label text-md-right">Sex</label>

        <div class="col-md">
            @foreach(Genealogy\Entities\Person::SEX as $key => $value)
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="{{ strtolower($value) }}" name="sex" class="custom-control-input" value="{{ $key }}" {{ $key == old('sex', $person->sex) ? ' checked' : '' }}>
                    <label class="custom-control-label" for="{{ strtolower($value) }}">{{$value}}</label>
                </div>
            @endforeach

            @if ($errors->has('sex'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('sex') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- Birth of date --}}
    <div class="form-group row">
        <label for="birth_of_date" class="col-md-4 col-form-label text-md-right">Birth of date</label>

        <div class="col-md">
            <input type="date" id="birth_of_date" class="form-control{{ $errors->has('birth_of_date') ? ' is-invalid' : '' }}" name="birth_of_date" value="{{ old('birth_of_date', $person->getBirthOfDate()) }}">

            @if ($errors->has('birth_of_date'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('birth_of_date') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- Birth of time --}}
    <div class="form-group row">
        <label for="birth_of_time" class="col-md-4 col-form-label text-md-right"></label>

        <div class="col-md">
            <input type="time" id="birth_of_time" class="form-control{{ $errors->has('birth_of_time') ? ' is-invalid' : '' }}" name="birth_of_time" value="{{ old('birth_of_time', $person->getBirthOfTime()) }}">

            @if ($errors->has('birth_of_time'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('birth_of_time') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- Is living --}}
    <div class="form-group row">
        <label for="is_living" class="col-md-4 col-form-label text-md-right"></label>

        <div class="col-md">
            <div class="custom-control custom-checkbox">
                <input onclick="document.getElementById('death').classList.toggle('d-none');" type="checkbox" class="custom-control-input" id="is_living" name="is_living" value="1" {{ 1 == old('is_living', $person->is_living) ? ' checked' : '' }}>
                <label class="custom-control-label" for="is_living">This person is living</label>
            </div>

            @if ($errors->has('is_living'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('is_living') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div id="death" class="{{ 1 == old('is_living', $person->is_living) ? ' d-none' : '' }}">
        {{-- Death of date --}}
        <div class="form-group row">
            <label for="death_of_date" class="col-md-4 col-form-label text-md-right">Death of date</label>

            <div class="col-md">
                <input type="date" id="death_of_date" class="form-control{{ $errors->has('death_of_date') ? ' is-invalid' : '' }}" name="death_of_date" value="{{ old('death_of_date', $person->getDeathOfDate()) }}">

                @if ($errors->has('death_of_date'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('death_of_date') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        {{-- Death of time --}}
        <div class="form-group row">
            <label for="death_of_time" class="col-md-4 col-form-label text-md-right"></label>

            <div class="col-md">
                <input type="time" id="death_of_time" class="form-control{{ $errors->has('death_of_time') ? ' is-invalid' : '' }}" name="death_of_time" value="{{ old('death_of_time', $person->getDeathOfTime()) }}">

                @if ($errors->has('death_of_time'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('death_of_time') }}</strong>
                    </span>
                @endif
            </div>
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