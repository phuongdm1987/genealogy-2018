<div class="card">
    <div class="card-header text-center">{{ $person->getFullName() ?? 'Me' }}</div>

    <div class="card-body">
        {{--@if ($person->avatar)--}}
            <div class="text-center">
                <img src="{{ $person->getAvatar() }}" alt="{{ $person->getFullName() }}" class="img-thumbnail">
            </div>
        {{--@else--}}
            <form class="form-inline" id="avatar-upload" action="{{ route('persons.upload.avatar', ['id' => $person->id]) }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="avatar" name="avatar" value="{{ old('avatar', $person->avatar) }}" onchange="document.getElementById('avatar-upload').submit();">
                    <label class="custom-file-label" for="avatar">Choose image</label>
                </div>
            </form>
        {{--@endif--}}

        <div class="mt-md-3">
            <nav class="mb-md-3">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-personal" role="tab" aria-controls="nav-personal" aria-selected="true">Personal</a>
                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</a>
                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-biographical" role="tab" aria-controls="nav-biographical" aria-selected="false">Biographical</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                {{-- Tab Person --}}
                <div class="tab-pane fade show active" id="nav-personal" role="tabpanel" aria-labelledby="nav-home-tab">
                    @include('includes.forms.person')
                </div>

                {{-- Tab Contact --}}
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                    @include('includes.forms.contact')
                </div>

                {{-- Tab Biographical --}}
                <div class="tab-pane fade" id="nav-biographical" role="tabpanel" aria-labelledby="nav-biographical-tab">
                    @include('includes.forms.biographical')
                </div>
            </div>
        </div>
    </div>
</div>