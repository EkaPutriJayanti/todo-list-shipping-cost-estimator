<!DOCTYPE html>
<html>
<head>
    <title>Estimasi Biaya Pengiriman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
    <div class="container">
        <h1>Estimasi Biaya Pengiriman</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('shipping.calculate') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="weight" class="form-label">Berat (kg)</label>
                <input type="number" class="form-control" name="weight" value="{{ old('weight') }}" step="0.01" required min="0">
            </div>

            <div class="mb-3">
                <label for="distance" class="form-label">Jarak (km)</label>
                <input type="number" class="form-control" name="distance" value="{{ old('distance') }}" step="0.1" required min="0">
            </div>

            <div class="mb-3">
                <label for="service" class="form-label">Tipe Layanan</label>
                <select name="service" class="form-control" required>
                    <option value="">-- Pilih Layanan --</option>
                    <option value="regular" {{ old('service') === 'regular' ? 'selected' : '' }}>Regular</option>
                    <option value="express" {{ old('service') === 'express' ? 'selected' : '' }}>Express</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Hitung</button>
        </form>

        @if (session('cost'))
            <div class="alert alert-success mt-4">
                <strong>Total Biaya:</strong> Rp {{ number_format(session('cost'), 0, ',', '.') }}
            </div>
        @endif
    </div>
</body>
</html>