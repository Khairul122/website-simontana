<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Wilayah API</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .result { background: #f5f5f5; padding: 10px; margin: 10px 0; border-radius: 5px; }
        .error { background: #ffebee; color: #c62828; }
        .success { background: #e8f5e8; color: #2e7d32; }
        select { width: 100%; padding: 10px; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>Test Wilayah API</h1>

    <h3>Provinsi:</h3>
    <select id="provinsi_id">
        <option value="">Loading...</option>
    </select>

    <h3>Kabupaten:</h3>
    <select id="kabupaten_id" disabled>
        <option value="">Pilih provinsi dulu</option>
    </select>

    <h3>Kecamatan:</h3>
    <select id="kecamatan_id" disabled>
        <option value="">Pilih kabupaten dulu</option>
    </select>

    <h3>Desa:</h3>
    <select id="desa_id" disabled>
        <option value="">Pilih kecamatan dulu</option>
    </select>

    <div id="result"></div>

    <script>
        function log(message, data = null) {
            console.log('[TEST WILAYAH]', message, data || '');
            const resultDiv = document.getElementById('result');
            resultDiv.innerHTML += `<div class="result">${message} ${data ? JSON.stringify(data) : ''}</div>`;
        }

        async function testProvinsi() {
            log('Testing provinsi API...');
            try {
                const response = await fetch('index.php?controller=wilayah&action=getProvinsi');
                log('Response status:', response.status);
                log('Response OK:', response.ok);

                const data = await response.json();
                log('Provinsi data:', data);

                if (data.success && data.data) {
                    const select = document.getElementById('provinsi_id');
                    select.innerHTML = '<option value="">Pilih Provinsi</option>';

                    data.data.forEach(provinsi => {
                        const option = document.createElement('option');
                        option.value = provinsi.id;
                        option.textContent = provinsi.nama;
                        select.appendChild(option);
                    });

                    log(`${data.data.length} provinsi loaded successfully`);
                    select.disabled = false;
                } else {
                    log('Failed to load provinsi:', data);
                }
            } catch (error) {
                log('Error loading provinsi:', error.message);
            }
        }

        async function testKabupaten(provinsiId) {
            if (!provinsiId) return;

            log(`Testing kabupaten API for provinsi ${provinsiId}...`);
            try {
                const response = await fetch(`index.php?controller=wilayah&action=getKabupaten&id=${provinsiId}`);
                const data = await response.json();
                log('Kabupaten data:', data);

                if (data.success && data.data) {
                    const select = document.getElementById('kabupaten_id');
                    select.innerHTML = '<option value="">Pilih Kabupaten</option>';

                    data.data.forEach(kabupaten => {
                        const option = document.createElement('option');
                        option.value = kabupaten.id;
                        option.textContent = kabupaten.nama;
                        select.appendChild(option);
                    });

                    log(`${data.data.length} kabupaten loaded successfully`);
                    select.disabled = false;
                } else {
                    log('Failed to load kabupaten:', data);
                }
            } catch (error) {
                log('Error loading kabupaten:', error.message);
            }
        }

        async function testKecamatan(kabupatenId) {
            if (!kabupatenId) return;

            log(`Testing kecamatan API for kabupaten ${kabupatenId}...`);
            try {
                const response = await fetch(`index.php?controller=wilayah&action=getKecamatan&id=${kabupatenId}`);
                const data = await response.json();
                log('Kecamatan data:', data);

                if (data.success && data.data) {
                    const select = document.getElementById('kecamatan_id');
                    select.innerHTML = '<option value="">Pilih Kecamatan</option>';

                    data.data.forEach(kecamatan => {
                        const option = document.createElement('option');
                        option.value = kecamatan.id;
                        option.textContent = kecamatan.nama;
                        select.appendChild(option);
                    });

                    log(`${data.data.length} kecamatan loaded successfully`);
                    select.disabled = false;
                } else {
                    log('Failed to load kecamatan:', data);
                }
            } catch (error) {
                log('Error loading kecamatan:', error.message);
            }
        }

        async function testDesa(kecamatanId) {
            if (!kecamatanId) return;

            log(`Testing desa API for kecamatan ${kecamatanId}...`);
            try {
                const response = await fetch(`index.php?controller=wilayah&action=getDesa&id=${kecamatanId}`);
                const data = await response.json();
                log('Desa data:', data);

                if (data.success && data.data) {
                    const select = document.getElementById('desa_id');
                    select.innerHTML = '<option value="">Pilih Desa</option>';

                    data.data.forEach(desa => {
                        const option = document.createElement('option');
                        option.value = desa.id;
                        option.textContent = desa.nama;
                        select.appendChild(option);
                    });

                    log(`${data.data.length} desa loaded successfully`);
                    select.disabled = false;
                } else {
                    log('Failed to load desa:', data);
                }
            } catch (error) {
                log('Error loading desa:', error.message);
            }
        }

        // Event listeners
        document.getElementById('provinsi_id').addEventListener('change', (e) => {
            const kabupatenSelect = document.getElementById('kabupaten_id');
            const kecamatanSelect = document.getElementById('kecamatan_id');
            const desaSelect = document.getElementById('desa_id');

            kabupatenSelect.disabled = true;
            kecamatanSelect.disabled = true;
            desaSelect.disabled = true;

            testKabupaten(e.target.value);
        });

        document.getElementById('kabupaten_id').addEventListener('change', (e) => {
            const kecamatanSelect = document.getElementById('kecamatan_id');
            const desaSelect = document.getElementById('desa_id');

            kecamatanSelect.disabled = true;
            desaSelect.disabled = true;

            testKecamatan(e.target.value);
        });

        document.getElementById('kecamatan_id').addEventListener('change', (e) => {
            const desaSelect = document.getElementById('desa_id');
            desaSelect.disabled = true;
            testDesa(e.target.value);
        });

        // Initialize
        log('Starting test...');
        testProvinsi();
    </script>
</body>
</html>