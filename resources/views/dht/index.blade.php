@extends('layouts.app')

@section('title', 'Data Suhu & Kelembapan')

@section('content')
    <h2>Data Suhu & Kelembapan</h2>

    <table id="sensorTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Suhu (°C)</th>
                <th>Kelembapan (%)</th>
                <th>Waktu</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $i => $item)
                <tr id="row-{{ $item->id }}">
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->temperature }}</td>
                    <td>{{ $item->humidity }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                        <button class="btn btn-danger btn-sm deleteBtn" data-id="{{ $item->id }}">
                            Delete
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#sensorTable').DataTable();

            $('#sensorTable tbody').on('click', '.deleteBtn', function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data ini tidak bisa dikembalikan",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: '/sensor/' + id,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {

                                if (response.status) {
                                    let table = $('#sensorTable').DataTable();
                                    table.row($('#row-' + id)).remove().draw(false);

                                    Swal.fire(
                                        'Berhasil!',
                                        'Data telah dihapus.',
                                        'success'
                                    );
                                }
                            }
                        });

                    }
                });
            });
        });
    </script>
@endsection
