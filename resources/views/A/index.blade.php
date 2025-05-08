<!-- resources/views/mahasiswa/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Manajemen Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Manajemen Data Mahasiswa</h1>

        <!-- Form Input -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Form Mahasiswa</h5>
            </div>
            <div class="card-body">
                <form id="mahasiswaForm">
                    @csrf
                    <input type="hidden" name="id" id="mahasiswaId">
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nim" class="form-label">NIM</label>
                            <input type="text" class="form-control" id="nim" name="nim" required>
                            <div class="invalid-feedback">NIM harus 8 digit angka</div>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                            <div class="invalid-feedback">Nama minimal 3 karakter</div>
                        </div>
                        
                        <div class="col-md-4">
                            <label for="fakultas" class="form-label">Fakultas</label>
                            <select class="form-select" id="fakultas" name="fakultas_id" required>
                                <option value="">Pilih Fakultas</option>
                                <!-- Options akan diisi via AJAX -->
                            </select>
                        </div>
                        
                        <div class="col-md-4">
                            <label for="jurusan" class="form-label">Jurusan</label>
                            <select class="form-select" id="jurusan" name="jurusan_id" disabled required>
                                <option value="">Pilih Jurusan</option>
                            </select>
                        </div>
                        
                        <div class="col-md-4">
                            <label for="prodi" class="form-label">Program Studi</label>
                            <select class="form-select" id="prodi" name="prodi_id" disabled required>
                                <option value="">Pilih Prodi</option>
                            </select>
                        </div>
                        
                        <div class="col-12">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="2" required></textarea>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="angkatan" class="form-label">Angkatan</label>
                            <select class="form-select" id="angkatan" name="angkatan" required>
                                <option value="">Pilih Tahun</option>
                                @for($year = 2018; $year <= date('Y'); $year++)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">Batal</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Daftar Mahasiswa</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Fakultas</th>
                                <th>Jurusan</th>
                                <th>Prodi</th>
                                <th>Angkatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="mahasiswaTable">
                            <!-- Data akan diisi via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Load data awal
            loadMahasiswa();
            loadFakultas();

            // Setup CSRF
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Load Fakultas
            function loadFakultas() {
                $.get('/api/fakultas', function(data) {
                    $('#fakultas').html('<option value="">Pilih Fakultas</option>');
                    data.forEach(function(fakultas) {
                        $('#fakultas').append(
                            `<option value="${fakultas.fakultas_id}">${fakultas.nama}</option>`
                        );
                    });
                });
            }

            // Cascading Dropdown
            $('#fakultas').change(function() {
                const fakultasId = $(this).val();
                $('#jurusan').prop('disabled', !fakultasId);
                
                if(fakultasId) {
                    $.get(`/api/jurusan/${fakultasId}`, function(data) {
                        $('#jurusan').html('<option value="">Pilih Jurusan</option>');
                        data.forEach(function(jurusan) {
                            $('#jurusan').append(
                                `<option value="${jurusan.jurusan_id}">${jurusan.nama}</option>`
                            );
                        });
                    });
                }
            });

            $('#jurusan').change(function() {
                const jurusanId = $(this).val();
                $('#prodi').prop('disabled', !jurusanId);
                
                if(jurusanId) {
                    $.get(`/api/prodi/${jurusanId}`, function(data) {
                        $('#prodi').html('<option value="">Pilih Prodi</option>');
                        data.forEach(function(prodi) {
                            $('#prodi').append(
                                `<option value="${prodi.prodi_id}">${prodi.nama}</option>`
                            );
                        });
                    });
                }
            });

            // Submit Form
            $('#mahasiswaForm').submit(function(e) {
                e.preventDefault();
                
                // Validasi Frontend
                if($('#nim').val().length !== 8) {
                    $('#nim').addClass('is-invalid');
                    return;
                }
                
                const formData = $(this).serialize();
                const url = $('#mahasiswaId').val() ? `/api/mahasiswa/${$('#mahasiswaId').val()}` : '/api/mahasiswa';
                const method = $('#mahasiswaId').val() ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    method: method,
                    data: formData,
                    success: function(response) {
                        loadMahasiswa();
                        resetForm();
                        alert('Data berhasil disimpan!');
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseJSON.message);
                    }
                });
            });

            // Load Data Mahasiswa
            function loadMahasiswa() {
                $.get('/api/mahasiswa', function(data) {
                    console.log(data);
                    let html = '';
                    data.data.forEach(function(mhs) {
                        html += `
                            <tr>
                                <td>${mhs.nim}</td>
                                <td>${mhs.nama}</td>
                                <td>${mhs.prodi.jurusan.fakultas.nama}</td>
                                <td>${mhs.prodi.jurusan.nama}</td>
                                <td>${mhs.prodi.nama}</td>
                                <td>${mhs.angkatan}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning edit-btn" data-id="${mhs.mahasiswa_id}">Edit</button>
                                    <button class="btn btn-sm btn-danger delete-btn" data-id="${mhs.mahasiswa_id}">Hapus</button>
                                </td>
                            </tr>`;
                    });
                    $('#mahasiswaTable').html(html);
                });
            }

            // Edit Data
            $(document).on('click', '.edit-btn', function() {
                const id = $(this).data('id');
                
                $.get(`/api/mahasiswa/${id}`, function(data) {
                    $('#mahasiswaId').val(data.id);
                    $('#nim').val(data.nim);
                    $('#nama').val(data.nama);
                    $('#alamat').val(data.alamat);
                    $('#angkatan').val(data.angkatan);
                    
                    // Set dropdown
                    $('#fakultas').val(data.prodi.jurusan.fakultas.id).trigger('change');
                    setTimeout(() => {
                        $('#jurusan').val(data.prodi.jurusan.id).trigger('change');
                        setTimeout(() => {
                            $('#prodi').val(data.prodi_id);
                        }, 300);
                    }, 300);
                });
            });

            // Hapus Data
            $(document).on('click', '.delete-btn', function() {
                if(confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    const id = $(this).data('id');
                    
                    $.ajax({
                        url: `/api/mahasiswa/${id}`,
                        method: 'DELETE',
                        success: function() {
                            loadMahasiswa();
                            alert('Data berhasil dihapus!');
                        }
                    });
                }
            });

            // Reset Form
            window.resetForm = function() {
                $('#mahasiswaForm')[0].reset();
                $('#mahasiswaId').val('');
                $('#jurusan, #prodi').prop('disabled', true);
                $('.is-invalid').removeClass('is-invalid');
            }
        });
    </script>
</body>
</html>