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
                    `<option value="${fakultas.id}">${fakultas.nama}</option>`
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
                        `<option value="${jurusan.id}">${jurusan.nama}</option>`
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
                        `<option value="${prodi.id}">${prodi.nama}</option>`
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
            let html = '';
            data.forEach(function(mhs) {
                html += `
                    <tr>
                        <td>${mhs.nim}</td>
                        <td>${mhs.nama}</td>
                        <td>${mhs.prodi.jurusan.fakultas.nama}</td>
                        <td>${mhs.prodi.jurusan.nama}</td>
                        <td>${mhs.prodi.nama}</td>
                        <td>${mhs.angkatan}</td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-btn" data-id="${mhs.id}">Edit</button>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="${mhs.id}">Hapus</button>
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