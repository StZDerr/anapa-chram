<div class="clergy">
    <div class="container">
        <div class="title text-center">ДУХОВЕНСТВО ХРАМА</div>
        <div class="details">Священнослужители, постоянно служащие в нашем храме</div>
        <div class="clergy-cards">
            <div class="row g-4">
                @foreach ($clergy->where('category', 'ДУХОВЕНСТВО ХРАМА') as $member)
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="clergy-card">
                            @if ($member->image)
                                <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->full_name }}">
                            @endif
                            <div class="card-name">{{ $member->full_name }}</div>
                            <div class="card-position">{{ $member->position }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="title text-center mt-5">ПЕРСОНАЛ ХРАМА</div>
        <div class="details">Работающих на приходе</div>
        <div class="clergy-cards">
            <div class="row g-4">
                @foreach ($clergy->where('category', 'ПЕРСОНАЛ ХРАМА') as $member)
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="clergy-card">
                            @if ($member->image)
                                <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->full_name }}">
                            @endif
                            <div class="card-name">{{ $member->full_name }}</div>
                            <div class="card-position">{{ $member->position }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
