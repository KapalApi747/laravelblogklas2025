<div class="row">
    <!-- Gebruikerskaart -->
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">
                <h5>Totaal gebruikers: {{ $totalUsers }}</h5>
                <small>Actief: {{ $activeUsers }} | Inactief: {{ $inactiveUsers }}</small>
            </div>
        </div>
    </div>

    <!-- Posts-kaart -->
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">
                <h5>Totaal posts: {{ $totalPosts }}</h5>
                <small>Gepubliceerd: {{ $publishedPosts }} | Niet gepubliceerd: {{ $unpublishedPosts }}</small>
            </div>
        </div>
    </div>
</div>
