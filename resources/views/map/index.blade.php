@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-8">Mapa Operatorów</h1>
    
    <div class="bg-white rounded-lg shadow-lg p-4">
        <div id="map" style="height: 600px; width: 100%;"></div>
    </div>
</div>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>

<script>
    // Initialize the map
    const map = L.map('map').setView([52.2297, 21.0122], 6); // Default to Poland

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);

    // Add markers for operators
    const operators = @json($operators);
    
    operators.forEach(operator => {
        if (operator.profile && operator.profile.latitude && operator.profile.longitude) {
            const marker = L.marker([operator.profile.latitude, operator.profile.longitude])
                .addTo(map)
                .bindPopup(`
                    <strong>${operator.name}</strong><br>
                    ${operator.profile.location || 'Location not specified'}<br>
                    <a href="/profile/${operator.id}" class="text-blue-600 hover:underline">View Profile</a>
                `);
        }
    });

    // Fit bounds if there are markers
    if (operators.length > 0) {
        const group = L.featureGroup(
            operators
                .filter(op => op.profile && op.profile.latitude && op.profile.longitude)
                .map(op => L.marker([op.profile.latitude, op.profile.longitude]))
        );
        if (group.getBounds().isValid()) {
            map.fitBounds(group.getBounds().pad(0.1));
        }
    }
</script>
@endsection
