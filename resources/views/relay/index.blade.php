@extends('layouts.app')

@section('title', 'Kontrol Relay')

@section('content')
    <div class="mb-3">
        <h4>Control Relay</h4>

        <button id="relayBtn" class="btn btn-secondary">
            Loading...
        </button>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            function loadRelayStatus() {
                $.get('/relay/status', function(res) {
                    if (res && res.status == 1) {
                        $('#relayBtn').removeClass('btn-danger').addClass('btn-success').text('Relay ON');
                        $('#relayBtn').data('status', 1);
                    } else {
                        $('#relayBtn').removeClass('btn-success').addClass('btn-danger').text('Relay OFF');
                        $('#relayBtn').data('status', 0);
                    }
                });
            }

            $('#relayBtn').on('click', function() {
                let status = $(this).data('status') == 1 ? 0 : 1;

                $.post('/relay/update', {
                    _token: '{{ csrf_token() }}',
                    status: status
                }, function(res) {
                    if (res.status) {
                        loadRelayStatus();
                        Swal.fire('Berhasil!', 'Relay berhasil diubah', 'success');
                    }
                });
            });

            loadRelayStatus();
        });
    </script>
@endsection
